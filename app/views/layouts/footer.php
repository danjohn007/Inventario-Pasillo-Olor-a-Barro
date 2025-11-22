    </main>
    
    <!-- Footer -->
    <footer class="bg-white mt-12 shadow-lg">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-gray-600 text-sm">
                        &copy; <?= date('Y') ?> <?= SITE_NAME ?>. Todos los derechos reservados.
                    </p>
                    <p class="text-gray-500 text-xs mt-1">
                        Sistema de Inventario Multisucursal v<?= SITE_VERSION ?>
                    </p>
                </div>
                <div class="flex space-x-6">
                    <a href="#" class="text-gray-400 hover:text-gray-500">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-gray-500">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-gray-500">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>
    
    <script>
        // JavaScript global
        const BASE_URL = '<?= BASE_URL ?>';
        
        // Auto-ocultar mensajes después de 5 segundos
        setTimeout(() => {
            const alerts = document.querySelectorAll('[role="alert"]');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);
    </script>
</body>
</html>
