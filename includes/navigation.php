<?php include_once '../functions/auth.php'; ?>

<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom mb-4">
  <div class="container">
    <a class="navbar-brand fw-bold" href="../pages/index.php">DC's Absolute Comics Store</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="../pages/index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="../pages/catalog.php">Catalog</a></li>
        <li class="nav-item"><a class="nav-link" href="../pages/cart.php">Cart</a></li>

        <?php if (isset($_SESSION['id_usuario']) && $_SESSION['id_usuario'] == 1): ?>
          <li class="nav-item"><a class="nav-link text-warning" href="../admin/admin_productos.php">Admin</a></li>
          <li class="nav-item"><a class="nav-link text-warning" href="../admin/admin_historial.php">Historial</a></li>
        <?php endif; ?>
      </ul>

      <ul class="navbar-nav">
        <?php if (isset($_SESSION['id_usuario'])): ?>
          <li class="nav-item">
            <span class="nav-link">Hola, <?= htmlspecialchars($_SESSION['nombre']) ?> 👋</span>
          </li>
          <li class="nav-item">
            <a class="nav-link text-danger" href="../functions/logout.php">Cerrar sesión</a>
          </li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="../pages/login.php">Login</a></li>
          <li class="nav-item"><a class="nav-link" href="../pages/register.php">Register</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
