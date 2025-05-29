<?php
session_start();
include './includes/condb.php';

// — Control de acceso: solo admin —
if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// — Si vienen datos por POST, procesamos y redirigimos ANTES de imprimir HTML —
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nie_original = $conexion->real_escape_string($_GET['NIE'] ?? '');
    $nie_nuevo    = $conexion->real_escape_string($_POST['nie_nuevo']);
    $nombre       = $conexion->real_escape_string($_POST['nombre']);
    $direccion    = $conexion->real_escape_string($_POST['direccion']);
    $telefono     = $conexion->real_escape_string($_POST['telefono']);

    // 1) Actualizar NIE si cambió
    if ($nie_original !== $nie_nuevo) {
        $conexion->query("UPDATE proveedores SET NIE='$nie_nuevo' WHERE NIE='$nie_original'");
        $nie_original = $nie_nuevo;
    }

    // 2) Actualizar resto de campos
    $sql = "UPDATE proveedores SET
                nombre    = '$nombre',
                direccion = '$direccion',
                telefono  = '$telefono'
            WHERE NIE = '$nie_original'";

    if ($conexion->query($sql) === TRUE) {
        $_SESSION['flash_proveedor_mensaje'] = 'Proveedor editado correctamente';
        $_SESSION['flash_proveedor_tipo']    = 'success';
        header("Location: proveedores.php");
        exit();
    } else {
        $_SESSION['flash_proveedor_mensaje'] = 'Error al actualizar el proveedor';
        $_SESSION['flash_proveedor_tipo']    = 'error';
        header("Location: modificarproveedores1.php?NIE={$nie_original}");
        exit();
    }
}

// — Si llegamos por GET, cargamos datos para el formulario —
$nie = $conexion->real_escape_string($_GET['NIE'] ?? '');
if ($nie === '') {
    header("Location: proveedores.php");
    exit();
}

$resultado = $conexion->query("SELECT * FROM proveedores WHERE NIE = '$nie'");
if (!$resultado || $resultado->num_rows === 0) {
    $_SESSION['flash_proveedor_mensaje'] = 'Proveedor no encontrado';
    $_SESSION['flash_proveedor_tipo']    = 'error';
    header("Location: proveedores.php");
    exit();
}
$proveedor = $resultado->fetch_assoc();
$conexion->close();

// — Ahora sí imprimimos el HTML —
include './includes/header.php';
?>
<link rel="stylesheet" href="css/productos.css">

<main class="container">
  <div class="form-container">
    <h2>Modificar Proveedor</h2>

    <form method="POST" action="" enctype="application/x-www-form-urlencoded">
      <label for="nie_nuevo">NIE:</label><br>
      <input
        type="text"
        id="nie_nuevo"
        name="nie_nuevo"
        value="<?= htmlspecialchars($proveedor['NIE']) ?>"
        required
      ><br><br>

      <label for="nombre">Nombre:</label><br>
      <input
        type="text"
        id="nombre"
        name="nombre"
        value="<?= htmlspecialchars($proveedor['nombre']) ?>"
        required
      ><br><br>

      <label for="direccion">Dirección:</label><br>
      <input
        type="text"
        id="direccion"
        name="direccion"
        value="<?= htmlspecialchars($proveedor['direccion']) ?>"
        required
      ><br><br>

      <label for="telefono">Teléfono:</label><br>
      <input
        type="text"
        id="telefono"
        name="telefono"
        value="<?= htmlspecialchars($proveedor['telefono']) ?>"
        required
      ><br><br>

      <button type="submit" class="add-cart-btn">Actualizar</button>
      <button type="reset"  class="add-cart-btn" style="background: #757575; margin-left: .5rem;">
        Reiniciar
      </button>
    </form>
  </div>
</main>

<?php include './includes/footer.php'; ?>
