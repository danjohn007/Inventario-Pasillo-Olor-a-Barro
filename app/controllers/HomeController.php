<?php
require_once ROOT_PATH . 'app/controllers/BaseController.php';

class HomeController extends BaseController {
    
    public function index() {
        // Si está autenticado, redirigir al dashboard
        if (isset($_SESSION['user_id'])) {
            $this->redirect('home/dashboard');
        }
        
        // Página de bienvenida pública
        $this->viewOnly('home/index');
    }
    
    public function dashboard() {
        $this->requireAuth();
        
        $user = $this->getCurrentUser();
        
        // Obtener estadísticas generales
        $stats = [
            'total_productos' => 0,
            'total_sucursales' => 0,
            'ventas_hoy' => 0,
            'ventas_mes' => 0,
            'stock_bajo' => 0,
            'transferencias_pendientes' => 0,
        ];
        
        // Total de productos activos
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM productos WHERE activo = 1");
        $stats['total_productos'] = $stmt->fetch()['total'];
        
        // Total de sucursales activas
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM sucursales WHERE activo = 1");
        $stats['total_sucursales'] = $stmt->fetch()['total'];
        
        // Ventas de hoy
        $stmt = $this->db->query("SELECT COALESCE(SUM(total), 0) as total FROM ventas 
                                  WHERE DATE(fecha_venta) = CURDATE() AND estado = 'completada'");
        $stats['ventas_hoy'] = $stmt->fetch()['total'];
        
        // Ventas del mes
        $stmt = $this->db->query("SELECT COALESCE(SUM(total), 0) as total FROM ventas 
                                  WHERE MONTH(fecha_venta) = MONTH(CURDATE()) 
                                  AND YEAR(fecha_venta) = YEAR(CURDATE())
                                  AND estado = 'completada'");
        $stats['ventas_mes'] = $stmt->fetch()['total'];
        
        // Productos con stock bajo
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM inventario 
                                  WHERE cantidad <= stock_minimo");
        $stats['stock_bajo'] = $stmt->fetch()['total'];
        
        // Transferencias pendientes
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM transferencias 
                                  WHERE estado IN ('pendiente', 'en_transito')");
        $stats['transferencias_pendientes'] = $stmt->fetch()['total'];
        
        // Productos más vendidos
        $stmt = $this->db->query("SELECT p.nombre, p.sku, SUM(vd.cantidad) as total_vendido, 
                                  SUM(vd.subtotal) as ingresos
                                  FROM venta_detalles vd
                                  JOIN productos p ON vd.producto_id = p.id
                                  JOIN ventas v ON vd.venta_id = v.id
                                  WHERE v.estado = 'completada'
                                  AND MONTH(v.fecha_venta) = MONTH(CURDATE())
                                  GROUP BY p.id
                                  ORDER BY total_vendido DESC
                                  LIMIT 5");
        $top_productos = $stmt->fetchAll();
        
        // Ventas recientes
        $stmt = $this->db->query("SELECT v.*, s.nombre as sucursal, u.nombre_completo as vendedor
                                  FROM ventas v
                                  JOIN sucursales s ON v.sucursal_id = s.id
                                  JOIN usuarios u ON v.usuario_id = u.id
                                  ORDER BY v.fecha_venta DESC
                                  LIMIT 10");
        $ventas_recientes = $stmt->fetchAll();
        
        $this->view('home/dashboard', [
            'user' => $user,
            'stats' => $stats,
            'top_productos' => $top_productos,
            'ventas_recientes' => $ventas_recientes
        ]);
    }
}
