<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= SITE_NAME ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#8B4513',
                        secondary: '#D2691E',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gradient-to-br from-amber-50 to-orange-100">
    
    <!-- Hero Section -->
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="text-center">
            <i class="fas fa-store text-8xl text-primary mb-6"></i>
            <h1 class="text-5xl font-bold text-gray-900 mb-4">
                <?= SITE_NAME ?>
            </h1>
            <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
                Sistema completo de gestión de inventarios para negocios de productos artesanales 
                con múltiples sucursales
            </p>
            
            <div class="space-x-4">
                <a href="<?= BASE_URL ?>auth/login" 
                   class="inline-block px-8 py-3 bg-primary text-white rounded-lg hover:bg-secondary transition duration-300 shadow-lg">
                    <i class="fas fa-sign-in-alt mr-2"></i>Iniciar Sesión
                </a>
            </div>
            
            <!-- Features -->
            <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <i class="fas fa-boxes text-4xl text-primary mb-4"></i>
                    <h3 class="text-xl font-semibold mb-2">Control de Inventario</h3>
                    <p class="text-gray-600">Gestión completa de stock por sucursal con alertas y movimientos</p>
                </div>
                
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <i class="fas fa-building text-4xl text-primary mb-4"></i>
                    <h3 class="text-xl font-semibold mb-2">Multisucursal</h3>
                    <p class="text-gray-600">Administra múltiples sucursales con transferencias en tiempo real</p>
                </div>
                
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <i class="fas fa-chart-line text-4xl text-primary mb-4"></i>
                    <h3 class="text-xl font-semibold mb-2">Reportes y Analytics</h3>
                    <p class="text-gray-600">Análisis detallado con gráficas y estadísticas de ventas</p>
                </div>
                
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <i class="fas fa-cash-register text-4xl text-primary mb-4"></i>
                    <h3 class="text-xl font-semibold mb-2">Punto de Venta</h3>
                    <p class="text-gray-600">Sistema POS con múltiples métodos de pago y fidelización</p>
                </div>
                
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <i class="fas fa-palette text-4xl text-primary mb-4"></i>
                    <h3 class="text-xl font-semibold mb-2">Productos Artesanales</h3>
                    <p class="text-gray-600">Catálogo especializado con certificados de autenticidad</p>
                </div>
                
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <i class="fas fa-users text-4xl text-primary mb-4"></i>
                    <h3 class="text-xl font-semibold mb-2">Gestión de Usuarios</h3>
                    <p class="text-gray-600">Sistema de roles y permisos con seguridad avanzada</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <footer class="bg-white py-6">
        <div class="text-center text-gray-600">
            <p>&copy; <?= date('Y') ?> <?= SITE_NAME ?>. Querétaro, México</p>
        </div>
    </footer>
    
</body>
</html>
