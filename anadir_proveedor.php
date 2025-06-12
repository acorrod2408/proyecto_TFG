<?php
  session_start();
  include 'includes/header.php';
  include 'includes/condb.php';

  // Recuperar mensaje flash y campos con error
  $flash_msg    = $_SESSION['flash_proveedor_mensaje'] ?? '';
  $flash_type   = $_SESSION['flash_proveedor_tipo']    ?? '';
  $error_fields = $_SESSION['error_fields']            ?? [];
  $old          = $_SESSION['old_inputs']             ?? [];

  // Limpiar sesión de flash
  unset(
      $_SESSION['flash_proveedor_mensaje'], 
      $_SESSION['flash_proveedor_tipo'], 
      $_SESSION['error_fields'],
      $_SESSION['old_inputs']
  );
?>

<?php
  if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
      header("Location: index.php");
      exit();
  }
?>

<main class="container">
  <?php if ($flash_msg): ?>
    <div class="<?= $flash_type === 'success' ? 'mensaje-exito' : 'mensaje-error' ?>">
      <?= htmlspecialchars($flash_msg) ?>
    </div>
  <?php endif; ?>

  <h2>Agregar Proveedor</h2>

  <div class="form-container">
    <form method="POST" action="anadir_proveedor1.php">
      <label for="nie">NIE:</label>
      <input
        type="text"
        id="nie"
        name="nie"
        required
        value="<?= htmlspecialchars($old['nie'] ?? '') ?>"
        <?= in_array('nie', $error_fields)
            ? 'style="border:2px solid #dc3545;"'
            : '' ?>
      ><br><br>

      <label for="nombre">Nombre:</label>
      <input
        type="text"
        id="nombre"
        name="nombre"
        required
        value="<?= htmlspecialchars($old['nombre'] ?? '') ?>"
        <?= in_array('nombre', $error_fields)
            ? 'style="border:2px solid #dc3545;"'
            : '' ?>
      ><br><br>

      <label for="direccion">Dirección:</label>
      <input
        type="text"
        id="direccion"
        name="direccion"
        required
        value="<?= htmlspecialchars($old['direccion'] ?? '') ?>"
      ><br><br>

      <label for="telefono">Teléfono:</label>
      <input
        type="tel"
        id="telefono"
        name="telefono"
        required
        pattern="[0-9]{9}"
        value="<?= htmlspecialchars($old['telefono'] ?? '') ?>"
      ><br><br>

      <input type="submit" value="Agregar Proveedor">
      <input type="reset" name="reset" value="Reiniciar">
    </form>
  </div>
</main>

<?php include 'includes/footer.php'; ?>
