<?php
include 'auth.php';
include '../includes/db.php';

if (!isset($_SESSION['id_usuario'])) {
  header("Location: ../pages/login.php");
  exit;
}

$id_usuario = $_SESSION['id_usuario'];
$fecha_actual = date('Y-m-d H:i:s');

// Obtener productos del carrito
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

  // Evitar que la cantidad exceda el stock disponible
  $cantidad_final = min($cantidad, $stock);

  if ($cantidad_final > 0) {
    // Insertar en historial de compras
    $stmt = mysqli_prepare($conn, "INSERT INTO historial_compras (id_usuario, id_comic, cantidad, fecha_compra) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "iiis", $id_usuario, $id_comic, $cantidad_final, $fecha_actual);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // Actualizar stock en inventario
    $stmt = mysqli_prepare($conn, "UPDATE comics SET cantidad = cantidad - ? WHERE id_comic = ?");
    mysqli_stmt_bind_param($stmt, "ii", $cantidad_final, $id_comic);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
  }
}

// Vaciar carrito
$stmt = mysqli_prepare($conn, "DELETE FROM carrito WHERE id_usuario = ?");
mysqli_stmt_bind_param($stmt, "i", $id_usuario);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

// Redirigir con mensaje
header("Location: ../pages/catalog.php?checkout=success");
exit;
