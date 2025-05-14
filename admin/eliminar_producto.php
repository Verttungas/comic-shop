<?php
include '../functions/auth.php';
include '../includes/db.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  header("Location: admin_productos.php?error=1");
  exit;
}

$id_comic = $_GET['id'];

// Eliminar el cómic
$stmt = mysqli_prepare($conn, "DELETE FROM comics WHERE id_comic = ?");
mysqli_stmt_bind_param($stmt, "i", $id_comic);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

// Redirigir de regreso
header("Location: admin_productos.php?eliminado=1");
exit;
