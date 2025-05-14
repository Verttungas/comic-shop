<?php
include '../functions/auth.php';
include '../includes/db.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  header("Location: admin_productos.php?error=1");
  exit;
}

$id_comic = (int)$_GET['id'];

// Verificar si el cómic existe
$stmt = mysqli_prepare($conn, "SELECT id_comic FROM comics WHERE id_comic = ?");
mysqli_stmt_bind_param($stmt, "i", $id_comic);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

if (mysqli_stmt_num_rows($stmt) === 0) {
  mysqli_stmt_close($stmt);
  mysqli_close($conn);
  header("Location: admin_productos.php?error=2"); // No existe
  exit;
}
mysqli_stmt_close($stmt);

// Eliminar el cómic
$stmt = mysqli_prepare($conn, "DELETE FROM comics WHERE id_comic = ?");
mysqli_stmt_bind_param($stmt, "i", $id_comic);

if (mysqli_stmt_execute($stmt)) {
  mysqli_stmt_close($stmt);
  mysqli_close($conn);
  header("Location: admin_productos.php?eliminado=1");
  exit;
} else {
  mysqli_stmt_close($stmt);
  mysqli_close($conn);
  header("Location: admin_productos.php?error=3"); // Fallo al eliminar
  exit;
}
