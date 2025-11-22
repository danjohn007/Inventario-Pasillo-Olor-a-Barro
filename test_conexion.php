<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test de Conexión - Sistema de Inventario</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center py-12 px-4">
        <div class="max-w-3xl w-full bg-white rounded-lg shadow-2xl p-8">
            <h1 class="text-3xl font-bold text-center mb-8 text-gray-800">
                <i class="fas fa-stethoscope text-blue-500 mr-2"></i>
                Test de Conexión y Configuración
            </h1>
            
            <?php
            require_once 'config/config.php';
            
            $tests = [];
            
            // Test 1: Configuración básica
            $tests[] = [
                'name' => 'Configuración Básica',
                'status' => defined('BASE_URL') && defined('DB_HOST'),
                'message' => defined('BASE_URL') ? 'URL Base: ' . BASE_URL : 'Error en configuración',
                'icon' => 'fa-cog'
            ];
            
            // Test 2: URL Base automática
            $tests[] = [
                'name' => 'Auto-detección de URL Base',
                'status' => true,
                'message' => 'URL detectada correctamente: ' . BASE_URL,
                'icon' => 'fa-link'
            ];
            
            // Test 3: Conexión a la base de datos
            $dbConnected = false;
            $dbMessage = '';
            try {
                require_once 'config/database.php';
                $db = Database::getInstance()->getConnection();
                $dbConnected = true;
                $dbMessage = 'Conexión exitosa a: ' . DB_NAME . '@' . DB_HOST;
            } catch (Exception $e) {
                $dbMessage = 'Error: ' . $e->getMessage();
            }
            
            $tests[] = [
                'name' => 'Conexión a Base de Datos',
                'status' => $dbConnected,
                'message' => $dbMessage,
                'icon' => 'fa-database'
            ];
            
            // Test 4: Verificar tablas
            $tablesExist = false;
            $tablesMessage = '';
            if ($dbConnected) {
                try {
                    $stmt = $db->query("SHOW TABLES");
                    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
                    $requiredTables = ['usuarios', 'roles', 'productos', 'sucursales', 'inventario'];
                    $missingTables = array_diff($requiredTables, $tables);
                    
                    if (empty($missingTables)) {
                        $tablesExist = true;
                        $tablesMessage = 'Todas las tablas necesarias existen (' . count($tables) . ' tablas)';
                    } else {
                        $tablesMessage = 'Faltan tablas: ' . implode(', ', $missingTables);
                    }
                } catch (Exception $e) {
                    $tablesMessage = 'Error al verificar tablas: ' . $e->getMessage();
                }
            } else {
                $tablesMessage = 'No se puede verificar (sin conexión a DB)';
            }
            
            $tests[] = [
                'name' => 'Tablas de Base de Datos',
                'status' => $tablesExist,
                'message' => $tablesMessage,
                'icon' => 'fa-table'
            ];
            
            // Test 5: Sesiones PHP
            $tests[] = [
                'name' => 'Soporte de Sesiones PHP',
                'status' => session_status() === PHP_SESSION_ACTIVE,
                'message' => session_status() === PHP_SESSION_ACTIVE ? 'Sesiones habilitadas' : 'Sesiones deshabilitadas',
                'icon' => 'fa-user-shield'
            ];
            
            // Test 6: Permisos de escritura
            $writableDir = ROOT_PATH . 'public/uploads/';
            $canWrite = is_writable($writableDir);
            $tests[] = [
                'name' => 'Permisos de Escritura',
                'status' => $canWrite,
                'message' => $canWrite ? 'Directorio de uploads escribible' : 'Sin permisos en: ' . $writableDir,
                'icon' => 'fa-folder-open'
            ];
            
            // Test 7: Versión de PHP
            $phpVersion = phpversion();
            $phpOk = version_compare($phpVersion, '7.4.0', '>=');
            $tests[] = [
                'name' => 'Versión de PHP',
                'status' => $phpOk,
                'message' => 'PHP ' . $phpVersion . ($phpOk ? ' (Compatible)' : ' (Requiere 7.4+)'),
                'icon' => 'fa-code'
            ];
            
            // Contar tests exitosos
            $passed = count(array_filter($tests, function($test) { return $test['status']; }));
            $total = count($tests);
            ?>
            
            <!-- Resumen -->
            <div class="mb-6 p-4 rounded-lg <?= $passed === $total ? 'bg-green-100 border-green-500' : 'bg-yellow-100 border-yellow-500' ?> border-l-4">
                <h2 class="text-xl font-semibold mb-2">
                    <?= $passed === $total ? '✓ Sistema Listo' : '⚠ Configuración Incompleta' ?>
                </h2>
                <p class="text-gray-700">
                    <?= $passed ?> de <?= $total ?> pruebas exitosas
                </p>
            </div>
            
            <!-- Tests -->
            <div class="space-y-4">
                <?php foreach ($tests as $test): ?>
                <div class="border rounded-lg p-4 <?= $test['status'] ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200' ?>">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <i class="fas <?= $test['icon'] ?> text-2xl <?= $test['status'] ? 'text-green-500' : 'text-red-500' ?>"></i>
                        </div>
                        <div class="ml-4 flex-1">
                            <h3 class="text-lg font-semibold <?= $test['status'] ? 'text-green-800' : 'text-red-800' ?>">
                                <?= $test['name'] ?>
                                <span class="ml-2">
                                    <?= $test['status'] ? '✓' : '✗' ?>
                                </span>
                            </h3>
                            <p class="mt-1 text-sm <?= $test['status'] ? 'text-green-700' : 'text-red-700' ?>">
                                <?= $test['message'] ?>
                            </p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Información adicional -->
            <div class="mt-8 p-4 bg-blue-50 border-l-4 border-blue-500 rounded">
                <h3 class="font-semibold text-blue-800 mb-2">
                    <i class="fas fa-info-circle mr-2"></i>Información del Sistema
                </h3>
                <ul class="text-sm text-blue-700 space-y-1">
                    <li><strong>Servidor:</strong> <?= $_SERVER['SERVER_SOFTWARE'] ?? 'Desconocido' ?></li>
                    <li><strong>PHP:</strong> <?= phpversion() ?></li>
                    <li><strong>Sistema:</strong> <?= php_uname() ?></li>
                    <li><strong>Directorio raíz:</strong> <?= ROOT_PATH ?></li>
                </ul>
            </div>
            
            <!-- Botones de acción -->
            <div class="mt-8 flex justify-center space-x-4">
                <?php if ($passed === $total): ?>
                <a href="<?= BASE_URL ?>" class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                    <i class="fas fa-rocket mr-2"></i>Ir al Sistema
                </a>
                <?php else: ?>
                <a href="README.md" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-book mr-2"></i>Ver Documentación
                </a>
                <?php endif; ?>
                
                <button onclick="location.reload()" class="px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                    <i class="fas fa-redo mr-2"></i>Volver a Probar
                </button>
            </div>
        </div>
    </div>
</body>
</html>
