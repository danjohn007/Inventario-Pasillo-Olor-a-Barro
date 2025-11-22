<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-chart-bar mr-3 text-primary"></i>Reportes y Análisis
        </h1>
        <p class="mt-1 text-sm text-gray-600">Dashboard de análisis y estadísticas</p>
    </div>
    
    <!-- Charts Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        
        <!-- Ventas Mensuales -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">
                <i class="fas fa-chart-line mr-2 text-primary"></i>Ventas Mensuales
            </h2>
            <canvas id="ventasMesChart"></canvas>
        </div>
        
        <!-- Ventas por Sucursal -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">
                <i class="fas fa-building mr-2 text-primary"></i>Ventas por Sucursal (Este Mes)
            </h2>
            <canvas id="ventasSucursalChart"></canvas>
        </div>
        
        <!-- Top Productos -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">
                <i class="fas fa-trophy mr-2 text-yellow-500"></i>Productos Más Vendidos (Este Mes)
            </h2>
            <div class="space-y-3">
                <?php foreach (array_slice($top_productos, 0, 5) as $idx => $prod): ?>
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-primary text-white text-sm font-medium">
                            <?= $idx + 1 ?>
                        </span>
                        <div class="ml-3">
                            <p class="text-sm font-medium"><?= htmlspecialchars($prod['nombre']) ?></p>
                            <p class="text-xs text-gray-500"><?= $prod['total_vendido'] ?> unidades</p>
                        </div>
                    </div>
                    <span class="text-sm font-semibold text-green-600">$<?= number_format($prod['ingresos'], 2) ?></span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- Inventario por Categoría -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">
                <i class="fas fa-tags mr-2 text-primary"></i>Inventario por Categoría
            </h2>
            <canvas id="inventarioCategoriaChart"></canvas>
        </div>
        
    </div>
    
</div>

<script>
// Datos para gráficas
const ventasMesData = <?= json_encode($ventas_mes) ?>;
const ventasSucursalData = <?= json_encode($ventas_sucursal) ?>;
const inventarioCategoriaData = <?= json_encode($inventario_categoria) ?>;

// Gráfica de ventas mensuales
const ctxVentasMes = document.getElementById('ventasMesChart').getContext('2d');
new Chart(ctxVentasMes, {
    type: 'line',
    data: {
        labels: ventasMesData.map(item => item.mes),
        datasets: [{
            label: 'Ventas ($)',
            data: ventasMesData.map(item => item.total),
            borderColor: '#8B4513',
            backgroundColor: 'rgba(139, 69, 19, 0.1)',
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true
    }
});

// Gráfica de ventas por sucursal
const ctxVentasSucursal = document.getElementById('ventasSucursalChart').getContext('2d');
new Chart(ctxVentasSucursal, {
    type: 'bar',
    data: {
        labels: ventasSucursalData.map(item => item.nombre),
        datasets: [{
            label: 'Ingresos ($)',
            data: ventasSucursalData.map(item => item.ingresos),
            backgroundColor: '#D2691E'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true
    }
});

// Gráfica de inventario por categoría
const ctxInventarioCategoria = document.getElementById('inventarioCategoriaChart').getContext('2d');
new Chart(ctxInventarioCategoria, {
    type: 'doughnut',
    data: {
        labels: inventarioCategoriaData.map(item => item.nombre),
        datasets: [{
            data: inventarioCategoriaData.map(item => item.stock_total),
            backgroundColor: [
                '#8B4513',
                '#D2691E',
                '#CD853F',
                '#DEB887',
                '#F4A460',
                '#D2B48C'
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true
    }
});
</script>
