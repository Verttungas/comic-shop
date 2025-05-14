<?php
include 'auth.php';
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Validar entrada
  if (
    isset($_POST['id_carrito'], $_POST['cantidad']) &&
    is_numeric($_POST['id_carrito']) &&
    is_numeric($_POST['cantidad'])
  ) {
    $id_carrito = (int) $_POST['id_carrito'];
    $cantidad = (int) $_POST['cantidad'];

    // Asegurar que la cantidad sea al menos 1
    $cantidad = max($cantidad, 1);

    $stmt = mysqli_prepare($conn, "UPDATE carrito SET cantidad = ? WHERE id_carrito = ?");
    mysqli_stmt_bind_param($stmt, "ii", $cantidad, $id_carrito);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
  }
}

// Redirigir de vuelta a donde el usuario estaba
$redirect = $_SERVER['HTTP_REFERER'] ?? '../pages/cart.php';
header("Location: $redirect");
exit;
