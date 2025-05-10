<?php
$host = "localhost";
$user = "root";
$pass = "root";
$db = "tienda_comics";

// Crear conexión
$conn = mysqli_connect($host, $user, $pass, $db);

// Verificar conexión
if (!$conn) {
  die("Conexión fallida: " . mysqli_connect_error());
}
?>
