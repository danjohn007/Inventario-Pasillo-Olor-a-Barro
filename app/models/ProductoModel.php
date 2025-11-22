<?php
require_once ROOT_PATH . 'app/models/BaseModel.php';

class ProductoModel extends BaseModel {
    
    protected $table = 'productos';
    
    // Obtener productos con información relacionada
    public function getAllWithDetails() {
        $sql = "SELECT p.*, c.nombre as categoria_nombre, pr.nombre as proveedor_nombre,
                (SELECT COUNT(*) FROM producto_variantes WHERE producto_id = p.id) as total_variantes,
                (SELECT SUM(cantidad) FROM inventario WHERE producto_id = p.id) as stock_total
                FROM productos p
                LEFT JOIN categorias c ON p.categoria_id = c.id
                LEFT JOIN proveedores pr ON p.proveedor_id = pr.id
                WHERE p.activo = 1
                ORDER BY p.created_at DESC";
        
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
    
    // Obtener producto por ID con detalles
    public function getByIdWithDetails($id) {
        $sql = "SELECT p.*, c.nombre as categoria_nombre, pr.nombre as proveedor_nombre, pr.region_origen
                FROM productos p
                LEFT JOIN categorias c ON p.categoria_id = c.id
                LEFT JOIN proveedores pr ON p.proveedor_id = pr.id
                WHERE p.id = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    // Obtener variantes de un producto
    public function getVariantes($producto_id) {
        $sql = "SELECT * FROM producto_variantes WHERE producto_id = ? AND activo = 1 ORDER BY atributo, valor";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$producto_id]);
        return $stmt->fetchAll();
    }
    
    // Obtener fotos de un producto
    public function getFotos($producto_id) {
        $sql = "SELECT * FROM producto_fotos WHERE producto_id = ? ORDER BY es_principal DESC, orden ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$producto_id]);
        return $stmt->fetchAll();
    }
    
    // Obtener certificado de un producto
    public function getCertificado($producto_id) {
        $sql = "SELECT * FROM certificados WHERE producto_id = ? ORDER BY fecha_emision DESC LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$producto_id]);
        return $stmt->fetch();
    }
    
    // Buscar productos
    public function searchProductos($search) {
        $sql = "SELECT p.*, c.nombre as categoria_nombre, pr.nombre as proveedor_nombre
                FROM productos p
                LEFT JOIN categorias c ON p.categoria_id = c.id
                LEFT JOIN proveedores pr ON p.proveedor_id = pr.id
                WHERE p.activo = 1 
                AND (p.nombre LIKE ? OR p.sku LIKE ? OR p.descripcion LIKE ?)
                ORDER BY p.nombre ASC";
        
        $searchTerm = '%' . $search . '%';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$searchTerm, $searchTerm, $searchTerm]);
        return $stmt->fetchAll();
    }
    
    // Verificar si SKU existe
    public function skuExists($sku, $excludeId = null) {
        if ($excludeId) {
            $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM productos WHERE sku = ? AND id != ?");
            $stmt->execute([$sku, $excludeId]);
        } else {
            $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM productos WHERE sku = ?");
            $stmt->execute([$sku]);
        }
        $result = $stmt->fetch();
        return $result['count'] > 0;
    }
    
    // Obtener productos por categoría
    public function getByCategoria($categoria_id) {
        $sql = "SELECT p.*, c.nombre as categoria_nombre
                FROM productos p
                LEFT JOIN categorias c ON p.categoria_id = c.id
                WHERE p.categoria_id = ? AND p.activo = 1
                ORDER BY p.nombre ASC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$categoria_id]);
        return $stmt->fetchAll();
    }
    
    // Obtener stock total de un producto
    public function getStockTotal($producto_id) {
        $stmt = $this->db->prepare("SELECT COALESCE(SUM(cantidad), 0) as total FROM inventario WHERE producto_id = ?");
        $stmt->execute([$producto_id]);
        $result = $stmt->fetch();
        return $result['total'];
    }
}
