<?php
include '../functions/auth.php';
include '../includes/db.php';
include '../includes/header.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  echo "<div class='container mt-5 text-center'><p class='text-danger'>Invalid comic ID.</p></div>";
  include '../includes/footer.php';
  exit;
}

$id_comic = (int)$_GET['id'];
$mensaje = "";

// Obtener datos actuales
$stmt = mysqli_prepare($conn, "SELECT * FROM comics WHERE id_comic = ?");
mysqli_stmt_bind_param($stmt, "i", $id_comic);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
$comic = mysqli_fetch_assoc($resultado);
mysqli_stmt_close($stmt);

if (!$comic) {
  echo "<div class='container mt-5 text-center'><p class='text-danger'>Comic not found.</p></div>";
  include '../includes/footer.php';
  exit;
}

// Guardar cambios
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $titulo = trim($_POST['titulo']);
  $numero_issue = $_POST['numero_issue'];
  $precio = $_POST['precio'];
  $cantidad = $_POST['cantidad'];
  $imagen = trim($_POST['imagen']);
  $descripcion = trim($_POST['descripcion']);

  $stmt = mysqli_prepare($conn, "
    UPDATE comics SET 
      titulo = ?, numero_issue = ?, precio = ?, cantidad = ?, imagen = ?, descripcion = ? 
    WHERE id_comic = ?
  ");
  mysqli_stmt_bind_param($stmt, "sddissi", $titulo, $numero_issue, $precio, $cantidad, $imagen, $descripcion, $id_comic);

  if (mysqli_stmt_execute($stmt)) {
    $mensaje = "Comic updated successfully.";
    $comic['titulo'] = $titulo;
    $comic['numero_issue'] = $numero_issue;
    $comic['precio'] = $precio;
    $comic['cantidad'] = $cantidad;
    $comic['imagen'] = $imagen;
    $comic['descripcion'] = $descripcion;
  } else {
    $mensaje = "Error updating comic.";
  }

  mysqli_stmt_close($stmt);
}
?>

<section class="hero text-white text-center">
  <div class="container">
    <h1 class="display-5 fw-bold">Edit Comic</h1>
    <p class="lead">Make changes to the selected title.</p>
  </div>
</section>

<section class="section bg-light pt-0">
  <div class="container-padded" style="max-width: 700px;">
    <?php if ($mensaje): ?>
      <div class="alert alert-info text-center"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

    <form method="POST">
      <div class="mb-3"><label class="form-label">Title</label>
        <input type="text" name="titulo" class="form-control" value="<?= htmlspecialchars($comic['titulo']) ?>" required>
      </div>
      <div class="mb-3"><label class="form-label">Issue</label>
        <input type="number" name="numero_issue" class="form-control" value="<?= $comic['numero_issue'] ?>" required>
      </div>
      <div class="mb-3"><label class="form-label">Price</label>
        <input type="number" step="0.01" name="precio" class="form-control" value="<?= $comic['precio'] ?>" required>
      </div>
      <div class="mb-3"><label class="form-label">Stock</label>
        <input type="number" name="cantidad" class="form-control" value="<?= $comic['cantidad'] ?>" required>
      </div>
      <div class="mb-3"><label class="form-label">Image URL</label>
        <input type="text" name="imagen" class="form-control" value="<?= htmlspecialchars($comic['imagen']) ?>">
      </div>
      <div class="mb-3"><label class="form-label">Description</label>
        <textarea name="descripcion" class="form-control" rows="4"><?= htmlspecialchars($comic['descripcion']) ?></textarea>
      </div>
      <div class="text-end">
        <button type="submit" class="btn btn-success">Save Changes</button>
        <a href="admin_productos.php" class="btn btn-secondary">Back to Admin</a>
      </div>
    </form>
  </div>
</section>

<?php include '../includes/footer.php'; ?>
