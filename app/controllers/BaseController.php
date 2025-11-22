<?php
class BaseController {
    protected $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    // Cargar vista
    protected function view($view, $data = []) {
        extract($data);
        
        // Cargar el layout
        require_once ROOT_PATH . 'app/views/layouts/header.php';
        require_once ROOT_PATH . 'app/views/' . $view . '.php';
        require_once ROOT_PATH . 'app/views/layouts/footer.php';
    }
    
    // Cargar vista sin layout
    protected function viewOnly($view, $data = []) {
        extract($data);
        require_once ROOT_PATH . 'app/views/' . $view . '.php';
    }
    
    // Redireccionar
    protected function redirect($url) {
        header('Location: ' . BASE_URL . $url);
        exit;
    }
    
    // Verificar si el usuario está autenticado
    protected function requireAuth() {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];
            $this->redirect('auth/login');
        }
    }
    
    // Verificar permisos por rol
    protected function requireRole($roles = []) {
        $this->requireAuth();
        
        if (!in_array($_SESSION['user_role'], $roles)) {
            $_SESSION['error'] = 'No tienes permisos para acceder a esta sección';
            $this->redirect('home');
        }
    }
    
    // Obtener usuario actual
    protected function getCurrentUser() {
        if (!isset($_SESSION['user_id'])) {
            return null;
        }
        
        $stmt = $this->db->prepare("SELECT u.*, r.nombre as rol_nombre FROM usuarios u 
                                     JOIN roles r ON u.rol_id = r.id 
                                     WHERE u.id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        return $stmt->fetch();
    }
    
    // Respuesta JSON
    protected function json($data, $status = 200) {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
