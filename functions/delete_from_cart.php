<?php
include 'auth.php';
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Validar ID recibido
  if (isset($_POST['id_carrito']) && is_numeric($_POST['id_carrito'])) {
    $id_carrito = (int) $_POST['id_carrito'];

    // Eliminar el item del carrito
    $stmt = mysqli_prepare($conn, "DELETE FROM carrito WHERE id_carrito = ?");
    mysqli_stmt_bind_param($stmt, "i", $id_carrito);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
  }
}

// Volver al carrito (o a donde venga el usuario)
$redirect = $_SERVER['HTTP_REFERER'] ?? '../pages/cart.php';
header("Location: $redirect");
exit;
