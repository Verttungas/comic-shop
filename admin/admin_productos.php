<?php
include '../functions/auth.php';
include '../includes/db.php';
include '../includes/header.php';
?>

<!-- Hero -->
<section class="hero text-white text-center">
  <div class="container">
    <h1 class="display-5 fw-bold">Product Management</h1>
    <p class="lead mb-4">Edit, add or delete titles from the Absolute collection.</p>
  </div>
</section>

<!-- Panel de administración -->
<section class="section bg-light pt-0">
  <div class="container-padded">

    <!-- Mensajes -->
    <?php if (isset($_GET['agregado'])): ?>
      <div class="alert alert-success text-center">Comic added successfully.</div>
    <?php elseif (isset($_GET['eliminado'])): ?>
      <div class="alert alert-success text-center">Comic deleted successfully.</div>
    <?php elseif (isset($_GET['error'])): ?>
      <div class="alert alert-danger text-center">
        <?php
          switch ($_GET['error']) {
            case 1: echo "Invalid comic ID."; break;
            case 2: echo "Comic not found."; break;
            case 3: echo "Error deleting comic."; break;
            default: echo "Something went wrong."; break;
          }
        ?>
      </div>
    <?php endif; ?>

    <!-- Tabla de productos -->
    <div class="table-responsive mb-5">
      <table class="table table-striped table-hover align-middle text-center bg-white">
        <thead class="table-dark">
          <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Issue</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $query = "SELECT * FROM comics";
          $resultado = mysqli_query($conn, $query);

          while ($comic = mysqli_fetch_assoc($resultado)):
          ?>
            <tr>
              <td><?= $comic['id_comic'] ?></td>
              <td><?= htmlspecialchars($comic['titulo']) ?></td>
              <td>#<?= $comic['numero_issue'] ?></td>
              <td>$<?= number_format($comic['precio'], 2) ?></td>
              <td><?= $comic['cantidad'] ?></td>
              <td>
                <a href="editar_producto.php?id=<?= $comic['id_comic'] ?>" class="btn btn-sm btn-dc">Edit</a>
                <a href="eliminar_producto.php?id=<?= $comic['id_comic'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this comic?')">Delete</a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>

    <!-- Formulario para agregar nuevo cómic -->
    <div class="card shadow-sm">
      <div class="card-header bg-dark text-white">
        Add New Comic
      </div>
      <div class="card-body">
        <form action="agregar_producto.php" method="POST">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Title</label>
              <input type="text" name="titulo" class="form-control" required>
            </div>
            <div class="col-md-3">
              <label class="form-label">Issue</label>
              <input type="number" name="numero_issue" class="form-control" required>
            </div>
            <div class="col-md-3">
              <label class="form-label">Price</label>
              <input type="number" step="0.01" name="precio" class="form-control" required>
            </div>
            <div class="col-md-3">
              <label class="form-label">Stock</label>
              <input type="number" name="cantidad" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Image URL</label>
              <input type="text" name="imagen" class="form-control">
            </div>
            <div class="col-12">
              <label class="form-label">Description</label>
              <textarea name="descripcion" class="form-control" rows="3"></textarea>
            </div>
            <div class="col-12 text-end">
              <button type="submit" class="btn btn-success">Add Comic</button>
            </div>
          </div>
        </form>
      </div>
    </div>

  </div>
</section>

<?php include '../includes/footer.php'; ?>
