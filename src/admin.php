<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Productos</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold text-center mb-6">Administrar Productos</h1>
        <form method="POST" action="admin.php" class="mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
                    <input type="text" name="descripcion" id="descripcion" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label for="precio" class="block text-sm font-medium text-gray-700">Precio</label>
                    <input type="number" name="precio" id="precio" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label for="stock" class="block text-sm font-medium text-gray-700">Stock</label>
                    <input type="number" name="stock" id="stock" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label for="imagen" class="block text-sm font-medium text-gray-700">Imagen</label>
                    <input type="text" name="imagen" id="imagen" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>
            </div>
            <div class="mt-4 flex justify-between">
                <input type="submit" name="agregar" value="Agregar" class="bg-green-500 text-white px-4 py-2 rounded">
            </div>
        </form>
        <table class="w-full bg-white rounded shadow">
            <thead>
                <tr>
                    <th class="border px-4 py-2">ID</th>
                    <th class="border px-4 py-2">Nombre</th>
                    <th class="border px-4 py-2">Descripción</th>
                    <th class="border px-4 py-2">Precio</th>
                    <th class="border px-4 py-2">Stock</th>
                    <th class="border px-4 py-2">Imagen</th>
                    <th class="border px-4 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $conexion = new mysqli("db", "root", "root", "tienda");

                if ($conexion->connect_error) {
                    die("Error de conexión: " . $conexion->connect_error);
                }

                if (isset($_POST['agregar'])) {
                    $nombre = $_POST['nombre'];
                    $descripcion = $_POST['descripcion'];
                    $precio = $_POST['precio'];
                    $stock = $_POST['stock'];
                    $imagen = $_POST['imagen'];

                    $sql = "INSERT INTO productos (nombre, descripcion, precio, stock, imagen) 
                            VALUES ('$nombre', '$descripcion', $precio, $stock, '$imagen')";
                    $conexion->query($sql);
                }

                if (isset($_GET['eliminar'])) {
                    $id = $_GET['eliminar'];
                    $sql = "DELETE FROM productos WHERE id=$id";
                    $conexion->query($sql);
                }

                $sql = "SELECT * FROM productos";
                $result = $conexion->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "
                        <tr>
                            <td class='border px-4 py-2'>{$row['id']}</td>
                            <td class='border px-4 py-2'>{$row['nombre']}</td>
                            <td class='border px-4 py-2'>{$row['descripcion']}</td>
                            <td class='border px-4 py-2'>\${$row['precio']}</td>
                            <td class='border px-4 py-2'>{$row['stock']}</td>
                            <td class='border px-4 py-2'>{$row['imagen']}</td>
                            <td class='border px-4 py-2'>
                                <a href='modificar.php?id={$row['id']}' class='bg-yellow-500 text-white px-2 py-1 rounded'>Modificar</a>
                                <a href='admin.php?eliminar={$row['id']}' class='bg-red-500 text-white px-2 py-1 rounded'>Eliminar</a>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7' class='text-center border px-4 py-2'>No hay productos disponibles.</td></tr>";
                }

                $conexion->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>