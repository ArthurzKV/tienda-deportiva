<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Producto</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold text-center mb-6">Modificar Producto</h1>
        <?php
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
        

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $sql = "SELECT * FROM productos WHERE id=$id";
            $result = $conexion->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                ?>
                <form method="POST" action="modificar.php">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                            <input type="text" name="nombre" id="nombre" value="<?php echo $row['nombre']; ?>" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
                            <input type="text" name="descripcion" id="descripcion" value="<?php echo $row['descripcion']; ?>" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label for="precio" class="block text-sm font-medium text-gray-700">Precio</label>
                            <input type="number" name="precio" id="precio" value="<?php echo $row['precio']; ?>" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label for="stock" class="block text-sm font-medium text-gray-700">Stock</label>
                            <input type="number" name="stock" id="stock" value="<?php echo $row['stock']; ?>" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label for="imagen" class="block text-sm font-medium text-gray-700">Imagen</label>
                            <input type="text" name="imagen" id="imagen" value="<?php echo $row['imagen']; ?>" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                    </div>
                    <div class="mt-4 flex justify-between">
                        <input type="submit" name="modificar" value="Modificar" class="bg-yellow-500 text-white px-4 py-2 rounded">
                        <a href="admin.php" class="bg-blue-500 text-white px-4 py-2 rounded">Cancelar</a>
                    </div>
                </form>
                <?php
            } else {
                echo "<p class='text-center text-red-500'>Producto no encontrado.</p>";
            }
        }

        if (isset($_POST['modificar'])) {
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $precio = $_POST['precio'];
            $stock = $_POST['stock'];
            $imagen = $_POST['imagen'];

            $sql = "UPDATE productos SET nombre='$nombre', descripcion='$descripcion', precio=$precio, stock=$stock, imagen='$imagen' 
                    WHERE id=$id";
            if ($conexion->query($sql) === TRUE) {
                echo "<script>alert('Producto modificado con éxito'); window.location.href='admin.php';</script>";
            } else {
                echo "<p class='text-center text-red-500'>Error al modificar el producto: " . $conexion->error . "</p>";
            }
        }

        $conexion->close();
        ?>
    </div>
</body>
</html>