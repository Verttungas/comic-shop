<?php
include '../functions/auth.php';
include '../includes/db.php';
include '../includes/header.php';

if (!isset($_SESSION['id_usuario'])) {
  echo '<div class="container text-center mt-5"><p class="text-danger">You must be logged in to view your cart.</p></div>';
  include '../includes/footer.php';
  exit;
}

$id_usuario = $_SESSION['id_usuario'];

// Obtener productos del carrito
$query = "
SELECT c.id_carrito, c.cantidad, co.titulo, co.numero_issue, co.precio, co.imagen
FROM carrito c
JOIN comics co ON c.id_comic = co.id_comic
WHERE c.id_usuario = $id_usuario
";
$resultado = mysqli_query($conn, $query);

$total = 0;
?>

<!-- Hero Section -->
<section class="hero">
  <div class="container">
    <h1 class="display-4 fw-bold mb-3">Your Cart</h1>
    <p class="lead mb-4">Manage your selected issues before proceeding to checkout.</p>
  </div>
</section>

<section class="section bg-light pt-0">
  <div class="container-padded">
    <?php if (mysqli_num_rows($resultado) > 0): ?>
      <div class="table-responsive">
        <table class="table table-bordered align-middle text-center bg-white">
          <thead class="table-light">
            <tr>
              <th>Cover</th>
              <th>Title</th>
              <th>Price</th>
              <th>Qty</th>
              <th>Subtotal</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($item = mysqli_fetch_assoc($resultado)): 
              $subtotal = $item['precio'] * $item['cantidad'];
              $total += $subtotal;
            ?>
              <tr>
                <td><img src="<?= htmlspecialchars($item['imagen']) ?>" alt="<?= htmlspecialchars($item['titulo']) ?>" width="60"></td>
                <td><?= htmlspecialchars($item['titulo']) ?> #<?= $item['numero_issue'] ?></td>
                <td>$<?= number_format($item['precio'], 2) ?> USD</td>
                <td>
                  <form method="POST" action="../functions/update_cart.php" class="d-flex justify-content-center">
                    <input type="hidden" name="id_carrito" value="<?= $item['id_carrito'] ?>">
                    <input type="number" name="cantidad" min="1" value="<?= $item['cantidad'] ?>" class="form-control form-control-sm w-50 me-2">
                    <button type="submit" class="btn btn-sm btn-dc">Update</button>
                  </form>
                </td>
                <td>$<?= number_format($subtotal, 2) ?> USD</td>
                <td>
                  <form method="POST" action="../functions/delete_from_cart.php">
                    <input type="hidden" name="id_carrito" value="<?= $item['id_carrito'] ?>">
                    <button type="submit" class="btn btn-sm btn-outline-danger">Remove</button>
                  </form>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>

      <div class="text-end mt-4">
        <h4>Total: $<?= number_format($total, 2) ?> USD</h4>
        <form action="../functions/checkout.php" method="POST" class="d-inline-block mt-2">
          <button type="submit" class="btn btn-success btn-lg">Checkout</button>
        </form>
      </div>

    <?php else: ?>
      <p class="text-center text-muted fs-5">Your cart is currently empty.</p>
    <?php endif; ?>
  </div>
</section>

<?php include '../includes/footer.php'; ?>
