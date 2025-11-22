<?php
require_once ROOT_PATH . 'app/controllers/BaseController.php';

class ConfiguracionController extends BaseController {
    
    public function index() {
        $this->requireRole(['Administrador']);
        
        // Obtener todas las configuraciones agrupadas por categoría
        $stmt = $this->db->query("SELECT * FROM configuracion ORDER BY categoria, clave");
        $configs = $stmt->fetchAll();
        
        // Agrupar por categoría
        $configuraciones = [];
        foreach ($configs as $config) {
            $cat = $config['categoria'] ?? 'general';
            if (!isset($configuraciones[$cat])) {
                $configuraciones[$cat] = [];
            }
            $configuraciones[$cat][] = $config;
        }
        
        $this->view('configuracion/index', [
            'configuraciones' => $configuraciones
        ]);
    }
    
    public function guardar() {
        $this->requireRole(['Administrador']);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                foreach ($_POST as $clave => $valor) {
                    if ($clave !== 'submit') {
                        // Actualizar o crear configuración
                        $stmt = $this->db->prepare("UPDATE configuracion SET valor = ? WHERE clave = ?");
                        $stmt->execute([$valor, $clave]);
                    }
                }
                
                $_SESSION['success'] = 'Configuración guardada exitosamente';
            } catch (Exception $e) {
                $_SESSION['error'] = 'Error al guardar la configuración: ' . $e->getMessage();
            }
        }
        
        $this->redirect('configuracion');
    }
    
    public function general() {
        $this->requireRole(['Administrador']);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $configs = [
                'sitio_nombre' => trim($_POST['sitio_nombre'] ?? SITE_NAME),
                'color_primario' => trim($_POST['color_primario'] ?? '#8B4513'),
                'color_secundario' => trim($_POST['color_secundario'] ?? '#D2691E'),
                'iva_porcentaje' => trim($_POST['iva_porcentaje'] ?? '16'),
                'puntos_por_peso' => trim($_POST['puntos_por_peso'] ?? '1')
            ];
            
            foreach ($configs as $clave => $valor) {
                $stmt = $this->db->prepare("UPDATE configuracion SET valor = ? WHERE clave = ?");
                $stmt->execute([$valor, $clave]);
            }
            
            $_SESSION['success'] = 'Configuración general actualizada';
            $this->redirect('configuracion/general');
        }
        
        $stmt = $this->db->query("SELECT * FROM configuracion WHERE categoria = 'general' OR categoria = 'apariencia' OR categoria = 'ventas' OR categoria = 'fidelidad'");
        $configs = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
        
        $this->view('configuracion/general', [
            'configs' => $configs
        ]);
    }
    
    public function email() {
        $this->requireRole(['Administrador']);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $configs = [
                'email_remitente' => trim($_POST['email_remitente'] ?? ''),
                'email_smtp_host' => trim($_POST['email_smtp_host'] ?? ''),
                'email_smtp_port' => trim($_POST['email_smtp_port'] ?? '587')
            ];
            
            foreach ($configs as $clave => $valor) {
                $stmt = $this->db->prepare("UPDATE configuracion SET valor = ? WHERE clave = ?");
                $stmt->execute([$valor, $clave]);
            }
            
            $_SESSION['success'] = 'Configuración de email actualizada';
            $this->redirect('configuracion/email');
        }
        
        $stmt = $this->db->query("SELECT * FROM configuracion WHERE categoria = 'email'");
        $configs = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
        
        $this->view('configuracion/email', [
            'configs' => $configs
        ]);
    }
    
    public function integraciones() {
        $this->requireRole(['Administrador']);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $configs = [
                'paypal_client_id' => trim($_POST['paypal_client_id'] ?? ''),
                'paypal_modo' => trim($_POST['paypal_modo'] ?? 'sandbox'),
                'qr_api_key' => trim($_POST['qr_api_key'] ?? '')
            ];
            
            foreach ($configs as $clave => $valor) {
                $stmt = $this->db->prepare("UPDATE configuracion SET valor = ? WHERE clave = ?");
                $stmt->execute([$valor, $clave]);
            }
            
            $_SESSION['success'] = 'Configuración de integraciones actualizada';
            $this->redirect('configuracion/integraciones');
        }
        
        $stmt = $this->db->query("SELECT * FROM configuracion WHERE categoria = 'pagos' OR categoria = 'integracion'");
        $configs = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
        
        $this->view('configuracion/integraciones', [
            'configs' => $configs
        ]);
    }
}
