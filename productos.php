<?php 
  include 'includes/header.php'; 
  include 'includes/condb.php'; 
?>

<div class="productos-container">
  <h2>Productos Disponibles</h2>

  <form class="search-form" method="GET" action="">
    <label for="buscar">Buscar por Nombre o ID:</label>
    <input 
      type="text" 
      id="buscar" 
      name="buscar" 
      placeholder="Nombre o ID del producto" 
      required
    >
    <button type="submit">Buscar</button>
  </form>

  <div class="table-container">
    <table class="products-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Descripción</th>
          <th>Precio</th>
          <th>Inventario</th>
          <th>Imagen</th>
          <th>Cantidad</th>
          <th>Añadir al Carrito</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $condicion = "";
          if (!empty($_GET['buscar'])) {
            $b = $conexion->real_escape_string($_GET['buscar']);
            $condicion = "WHERE nombre LIKE '%$b%' OR id_producto = '$b'";
          }
          $sql = "SELECT * FROM productos $condicion";
          $res = $conexion->query($sql);

          if ($res->num_rows > 0):
            while($p = $res->fetch_assoc()):
        ?>
        <tr>
          <td><?= $p['id_producto'] ?></td>
          <td><?= htmlspecialchars($p['nombre']) ?></td>
          <td><?= htmlspecialchars($p['descripcion']) ?></td>
          <td><?= number_format($p['precio'],2) ?>€</td>
          <td><?= $p['inventario'] ?></td>
          <td>
            <img 
              src="imagenes/<?= htmlspecialchars($p['imagen']) ?>" 
              alt="Producto <?= htmlspecialchars($p['nombre']) ?>" 
              style="max-width:80px; border-radius:0.5rem;"
            >
          </td>

          <!-- Celda de cantidad -->
          <td>
            <input 
              class="quantity-input"
              type="number" 
              name="cantidad" 
              form="form-<?= $p['id_producto'] ?>"
              min="1" 
              max="<?= $p['inventario'] ?>" 
              value="1"
              required
            >
          </td>

          <!-- Celda del botón y form -->
          <td>
            <form 
              id="form-<?= $p['id_producto'] ?>" 
              method="POST" 
              action="anadir_al_carrito.php"
            >
              <input type="hidden" name="id_producto" value="<?= $p['id_producto'] ?>">
              <button class="add-cart-btn" type="submit">
                &#128722;
              </button>
            </form>
          </td>
        </tr>
        <?php 
            endwhile;
          else:
        ?>
        <tr>
          <td colspan="8">No se encontraron resultados.</td>
        </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
