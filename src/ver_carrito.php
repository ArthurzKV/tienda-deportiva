<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Incluir Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-r from-green-100 via-white to-green-100 flex flex-col min-h-screen">
    <!-- Encabezado -->
    <header class="bg-green-600 text-white shadow-lg">
        <div class="container mx-auto p-4 flex justify-between items-center">
            <h1 class="text-3xl font-bold">Carrito de Compras</h1>
            <a href="index.php" class="text-white text-lg hover:text-gray-200">
                <i class="fas fa-store mr-2"></i> Regresar a la Tienda
            </a>
        </div>
    </header>

    <!-- Tabla de productos en el carrito -->
    <main class="container mx-auto p-6 flex-grow">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <table class="w-full">
                <thead class="bg-green-500 text-white">
                    <tr>
                        <th class="px-4 py-3 text-left">Producto</th>
                        <th class="px-4 py-3 text-left">Cantidad</th>
                        <th class="px-4 py-3 text-left">Precio</th>
                        <th class="px-4 py-3 text-left">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $conexion = new mysqli("db", "root", "root", "tienda");

                    if ($conexion->connect_error) {
                        die("Error de conexión: " . $conexion->connect_error);
                    }

                    $sql = "SELECT c.cantidad, p.id, p.nombre, p.precio, (c.cantidad * p.precio) AS subtotal 
                            FROM carrito c 
                            INNER JOIN productos p ON c.producto_id = p.id";
                    $result = $conexion->query($sql);

                    if ($result->num_rows > 0) {
                        $total = 0;
                        while ($row = $result->fetch_assoc()) {
                            echo "
                            <tr class='border-t'>
                                <td class='px-4 py-3'>{$row['nombre']}</td>
                                <td class='px-4 py-3'>{$row['cantidad']}</td>
                                <td class='px-4 py-3'>\${$row['precio']}</td>
                                <td class='px-4 py-3'>\${$row['subtotal']}</td>
                            </tr>";
                            $total += $row['subtotal'];
                        }
                        echo "
                        <tr class='border-t bg-green-100'>
                            <td colspan='3' class='px-4 py-3 text-right font-bold'>Total</td>
                            <td class='px-4 py-3'>\${$total}</td>
                        </tr>";
                    } else {
                        echo "<tr><td colspan='4' class='px-4 py-3 text-center'>El carrito está vacío.</td></tr>";
                    }

                    $conexion->close();
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Acciones del carrito -->
        <div class="mt-6 flex justify-between">
            <form method="POST" action="ver_carrito.php">
                <button type="submit" name="comprar" class="bg-green-500 text-white px-4 py-2 rounded shadow hover:bg-green-600">
                    <i class="fas fa-check mr-2"></i> Comprar
                </button>
            </form>
        </div>
    </main>

    <?php
    if (isset($_POST['comprar'])) {
        // $conexion = new mysqli("db", "root", "root", "tienda");
        $conexion = new mysqli(
            getenv('DB_HOST') ?: 'localhost',
            getenv('DB_USER') ?: 'root',
            getenv('DB_PASSWORD') ?: 'root',
            getenv('DB_NAME') ?: 'tienda'
        );
        
        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }
        

        $sql = "SELECT producto_id, cantidad FROM carrito";
        $result = $conexion->query($sql);

        while ($row = $result->fetch_assoc()) {
            $producto_id = $row['producto_id'];
            $cantidad = $row['cantidad'];

            $sql_update = "UPDATE productos SET stock = stock - $cantidad WHERE id = $producto_id";
            $conexion->query($sql_update);

            $sql_check = "SELECT stock FROM productos WHERE id = $producto_id";
            $result_check = $conexion->query($sql_check);
            $row_check = $result_check->fetch_assoc();

            if ($row_check['stock'] <= 0) {
                $sql_delete = "DELETE FROM productos WHERE id = $producto_id";
                $conexion->query($sql_delete);
            }
        }

        $sql_clear = "DELETE FROM carrito";
        $conexion->query($sql_clear);

        $conexion->close();

        echo "<script>alert('Compra realizada con éxito'); window.location.href='index.php';</script>";
    }
    ?>
</body>
</html>
