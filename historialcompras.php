<?php
// historialcompras.php

session_start();
include 'includes/condb.php';

// 1) Comprobamos que sea admin
if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// 2) Recogemos filtros de la URL
$id_filtro      = isset($_GET['id_carrito']) ? (int)$_GET['id_carrito'] : 0;
$usuario_filtro = isset($_GET['usuario'])     ? trim($_GET['usuario']) : '';

// 3) Construimos dinámicamente la cláusula WHERE
$where  = "c.estado = 'comprado'";
if ($id_filtro > 0) {
    $where .= " AND c.id_carrito = {$id_filtro}";
}
if ($usuario_filtro !== '') {
    $u_esc = $conexion->real_escape_string($usuario_filtro);
    $where .= " AND u.nombre_usuario LIKE '%{$u_esc}%'";
}

// 4) Consulta: añadimos precio_unitario y precio_total
$sql = "
    SELECT
      c.id_carrito,
      p.nombre                AS producto,
      c.cantidad,
      p.precio                AS precio_unitario,
      (p.precio * c.cantidad) AS precio_total,
      c.fecha,
      u.nombre_usuario        AS usuario
    FROM carrito c
    JOIN productos p ON c.id_producto = p.id_producto
    JOIN usuarios  u ON c.id_usuario   = u.id_usuario
    WHERE {$where}
    ORDER BY c.fecha DESC
";
$resultado = $conexion->query($sql);
?>
<?php include 'includes/header.php'; ?>

<br>
<h2>Historial Completo de Compras</h2>

<!-- Formulario de filtros -->
<form method="get" class="filtros-historial" style="margin-bottom:1rem;">
  <label>
    ID Carrito:
    <input type="number" name="id_carrito" value="<?= $id_filtro ?: '' ?>" placeholder="Ej. 123">
  </label>
  <label style="margin-left:1rem;">
    Usuario:
    <input type="text" name="usuario" value="<?= htmlspecialchars($usuario_filtro) ?>" placeholder="Ej. pepe123">
  </label>
  <button type="submit">Filtrar</button>
  <?php if ($id_filtro || $usuario_filtro): ?>
    <a href="historialcompras.php" class="reset-link" style="margin-left:1rem;">Ver todo</a>
  <?php endif; ?>
</form>

<div class="table-container">
  <table class="products-table" border="1" cellpadding="5" cellspacing="0">
    <thead>
      <tr>
        <th>ID Carrito</th>
        <th>Producto</th>
        <th>Cantidad</th>
        <th>Precio Unit.</th>
        <th>Precio Total</th>
        <th>Fecha</th>
        <th>Usuario</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($resultado && $resultado->num_rows > 0): ?>
        <?php while ($compra = $resultado->fetch_assoc()): ?>
          <tr>
            <td><?= $compra['id_carrito'] ?></td>
            <td><?= htmlspecialchars($compra['producto']) ?></td>
            <td><?= $compra['cantidad'] ?></td>
            <td><?= number_format($compra['precio_unitario'], 2) ?> €</td>
            <td><?= number_format($compra['precio_total'], 2) ?> €</td>
            <td><?= htmlspecialchars($compra['fecha']) ?></td>
            <td><?= htmlspecialchars($compra['usuario']) ?></td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr>
          <td colspan="7">No hay compras que coincidan con ese filtro.</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<?php include 'includes/footer.php'; ?>
