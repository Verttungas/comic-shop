<?php
include 'auth.php';
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id_carrito = $_POST['id_carrito'];
  $cantidad = $_POST['cantidad'];

  // Validar cantidad
  if ($cantidad < 1) {
    $cantidad = 1;
  }

  $stmt = mysqli_prepare($conn, "UPDATE carrito SET cantidad = ? WHERE id_carrito = ?");
  mysqli_stmt_bind_param($stmt, "ii", $cantidad, $id_carrito);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
}

header("Location: ../pages/cart.php");
exit;
