<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <!-- Page Header -->
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">
                <i class="fas fa-building mr-3 text-primary"></i>Sucursales
            </h1>
            <p class="mt-1 text-sm text-gray-600">Gestión de sucursales multisucursal</p>
        </div>
        
        <?php if ($_SESSION['user_role'] === 'Administrador'): ?>
        <div>
            <a href="<?= BASE_URL ?>sucursales/crear" class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-secondary transition">
                <i class="fas fa-plus mr-2"></i>Nueva Sucursal
            </a>
        </div>
        <?php endif; ?>
    </div>
    
    <!-- Sucursales Grid -->
    <?php if (empty($sucursales)): ?>
    <div class="bg-white shadow-lg rounded-lg p-12 text-center">
        <i class="fas fa-building text-6xl text-gray-300 mb-4"></i>
        <h3 class="text-xl font-semibold text-gray-600 mb-2">No hay sucursales registradas</h3>
    </div>
    <?php else: ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($sucursales as $sucursal): ?>
        <div class="bg-white shadow-lg rounded-lg overflow-hidden hover:shadow-xl transition">
            <div class="bg-gradient-to-br from-primary to-secondary p-6 text-white">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs opacity-80 mb-1"><?= htmlspecialchars($sucursal['codigo']) ?></p>
                        <h3 class="text-xl font-bold"><?= htmlspecialchars($sucursal['nombre']) ?></h3>
                    </div>
                    <i class="fas fa-building text-3xl opacity-30"></i>
                </div>
            </div>
            
            <div class="p-6">
                <div class="mb-4">
                    <p class="text-sm text-gray-600 flex items-start">
                        <i class="fas fa-map-marker-alt mr-2 mt-1"></i>
                        <span><?= htmlspecialchars($sucursal['direccion']) ?><br>
                        <?= htmlspecialchars($sucursal['ciudad']) ?>, <?= htmlspecialchars($sucursal['estado']) ?></span>
                    </p>
                </div>
                
                <?php if ($sucursal['telefono']): ?>
                <p class="text-sm text-gray-600 mb-2">
                    <i class="fas fa-phone mr-2"></i><?= htmlspecialchars($sucursal['telefono']) ?>
                </p>
                <?php endif; ?>
                
                <?php if ($sucursal['email']): ?>
                <p class="text-sm text-gray-600 mb-4">
                    <i class="fas fa-envelope mr-2"></i><?= htmlspecialchars($sucursal['email']) ?>
                </p>
                <?php endif; ?>
                
                <div class="border-t pt-4 mt-4">
                    <div class="grid grid-cols-3 gap-2 text-center">
                        <div>
                            <p class="text-xs text-gray-500">Productos</p>
                            <p class="text-lg font-bold text-primary"><?= $sucursal['total_productos'] ?></p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Stock</p>
                            <p class="text-lg font-bold text-green-600"><?= $sucursal['stock_total'] ?? 0 ?></p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Ventas Hoy</p>
                            <p class="text-lg font-bold text-blue-600"><?= $sucursal['ventas_hoy'] ?></p>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4 flex gap-2">
                    <a href="<?= BASE_URL ?>sucursales/ver/<?= $sucursal['id'] ?>" 
                       class="flex-1 text-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                        <i class="fas fa-eye mr-1"></i>Ver Detalles
                    </a>
                    <?php if ($_SESSION['user_role'] === 'Administrador'): ?>
                    <a href="<?= BASE_URL ?>sucursales/editar/<?= $sucursal['id'] ?>" 
                       class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                        <i class="fas fa-edit"></i>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
    
</div>
