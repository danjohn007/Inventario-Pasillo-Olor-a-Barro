<?php
// Punto de entrada principal de la aplicación
require_once '../config/config.php';
require_once '../config/database.php';

// Autoloader simple
spl_autoload_register(function ($class) {
    $paths = [
        ROOT_PATH . 'app/controllers/',
        ROOT_PATH . 'app/models/',
    ];
    
    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Obtener la ruta solicitada
$request_uri = $_SERVER['REQUEST_URI'];
$script_name = dirname($_SERVER['SCRIPT_NAME']);

// Remover el directorio base de la URI
if ($script_name !== '/') {
    $request_uri = str_replace($script_name, '', $request_uri);
}

// Remover query string
$request_uri = strtok($request_uri, '?');

// Limpiar la ruta
$request_uri = trim($request_uri, '/');

// Dividir la ruta en partes
$parts = $request_uri ? explode('/', $request_uri) : [];

// Determinar controlador y acción
$controllerName = !empty($parts[0]) ? ucfirst($parts[0]) . 'Controller' : 'HomeController';
$action = isset($parts[1]) ? $parts[1] : 'index';
$params = array_slice($parts, 2);

// Si es la raíz, mostrar página de inicio
if (empty($parts[0])) {
    $controllerName = 'HomeController';
    $action = 'index';
}

// Verificar si el controlador existe
$controllerFile = ROOT_PATH . 'app/controllers/' . $controllerName . '.php';

if (!file_exists($controllerFile)) {
    // Mostrar página 404
    http_response_code(404);
    include ROOT_PATH . 'app/views/layouts/404.php';
    exit;
}

// Crear instancia del controlador
$controller = new $controllerName();

// Verificar si el método existe
if (!method_exists($controller, $action)) {
    http_response_code(404);
    include ROOT_PATH . 'app/views/layouts/404.php';
    exit;
}

// Ejecutar la acción
call_user_func_array([$controller, $action], $params);
