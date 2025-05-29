<?php
session_start();


// Control de acceso: solo admin
if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
    header("Location: index.php");
    exit();
}
include './includes/header.php';
?>

<main class="container">
  <?php
  // Flash message
  if (isset($_SESSION['flash_mensaje'])):
      $clase = $_SESSION['flash_mensaje_tipo'] === 'success'
             ? 'mensaje-exito'
             : 'mensaje-error';
      echo "<div class=\"$clase\">{$_SESSION['flash_mensaje']}</div>";
      unset($_SESSION['flash_mensaje'], $_SESSION['flash_mensaje_tipo']);
  endif;
  ?>

  <div class="form-container">
      <h2>Insertar Productos</h2>

      <form method="POST" action="insertar1.php" enctype="multipart/form-data">
          <label for="nombre">Nombre:</label><br>
          <input type="text" name="nombre" id="nombre" required><br><br>

          <label for="descripcion">Descripción:</label><br>
          <input type="text" name="descripcion" id="descripcion" required><br><br>

          <label for="precio">Precio:</label><br>
          <input type="number" name="precio" id="precio"
                 min="0.01" step="0.01" required><br><br>

          <label for="imagen">Imagen:</label><br>
          <input type="file" name="imagen" id="imagen"
                 accept="image/*" required><br><br>

          <button type="submit" class="add-cart-btn">Enviar</button>
          <button type="reset"  class="add-cart-btn"
                  style="background:#757575; margin-left:0.5rem;">
            Reiniciar
          </button>
      </form>
  </div>
</main>

<?php include './includes/footer.php'; ?>
