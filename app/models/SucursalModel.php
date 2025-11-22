<?php
require_once ROOT_PATH . 'app/models/BaseModel.php';

class SucursalModel extends BaseModel {
    
    protected $table = 'sucursales';
    
    public function getAllActive() {
        return $this->getAll('nombre', 'ASC');
    }
    
    public function getAllWithStats() {
        $sql = "SELECT s.*,
                (SELECT COUNT(*) FROM inventario WHERE sucursal_id = s.id) as total_productos,
                (SELECT SUM(cantidad) FROM inventario WHERE sucursal_id = s.id) as stock_total,
                (SELECT COUNT(*) FROM ventas WHERE sucursal_id = s.id AND DATE(fecha_venta) = CURDATE()) as ventas_hoy
                FROM sucursales s
                WHERE s.activo = 1
                ORDER BY s.nombre ASC";
        
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
    
    public function getByIdWithStats($id) {
        $sql = "SELECT s.*,
                (SELECT COUNT(*) FROM inventario WHERE sucursal_id = s.id) as total_productos,
                (SELECT SUM(cantidad) FROM inventario WHERE sucursal_id = s.id) as stock_total,
                (SELECT COUNT(*) FROM ventas WHERE sucursal_id = s.id AND MONTH(fecha_venta) = MONTH(CURDATE())) as ventas_mes,
                (SELECT COALESCE(SUM(total), 0) FROM ventas WHERE sucursal_id = s.id AND MONTH(fecha_venta) = MONTH(CURDATE())) as ingresos_mes
                FROM sucursales s
                WHERE s.id = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function codigoExists($codigo, $excludeId = null) {
        if ($excludeId) {
            $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM sucursales WHERE codigo = ? AND id != ?");
            $stmt->execute([$codigo, $excludeId]);
        } else {
            $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM sucursales WHERE codigo = ?");
            $stmt->execute([$codigo]);
        }
        $result = $stmt->fetch();
        return $result['count'] > 0;
    }
}
