<?php
session_start();
include './includes/condb.php';

if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
    header("Location: index.php");
    exit();
}


$flash_msg  = $_SESSION['flash_proveedor_mensaje'] ?? '';
$flash_type = $_SESSION['flash_proveedor_tipo']    ?? '';
unset($_SESSION['flash_proveedor_mensaje'], $_SESSION['flash_proveedor_tipo']);

$condicion = '';
if (isset($_GET['buscar']) && trim($_GET['buscar']) !== '') {
    $buscar = $conexion->real_escape_string(trim($_GET['buscar']));
    $condicion = "WHERE nombre LIKE '%$buscar%' OR NIE = '$buscar'";
}
// Ejecutamos la consulta con la posible condición
$reg = $conexion->query("SELECT * FROM proveedores $condicion");
?>

<?php include './includes/header.php'; ?>
<link rel="stylesheet" href="css/productos.css">

<main class="container">
  <?php if ($flash_msg !== ''): ?>
    <div class="<?= $flash_type === 'success' ? 'mensaje-exito' : 'mensaje-error' ?>">
      <?= htmlspecialchars($flash_msg) ?>
    </div>
  <?php endif; ?>

  <h2>Lista de Proveedores</h2>

  <form class="search-form" method="GET" action="">
    <label for="buscar">Buscar por Nombre o NIE:</label>
    <input
      type="text"
      id="buscar"
      name="buscar"
      placeholder="Nombre o NIE"
      value="<?= isset($_GET['buscar']) ? htmlspecialchars($_GET['buscar']) : '' ?>"
    >
    <button type="submit">Buscar</button>
  </form>

  <a href="anadir_proveedor.php" class="add-cart-btn" style="margin-bottom:1rem; display:inline-block;">
    Añadir Proveedor
  </a>

 <div class="table-container">
    <table class="products-table">
      <thead>
        <tr>
          <th>NIE</th>
          <th>Nombre</th>
          <th>Dirección</th>
          <th>Teléfono</th>
          <th>Modificar</th>
          <th>Borrar</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($reg->num_rows > 0): ?>
          <?php while ($fila = $reg->fetch_assoc()): ?>
            <tr>
              <td><?= htmlspecialchars($fila['NIE']) ?></td>
              <td><?= htmlspecialchars($fila['nombre']) ?></td>
              <td><?= htmlspecialchars($fila['direccion']) ?></td>
              <td><?= htmlspecialchars($fila['telefono']) ?></td>
              <td>
                <a href="modificarproveedores1.php?NIE=<?= urlencode($fila['NIE']) ?>">
                  <img src="./images/lapiz.png" width="20" alt="Editar">
                </a>
              </td>
              <td>
                <a href="borrarproveedores1.php?NIE=<?= urlencode($fila['NIE']) ?>" 
                  onclick="return confirm('¿Seguro que quieres borrar este proveedor?');">
                  <img src="./images/basura.jpg" width="20" alt="Borrar">
                </a>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr>
            <td colspan="6">No se encontraron resultados.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</main>

<?php include './includes/footer.php'; ?>