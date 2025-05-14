<?php
include '../functions/auth.php';
include '../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $titulo = trim($_POST['titulo']);
  $numero_issue = $_POST['numero_issue'];
  $precio = $_POST['precio'];
  $cantidad = $_POST['cantidad'];
  $editorial = trim($_POST['editorial']);
  $imagen = trim($_POST['imagen']);
  $descripcion = trim($_POST['descripcion']);

  // Validación simple
  if (!empty($titulo) && is_numeric($numero_issue) && is_numeric($precio) && is_numeric($cantidad)) {
    $stmt = mysqli_prepare($conn, "INSERT INTO comics (titulo, numero_issue, precio, cantidad, editorial, imagen, descripcion) VALUES (?, ?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sddiiss", $titulo, $numero_issue, $precio, $cantidad, $editorial, $imagen, $descripcion);

    if (mysqli_stmt_execute($stmt)) {
      // Redirigir con éxito
      header("Location: admin_productos.php?agregado=1");
      exit;
    } else {
      echo "Error al insertar el cómic.";
    }

    mysqli_stmt_close($stmt);
  } else {
    echo "Datos inválidos.";
  }
}

mysqli_close($conn);
?>
