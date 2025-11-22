<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= SITE_NAME ?></title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- FullCalendar -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
    
    <!-- Font Awesome -->
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
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50">
    
    <!-- Navbar -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <a href="<?= BASE_URL ?>" class="text-2xl font-bold text-primary">
                            <i class="fas fa-store mr-2"></i><?= SITE_NAME ?>
                        </a>
                    </div>
                    
                    <?php if (isset($_SESSION['user_id'])): ?>
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <a href="<?= BASE_URL ?>home/dashboard" class="border-transparent text-gray-500 hover:border-primary hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            <i class="fas fa-home mr-1"></i> Dashboard
                        </a>
                        <a href="<?= BASE_URL ?>productos" class="border-transparent text-gray-500 hover:border-primary hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            <i class="fas fa-box mr-1"></i> Productos
                        </a>
                        <a href="<?= BASE_URL ?>sucursales" class="border-transparent text-gray-500 hover:border-primary hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            <i class="fas fa-building mr-1"></i> Sucursales
                        </a>
                        <a href="<?= BASE_URL ?>inventario" class="border-transparent text-gray-500 hover:border-primary hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            <i class="fas fa-boxes mr-1"></i> Inventario
                        </a>
                        <a href="<?= BASE_URL ?>ventas" class="border-transparent text-gray-500 hover:border-primary hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            <i class="fas fa-cash-register mr-1"></i> Ventas
                        </a>
                        <a href="<?= BASE_URL ?>reportes" class="border-transparent text-gray-500 hover:border-primary hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            <i class="fas fa-chart-bar mr-1"></i> Reportes
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
                
                <?php if (isset($_SESSION['user_id'])): ?>
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <span class="text-sm text-gray-700">
                            <i class="fas fa-user-circle mr-1"></i><?= $_SESSION['user_name'] ?? '' ?>
                        </span>
                        <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary text-white">
                            <?= $_SESSION['user_role'] ?? '' ?>
                        </span>
                    </div>
                    <div class="ml-4 flex-shrink-0">
                        <a href="<?= BASE_URL ?>auth/logout" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-secondary hover:bg-primary focus:outline-none">
                            <i class="fas fa-sign-out-alt mr-2"></i>Salir
                        </a>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    
    <!-- Mensajes Flash -->
    <?php if (isset($_SESSION['success'])): ?>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline"><?= $_SESSION['success'] ?></span>
        </div>
    </div>
    <?php unset($_SESSION['success']); endif; ?>
    
    <?php if (isset($_SESSION['error'])): ?>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline"><?= $_SESSION['error'] ?></span>
        </div>
    </div>
    <?php unset($_SESSION['error']); endif; ?>
    
    <!-- Main Content -->
    <main class="py-6">
