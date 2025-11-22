<?php
require_once ROOT_PATH . 'app/models/BaseModel.php';

class UsuarioModel extends BaseModel {
    
    protected $table = 'usuarios';
    
    public function getAllWithDetails() {
        $sql = "SELECT u.*, r.nombre as rol_nombre, s.nombre as sucursal_nombre
                FROM usuarios u
                JOIN roles r ON u.rol_id = r.id
                LEFT JOIN sucursales s ON u.sucursal_id = s.id
                ORDER BY u.nombre_completo ASC";
        
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
    
    public function getByIdWithDetails($id) {
        $sql = "SELECT u.*, r.nombre as rol_nombre, s.nombre as sucursal_nombre
                FROM usuarios u
                JOIN roles r ON u.rol_id = r.id
                LEFT JOIN sucursales s ON u.sucursal_id = s.id
                WHERE u.id = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function usernameExists($username, $excludeId = null) {
        if ($excludeId) {
            $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM usuarios WHERE username = ? AND id != ?");
            $stmt->execute([$username, $excludeId]);
        } else {
            $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM usuarios WHERE username = ?");
            $stmt->execute([$username]);
        }
        $result = $stmt->fetch();
        return $result['count'] > 0;
    }
    
    public function emailExists($email, $excludeId = null) {
        if ($excludeId) {
            $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM usuarios WHERE email = ? AND id != ?");
            $stmt->execute([$email, $excludeId]);
        } else {
            $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM usuarios WHERE email = ?");
            $stmt->execute([$email]);
        }
        $result = $stmt->fetch();
        return $result['count'] > 0;
    }
}
