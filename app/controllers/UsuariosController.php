<?php
require_once ROOT_PATH . 'app/controllers/BaseController.php';
require_once ROOT_PATH . 'app/models/UsuarioModel.php';
require_once ROOT_PATH . 'app/models/RolModel.php';
require_once ROOT_PATH . 'app/models/SucursalModel.php';

class UsuariosController extends BaseController {
    
    private $usuarioModel;
    private $rolModel;
    private $sucursalModel;
    
    public function __construct() {
        parent::__construct();
        $this->usuarioModel = new UsuarioModel();
        $this->rolModel = new RolModel();
        $this->sucursalModel = new SucursalModel();
    }
    
    public function index() {
        $this->requireRole(['Administrador', 'Gerente']);
        
        $usuarios = $this->usuarioModel->getAllWithDetails();
        
        $this->view('usuarios/index', [
            'usuarios' => $usuarios
        ]);
    }
    
    public function ver($id) {
        $this->requireRole(['Administrador', 'Gerente']);
        
        $usuario = $this->usuarioModel->getByIdWithDetails($id);
        
        if (!$usuario) {
            $_SESSION['error'] = 'Usuario no encontrado';
            $this->redirect('usuarios');
        }
        
        $this->view('usuarios/ver', [
            'usuario' => $usuario
        ]);
    }
    
    public function crear() {
        $this->requireRole(['Administrador']);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $nombre_completo = trim($_POST['nombre_completo'] ?? '');
            $rol_id = intval($_POST['rol_id'] ?? 0);
            
            if (empty($username) || empty($email) || empty($password) || empty($nombre_completo) || !$rol_id) {
                $_SESSION['error'] = 'Todos los campos son obligatorios';
            } elseif ($this->usuarioModel->usernameExists($username)) {
                $_SESSION['error'] = 'El nombre de usuario ya existe';
            } elseif ($this->usuarioModel->emailExists($email)) {
                $_SESSION['error'] = 'El email ya está registrado';
            } else {
                $data = [
                    'username' => $username,
                    'email' => $email,
                    'password' => password_hash($password, PASSWORD_DEFAULT),
                    'nombre_completo' => $nombre_completo,
                    'rol_id' => $rol_id,
                    'sucursal_id' => !empty($_POST['sucursal_id']) ? intval($_POST['sucursal_id']) : null,
                    'telefono' => trim($_POST['telefono'] ?? ''),
                    'activo' => 1
                ];
                
                $id = $this->usuarioModel->create($data);
                
                if ($id) {
                    $_SESSION['success'] = 'Usuario creado exitosamente';
                    $this->redirect('usuarios/ver/' . $id);
                } else {
                    $_SESSION['error'] = 'Error al crear el usuario';
                }
            }
        }
        
        $roles = $this->rolModel->getAllActive();
        $sucursales = $this->sucursalModel->getAllActive();
        
        $this->view('usuarios/crear', [
            'roles' => $roles,
            'sucursales' => $sucursales
        ]);
    }
    
    public function editar($id) {
        $this->requireRole(['Administrador']);
        
        $usuario = $this->usuarioModel->getById($id);
        
        if (!$usuario) {
            $_SESSION['error'] = 'Usuario no encontrado';
            $this->redirect('usuarios');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $nombre_completo = trim($_POST['nombre_completo'] ?? '');
            $rol_id = intval($_POST['rol_id'] ?? 0);
            
            if (empty($username) || empty($email) || empty($nombre_completo) || !$rol_id) {
                $_SESSION['error'] = 'Campos obligatorios incompletos';
            } elseif ($this->usuarioModel->usernameExists($username, $id)) {
                $_SESSION['error'] = 'El nombre de usuario ya existe';
            } elseif ($this->usuarioModel->emailExists($email, $id)) {
                $_SESSION['error'] = 'El email ya está registrado';
            } else {
                $data = [
                    'username' => $username,
                    'email' => $email,
                    'nombre_completo' => $nombre_completo,
                    'rol_id' => $rol_id,
                    'sucursal_id' => !empty($_POST['sucursal_id']) ? intval($_POST['sucursal_id']) : null,
                    'telefono' => trim($_POST['telefono'] ?? ''),
                    'activo' => isset($_POST['activo']) ? 1 : 0
                ];
                
                // Solo actualizar contraseña si se proporciona
                if (!empty($_POST['password'])) {
                    $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
                }
                
                if ($this->usuarioModel->update($id, $data)) {
                    $_SESSION['success'] = 'Usuario actualizado exitosamente';
                    $this->redirect('usuarios/ver/' . $id);
                } else {
                    $_SESSION['error'] = 'Error al actualizar el usuario';
                }
            }
        }
        
        $roles = $this->rolModel->getAllActive();
        $sucursales = $this->sucursalModel->getAllActive();
        
        $this->view('usuarios/editar', [
            'usuario' => $usuario,
            'roles' => $roles,
            'sucursales' => $sucursales
        ]);
    }
    
    public function perfil() {
        $this->requireAuth();
        
        $usuario = $this->getCurrentUser();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $telefono = trim($_POST['telefono'] ?? '');
            
            $data = [
                'email' => $email,
                'telefono' => $telefono
            ];
            
            // Cambiar contraseña si se proporciona
            if (!empty($_POST['password']) && !empty($_POST['password_confirm'])) {
                if ($_POST['password'] === $_POST['password_confirm']) {
                    $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
                } else {
                    $_SESSION['error'] = 'Las contraseñas no coinciden';
                }
            }
            
            if (!isset($_SESSION['error']) && $this->usuarioModel->update($usuario['id'], $data)) {
                $_SESSION['success'] = 'Perfil actualizado exitosamente';
                $this->redirect('usuarios/perfil');
            } else {
                if (!isset($_SESSION['error'])) {
                    $_SESSION['error'] = 'Error al actualizar el perfil';
                }
            }
        }
        
        $usuario = $this->getCurrentUser();
        
        $this->view('usuarios/perfil', [
            'usuario' => $usuario
        ]);
    }
}
