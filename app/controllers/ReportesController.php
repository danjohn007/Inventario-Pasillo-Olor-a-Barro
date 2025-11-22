<?php
require_once ROOT_PATH . 'app/controllers/BaseController.php';

class ReportesController extends BaseController {
    
    public function index() {
        $this->requireAuth();
        
        // Ventas por mes (últimos 6 meses)
        $stmt = $this->db->query("SELECT DATE_FORMAT(fecha_venta, '%Y-%m') as mes, 
                                   COALESCE(SUM(total), 0) as total, COUNT(*) as cantidad
                                   FROM ventas
                                   WHERE fecha_venta >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
                                   AND estado = 'completada'
                                   GROUP BY mes
                                   ORDER BY mes");
        $ventas_mes = $stmt->fetchAll();
        
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
                                   LIMIT 10");
        $top_productos = $stmt->fetchAll();
        
        // Ventas por sucursal
        $stmt = $this->db->query("SELECT s.nombre, COUNT(v.id) as total_ventas, 
                                   COALESCE(SUM(v.total), 0) as ingresos
                                   FROM sucursales s
                                   LEFT JOIN ventas v ON s.id = v.sucursal_id 
                                   AND MONTH(v.fecha_venta) = MONTH(CURDATE())
                                   AND v.estado = 'completada'
                                   WHERE s.activo = 1
                                   GROUP BY s.id
                                   ORDER BY ingresos DESC");
        $ventas_sucursal = $stmt->fetchAll();
        
        // Inventario por categoría
        $stmt = $this->db->query("SELECT c.nombre, COUNT(DISTINCT p.id) as total_productos,
                                   COALESCE(SUM(i.cantidad), 0) as stock_total
                                   FROM categorias c
                                   LEFT JOIN productos p ON c.id = p.categoria_id AND p.activo = 1
                                   LEFT JOIN inventario i ON p.id = i.producto_id
                                   WHERE c.activo = 1
                                   GROUP BY c.id
                                   ORDER BY stock_total DESC");
        $inventario_categoria = $stmt->fetchAll();
        
        $this->view('reportes/index', [
            'ventas_mes' => $ventas_mes,
            'top_productos' => $top_productos,
            'ventas_sucursal' => $ventas_sucursal,
            'inventario_categoria' => $inventario_categoria
        ]);
    }
    
    public function ventas() {
        $this->requireAuth();
        
        $fecha_inicio = $_GET['fecha_inicio'] ?? date('Y-m-01');
        $fecha_fin = $_GET['fecha_fin'] ?? date('Y-m-t');
        
        $stmt = $this->db->prepare("SELECT DATE(fecha_venta) as fecha, COUNT(*) as total_ventas,
                                     COALESCE(SUM(total), 0) as ingresos
                                     FROM ventas
                                     WHERE DATE(fecha_venta) BETWEEN ? AND ?
                                     AND estado = 'completada'
                                     GROUP BY DATE(fecha_venta)
                                     ORDER BY fecha");
        $stmt->execute([$fecha_inicio, $fecha_fin]);
        $datos = $stmt->fetchAll();
        
        $this->view('reportes/ventas', [
            'datos' => $datos,
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin
        ]);
    }
}
