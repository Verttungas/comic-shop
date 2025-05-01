<?php
include '../includes/db.php'; 
include '../includes/header.php';

$nombre = $correo = $contrasena = $fecha_nacimiento = $numero_tarjeta = $direccion_postal = "";
$errores = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Obtener datos del formulario
  $nombre = trim($_POST['nombre']);
  $correo = trim($_POST['correo']);
  $contrasena = $_POST['contrasena'];
  $fecha_nacimiento = $_POST['fecha_nacimiento'];
  $numero_tarjeta = trim($_POST['numero_tarjeta']);
  $direccion_postal = trim($_POST['direccion_postal']);

  // Validaciones básicas
  if (empty($nombre) || empty($correo) || empty($contrasena)) {
    $errores[] = "Nombre, correo y contraseña son obligatorios.";
  }

  // Validar si el correo ya existe
  $stmt = mysqli_prepare($conn, "SELECT id_usuario FROM usuarios WHERE correo_electronico = ?");
  mysqli_stmt_bind_param($stmt, "s", $correo);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_store_result($stmt);

  if (mysqli_stmt_num_rows($stmt) > 0) {
    $errores[] = "Ya existe una cuenta con ese correo.";
  }
  mysqli_stmt_close($stmt);

  // Si no hay errores, insertar en la base de datos
  if (empty($errores)) {
    $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);

    $stmt = mysqli_prepare($conn, "INSERT INTO usuarios (nombre, correo_electronico, contrasena, fecha_nacimiento, numero_tarjeta, direccion_postal) VALUES (?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssssss", $nombre, $correo, $contrasena_hash, $fecha_nacimiento, $numero_tarjeta, $direccion_postal);

    if (mysqli_stmt_execute($stmt)) {
      echo '<div class="alert alert-success text-center">Cuenta creada correctamente. <a href="login.php">Iniciar sesión</a></div>';
      // Limpiar campos
      $nombre = $correo = $fecha_nacimiento = $numero_tarjeta = $direccion_postal = "";
    } else {
      $errores[] = "Error al registrar. Intenta más tarde.";
    }

    mysqli_stmt_close($stmt);
  }
}
?>

<div class="container mt-5" style="max-width: 600px;">
  <h2 class="mb-4 text-center">Crear cuenta</h2>

  <?php if (!empty($errores)): ?>
    <div class="alert alert-danger">
      <ul class="mb-0">
        <?php foreach ($errores as $error): ?>
          <li><?= $error ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <form method="POST" action="register.php">
    <div class="mb-3">
      <label for="nombre" class="form-label">Nombre</label>
      <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($nombre) ?>" required>
    </div>
    <div class="mb-3">
      <label for="correo" class="form-label">Correo electrónico</label>
      <input type="email" name="correo" class="form-control" value="<?= htmlspecialchars($correo) ?>" required>
    </div>
    <div class="mb-3">
      <label for="contrasena" class="form-label">Contraseña</label>
      <input type="password" name="contrasena" class="form-control" required>
    </div>
    <div class="mb-3">
      <label for="fecha_nacimiento" class="form-label">Fecha de nacimiento</label>
      <input type="date" name="fecha_nacimiento" class="form-control" value="<?= htmlspecialchars($fecha_nacimiento) ?>">
    </div>
    <div class="mb-3">
      <label for="numero_tarjeta" class="form-label">Número de tarjeta</label>
      <input type="text" name="numero_tarjeta" class="form-control" value="<?= htmlspecialchars($numero_tarjeta) ?>">
    </div>
    <div class="mb-3">
      <label for="direccion_postal" class="form-label">Dirección postal</label>
      <textarea name="direccion_postal" class="form-control"><?= htmlspecialchars($direccion_postal) ?></textarea>
    </div>
    <div class="d-grid">
      <button type="submit" class="btn btn-dark">Crear cuenta</button>
    </div>
  </form>
</div>

<?php include '../includes/footer.php'; ?>
