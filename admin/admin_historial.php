<?php
include '../functions/auth.php';
include '../includes/db.php';
include '../includes/header.php';
?>

<!-- Hero -->
<section class="hero text-white text-center">
  <div class="container">
    <h1 class="display-5 fw-bold mb-3">Purchase History</h1>
    <p class="lead mb-4">See all the past orders made across the Absolute Universe.</p>
  </div>
</section>

<!-- Tabla de historial -->
<section class="section bg-light pt-0">
  <div class="container-padded">
    <div class="table-responsive">
      <table class="table table-bordered table-hover align-middle text-center bg-white">
        <thead class="table-dark">
          <tr>
            <th>User</th>
            <th>Email</th>
            <th>Comic</th>
            <th>Issue</th>
            <th>Quantity</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $query = "
            SELECT u.nombre, u.correo_electronico, c.titulo, c.numero_issue, h.cantidad, h.fecha_compra
            FROM historial_compras h
            JOIN usuarios u ON h.id_usuario = u.id_usuario
            JOIN comics c ON h.id_comic = c.id_comic
            ORDER BY h.fecha_compra DESC
          ";
          $resultado = mysqli_query($conn, $query);

          while ($row = mysqli_fetch_assoc($resultado)):
          ?>
            <tr>
              <td><?= htmlspecialchars($row['nombre']) ?></td>
              <td><?= htmlspecialchars($row['correo_electronico']) ?></td>
              <td><?= htmlspecialchars($row['titulo']) ?></td>
              <td>#<?= $row['numero_issue'] ?></td>
              <td><?= $row['cantidad'] ?></td>
              <td><?= $row['fecha_compra'] ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<?php include '../includes/footer.php'; ?>
