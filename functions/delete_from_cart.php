<?php
include 'auth.php';
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id_carrito = $_POST['id_carrito'];

  $stmt = mysqli_prepare($conn, "DELETE FROM carrito WHERE id_carrito = ?");
  mysqli_stmt_bind_param($stmt, "i", $id_carrito);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
}

header("Location: ../pages/cart.php");
exit;
