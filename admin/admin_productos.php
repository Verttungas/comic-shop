<?php
include '../functions/auth.php';
include '../includes/db.php';
include '../includes/header.php';

// ⚠️ Opcional: Solo permitir a un admin. Por ahora lo dejamos libre.
?>

<div class="container mt-5">
  <h2 class="mb-4 text-center">Administración de productos</h2>

  <!-- Tabla de productos -->
  <table class="table table-striped">
    <thead class="table-dark text-center">
      <tr>
        <th>ID</th>
        <th>Título</th>
        <th>Issue</th>
        <th>Precio</th>
        <th>Stock</th>
        <th>Editorial</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody class="text-center">
      <?php
      $query = "SELECT * FROM comics";
      $resultado = mysqli_query($conn, $query);

      while ($comic = mysqli_fetch_assoc($resultado)):
      ?>
        <tr>
          <td><?= $comic['id_comic'] ?></td>
          <td><?= htmlspecialchars($comic['titulo']) ?></td>
          <td><?= $comic['numero_issue'] ?></td>
          <td>$<?= number_format($comic['precio'], 2) ?></td>
          <td><?= $comic['cantidad'] ?></td>
          <td><?= htmlspecialchars($comic['editorial']) ?></td>
          <td>
            <a href="editar_producto.php?id=<?= $comic['id_comic'] ?>" class="btn btn-sm btn-primary">Editar</a>
            <a href="eliminar_producto.php?id=<?= $comic['id_comic'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este cómic?')">Eliminar</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>

  <!-- Formulario para agregar nuevo producto -->
  <div class="card mt-5">
    <div class="card-header">
      Agregar nuevo cómic
    </div>
    <div class="card-body">
      <form action="agregar_producto.php" method="POST">
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Título</label>
            <input type="text" name="titulo" class="form-control" required>
          </div>
          <div class="col-md-3">
            <label class="form-label">Issue</label>
            <input type="number" name="numero_issue" class="form-control" required>
          </div>
          <div class="col-md-3">
            <label class="form-label">Precio</label>
            <input type="number" step="0.01" name="precio" class="form-control" required>
          </div>
          <div class="col-md-3">
            <label class="form-label">Stock</label>
            <input type="number" name="cantidad" class="form-control" required>
          </div>
          <div class="col-md-3">
            <label class="form-label">Editorial</label>
            <input type="text" name="editorial" class="form-control">
          </div>
          <div class="col-md-6">
            <label class="form-label">URL de imagen</label>
            <input type="text" name="imagen" class="form-control">
          </div>
          <div class="col-12">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control" rows="3"></textarea>
          </div>
          <div class="col-12 text-end">
            <button type="submit" class="btn btn-success">Agregar cómic</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include '../includes/footer.php'; ?>
