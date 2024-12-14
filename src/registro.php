<?php
// require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/vendor/autoload.php';

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
    $tipo = $_POST['tipo'] ?? 'user';

    if (empty($username) || empty($password)) {
        $error = "Por favor, completa todos los campos.";
    } else {
        $stmt = $conexion->prepare("SELECT id FROM usuarios WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $error = "El usuario ya existe.";
        } else {
            $stmt->close();

            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $conexion->prepare("INSERT INTO usuarios (username, password, tipo) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $hashed_password, $tipo);

            if ($stmt->execute()) {
                $success = "Usuario registrado exitosamente. Ahora puedes iniciar sesión.";
            } else {
                $error = "Error al registrar el usuario.";
            }
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white border-black border-2 rounded-lg shadow-lg p-6 w-full max-w-sm">
        <img src="logo.png" alt="Logo" class="w-24 h-24 mx-auto mb-4">
        <h1 class="text-2xl font-bold text-center mb-6">Crear Cuenta</h1>
        <?php if (isset($error)): ?>
            <p class="text-red-500 text-center mb-4"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <?php if (isset($success)): ?>
            <p class="text-green-500 text-center mb-4"><?= htmlspecialchars($success) ?></p>
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
            <div class="mb-4">
                <label for="tipo" class="block text-sm font-bold mb-2">Tipo de Usuario</label>
                <select id="tipo" name="tipo" class="w-full border border-gray-300 rounded-lg p-2">
                    <option value="user">Usuario</option>
                    <option value="admin">Administrador</option>
                </select>
            </div>
            <button type="submit" class="bg-blue-500 text-white w-full py-2 rounded-lg">Registrarse</button>
        </form>
        <p class="text-sm text-center mt-4">¿Ya tienes cuenta? <a href="login.php" class="text-blue-500">Inicia sesión</a></p>
    </div>
</body>
</html>
