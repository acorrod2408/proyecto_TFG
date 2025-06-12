<?php
// anadirusuarios1.php
ob_start();
session_start();
include './includes/condb.php';

// Inicializamos $error para evitar warnings
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $conexion->real_escape_string(trim($_POST['nombre_usuario']));
    $mail = $conexion->real_escape_string(trim($_POST['correo']));
    $rol  = $conexion->real_escape_string($_POST['rol']);

    // --- Ya no hacemos password_hash(), simplemente escapamos:
    $pass = $conexion->real_escape_string($_POST['contrasena']);

    // Orden de columnas acorde a la tabla
    $sql = "
      INSERT INTO usuarios
        (nombre_usuario, contrasena, correo, rol)
      VALUES
        ('$user', '$pass', '$mail', '$rol')
    ";

    if ($conexion->query($sql)) {
        header("Location: usuarios.php?msg=creado");
        exit;
    } else {
        $error = $conexion->error;
    }
}

// Solo incluimos el header tras toda la lógica de header() si hubiera
include './includes/header.php';
?>
<main class="container">
  <h2>Nuevo Usuario</h2>

  <?php if (!empty($error)): ?>
    <div class="mensaje-error"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <form method="POST" class="form-container" action="">
    <label>
      Usuario:
      <input type="text" name="nombre_usuario" required>
    </label>
    <label>
      Correo:
      <input type="email" name="correo" required>
    </label>
    <label>
      Contraseña:
      <input type="password" name="contrasena" required>
    </label>
    <label>
      Rol:
      <select name="rol" required>
        <option value="cliente">Cliente</option>
        <option value="admin">Administrador</option>
      </select>
    </label>
    <button type="submit" class="add-cart-btn">Crear Usuario</button>
    <a href="usuarios.php" class="reset-link">Cancelar</a>
  </form>
</main>
<?php include './includes/footer.php'; ?>