<?php
include '../functions/auth.php';
include '../includes/db.php';

if (!isset($_SESSION['id_usuario'])) {
  header("Location: ../pages/login.php");
  exit;
}

$id_usuario = $_SESSION['id_usuario'];
$id_comic = $_POST['id_comic'];
$cantidad = $_POST['cantidad'];

// Verificar si ya existe ese cómic en el carrito
$stmt = mysqli_prepare($conn, "SELECT cantidad FROM carrito WHERE id_usuario = ? AND id_comic = ?");
mysqli_stmt_bind_param($stmt, "ii", $id_usuario, $id_comic);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

if (mysqli_stmt_num_rows($stmt) > 0) {
  // Ya existe → actualizar cantidad
  mysqli_stmt_close($stmt);
  $stmt = mysqli_prepare($conn, "UPDATE carrito SET cantidad = cantidad + ? WHERE id_usuario = ? AND id_comic = ?");
  mysqli_stmt_bind_param($stmt, "iii", $cantidad, $id_usuario, $id_comic);
  mysqli_stmt_execute($stmt);
} else {
  // No existe → insertar
  mysqli_stmt_close($stmt);
  $stmt = mysqli_prepare($conn, "INSERT INTO carrito (id_usuario, id_comic, cantidad) VALUES (?, ?, ?)");
  mysqli_stmt_bind_param($stmt, "iii", $id_usuario, $id_comic, $cantidad);
  mysqli_stmt_execute($stmt);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);

// Redirigir de vuelta a la página de origen
$redirect = $_SERVER['HTTP_REFERER'] ?? '../pages/catalog.php';
header("Location: $redirect");
exit;
