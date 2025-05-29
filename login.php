<?php
// login.php

include 'includes/header.php';  // aquí ya debe arrancarse la sesión

// 1) Recuperamos y limpiamos el flash
$flash_msg  = $_SESSION['flash_msg']  ?? '';
$flash_type = $_SESSION['flash_type'] ?? '';
unset($_SESSION['flash_msg'], $_SESSION['flash_type']);
?>

<div class="inicio-sesion-container">
  <!-- 2) Mostramos el flash si lo hay -->
  <?php if ($flash_msg !== ''): ?>
    <div class="<?= $flash_type === 'success'
                     ? 'mensaje-exito'
                     : 'mensaje-error' ?>">
      <?= htmlspecialchars($flash_msg) ?>
    </div>
  <?php endif; ?>

  <!-- 3) Tu formulario -->
  <form method="POST" action="login1.php" class="inicio-sesion">
      <h2>Iniciar sesión</h2>
      <label for="nombre_usuario">Nombre de usuario:</label>
      <input type="text" id="nombre_usuario" name="nombre_usuario" required><br>

      <label for="contrasena">Contraseña:</label>
      <input type="password" id="contrasena" name="contrasena" required><br>

      <button type="submit" class="add-cart-btn">Iniciar sesión</button>
      <button type="reset"  class="add-cart-btn" style="background:#757575; margin-left:0.5rem;">Reiniciar</button>
      <p>O si no tienes cuenta <a href="registrar.php" class="reset-link">regístrate</a></p>
  </form>
</div>

<?php
include 'includes/footer.php';
?>
