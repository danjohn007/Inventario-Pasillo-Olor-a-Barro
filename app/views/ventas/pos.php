<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-cash-register mr-3 text-green-500"></i>Punto de Venta (POS)
        </h1>
        <p class="mt-1 text-sm text-gray-600">Registra una nueva venta</p>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Products Section -->
        <div class="lg:col-span-2">
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h2 class="text-xl font-semibold mb-4">
                    <i class="fas fa-box mr-2 text-primary"></i>Productos
                </h2>
                
                <!-- Search -->
                <div class="mb-4">
                    <input type="text" id="searchProduct" placeholder="Buscar producto..." 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                </div>
                
                <!-- Products Grid -->
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 max-h-96 overflow-y-auto">
                    <?php foreach ($productos as $prod): ?>
                    <div class="border border-gray-200 rounded-lg p-3 hover:border-primary cursor-pointer transition product-item"
                         data-id="<?= $prod['id'] ?>"
                         data-nombre="<?= htmlspecialchars($prod['nombre']) ?>"
                         data-sku="<?= htmlspecialchars($prod['sku']) ?>"
                         data-precio="<?= $prod['precio_venta'] ?>"
                         data-stock="<?= $prod['stock_total'] ?>"
                         onclick="addToCart(this)">
                        <div class="text-center">
                            <div class="bg-gray-100 h-20 flex items-center justify-center rounded mb-2">
                                <i class="fas fa-box text-3xl text-gray-400"></i>
                            </div>
                            <p class="text-sm font-medium text-gray-900 mb-1"><?= htmlspecialchars($prod['nombre']) ?></p>
                            <p class="text-xs text-gray-500 mb-2"><?= htmlspecialchars($prod['sku']) ?></p>
                            <p class="text-lg font-bold text-primary">$<?= number_format($prod['precio_venta'], 2) ?></p>
                            <p class="text-xs text-gray-500">Stock: <?= $prod['stock_total'] ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        
        <!-- Cart Section -->
        <div>
            <div class="bg-white shadow-lg rounded-lg p-6 sticky top-4">
                <h2 class="text-xl font-semibold mb-4">
                    <i class="fas fa-shopping-cart mr-2 text-green-500"></i>Carrito
                </h2>
                
                <!-- Cart Items -->
                <div id="cartItems" class="space-y-2 mb-4 max-h-64 overflow-y-auto">
                    <p class="text-gray-500 text-sm text-center py-8">Carrito vacío</p>
                </div>
                
                <!-- Totals -->
                <div class="border-t pt-4 space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Subtotal:</span>
                        <span id="subtotal" class="font-semibold">$0.00</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">IVA (16%):</span>
                        <span id="iva" class="font-semibold">$0.00</span>
                    </div>
                    <div class="flex justify-between text-lg font-bold border-t pt-2">
                        <span>Total:</span>
                        <span id="total" class="text-green-600">$0.00</span>
                    </div>
                </div>
                
                <!-- Payment Method -->
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Método de Pago</label>
                    <select id="metodoPago" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                        <option value="efectivo">Efectivo</option>
                        <option value="tarjeta">Tarjeta</option>
                        <option value="transferencia">Transferencia</option>
                    </select>
                </div>
                
                <!-- Cliente -->
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cliente (Opcional)</label>
                    <select id="cliente" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                        <option value="">Cliente general</option>
                        <?php foreach ($clientes as $cliente): ?>
                        <option value="<?= $cliente['id'] ?>">
                            <?= htmlspecialchars($cliente['nombre']) ?>
                            <?php if ($cliente['puntos_fidelidad'] > 0): ?>
                            (<?= $cliente['puntos_fidelidad'] ?> pts)
                            <?php endif; ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <!-- Actions -->
                <div class="mt-6 space-y-2">
                    <button onclick="processSale()" 
                            class="w-full px-6 py-3 bg-green-500 text-white rounded-lg hover:bg-green-600 transition font-semibold">
                        <i class="fas fa-check mr-2"></i>Procesar Venta
                    </button>
                    <button onclick="clearCart()" 
                            class="w-full px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                        <i class="fas fa-trash mr-2"></i>Limpiar
                    </button>
                </div>
            </div>
        </div>
        
    </div>
    
