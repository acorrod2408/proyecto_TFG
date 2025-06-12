<?php
include 'includes/header.php';

$flash_msg  = $_SESSION['flash_msg']  ?? '';
$flash_type = $_SESSION['flash_type'] ?? '';
unset($_SESSION['flash_msg'], $_SESSION['flash_type']);
?>

<div class="registro-container">
  <!-- Mostrar mensaje si existe -->
  <?php if ($flash_msg !== ''): ?>
    <div class="<?= $flash_type === 'success'
                     ? 'mensaje-exito'
                     : 'mensaje-error' ?>">
      <?= htmlspecialchars($flash_msg) ?>
    </div>
  <?php endif; ?>

  <!-- Formulario de registro -->
  <form method="POST" action="registrar1.php" class="inicio-sesion">
    <h2>Regístrate</h2>
    <label for="nombre_usuario">Nombre de usuario:</label>
    <input type="text" id="nombre_usuario" name="nombre_usuario" required><br>

    <label for="correo">Correo:</label>
    <input type="email" id="correo" name="correo" required><br>
    
    <label for="contrasena">Contraseña:</label>
    <input type="password" id="contrasena" name="contrasena" required><br>

    <button type="submit" class="add-cart-btn">Registrarse</button>
    <button type="reset"  class="add-cart-btn" style="background:#757575; margin-left:0.5rem;">Reiniciar</button>

  </form>
</div>

<?php
include 'includes/footer.php';
?>


