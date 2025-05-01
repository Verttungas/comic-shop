<?php
include '../functions/auth.php';
include '../includes/db.php';
include '../includes/header.php';

$correo = $contrasena = "";
$errores = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $correo = trim($_POST['correo']);
  $contrasena = $_POST['contrasena'];

  if (empty($correo) || empty($contrasena)) {
    $errores[] = "Por favor completa todos los campos.";
  } else {
    $stmt = mysqli_prepare($conn, "SELECT id_usuario, nombre, contrasena FROM usuarios WHERE correo_electronico = ?");
    mysqli_stmt_bind_param($stmt, "s", $correo);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) == 1) {
      mysqli_stmt_bind_result($stmt, $id_usuario, $nombre, $hash);
      mysqli_stmt_fetch($stmt);

      if (password_verify($contrasena, $hash)) {
        // Iniciar sesión
        $_SESSION['id_usuario'] = $id_usuario;
        $_SESSION['nombre'] = $nombre;
        header("Location: index.php");
        exit;
      } else {
        $errores[] = "Contraseña incorrecta.";
      }
    } else {
      $errores[] = "Correo no encontrado.";
    }

    mysqli_stmt_close($stmt);
  }
}
?>

<div class="container mt-5" style="max-width: 500px;">
  <h2 class="mb-4 text-center">Iniciar sesión</h2>

  <?php if (!empty($errores)): ?>
    <div class="alert alert-danger">
      <ul class="mb-0">
        <?php foreach ($errores as $error): ?>
          <li><?= $error ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <form method="POST" action="login.php">
    <div class="mb-3">
      <label for="correo" class="form-label">Correo electrónico</label>
      <input type="email" name="correo" class="form-control" value="<?= htmlspecialchars($correo) ?>" required>
    </div>
    <div class="mb-3">
      <label for="contrasena" class="form-label">Contraseña</label>
      <input type="password" name="contrasena" class="form-control" required>
    </div>
    <div class="d-grid">
      <button type="submit" class="btn btn-dark">Entrar</button>
    </div>
  </form>
</div>

<?php include '../includes/footer.php'; ?>
