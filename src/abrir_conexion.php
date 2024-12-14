<?php
$servername = "db";
$username = "root";
$password = "root";
$dbname = "mydatabase";

$conexion = new mysqli($servername, $username, $password, $dbname);

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}
?>