<?php
// modificarusuarios1.php
ob_start();
session_start();
include './includes/header.php';
include './includes/condb.php';

// Sólo admin
if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
    header("Location: index.php");
    exit();
}

if (empty($_GET['id'])) {
    header("Location: usuarios.php");
    exit();
}

$id = (int)$_GET['id'];
$res = $conexion->query("SELECT * FROM usuarios WHERE id_usuario = $id");
if (!$res || $res->num_rows === 0) {
    header("Location: usuarios.php");
    exit();
}
$u = $res->fetch_assoc();

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mail = $conexion->real_escape_string(trim($_POST['correo']));
    $rol  = $conexion->real_escape_string($_POST['rol']);

    $sql = "UPDATE usuarios
            SET correo = '$mail',
                rol    = '$rol'
            WHERE id_usuario = $id";
    if ($conexion->query($sql)) {
        header("Location: usuarios.php?msg=editado");
        exit();
    } else {
        $error = $conexion->error;
    }
}
?>
<main class="container">
  <h2>Editar Usuario</h2>
  <?php if ($error): ?>
    <div class="mensaje-error"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <form method="POST" class="form-container" action="">
    <label>
      ID:
      <input type="text" value="<?= $u['id_usuario'] ?>" disabled>
    </label>
    <label>
      Usuario:
      <input type="text" value="<?= htmlspecialchars($u['nombre_usuario']) ?>" disabled>
    </label>
    <label>
      Correo:
      <input type="email" name="correo"
             value="<?= htmlspecialchars($u['correo']) ?>" required>
    </label>
    <label>
      Rol:
      <select name="rol" required>
        <option value="cliente" <?= $u['rol']==='cliente'?'selected':'' ?>>Cliente</option>
        <option value="admin"   <?= $u['rol']==='admin'?'selected':''   ?>>Administrador</option>
      </select>
    </label>
    <button type="submit">Guardar cambios</button>
    <a href="usuarios.php" class="btn-link">Cancelar</a>
  </form>
</main>
<?php include './includes/footer.php'; ?>
