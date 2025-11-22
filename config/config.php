<?php
// Configuración automática de la URL base
function getBaseUrl() {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    $script = $_SERVER['SCRIPT_NAME'];
    $dir = str_replace('\\', '/', dirname($script));
    
    // Si está en el directorio raíz
    if ($dir === '/') {
        return $protocol . '://' . $host . '/';
    }
    
    return $protocol . '://' . $host . $dir . '/';
}

define('BASE_URL', getBaseUrl());
define('ROOT_PATH', dirname(__DIR__) . '/');

// Configuración de la base de datos
define('DB_HOST', 'localhost');
define('DB_NAME', 'inventario_artesanal');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Configuración del sitio
define('SITE_NAME', 'Sistema de Inventario Artesanal');
define('SITE_VERSION', '1.0.0');

// Configuración de sesión
define('SESSION_LIFETIME', 3600); // 1 hora

// Zona horaria
date_default_timezone_set('America/Mexico_City');

// Mostrar errores en desarrollo (cambiar a false en producción)
define('DEBUG_MODE', true);

if (DEBUG_MODE) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Iniciar sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
