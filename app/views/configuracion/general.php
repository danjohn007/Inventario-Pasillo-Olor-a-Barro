<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-cog mr-3 text-primary"></i>Configuración General
        </h1>
        <p class="mt-1 text-sm text-gray-600">Configuración básica del sistema</p>
    </div>
    
    <!-- Navigation Tabs -->
    <div class="mb-6 border-b border-gray-200">
        <nav class="-mb-px flex space-x-8">
            <a href="<?= BASE_URL ?>configuracion/general" class="border-primary text-primary whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                General
            </a>
            <a href="<?= BASE_URL ?>configuracion/email" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Email
            </a>
            <a href="<?= BASE_URL ?>configuracion/integraciones" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Integraciones
            </a>
        </nav>
    </div>
    
    <form method="POST" action="<?= BASE_URL ?>configuracion/general" class="bg-white shadow-lg rounded-lg p-8">
        
        <!-- Sitio -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-4 text-gray-800 border-b pb-2">
                <i class="fas fa-globe mr-2 text-primary"></i>Información del Sitio
            </h2>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Nombre del Sitio</label>
                <input type="text" name="sitio_nombre" value="<?= htmlspecialchars($configs['sitio_nombre'] ?? SITE_NAME) ?>" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
            </div>
        </div>
        
        <!-- Apariencia -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-4 text-gray-800 border-b pb-2">
                <i class="fas fa-palette mr-2 text-primary"></i>Apariencia
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Color Primario</label>
                    <input type="color" name="color_primario" value="<?= htmlspecialchars($configs['color_primario'] ?? '#8B4513') ?>" 
                           class="w-full h-12 border border-gray-300 rounded-lg">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Color Secundario</label>
                    <input type="color" name="color_secundario" value="<?= htmlspecialchars($configs['color_secundario'] ?? '#D2691E') ?>" 
                           class="w-full h-12 border border-gray-300 rounded-lg">
                </div>
            </div>
        </div>
        
        <!-- Ventas -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-4 text-gray-800 border-b pb-2">
                <i class="fas fa-dollar-sign mr-2 text-primary"></i>Configuración de Ventas
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Porcentaje de IVA (%)</label>
                    <input type="number" name="iva_porcentaje" step="0.01" value="<?= htmlspecialchars($configs['iva_porcentaje'] ?? '16') ?>" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Puntos por Peso Gastado</label>
                    <input type="number" name="puntos_por_peso" step="0.01" value="<?= htmlspecialchars($configs['puntos_por_peso'] ?? '1') ?>" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                </div>
            </div>
        </div>
        
        <div class="flex justify-end gap-4">
            <a href="<?= BASE_URL ?>home/dashboard" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                <i class="fas fa-times mr-2"></i>Cancelar
            </a>
            <button type="submit" class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-secondary transition">
                <i class="fas fa-save mr-2"></i>Guardar Cambios
            </button>
        </div>
    </form>
    
</div>
