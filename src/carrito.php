<?php
// $conexion = new mysqli("db", "root", "root", "tienda");
$host = getenv('DB_HOST') ?: 'db'; // Usa 'db' como fallback en local
$user = getenv('DB_USER') ?: 'root';
$password = getenv('DB_PASSWORD') ?: 'root';
$database = getenv('DB_NAME') ?: 'tienda';

$conexion = new mysqli($host, $user, $password, $database);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}


if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $producto_id = intval($_POST['producto_id']);
    $cantidad = intval($_POST['cantidad']);

    // Verificar el stock disponible del producto
    $sql_stock = "SELECT stock FROM productos WHERE id = ?";
    $stmt_stock = $conexion->prepare($sql_stock);
    $stmt_stock->bind_param("i", $producto_id);
    $stmt_stock->execute();
    $stmt_stock->bind_result($stock_disponible);
    $stmt_stock->fetch();
    $stmt_stock->close();

    if ($cantidad > $stock_disponible) {
        // Si la cantidad solicitada excede el stock disponible
        echo "<script>alert('No hay suficiente stock disponible para este producto.'); window.location.href='index.php';</script>";
        exit();
    }

    // Verificar si el producto ya está en el carrito
    $sql_check = "SELECT cantidad FROM carrito WHERE producto_id = ?";
    $stmt = $conexion->prepare($sql_check);
    $stmt->bind_param("i", $producto_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Si el producto ya está en el carrito, actualiza la cantidad
        $stmt->bind_result($cantidad_existente);
        $stmt->fetch();
        $nueva_cantidad = $cantidad_existente + $cantidad;

        if ($nueva_cantidad > $stock_disponible) {
            // Si la cantidad total en el carrito excede el stock disponible
            echo "<script>alert('No puedes agregar más de la cantidad disponible en stock.'); window.location.href='index.php';</script>";
            exit();
        }

        $sql_update = "UPDATE carrito SET cantidad = ? WHERE producto_id = ?";
        $stmt_update = $conexion->prepare($sql_update);
        $stmt_update->bind_param("ii", $nueva_cantidad, $producto_id);
        $stmt_update->execute();
        $stmt_update->close();
    } else {
        // Si el producto no está en el carrito, inserta un nuevo registro
        $sql_insert = "INSERT INTO carrito (producto_id, cantidad) VALUES (?, ?)";
        $stmt_insert = $conexion->prepare($sql_insert);
        $stmt_insert->bind_param("ii", $producto_id, $cantidad);
        $stmt_insert->execute();
        $stmt_insert->close();
    }

    $stmt->close();

    // Redirigir al carrito
    header("Location: ver_carrito.php");
    exit();
}

$conexion->close();
?>
