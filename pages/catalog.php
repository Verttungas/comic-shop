<?php
include '../functions/auth.php';
include '../includes/db.php';
include '../includes/header.php';

// Series disponibles
$series = [
  'Absolute Batman',
  'Absolute Superman',
  'Absolute Wonder Woman',
  'Absolute Green Lantern',
  'Absolute Flash',
  'Absolute Martian Manhunter',
];

$serie_activa = isset($_GET['serie']) ? $_GET['serie'] : '';

// Paginación
$por_pagina = 6;
$pagina = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;
$offset = ($pagina - 1) * $por_pagina;

// Total de productos
if ($serie_activa) {
  $stmt = mysqli_prepare($conn, "SELECT COUNT(*) AS total FROM comics WHERE titulo LIKE CONCAT(?, '%')");
  mysqli_stmt_bind_param($stmt, "s", $serie_activa);
} else {
  $stmt = mysqli_prepare($conn, "SELECT COUNT(*) AS total FROM comics");
}
mysqli_stmt_execute($stmt);
$result_total = mysqli_stmt_get_result($stmt);
$total_result = mysqli_fetch_assoc($result_total);
$total_comics = $total_result['total'];
$total_paginas = ceil($total_comics / $por_pagina);
mysqli_stmt_close($stmt);

// Obtener productos actuales
if ($serie_activa) {
  $stmt = mysqli_prepare($conn, "SELECT * FROM comics WHERE titulo LIKE CONCAT(?, '%') LIMIT ? OFFSET ?");
  mysqli_stmt_bind_param($stmt, "sii", $serie_activa, $por_pagina, $offset);
} else {
  $stmt = mysqli_prepare($conn, "SELECT * FROM comics LIMIT ? OFFSET ?");
  mysqli_stmt_bind_param($stmt, "ii", $por_pagina, $offset);
}
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
?>

<!-- Hero Título -->
<section class="hero">
  <div class="container">
    <h1 class="display-4 fw-bold mb-3">Explore the DC Absolute Catalog</h1>
    <p class="lead mb-4">Browse all the titles from the boldest reimagining in DC history.</p>
  </div>
</section>

<!-- Filtros por serie -->
<section class="bg-light py-4">
  <div class="container text-center">
    <h2 class="mb-3">Browse by Series</h2>
    <?php foreach ($series as $serie): ?>
      <a href="catalog.php?serie=<?= urlencode($serie) ?>" class="btn <?= ($serie === $serie_activa) ? 'btn-warning' : 'btn-dc' ?> mx-1 mb-2">
        <?= $serie ?>
      </a>
    <?php endforeach; ?>
    <a href="catalog.php" class="btn <?= $serie_activa === '' ? 'btn-secondary' : 'btn-dc' ?> mx-1 mb-2">All</a>
  </div>
</section>

<!-- Lista de productos -->
<section class="section bg-light pt-0">
  <div class="container-padded">
    <div class="row row-cols-1 row-cols-md-3 g-4">
      <?php while ($comic = mysqli_fetch_assoc($resultado)): ?>
        <div class="col">
          <div class="card h-100 product-card">
            <img src="<?= htmlspecialchars($comic['imagen']) ?>" class="card-img-top" alt="<?= htmlspecialchars($comic['titulo']) ?>">
            <div class="card-body">
              <h5 class="card-title"><?= htmlspecialchars($comic['titulo']) ?> #<?= $comic['numero_issue'] ?></h5>
              <p class="card-text"><strong>$<?= number_format($comic['precio'], 2) ?> USD</strong></p>
              <p class="card-text description"><?= htmlspecialchars($comic['descripcion']) ?></p>
            </div>
            <div class="card-footer">
              <?php if (isset($_SESSION['id_usuario'])): ?>
                <form method="POST" action="../functions/add_to_cart.php" class="d-flex justify-content-between">
                  <input type="hidden" name="id_comic" value="<?= $comic['id_comic'] ?>">
                  <input type="number" name="cantidad" min="1" max="<?= $comic['cantidad'] ?>" value="1" class="form-control w-25 me-2">
                  <button type="submit" class="btn btn-dark">Add to Cart</button>
                </form>
              <?php else: ?>
                <p class="text-muted text-center">Login to purchase</p>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>

    <!-- Paginación -->
    <nav class="mt-5">
      <ul class="pagination justify-content-center">
        <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
          <li class="page-item <?= ($i === $pagina) ? 'active' : '' ?>">
            <a class="page-link" href="catalog.php?<?= $serie_activa ? 'serie=' . urlencode($serie_activa) . '&' : '' ?>pagina=<?= $i ?>">
              <?= $i ?>
            </a>
          </li>
        <?php endfor; ?>
      </ul>
    </nav>
  </div>
</section>

<?php include '../includes/footer.php'; ?>
