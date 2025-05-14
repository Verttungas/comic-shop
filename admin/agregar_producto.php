<?php
include '../functions/auth.php';
include '../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $titulo = trim($_POST['titulo']);
  $numero_issue = $_POST['numero_issue'];
  $precio = $_POST['precio'];
  $cantidad = $_POST['cantidad'];
  $imagen = trim($_POST['imagen']);
  $descripcion = trim($_POST['descripcion']);

  if (!empty($titulo) && is_numeric($numero_issue) && is_numeric($precio) && is_numeric($cantidad)) {
    $stmt = mysqli_prepare($conn, "
      INSERT INTO comics (titulo, numero_issue, precio, cantidad, imagen, descripcion)
      VALUES (?, ?, ?, ?, ?, ?)
    ");
    mysqli_stmt_bind_param($stmt, "sddiss", $titulo, $numero_issue, $precio, $cantidad, $imagen, $descripcion);

    if (mysqli_stmt_execute($stmt)) {
      header("Location: admin_productos.php?agregado=1");
    } else {
      header("Location: admin_productos.php?error=1");
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    exit;
  } else {
    header("Location: admin_productos.php?error=1");
    exit;
  }
}
?>
