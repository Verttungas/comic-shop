<?php
include '../functions/auth.php';
include '../includes/header.php';
include '../includes/db.php';
?>

<!-- Hero Section -->
<section class="hero text-white text-center">
  <div class="container">
    <h1 class="display-4 fw-bold mb-3">Welcome to DC's Absolute Universe!</h1>
    <p class="lead mb-4">Experience a reimagined world where heroes rise from the shadows.</p>
    <a href="catalog.php" class="btn btn-warning btn-lg">Explore the Collection</a>
  </div>
</section>

<!-- Introduction to Absolute Universe -->
<section class="py-5 bg-light">
  <div class="container">
    <h2 class="text-center mb-4 fw-semibold">What is the Absolute Universe?</h2>
    <p class="text-center mx-auto" style="max-width: 800px;">
      The Absolute Universe is DC Comics' bold new initiative, introducing darker and more grounded versions of iconic characters. 
      Set in Earth-Alpha, these stories explore a reality where Batman isn't rich, Superman faces a divided Krypton, and Wonder Woman’s
      true origins remain a mystery—even to herself. It’s a narrative reboot that reshapes legacy into struggle and hope into resistance.
    </p>
  </div>
</section>

<!-- Featured Titles -->
<section class="py-5">
  <div class="container">
    <h2 class="text-center mb-4 fw-semibold">Featured Titles</h2>
    <div class="row row-cols-1 row-cols-md-3 g-4">
      <?php
      $query = "SELECT * FROM comics ORDER BY RAND() LIMIT 3";
      $resultado = mysqli_query($conn, $query);

      while ($comic = mysqli_fetch_assoc($resultado)):
      ?>
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
  </div>
</section>

<!-- Call to Action -->
<section class="py-5 bg-dark text-white text-center">
  <div class="container">
    <h2 class="mb-3">Ready to delve into the Absolute Universe?</h2>
    <a href="catalog.php" class="btn btn-warning btn-lg">Browse the Catalog</a>
  </div>
</section>

<?php include '../includes/footer.php'; ?>
