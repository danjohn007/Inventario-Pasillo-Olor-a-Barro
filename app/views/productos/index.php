<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <!-- Page Header -->
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">
                <i class="fas fa-box mr-3 text-primary"></i>Catálogo de Productos
            </h1>
            <?php if (isset($categoria_actual)): ?>
            <p class="mt-1 text-sm text-gray-600">
                Categoría: <?= htmlspecialchars($categoria_actual['nombre']) ?>
            </p>
            <?php endif; ?>
        </div>
        
        <?php if (in_array($_SESSION['user_role'], ['Administrador', 'Gerente'])): ?>
        <div>
            <a href="<?= BASE_URL ?>productos/crear" class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-secondary transition">
                <i class="fas fa-plus mr-2"></i>Nuevo Producto
            </a>
        </div>
        <?php endif; ?>
    </div>
    
    <!-- Search and Filter -->
    <div class="bg-white shadow-lg rounded-lg p-6 mb-8">
        <form method="GET" action="<?= BASE_URL ?>productos" class="flex gap-4">
            <div class="flex-1">
                <input type="text" name="search" value="<?= htmlspecialchars($search ?? '') ?>" 
                       placeholder="Buscar por nombre, SKU o descripción..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
            </div>
            <button type="submit" class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-secondary transition">
                <i class="fas fa-search mr-2"></i>Buscar
            </button>
            <?php if (!empty($search)): ?>
            <a href="<?= BASE_URL ?>productos" class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                <i class="fas fa-times mr-2"></i>Limpiar
            </a>
            <?php endif; ?>
        </form>
    </div>
    
    <!-- Categories -->
    <div class="bg-white shadow-lg rounded-lg p-6 mb-8">
        <h2 class="text-lg font-semibold mb-4">
            <i class="fas fa-tags mr-2 text-primary"></i>Categorías
        </h2>
        <div class="flex flex-wrap gap-2">
            <a href="<?= BASE_URL ?>productos" 
               class="px-4 py-2 <?= !isset($categoria_actual) ? 'bg-primary text-white' : 'bg-gray-200 text-gray-700' ?> rounded-lg hover:bg-secondary hover:text-white transition">
                Todas (<?= array_sum(array_column($categorias, 'total_productos')) ?>)
            </a>
            <?php foreach ($categorias as $cat): ?>
            <a href="<?= BASE_URL ?>productos/categoria/<?= $cat['id'] ?>" 
               class="px-4 py-2 <?= isset($categoria_actual) && $categoria_actual['id'] == $cat['id'] ? 'bg-primary text-white' : 'bg-gray-200 text-gray-700' ?> rounded-lg hover:bg-secondary hover:text-white transition">
                <?= htmlspecialchars($cat['nombre']) ?> (<?= $cat['total_productos'] ?>)
            </a>
            <?php endforeach; ?>
        </div>
    </div>
    
    <!-- Products Grid -->
    <?php if (empty($productos)): ?>
    <div class="bg-white shadow-lg rounded-lg p-12 text-center">
        <i class="fas fa-box-open text-6xl text-gray-300 mb-4"></i>
        <h3 class="text-xl font-semibold text-gray-600 mb-2">No se encontraron productos</h3>
        <p class="text-gray-500">Intenta con otra búsqueda o categoría</p>
    </div>
    <?php else: ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($productos as $producto): ?>
        <div class="bg-white shadow-lg rounded-lg overflow-hidden hover:shadow-xl transition">
            <div class="bg-gradient-to-br from-amber-100 to-orange-100 h-48 flex items-center justify-center">
                <i class="fas fa-image text-6xl text-gray-300"></i>
            </div>
            
            <div class="p-6">
                <div class="mb-2">
                    <span class="text-xs text-gray-500"><?= htmlspecialchars($producto['sku']) ?></span>
                    <?php if ($producto['edicion_limitada']): ?>
                    <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                        <i class="fas fa-star mr-1"></i>Edición Limitada
                    </span>
                    <?php endif; ?>
                </div>
                
                <h3 class="text-lg font-semibold text-gray-900 mb-2">
                    <?= htmlspecialchars($producto['nombre']) ?>
                </h3>
                
                <?php if ($producto['categoria_nombre']): ?>
                <p class="text-sm text-gray-600 mb-2">
                    <i class="fas fa-tag mr-1"></i><?= htmlspecialchars($producto['categoria_nombre']) ?>
                </p>
                <?php endif; ?>
                
                <?php if ($producto['region_origen']): ?>
                <p class="text-sm text-gray-600 mb-2">
                    <i class="fas fa-map-marker-alt mr-1"></i><?= htmlspecialchars($producto['region_origen']) ?>
                </p>
                <?php endif; ?>
                
                <div class="mt-4 flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-500">Precio</p>
                        <p class="text-xl font-bold text-primary">$<?= number_format($producto['precio_venta'], 2) ?></p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500">Stock</p>
                        <p class="text-lg font-semibold <?= $producto['stock_total'] > 10 ? 'text-green-600' : ($producto['stock_total'] > 0 ? 'text-yellow-600' : 'text-red-600') ?>">
                            <?= $producto['stock_total'] ?? 0 ?>
                        </p>
                    </div>
                </div>
                
                <div class="mt-4 flex gap-2">
                    <a href="<?= BASE_URL ?>productos/ver/<?= $producto['id'] ?>" 
                       class="flex-1 text-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                        <i class="fas fa-eye mr-1"></i>Ver
                    </a>
                    <?php if (in_array($_SESSION['user_role'], ['Administrador', 'Gerente'])): ?>
                    <a href="<?= BASE_URL ?>productos/editar/<?= $producto['id'] ?>" 
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
