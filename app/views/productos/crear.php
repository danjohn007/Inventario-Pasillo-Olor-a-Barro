<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-plus-circle mr-3 text-primary"></i>Crear Nuevo Producto
        </h1>
        <p class="mt-1 text-sm text-gray-600">
            Registra un nuevo producto artesanal en el catálogo
        </p>
    </div>
    
    <!-- Form -->
    <form method="POST" action="<?= BASE_URL ?>productos/crear" class="bg-white shadow-lg rounded-lg p-8">
        
        <!-- Información Básica -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-4 text-gray-800 border-b pb-2">
                <i class="fas fa-info-circle mr-2 text-primary"></i>Información Básica
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">SKU *</label>
                    <input type="text" name="sku" required 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"
                           placeholder="Ej: MUÑ-OTOMI-001">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Categoría</label>
                    <select name="categoria_id" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                        <option value="">Seleccionar categoría</option>
                        <?php foreach ($categorias as $cat): ?>
                        <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['nombre']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Nombre del Producto *</label>
                <input type="text" name="nombre" required 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"
                       placeholder="Ej: Muñeca Otomí Grande">
            </div>
            
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Descripción</label>
                <textarea name="descripcion" rows="3"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"
                          placeholder="Descripción detallada del producto"></textarea>
            </div>
        </div>
        
        <!-- Precios -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-4 text-gray-800 border-b pb-2">
                <i class="fas fa-dollar-sign mr-2 text-primary"></i>Precios
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Precio de Compra *</label>
                    <input type="number" name="precio_compra" step="0.01" min="0" required 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"
                           placeholder="0.00">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Precio de Venta *</label>
                    <input type="number" name="precio_venta" step="0.01" min="0" required 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"
                           placeholder="0.00">
                </div>
            </div>
        </div>
        
        <!-- Información Artesanal -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-4 text-gray-800 border-b pb-2">
                <i class="fas fa-palette mr-2 text-primary"></i>Información Artesanal
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Proveedor/Artesano</label>
                    <select name="proveedor_id" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                        <option value="">Seleccionar proveedor</option>
                        <?php foreach ($proveedores as $prov): ?>
                        <option value="<?= $prov['id'] ?>">
                            <?= htmlspecialchars($prov['nombre']) ?> - <?= htmlspecialchars($prov['tipo']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Región de Origen</label>
                    <input type="text" name="region_origen" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"
                           placeholder="Ej: Amealco de Bonfil, Qro">
                </div>
            </div>
            
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Materiales</label>
                <textarea name="materiales" rows="2"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"
                          placeholder="Ej: Tela de algodón, hilos de colores, relleno natural"></textarea>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Técnica</label>
                    <input type="text" name="tecnica" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"
                           placeholder="Ej: Bordado tradicional otomí">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tiempo de Elaboración</label>
                    <input type="text" name="tiempo_elaboracion" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"
                           placeholder="Ej: 15-20 días">
                </div>
            </div>
        </div>
        
        <!-- Características Físicas -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-4 text-gray-800 border-b pb-2">
                <i class="fas fa-ruler mr-2 text-primary"></i>Características Físicas
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Peso (kg)</label>
                    <input type="number" name="peso" step="0.01" min="0" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"
                           placeholder="0.00">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Dimensiones</label>
                    <input type="text" name="dimensiones" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"
                           placeholder="Ej: 30cm x 20cm x 15cm">
                </div>
            </div>
        </div>
        
        <!-- Opciones Especiales -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-4 text-gray-800 border-b pb-2">
                <i class="fas fa-star mr-2 text-primary"></i>Opciones Especiales
            </h2>
            
            <div class="space-y-4">
                <div class="flex items-center">
                    <input type="checkbox" name="edicion_limitada" id="edicion_limitada" 
                           class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                    <label for="edicion_limitada" class="ml-2 block text-sm text-gray-900">
                        Producto de edición limitada
                    </label>
                </div>
                
                <div id="unidades_limitadas_container" class="ml-6 hidden">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Unidades Limitadas</label>
                    <input type="number" name="unidades_limitadas" min="1" 
                           class="w-full md:w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                </div>
                
                <div class="flex items-center">
                    <input type="checkbox" name="requiere_certificado" id="requiere_certificado" 
                           class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                    <label for="requiere_certificado" class="ml-2 block text-sm text-gray-900">
                        Requiere certificado de autenticidad
                    </label>
                </div>
            </div>
        </div>
        
        <!-- Buttons -->
        <div class="flex justify-end gap-4">
            <a href="<?= BASE_URL ?>productos" 
               class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                <i class="fas fa-times mr-2"></i>Cancelar
            </a>
            <button type="submit" 
                    class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-secondary transition">
                <i class="fas fa-save mr-2"></i>Guardar Producto
            </button>
        </div>
    </form>
    
</div>

<script>
// Mostrar/ocultar campo de unidades limitadas
document.getElementById('edicion_limitada').addEventListener('change', function() {
    const container = document.getElementById('unidades_limitadas_container');
    if (this.checked) {
        container.classList.remove('hidden');
    } else {
        container.classList.add('hidden');
    }
});
</script>
