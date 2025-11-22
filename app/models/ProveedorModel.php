<?php
require_once ROOT_PATH . 'app/models/BaseModel.php';

class ProveedorModel extends BaseModel {
    
    protected $table = 'proveedores';
    
    // Obtener todos los proveedores activos
    public function getAllActive() {
        $sql = "SELECT * FROM proveedores WHERE activo = 1 ORDER BY nombre ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
    
    // Obtener por tipo
    public function getByTipo($tipo) {
        $sql = "SELECT * FROM proveedores WHERE tipo = ? AND activo = 1 ORDER BY nombre ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$tipo]);
        return $stmt->fetchAll();
    }
    
    // Obtener proveedores con conteo de productos
    public function getAllWithProductCount() {
        $sql = "SELECT p.*, COUNT(pr.id) as total_productos
                FROM proveedores p
                LEFT JOIN productos pr ON p.id = pr.proveedor_id AND pr.activo = 1
                WHERE p.activo = 1
                GROUP BY p.id
                ORDER BY p.nombre ASC";
        
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
}
