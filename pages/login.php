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
    $errores[] = "Please fill in all fields.";
  } else {
    $stmt = mysqli_prepare($conn, "SELECT id_usuario, nombre, contrasena FROM usuarios WHERE correo_electronico = ?");
    mysqli_stmt_bind_param($stmt, "s", $correo);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) == 1) {
      mysqli_stmt_bind_result($stmt, $id_usuario, $nombre, $hash);
      mysqli_stmt_fetch($stmt);

      if (password_verify($contrasena, $hash)) {
        $_SESSION['id_usuario'] = $id_usuario;
        $_SESSION['nombre'] = $nombre;
        header("Location: index.php");
        exit;
      } else {
        $errores[] = "Incorrect password.";
      }
    } else {
      $errores[] = "Email not found.";
    }

    mysqli_stmt_close($stmt);
  }
}
?>

<!-- Hero -->
<section class="hero">
  <div class="container text-center">
    <h1 class="display-5 fw-bold">Login to Your Account</h1>
    <p class="lead">Access your cart and purchase your favorite Absolute titles.</p>
  </div>
</section>

<!-- Formulario de login -->
<section class="bg-light py-5">
  <div class="container" style="max-width: 500px;">
    <?php if (!empty($errores)): ?>
      <div class="alert alert-danger">
        <ul class="mb-0">
          <?php foreach ($errores as $error): ?>
            <li><?= $error ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <div class="card shadow-sm">
      <div class="card-body">
        <h2 class="text-center mb-4">Login</h2>

        <form method="POST" action="login.php">
          <div class="mb-3">
            <label for="correo" class="form-label">Email address</label>
            <input type="email" name="correo" class="form-control" value="<?= htmlspecialchars($correo) ?>" required>
          </div>
          <div class="mb-3">
            <label for="contrasena" class="form-label">Password</label>
            <input type="password" name="contrasena" class="form-control" required>
          </div>
          <div class="d-grid">
            <button type="submit" class="btn btn-dc">Login</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>

<?php include '../includes/footer.php'; ?>
