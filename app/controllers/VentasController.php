<?php
require_once ROOT_PATH . 'app/controllers/BaseController.php';

class VentasController extends BaseController {
    
    public function index() {
        $this->requireAuth();
        
        $sql = "SELECT v.*, s.nombre as sucursal_nombre, c.nombre as cliente_nombre, u.nombre_completo as vendedor
                FROM ventas v
                JOIN sucursales s ON v.sucursal_id = s.id
                LEFT JOIN clientes c ON v.cliente_id = c.id
                JOIN usuarios u ON v.usuario_id = u.id
                ORDER BY v.fecha_venta DESC
                LIMIT 50";
        
        $stmt = $this->db->query($sql);
        $ventas = $stmt->fetchAll();
        
        $this->view('ventas/index', [
            'ventas' => $ventas
        ]);
    }
    
    public function ver($id) {
        $this->requireAuth();
        
        $stmt = $this->db->prepare("SELECT v.*, s.nombre as sucursal_nombre, s.direccion as sucursal_direccion,
                                     c.nombre as cliente_nombre, c.email as cliente_email, c.telefono as cliente_telefono,
                                     u.nombre_completo as vendedor
                                     FROM ventas v
                                     JOIN sucursales s ON v.sucursal_id = s.id
                                     LEFT JOIN clientes c ON v.cliente_id = c.id
                                     JOIN usuarios u ON v.usuario_id = u.id
                                     WHERE v.id = ?");
        $stmt->execute([$id]);
        $venta = $stmt->fetch();
        
        if (!$venta) {
            $_SESSION['error'] = 'Venta no encontrada';
            $this->redirect('ventas');
        }
        
        // Obtener detalles
        $stmt = $this->db->prepare("SELECT vd.*, p.nombre, p.sku
                                     FROM venta_detalles vd
                                     JOIN productos p ON vd.producto_id = p.id
                                     WHERE vd.venta_id = ?");
        $stmt->execute([$id]);
        $detalles = $stmt->fetchAll();
        
        $this->view('ventas/ver', [
            'venta' => $venta,
            'detalles' => $detalles
        ]);
    }
    
    public function pos() {
        $this->requireRole(['Administrador', 'Gerente', 'Vendedor']);
        
        // Obtener productos disponibles
        $stmt = $this->db->query("SELECT p.*, SUM(i.cantidad) as stock_total
                                   FROM productos p
                                   LEFT JOIN inventario i ON p.id = i.producto_id
                                   WHERE p.activo = 1
                                   GROUP BY p.id
                                   HAVING stock_total > 0
                                   ORDER BY p.nombre");
        $productos = $stmt->fetchAll();
        
        // Obtener clientes
        $clientes = $this->db->query("SELECT id, nombre, telefono, puntos_fidelidad FROM clientes WHERE activo = 1 ORDER BY nombre")->fetchAll();
        
        $this->view('ventas/pos', [
            'productos' => $productos,
            'clientes' => $clientes
        ]);
    }
}
