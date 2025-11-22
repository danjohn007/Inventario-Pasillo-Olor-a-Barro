<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <!-- Back Button -->
    <div class="mb-6">
        <a href="<?= BASE_URL ?>productos" class="text-primary hover:text-secondary">
            <i class="fas fa-arrow-left mr-2"></i>Volver al catálogo
        </a>
    </div>
    
    <!-- Product Header -->
    <div class="bg-white shadow-lg rounded-lg overflow-hidden mb-6">
        <div class="p-8">
            <div class="flex justify-between items-start">
                <div>
                    <div class="text-sm text-gray-500 mb-2">
                        SKU: <?= htmlspecialchars($producto['sku']) ?>
                        <?php if ($producto['edicion_limitada']): ?>
                        <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                            <i class="fas fa-star mr-1"></i>Edición Limitada
                        </span>
                        <?php endif; ?>
                        <?php if ($producto['requiere_certificado']): ?>
                        <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                            <i class="fas fa-certificate mr-1"></i>Con Certificado
                        </span>
                        <?php endif; ?>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">
                        <?= htmlspecialchars($producto['nombre']) ?>
                    </h1>
                    <p class="text-gray-600"><?= htmlspecialchars($producto['descripcion']) ?></p>
                </div>
                
                <?php if (in_array($_SESSION['user_role'], ['Administrador', 'Gerente'])): ?>
                <div class="flex gap-2">
                    <a href="<?= BASE_URL ?>productos/editar/<?= $producto['id'] ?>" 
                       class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                        <i class="fas fa-edit mr-2"></i>Editar
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Main Info -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Precios -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h2 class="text-xl font-semibold mb-4"><i class="fas fa-dollar-sign mr-2 text-green-500"></i>Precios</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Precio de Compra</p>
                        <p class="text-2xl font-bold text-gray-900">$<?= number_format($producto['precio_compra'], 2) ?></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Precio de Venta</p>
                        <p class="text-2xl font-bold text-primary">$<?= number_format($producto['precio_venta'], 2) ?></p>
                    </div>
                </div>
            </div>
            
            <!-- Información Artesanal -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h2 class="text-xl font-semibold mb-4"><i class="fas fa-palette mr-2 text-primary"></i>Información Artesanal</h2>
                <div class="space-y-3">
                    <?php if ($producto['categoria_nombre']): ?>
                    <div class="flex">
                        <span class="w-32 text-gray-600 font-medium">Categoría:</span>
                        <span class="text-gray-900"><?= htmlspecialchars($producto['categoria_nombre']) ?></span>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($producto['proveedor_nombre']): ?>
                    <div class="flex">
                        <span class="w-32 text-gray-600 font-medium">Proveedor:</span>
                        <span class="text-gray-900"><?= htmlspecialchars($producto['proveedor_nombre']) ?></span>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($producto['region_origen']): ?>
                    <div class="flex">
                        <span class="w-32 text-gray-600 font-medium">Región:</span>
                        <span class="text-gray-900"><?= htmlspecialchars($producto['region_origen']) ?></span>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($producto['materiales']): ?>
                    <div class="flex">
                        <span class="w-32 text-gray-600 font-medium">Materiales:</span>
                        <span class="text-gray-900"><?= htmlspecialchars($producto['materiales']) ?></span>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($producto['tecnica']): ?>
                    <div class="flex">
                        <span class="w-32 text-gray-600 font-medium">Técnica:</span>
                        <span class="text-gray-900"><?= htmlspecialchars($producto['tecnica']) ?></span>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($producto['tiempo_elaboracion']): ?>
                    <div class="flex">
                        <span class="w-32 text-gray-600 font-medium">Tiempo:</span>
                        <span class="text-gray-900"><?= htmlspecialchars($producto['tiempo_elaboracion']) ?></span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Variantes -->
            <?php if (!empty($variantes)): ?>
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h2 class="text-xl font-semibold mb-4"><i class="fas fa-th mr-2 text-primary"></i>Variantes</h2>
                <div class="space-y-2">
                    <?php foreach ($variantes as $variante): ?>
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                        <div>
                            <span class="font-medium"><?= htmlspecialchars($variante['nombre']) ?></span>
                            <span class="text-sm text-gray-500 ml-2">(<?= htmlspecialchars($variante['atributo']) ?>: <?= htmlspecialchars($variante['valor']) ?>)</span>
                        </div>
                        <?php if ($variante['precio_adicional'] > 0): ?>
                        <span class="text-green-600 font-semibold">+$<?= number_format($variante['precio_adicional'], 2) ?></span>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Stock por Sucursal -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h2 class="text-xl font-semibold mb-4"><i class="fas fa-warehouse mr-2 text-primary"></i>Stock por Sucursal</h2>
                <?php if (empty($stock_sucursales)): ?>
                <p class="text-gray-500 text-center py-8">No hay stock registrado</p>
                <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Sucursal</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Ubicación</th>
                                <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Cantidad</th>
                                <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Mínimo</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php foreach ($stock_sucursales as $stock): ?>
                            <tr>
                                <td class="px-4 py-3"><?= htmlspecialchars($stock['sucursal_nombre']) ?></td>
                                <td class="px-4 py-3 text-sm text-gray-600"><?= htmlspecialchars($stock['ubicacion_fisica']) ?></td>
                                <td class="px-4 py-3 text-center">
                                    <span class="font-semibold <?= $stock['cantidad'] <= $stock['stock_minimo'] ? 'text-red-600' : 'text-green-600' ?>">
                                        <?= $stock['cantidad'] ?>
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center text-gray-600"><?= $stock['stock_minimo'] ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            
        </div>
        
        <!-- Sidebar -->
        <div class="space-y-6">
            
            <!-- Stock Total -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4"><i class="fas fa-boxes mr-2 text-primary"></i>Stock Total</h3>
                <div class="text-center">
                    <p class="text-5xl font-bold <?= $stock_total > 10 ? 'text-green-600' : ($stock_total > 0 ? 'text-yellow-600' : 'text-red-600') ?>">
                        <?= $stock_total ?>
                    </p>
                    <p class="text-sm text-gray-500 mt-2">unidades disponibles</p>
                </div>
            </div>
            
            <!-- Características Físicas -->
            <?php if ($producto['peso'] || $producto['dimensiones']): ?>
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4"><i class="fas fa-ruler mr-2 text-primary"></i>Características</h3>
                <div class="space-y-2">
                    <?php if ($producto['peso']): ?>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Peso:</span>
                        <span class="font-semibold"><?= $producto['peso'] ?> kg</span>
                    </div>
                    <?php endif; ?>
                    <?php if ($producto['dimensiones']): ?>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Dimensiones:</span>
                        <span class="font-semibold"><?= htmlspecialchars($producto['dimensiones']) ?></span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
            
        </div>
    </div>
    
</div>
