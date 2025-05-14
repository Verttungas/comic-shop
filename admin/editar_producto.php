<?php
include '../functions/auth.php';
include '../includes/db.php';
include '../includes/header.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  echo "<div class='container mt-5 text-center'><p class='text-danger'>ID inválido.</p></div>";
  include '../includes/footer.php';
  exit;
}

$id_comic = $_GET['id'];
$mensaje = "";

// Obtener datos actuales del cómic
$stmt = mysqli_prepare($conn, "SELECT * FROM comics WHERE id_comic = ?");
mysqli_stmt_bind_param($stmt, "i", $id_comic);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
$comic = mysqli_fetch_assoc($resultado);
mysqli_stmt_close($stmt);

if (!$comic) {
  echo "<div class='container mt-5 text-center'><p class='text-danger'>Cómic no encontrado.</p></div>";
  include '../includes/footer.php';
  exit;
}

// Si el formulario se envió
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $titulo = trim($_POST['titulo']);
  $numero_issue = $_POST['numero_issue'];
  $precio = $_POST['precio'];
  $cantidad = $_POST['cantidad'];
  $editorial = trim($_POST['editorial']);
  $imagen = trim($_POST['imagen']);
  $descripcion = trim($_POST['descripcion']);

  $stmt = mysqli_prepare($conn, "UPDATE comics SET titulo = ?, numero_issue = ?, precio = ?, cantidad = ?, editorial = ?, imagen = ?, descripcion = ? WHERE id_comic = ?");
  mysqli_stmt_bind_param($stmt, "sddiissi", $titulo, $numero_issue, $precio, $cantidad, $editorial, $imagen, $descripcion, $id_comic);
  if (mysqli_stmt_execute($stmt)) {
    $mensaje = "Cómic actualizado correctamente.";
    // Actualizar datos del cómic local para mostrar el cambio
    $comic = array_merge($comic, $_POST);
  } else {
    $mensaje = "Error al actualizar.";
  }
  mysqli_stmt_close($stmt);
}
?>

<div class="container mt-5" style="max-width: 700px;">
  <h2 class="mb-4 text-center">Editar cómic</h2>

  <?php if ($mensaje): ?>
    <div class="alert alert-info"><?= $mensaje ?></div>
  <?php endif; ?>

  <form method="POST">
    <div class="mb-3">
      <label class="form-label">Título</label>
      <input type="text" name="titulo" class="form-control" value="<?= htmlspecialchars($comic['titulo']) ?>" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Número Issue</label>
      <input type="number" name="numero_issue" class="form-control" value="<?= $comic['numero_issue'] ?>" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Precio</label>
      <input type="number" step="0.01" name="precio" class="form-control" value="<?= $comic['precio'] ?>" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Stock</label>
      <input type="number" name="cantidad" class="form-control" value="<?= $comic['cantidad'] ?>" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Editorial</label>
      <input type="text" name="editorial
