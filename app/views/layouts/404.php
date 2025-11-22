<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página no encontrada - <?= SITE_NAME ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center">
        <div class="text-center">
            <h1 class="text-9xl font-bold text-gray-300">404</h1>
            <h2 class="text-3xl font-semibold text-gray-700 mt-4">Página no encontrada</h2>
            <p class="text-gray-500 mt-2">Lo sentimos, la página que buscas no existe.</p>
            <a href="<?= BASE_URL ?>" class="mt-6 inline-block px-6 py-3 bg-primary text-white rounded-lg hover:bg-secondary transition">
                <i class="fas fa-home mr-2"></i>Volver al inicio
            </a>
        </div>
    </div>
</body>
</html>
