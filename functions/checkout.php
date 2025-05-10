<?php
include 'auth.php';
include '../includes/db.php';

if (!isset($_SESSION['id_usuario'])) {
  header("Location: ../pages/login.php");
  exit;
}

$id_usuario = $_SESSION['id_usuario'];
$fecha_actual = date('Y-m-d H:i:s');

// Obtener todos los productos del carrito
$query = "
  SELECT c.id_comic, c.cantidad, co.cantidad AS stock
  FROM carrito c
  JOIN comics co ON c.id_comic = co.id_comic
  WHERE c.id_usuario = $id_usuario
";

$resultado = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($resultado)) {
  $id_comic = $row['id_comic'];
  $cantidad = $row['cantidad'];
  $stock = $row['stock'];

  // Evitar compras que superen el stock
  if ($cantidad > $stock) {
    $cantidad = $stock;
  }

  // Insertar en historial
  $stmt = mysqli_prepare($conn, "INSERT INTO historial_compras (id_usuario, id_comic, cantidad, fecha_compra) VALUES (?, ?, ?, ?)");
  mysqli_stmt_bind_param($stmt, "iiis", $id_usuario, $id_comic, $cantidad, $fecha_actual);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);

  // Restar del inventario
  $stmt = mysqli_prepare($conn, "UPDATE comics SET cantidad = cantidad - ? WHERE id_comic = ?");
  mysqli_stmt_bind_param($stmt, "ii", $cantidad, $id_comic);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
}

// Vaciar carrito
$stmt = mysqli_prepare($conn, "DELETE FROM carrito WHERE id_usuario = ?");
mysqli_stmt_bind_param($stmt, "i", $id_usuario);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

// Redirigir al catálogo con mensaje de éxito
header("Location: ../pages/catalog.php?checkout=success");
exit;
