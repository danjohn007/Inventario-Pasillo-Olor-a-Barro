<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">
                <i class="fas fa-cash-register mr-3 text-primary"></i>Ventas
            </h1>
            <p class="mt-1 text-sm text-gray-600">Historial de ventas realizadas</p>
        </div>
        
        <?php if (in_array($_SESSION['user_role'], ['Administrador', 'Gerente', 'Vendedor'])): ?>
        <a href="<?= BASE_URL ?>ventas/pos" class="px-6 py-3 bg-green-500 text-white rounded-lg hover:bg-green-600 transition shadow-lg">
            <i class="fas fa-plus mr-2"></i>Nueva Venta (POS)
        </a>
        <?php endif; ?>
    </div>
    
    <!-- Ventas Table -->
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Número</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sucursal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cliente</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Total</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Método Pago</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Estado</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if (empty($ventas)): ?>
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center text-gray-500">No hay ventas registradas</td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ($ventas as $venta): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-primary">
                                <?= htmlspecialchars($venta['numero_venta']) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                <?= date('d/m/Y H:i', strtotime($venta['fecha_venta'])) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <?= htmlspecialchars($venta['sucursal_nombre']) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <?= $venta['cliente_nombre'] ? htmlspecialchars($venta['cliente_nombre']) : 'Cliente general' ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center font-semibold text-green-600">
                                $<?= number_format($venta['total'], 2) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="px-2 py-1 text-xs rounded bg-blue-100 text-blue-800">
                                    <?= ucfirst($venta['metodo_pago']) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="px-2 py-1 text-xs rounded <?= $venta['estado'] == 'completada' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                                    <?= ucfirst($venta['estado']) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <a href="<?= BASE_URL ?>ventas/ver/<?= $venta['id'] ?>" 
                                   class="text-primary hover:text-secondary">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    
</div>