</div>

<script>
let cart = [];

function addToCart(element) {
    const producto = {
        id: element.dataset.id,
        nombre: element.dataset.nombre,
        sku: element.dataset.sku,
        precio: parseFloat(element.dataset.precio),
        stock: parseInt(element.dataset.stock),
        cantidad: 1
    };
    
    // Verificar si ya existe en el carrito
    const existing = cart.find(item => item.id === producto.id);
    if (existing) {
        if (existing.cantidad < producto.stock) {
            existing.cantidad++;
        } else {
            alert('No hay suficiente stock');
            return;
        }
    } else {
        cart.push(producto);
    }
    
    updateCart();
}

function removeFromCart(id) {
    cart = cart.filter(item => item.id !== id);
    updateCart();
}

function updateQuantity(id, delta) {
    const item = cart.find(item => item.id === id);
    if (item) {
        item.cantidad += delta;
        if (item.cantidad <= 0) {
            removeFromCart(id);
        } else if (item.cantidad > item.stock) {
            item.cantidad = item.stock;
            alert('No hay suficiente stock');
        }
        updateCart();
    }
}

function updateCart() {
    const cartItemsDiv = document.getElementById('cartItems');
    
    if (cart.length === 0) {
        cartItemsDiv.innerHTML = '<p class="text-gray-500 text-sm text-center py-8">Carrito vacío</p>';
    } else {
        cartItemsDiv.innerHTML = cart.map(item => `
            <div class="flex justify-between items-center p-2 bg-gray-50 rounded">
                <div class="flex-1">
                    <p class="text-sm font-medium">${item.nombre}</p>
                    <p class="text-xs text-gray-500">${item.sku}</p>
                </div>
                <div class="flex items-center gap-2">
                    <button onclick="updateQuantity('${item.id}', -1)" class="px-2 py-1 bg-gray-200 rounded hover:bg-gray-300">
                        <i class="fas fa-minus text-xs"></i>
                    </button>
                    <span class="font-semibold w-8 text-center">${item.cantidad}</span>
                    <button onclick="updateQuantity('${item.id}', 1)" class="px-2 py-1 bg-gray-200 rounded hover:bg-gray-300">
                        <i class="fas fa-plus text-xs"></i>
                    </button>
                    <button onclick="removeFromCart('${item.id}')" class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                </div>
            </div>
        `).join('');
    }
    
    // Calcular totales
    const subtotal = cart.reduce((sum, item) => sum + (item.precio * item.cantidad), 0);
    const iva = subtotal * 0.16;
    const total = subtotal + iva;
    
    document.getElementById('subtotal').textContent = '$' + subtotal.toFixed(2);
    document.getElementById('iva').textContent = '$' + iva.toFixed(2);
    document.getElementById('total').textContent = '$' + total.toFixed(2);
}

function clearCart() {
    if (confirm('¿Limpiar el carrito?')) {
        cart = [];
        updateCart();
    }
}

function processSale() {
    if (cart.length === 0) {
        alert('El carrito está vacío');
        return;
    }
    
    alert('Funcionalidad de venta en desarrollo.\n\nCarrito:\n' + 
          cart.map(item => `${item.nombre} x${item.cantidad}`).join('\n'));
}

// Search products
document.getElementById('searchProduct').addEventListener('input', function(e) {
    const search = e.target.value.toLowerCase();
    document.querySelectorAll('.product-item').forEach(item => {
        const nombre = item.dataset.nombre.toLowerCase();
        const sku = item.dataset.sku.toLowerCase();
        if (nombre.includes(search) || sku.includes(search)) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
});
</script>
