<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    $_SESSION['flash_msg']  = 'Debes iniciar sesión para acceder a tu carrito.';
    $_SESSION['flash_type'] = 'error';
    header('Location: login.php');
    exit;
}

include 'includes/header.php';
include 'includes/condb.php';

$flash_msg  = $_SESSION['flash_msg']  ?? '';
$flash_type = $_SESSION['flash_type'] ?? '';
unset($_SESSION['flash_msg'], $_SESSION['flash_type']);

$id_usuario = $_SESSION['id_usuario'];

$stmt = $conexion->prepare("
  SELECT 
    c.id_carrito, 
    p.nombre, 
    c.cantidad, 
    p.precio        AS precio_unitario
  FROM carrito c
  JOIN productos p 
    ON c.id_producto = p.id_producto
  WHERE c.id_usuario = ? 
    AND c.estado     = 'pendiente'
");
$stmt->bind_param('i', $id_usuario);
$stmt->execute();
$res = $stmt->get_result();
?>

<div class="carrito-container">
  <!-- Mensaje Flash -->
  <?php if ($flash_msg !== ''): ?>
    <div class="<?= $flash_type === 'success'
                     ? 'mensaje-exito'
                     : 'mensaje-error' ?>">
      <?= htmlspecialchars($flash_msg) ?>
    </div>
  <?php endif; ?>

  <h2>Tu Carrito</h2>

  <?php if ($res->num_rows === 0): ?>
    <p>El carrito está vacío.</p>
  <?php else:
      $total = 0;
  ?>
    <table class="products-table" border="1">
      <thead>
        <tr>
          <th>Producto</th>
          <th>Cantidad</th>
          <th>Precio Unit.</th>
          <th>Subtotal</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $res->fetch_assoc()):
            $subtotal = $row['precio_unitario'] * $row['cantidad'];
            $total   += $subtotal;
        ?>
          <tr>
            <td><?= htmlspecialchars($row['nombre']) ?></td>
            <td><?= $row['cantidad'] ?></td>
            <td><?= number_format($row['precio_unitario'], 2) ?>€</td>
            <td><?= number_format($subtotal, 2) ?>€</td>
          </tr>
        <?php endwhile; ?>
      </tbody>
      <tfoot>
        <tr>
          <th colspan="3" style="text-align:right;">Total:</th>
          <th><?= number_format($total, 2) ?>€</th>
        </tr>
      </tfoot>
    </table>

    <!-- Botón Comprar -->
    <form action="comprar.php" method="POST" style="margin-top:1rem; text-align:right;">
      <button type="submit" class="btn-comprar">🛒 Comprar</button>
    </form>
  <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
