<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-tachometer-alt mr-3 text-primary"></i>Dashboard
        </h1>
        <p class="mt-1 text-sm text-gray-600">
            Bienvenido, <?= $user['nombre_completo'] ?> - <?= $user['rol_nombre'] ?>
        </p>
    </div>
    
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white overflow-hidden shadow-lg rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-box text-3xl text-blue-500"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Productos</dt>
                            <dd class="text-2xl font-bold text-gray-900"><?= $stats['total_productos'] ?></dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="bg-white overflow-hidden shadow-lg rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-building text-3xl text-green-500"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Sucursales</dt>
                            <dd class="text-2xl font-bold text-gray-900"><?= $stats['total_sucursales'] ?></dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="bg-white overflow-hidden shadow-lg rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-dollar-sign text-3xl text-yellow-500"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Ventas Hoy</dt>
                            <dd class="text-2xl font-bold text-gray-900">$<?= number_format($stats['ventas_hoy'], 2) ?></dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="bg-white overflow-hidden shadow-lg rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-chart-line text-3xl text-purple-500"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Ventas Mes</dt>
                            <dd class="text-2xl font-bold text-gray-900">$<?= number_format($stats['ventas_mes'], 2) ?></dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Alerts -->
    <?php if ($stats['stock_bajo'] > 0): ?>
    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-triangle text-yellow-400 text-xl"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm text-yellow-700">
                    <strong>Atención:</strong> Hay <?= $stats['stock_bajo'] ?> producto(s) con stock bajo. 
                    <a href="<?= BASE_URL ?>inventario/alertas" class="font-medium underline hover:text-yellow-600">Ver ahora</a>
                </p>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <?php if ($stats['transferencias_pendientes'] > 0): ?>
    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-info-circle text-blue-400 text-xl"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm text-blue-700">
                    Hay <?= $stats['transferencias_pendientes'] ?> transferencia(s) pendiente(s). 
                    <a href="<?= BASE_URL ?>inventario/transferencias" class="font-medium underline hover:text-blue-600">Revisar</a>
                </p>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Top Productos -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">
                    <i class="fas fa-trophy text-yellow-500 mr-2"></i>Productos Más Vendidos (Este Mes)
                </h2>
            </div>
            <div class="p-6">
                <?php if (empty($top_productos)): ?>
                    <p class="text-gray-500 text-center py-8">No hay datos de ventas disponibles</p>
                <?php else: ?>
                    <div class="space-y-4">
                        <?php foreach ($top_productos as $idx => $producto): ?>
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-primary text-white text-sm font-medium">
                                    <?= $idx + 1 ?>
                                </span>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900"><?= htmlspecialchars($producto['nombre']) ?></p>
                                    <p class="text-xs text-gray-500"><?= htmlspecialchars($producto['sku']) ?></p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-semibold text-gray-900"><?= $producto['total_vendido'] ?> unidades</p>
                                <p class="text-xs text-gray-500">$<?= number_format($producto['ingresos'], 2) ?></p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Ventas Recientes -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">
                    <i class="fas fa-receipt text-green-500 mr-2"></i>Ventas Recientes
                </h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Número</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sucursal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php if (empty($ventas_recientes)): ?>
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-gray-500">No hay ventas registradas</td>
                        </tr>
                        <?php else: ?>
                            <?php foreach ($ventas_recientes as $venta): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    <?= htmlspecialchars($venta['numero_venta']) ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?= htmlspecialchars($venta['sucursal']) ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-600">
                                    $<?= number_format($venta['total'], 2) ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
    </div>
    
</div>
