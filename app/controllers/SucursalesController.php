<?php
require_once ROOT_PATH . 'app/controllers/BaseController.php';
require_once ROOT_PATH . 'app/models/SucursalModel.php';

class SucursalesController extends BaseController {
    
    private $sucursalModel;
    
    public function __construct() {
        parent::__construct();
        $this->sucursalModel = new SucursalModel();
    }
    
    public function index() {
        $this->requireAuth();
        
        $sucursales = $this->sucursalModel->getAllWithStats();
        
        $this->view('sucursales/index', [
            'sucursales' => $sucursales
        ]);
    }
    
    public function ver($id) {
        $this->requireAuth();
        
        $sucursal = $this->sucursalModel->getByIdWithStats($id);
        
        if (!$sucursal) {
            $_SESSION['error'] = 'Sucursal no encontrada';
            $this->redirect('sucursales');
        }
        
        // Obtener inventario de la sucursal
        $stmt = $this->db->prepare("SELECT i.*, p.nombre, p.sku, p.precio_venta
                                     FROM inventario i
                                     JOIN productos p ON i.producto_id = p.id
                                     WHERE i.sucursal_id = ?
                                     ORDER BY p.nombre");
        $stmt->execute([$id]);
        $inventario = $stmt->fetchAll();
        
        // Obtener ventas recientes
        $stmt = $this->db->prepare("SELECT v.*, u.nombre_completo as vendedor
                                     FROM ventas v
                                     JOIN usuarios u ON v.usuario_id = u.id
                                     WHERE v.sucursal_id = ?
                                     ORDER BY v.fecha_venta DESC
                                     LIMIT 10");
        $stmt->execute([$id]);
        $ventas = $stmt->fetchAll();
        
        $this->view('sucursales/ver', [
            'sucursal' => $sucursal,
            'inventario' => $inventario,
            'ventas' => $ventas
        ]);
    }
    
    public function crear() {
        $this->requireRole(['Administrador']);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre'] ?? '');
            $codigo = trim($_POST['codigo'] ?? '');
            $direccion = trim($_POST['direccion'] ?? '');
            $ciudad = trim($_POST['ciudad'] ?? '');
            
            if (empty($nombre) || empty($codigo) || empty($direccion)) {
                $_SESSION['error'] = 'Nombre, código y dirección son obligatorios';
            } elseif ($this->sucursalModel->codigoExists($codigo)) {
                $_SESSION['error'] = 'El código ya existe';
            } else {
                $data = [
                    'nombre' => $nombre,
                    'codigo' => $codigo,
                    'direccion' => $direccion,
                    'ciudad' => $ciudad,
                    'estado' => trim($_POST['estado'] ?? 'Querétaro'),
                    'codigo_postal' => trim($_POST['codigo_postal'] ?? ''),
                    'telefono' => trim($_POST['telefono'] ?? ''),
                    'email' => trim($_POST['email'] ?? ''),
                    'activo' => 1
                ];
                
                $id = $this->sucursalModel->create($data);
                
                if ($id) {
                    $_SESSION['success'] = 'Sucursal creada exitosamente';
                    $this->redirect('sucursales/ver/' . $id);
                } else {
                    $_SESSION['error'] = 'Error al crear la sucursal';
                }
            }
        }
        
        $this->view('sucursales/crear');
    }
    
    public function editar($id) {
        $this->requireRole(['Administrador']);
        
        $sucursal = $this->sucursalModel->getById($id);
        
        if (!$sucursal) {
            $_SESSION['error'] = 'Sucursal no encontrada';
            $this->redirect('sucursales');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre'] ?? '');
            $codigo = trim($_POST['codigo'] ?? '');
            $direccion = trim($_POST['direccion'] ?? '');
            $ciudad = trim($_POST['ciudad'] ?? '');
            
            if (empty($nombre) || empty($codigo) || empty($direccion)) {
                $_SESSION['error'] = 'Nombre, código y dirección son obligatorios';
            } elseif ($this->sucursalModel->codigoExists($codigo, $id)) {
                $_SESSION['error'] = 'El código ya existe';
            } else {
                $data = [
                    'nombre' => $nombre,
                    'codigo' => $codigo,
                    'direccion' => $direccion,
                    'ciudad' => $ciudad,
                    'estado' => trim($_POST['estado'] ?? 'Querétaro'),
                    'codigo_postal' => trim($_POST['codigo_postal'] ?? ''),
                    'telefono' => trim($_POST['telefono'] ?? ''),
                    'email' => trim($_POST['email'] ?? '')
                ];
                
                if ($this->sucursalModel->update($id, $data)) {
                    $_SESSION['success'] = 'Sucursal actualizada exitosamente';
                    $this->redirect('sucursales/ver/' . $id);
                } else {
                    $_SESSION['error'] = 'Error al actualizar la sucursal';
                }
            }
        }
        
        $this->view('sucursales/editar', [
            'sucursal' => $sucursal
        ]);
    }
}
