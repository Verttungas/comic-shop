<?php
include '../functions/auth.php';
include '../includes/db.php';
include '../includes/header.php';

if (!isset($_SESSION['id_usuario'])) {
  echo '<div class="container text-center mt-5"><p class="text-danger">Debes iniciar sesión para ver tu carrito.</p></div>';
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

<div class="container">
  <h1 class="mb-4 text-center">Tu carrito</h1>

  <?php if (mysqli_num_rows($resultado) > 0): ?>
    <table class="table table-bordered align-middle text-center">
      <thead class="table-light">
        <tr>
          <th>Imagen</th>
          <th>Título</th>
          <th>Precio</th>
          <th>Cantidad</th>
          <th>Subtotal</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($item = mysqli_fetch_assoc($resultado)): 
          $subtotal = $item['precio'] * $item['cantidad'];
          $total += $subtotal;
        ?>
          <tr>
            <td><img src="<?= $item['imagen'] ?>" alt="<?= $item['titulo'] ?>" width="60"></td>
            <td><?= $item['titulo'] ?> #<?= $item['numero_issue'] ?></td>
            <td>$<?= number_format($item['precio'], 2) ?> USD</td>
            <td>
              <form method="POST" action="../functions/update_cart.php" class="d-flex justify-content-center">
                <input type="hidden" name="id_carrito" value="<?= $item['id_carrito'] ?>">
                <input type="number" name="cantidad" min="1" value="<?= $item['cantidad'] ?>" class="form-control w-50 me-2">
                <button type="submit" class="btn btn-sm btn-outline-primary">Actualizar</button>
              </form>
            </td>
            <td>$<?= number_format($subtotal, 2) ?> USD</td>
            <td>
              <form method="POST" action="../functions/delete_from_cart.php">
                <input type="hidden" name="id_carrito" value="<?= $item['id_carrito'] ?>">
                <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
              </form>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>

    <div class="text-end">
      <h4>Total: $<?= number_format($total, 2) ?> USD</h4>
      <form action="../functions/checkout.php" method="POST">
        <button type="submit" class="btn btn-success">Finalizar compra</button>
      </form>
    </div>
  
  <?php else: ?>
    <p class="text-center text-muted">Tu carrito está vacío.</p>
  <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>
