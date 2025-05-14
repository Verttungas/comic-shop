<?php
include '../functions/auth.php';
include '../includes/db.php';
include '../includes/header.php';
?>

<div class="container mt-5">
  <h2 class="mb-4 text-center">Historial de compras</h2>

  <table class="table table-bordered text-center align-middle">
    <thead class="table-dark">
      <tr>
        <th>Usuario</th>
        <th>Correo</th>
        <th>Cómic</th>
        <th>Número</th>
        <th>Cantidad</th>
        <th>Fecha de compra</th>
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

<?php include '../includes/footer.php'; ?>
