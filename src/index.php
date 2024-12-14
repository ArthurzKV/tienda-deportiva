<?php
require __DIR__ . '/vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$key = "tu_secreto";

// Verificar la existencia del token JWT
if (!isset($_COOKIE['token'])) {
    header("Location: login.php");
    exit;
}

// Validar el token JWT
try {
    $decoded = JWT::decode($_COOKIE['token'], new Key($key, 'HS256'));
    $userRole = $decoded->tipo ?? 'user'; // Obtener el tipo de usuario del token
} catch (Exception $e) {
    header("Location: login.php");
    exit;
}

// Manejar el cierre de sesión
if (isset($_GET['logout'])) {
    setcookie('token', '', time() - 3600, '/'); // Elimina la cookie del token
    header("Location: login.php");
    exit;
}

// Conectar a la base de datos
$conexion = new mysqli("db", "root", "root", "tienda");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda Deportiva en Línea</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Incluir Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-r from-blue-100 via-white to-blue-100 flex flex-col min-h-screen">
    <!-- Encabezado -->
    <header class="bg-blue-600 text-white shadow-lg">
        <div class="container mx-auto p-4 flex justify-between items-center">
            <h1 class="text-3xl font-bold">Tienda Deportiva</h1>
            <div class="flex items-center space-x-6">
                <!-- Ícono del carrito -->
                <a href="ver_carrito.php" class="relative">
                    <i class="fas fa-shopping-cart text-2xl"></i>
                </a>
                <!-- Botón para Admin -->
                <?php if ($userRole === 'admin'): ?>
                    <a href="admin.php" class="bg-yellow-500 hover:bg-yellow-600 text-black px-4 py-2 rounded shadow">Panel Admin</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <!-- Lista de productos -->
    <main class="container mx-auto p-6 flex-grow">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php
            $sql = "SELECT * FROM productos";
            $result = $conexion->query($sql);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden transform hover:scale-105 transition-transform">
                        <img src="<?= htmlspecialchars($row['imagen']) ?>" alt="<?= htmlspecialchars($row['nombre']) ?>"
                             class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h2 class="text-xl font-bold text-gray-700">
                                <?= htmlspecialchars($row['nombre']) ?>
                            </h2>
                            <p class="text-gray-500 text-sm">
                                <?= htmlspecialchars($row['descripcion']) ?>
                            </p>
                            <p class="text-lg font-bold mt-2 text-green-600">
                                $<?= htmlspecialchars($row['precio']) ?>
                            </p>
                            <form method="POST" action="carrito.php" class="mt-4">
                                <input type="hidden" name="producto_id" value="<?= htmlspecialchars($row['id']) ?>">
                                <input type="number" name="cantidad" min="1" max="<?= htmlspecialchars($row['stock']) ?>" value="1"
                                       class="w-full border border-gray-300 rounded p-2 mb-2">
                                <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded shadow">
                                    Añadir al Carrito
                                </button>
                            </form>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<p class='text-center text-gray-500'>No hay productos disponibles.</p>";
            }

            $conexion->close();
            ?>
        </div>
    </main>

    <!-- Botón de Cerrar Sesión -->
    <footer class="bg-gray-200">
        <div class="container mx-auto p-4 text-left">
            <a href="?logout=true" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded shadow">
                Cerrar Sesión
            </a>
        </div>
    </footer>
</body>
</html>
