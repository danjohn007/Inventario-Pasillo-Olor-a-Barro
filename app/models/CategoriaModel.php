<?php
require_once ROOT_PATH . 'app/models/BaseModel.php';

class CategoriaModel extends BaseModel {
    
    protected $table = 'categorias';
    
    // Obtener todas las categorías activas
    public function getAllActive() {
        $sql = "SELECT * FROM categorias WHERE activo = 1 ORDER BY orden ASC, nombre ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
    
    // Obtener categorías con conteo de productos
    public function getAllWithCount() {
        $sql = "SELECT c.*, COUNT(p.id) as total_productos
                FROM categorias c
                LEFT JOIN productos p ON c.id = p.categoria_id AND p.activo = 1
                WHERE c.activo = 1
                GROUP BY c.id
                ORDER BY c.orden ASC, c.nombre ASC";
        
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
}
