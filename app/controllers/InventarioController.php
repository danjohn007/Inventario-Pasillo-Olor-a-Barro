<?php
require_once ROOT_PATH . 'app/controllers/BaseController.php';

class InventarioController extends BaseController {
    
    public function index() {
        $this->requireAuth();
        
        $sucursal_id = $_GET['sucursal'] ?? null;
        
        $sql = "SELECT i.*, p.nombre, p.sku, p.precio_venta, s.nombre as sucursal_nombre, s.codigo as sucursal_codigo
                FROM inventario i
                JOIN productos p ON i.producto_id = p.id
                JOIN sucursales s ON i.sucursal_id = s.id";
        
        if ($sucursal_id) {
            $sql .= " WHERE i.sucursal_id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$sucursal_id]);
        } else {
            $stmt = $this->db->query($sql);
        }
        
        $inventario = $stmt->fetchAll();
        
        // Obtener sucursales para filtro
        $sucursales = $this->db->query("SELECT id, nombre FROM sucursales WHERE activo = 1 ORDER BY nombre")->fetchAll();
        
        $this->view('inventario/index', [
            'inventario' => $inventario,
            'sucursales' => $sucursales,
            'sucursal_id' => $sucursal_id
        ]);
    }
    
    public function alertas() {
        $this->requireAuth();
        
        $sql = "SELECT i.*, p.nombre, p.sku, s.nombre as sucursal_nombre
                FROM inventario i
                JOIN productos p ON i.producto_id = p.id
                JOIN sucursales s ON i.sucursal_id = s.id
                WHERE i.cantidad <= i.stock_minimo
                ORDER BY i.cantidad ASC";
        
        $stmt = $this->db->query($sql);
        $alertas = $stmt->fetchAll();
        
        $this->view('inventario/alertas', [
            'alertas' => $alertas
        ]);
    }
    
    public function movimientos() {
        $this->requireAuth();
        
        $sql = "SELECT m.*, p.nombre as producto_nombre, p.sku,
                so.nombre as sucursal_origen, sd.nombre as sucursal_destino,
                u.nombre_completo as usuario_nombre
                FROM movimientos_inventario m
                JOIN productos p ON m.producto_id = p.id
                LEFT JOIN sucursales so ON m.sucursal_origen_id = so.id
                LEFT JOIN sucursales sd ON m.sucursal_destino_id = sd.id
                JOIN usuarios u ON m.usuario_id = u.id
                ORDER BY m.created_at DESC
                LIMIT 50";
        
        $stmt = $this->db->query($sql);
        $movimientos = $stmt->fetchAll();
        
        $this->view('inventario/movimientos', [
            'movimientos' => $movimientos
        ]);
    }
}
