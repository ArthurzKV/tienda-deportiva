<?php
// require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/vendor/autoload.php';
use Firebase\JWT\JWT;

$key = "tu_secreto";
// $conexion = new mysqli("db", "root", "root", "tienda");
$conexion = new mysqli(
    getenv('MYSQLHOST') ?: 'localhost',
    getenv('MYSQLUSER') ?: 'root',
    getenv('MYSQLPASSWORD') ?: 'root',
    getenv('MYSQLDATABASE') ?: 'railway'
);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $conexion->prepare("SELECT id, password, tipo FROM usuarios WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($id, $hash_password, $tipo);
    $stmt->fetch();
    $stmt->close();

    if ($id && password_verify($password, $hash_password)) {
        $token = JWT::encode(['id' => $id, 'tipo' => $tipo, 'exp' => time() + 3600], $key, 'HS256');
        setcookie('token', $token, time() + 3600, "/", "", false, true);
        header("Location: index.php");
        exit;
    } else {
        $error = "Usuario o contraseña incorrectos";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white border-black border-2 rounded-lg shadow-lg p-6 w-full max-w-sm">
        <img src="https://i.imgur.com/thjHzQy.png" alt="Logo" class="w-24 h-24 mx-auto mb-4">
        <h1 class="text-2xl font-bold text-center mb-6">Iniciar Sesión</h1>
        <?php if (isset($error)): ?>
            <p class="text-red-500 text-center mb-4"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-4">
                <label for="username" class="block text-sm font-bold mb-2">Usuario</label>
                <input type="text" id="username" name="username" required class="w-full border border-gray-300 rounded-lg p-2">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-bold mb-2">Contraseña</label>
                <input type="password" id="password" name="password" required class="w-full border border-gray-300 rounded-lg p-2">
            </div>
            <button type="submit" class="bg-blue-500 text-white w-full py-2 rounded-lg">Iniciar Sesión</button>
        </form>
        <p class="text-sm text-center mt-4">¿No tienes cuenta? <a href="registro.php" class="text-blue-500">Regístrate</a></p>
    </div>
</body>
</html>
