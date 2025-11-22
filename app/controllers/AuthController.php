<?php
require_once ROOT_PATH . 'app/controllers/BaseController.php';

class AuthController extends BaseController {
    
    public function login() {
        // Si ya está autenticado, redirigir al dashboard
        if (isset($_SESSION['user_id'])) {
            $this->redirect('home/dashboard');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            
            // Validar credenciales
            $stmt = $this->db->prepare("SELECT u.*, r.nombre as rol_nombre 
                                        FROM usuarios u 
                                        JOIN roles r ON u.rol_id = r.id 
                                        WHERE u.username = ? AND u.activo = 1");
            $stmt->execute([$username]);
            $user = $stmt->fetch();
            
            if ($user && password_verify($password, $user['password'])) {
                // Iniciar sesión
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['user_role'] = $user['rol_nombre'];
                $_SESSION['user_name'] = $user['nombre_completo'];
                $_SESSION['sucursal_id'] = $user['sucursal_id'];
                
                // Actualizar último acceso
                $stmt = $this->db->prepare("UPDATE usuarios SET ultimo_acceso = NOW() WHERE id = ?");
                $stmt->execute([$user['id']]);
                
                // Redirigir
                $redirect = $_SESSION['redirect_to'] ?? 'home/dashboard';
                unset($_SESSION['redirect_to']);
                $this->redirect($redirect);
            } else {
                $_SESSION['error'] = 'Usuario o contraseña incorrectos';
            }
        }
        
        $this->viewOnly('auth/login');
    }
    
    public function logout() {
        session_destroy();
        $this->redirect('auth/login');
    }
    
    public function register() {
        // Solo para desarrollo - en producción debe ser solo por admin
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $nombre_completo = $_POST['nombre_completo'] ?? '';
            
            // Validar que no exista el usuario
            $stmt = $this->db->prepare("SELECT id FROM usuarios WHERE username = ? OR email = ?");
            $stmt->execute([$username, $email]);
            
            if ($stmt->fetch()) {
                $_SESSION['error'] = 'El usuario o email ya existe';
            } else {
                // Crear usuario
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $this->db->prepare("INSERT INTO usuarios (username, email, password, nombre_completo, rol_id, activo) 
                                           VALUES (?, ?, ?, ?, 3, 1)");
                
                if ($stmt->execute([$username, $email, $hashed_password, $nombre_completo])) {
                    $_SESSION['success'] = 'Usuario creado exitosamente. Inicia sesión.';
                    $this->redirect('auth/login');
                } else {
                    $_SESSION['error'] = 'Error al crear el usuario';
                }
            }
        }
        
        $this->viewOnly('auth/register');
    }
}
