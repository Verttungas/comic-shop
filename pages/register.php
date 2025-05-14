<?php
include '../includes/db.php'; 
include '../includes/header.php';

$nombre = $correo = $contrasena = $fecha_nacimiento = $numero_tarjeta = $direccion_postal = "";
$errores = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nombre = trim($_POST['nombre']);
  $correo = trim($_POST['correo']);
  $contrasena = $_POST['contrasena'];
  $fecha_nacimiento = $_POST['fecha_nacimiento'];
  $numero_tarjeta = trim($_POST['numero_tarjeta']);
  $direccion_postal = trim($_POST['direccion_postal']);

  if (empty($nombre) || empty($correo) || empty($contrasena)) {
    $errores[] = "Name, email and password are required.";
  }

  $stmt = mysqli_prepare($conn, "SELECT id_usuario FROM usuarios WHERE correo_electronico = ?");
  mysqli_stmt_bind_param($stmt, "s", $correo);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_store_result($stmt);

  if (mysqli_stmt_num_rows($stmt) > 0) {
    $errores[] = "An account with that email already exists.";
  }
  mysqli_stmt_close($stmt);

  if (empty($errores)) {
    $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);

    $stmt = mysqli_prepare($conn, "INSERT INTO usuarios (nombre, correo_electronico, contrasena, fecha_nacimiento, numero_tarjeta, direccion_postal) VALUES (?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssssss", $nombre, $correo, $contrasena_hash, $fecha_nacimiento, $numero_tarjeta, $direccion_postal);

    if (mysqli_stmt_execute($stmt)) {
      echo '<div class="alert alert-success text-center mb-0">Account created successfully. <a href="login.php">Login here</a></div>';
      $nombre = $correo = $fecha_nacimiento = $numero_tarjeta = $direccion_postal = "";
    } else {
      $errores[] = "An error occurred. Please try again later.";
    }

    mysqli_stmt_close($stmt);
  }
}
?>

<!-- Hero -->
<section class="hero">
  <div class="container text-center">
    <h1 class="display-5 fw-bold">Create Your Account</h1>
    <p class="lead">Register to access exclusive Absolute Universe content.</p>
  </div>
</section>

<!-- Formulario -->
<section class="bg-light py-5">
  <div class="container" style="max-width: 600px;">
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
        <h2 class="text-center mb-4">Sign Up</h2>

        <form method="POST" action="register.php">
          <div class="mb-3">
            <label for="nombre" class="form-label">Name</label>
            <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($nombre) ?>" required>
          </div>
          <div class="mb-3">
            <label for="correo" class="form-label">Email</label>
            <input type="email" name="correo" class="form-control" value="<?= htmlspecialchars($correo) ?>" required>
          </div>
          <div class="mb-3">
            <label for="contrasena" class="form-label">Password</label>
            <input type="password" name="contrasena" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="fecha_nacimiento" class="form-label">Date of Birth</label>
            <input type="date" name="fecha_nacimiento" class="form-control" value="<?= htmlspecialchars($fecha_nacimiento) ?>">
          </div>
          <div class="mb-3">
            <label for="numero_tarjeta" class="form-label">Card Number</label>
            <input type="text" name="numero_tarjeta" class="form-control" value="<?= htmlspecialchars($numero_tarjeta) ?>">
          </div>
          <div class="mb-3">
            <label for="direccion_postal" class="form-label">Shipping Address</label>
            <textarea name="direccion_postal" class="form-control"><?= htmlspecialchars($direccion_postal) ?></textarea>
          </div>
          <div class="d-grid">
            <button type="submit" class="btn btn-dc">Create Account</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>

<?php include '../includes/footer.php'; ?>
