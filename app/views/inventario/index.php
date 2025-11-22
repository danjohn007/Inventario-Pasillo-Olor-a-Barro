<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <div class="mb-8 flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-boxes mr-3 text-primary"></i>Inventario
        </h1>
        <a href="<?= BASE_URL ?>inventario/alertas" class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition">
            <i class="fas fa-exclamation-triangle mr-2"></i>Ver Alertas
        </a>
    </div>
    
    <!-- Filter -->
    <div class="bg-white shadow-lg rounded-lg p-6 mb-8">
        <form method="GET" action="<?= BASE_URL ?>inventario" class="flex gap-4">
            <div class="flex-1">
                <select name="sucursal" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                    <option value="">Todas las sucursales</option>
                    <?php foreach ($sucursales as $suc): ?>
                    <option value="<?= $suc['id'] ?>" <?= $sucursal_id == $suc['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($suc['nombre']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-secondary transition">
                <i class="fas fa-filter mr-2"></i>Filtrar
            </button>
        </form>
    </div>
    
    <!-- Inventory Table -->
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Producto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">SKU</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sucursal</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Cantidad</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Mín/Máx</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ubicación</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if (empty($inventario)): ?>
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">No hay inventario registrado</td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ($inventario as $item): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="<?= BASE_URL ?>productos/ver/<?= $item['producto_id'] ?>" class="text-primary hover:underline">
                                    <?= htmlspecialchars($item['nombre']) ?>
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600"><?= htmlspecialchars($item['sku']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="px-2 py-1 bg-primary text-white text-xs rounded">
                                    <?= htmlspecialchars($item['sucursal_codigo']) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="text-lg font-semibold <?= $item['cantidad'] <= $item['stock_minimo'] ? 'text-red-600' : 'text-green-600' ?>">
                                    <?= $item['cantidad'] ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-600">
                                <?= $item['stock_minimo'] ?> / <?= $item['stock_maximo'] ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600"><?= htmlspecialchars($item['ubicacion_fisica']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    
</div>
