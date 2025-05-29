<?php include 'includes/header.php'; ?>
<?php include 'includes/condb.php'; ?>

<?php 
    if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
        header("Location: index.php");
        exit();
    } 
?>
<br>
<h2>Historial de Compras</h2>
<div class="table-container">
    <table class="products-table" border="1">
        <thead>
            <tr>
                <th>ID Producto</th>
                <th>Proveedor (NIE)</th>
                <th>Fecha de Compra</th>
                <th>Precio Total</th>
                <th>Cantidad Comprada</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $consulta_historial = "SELECT id_producto, NIE, fecha_compra, precio, cantidad FROM productos_proveedores ORDER BY fecha_compra DESC";
            $resultados_historial = $conexion->query($consulta_historial);
            while ($compra = $resultados_historial->fetch_assoc()) {
            ?>
                <tr>
                    <td><?php echo $compra['id_producto']; ?></td>
                    <td><?php echo $compra['NIE']; ?></td>
                    <td><?php echo $compra['fecha_compra']; ?></td>
                    <td><?php echo $compra['precio']; ?> €</td>
                    <td><?php echo $compra['cantidad']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<?php include 'includes/footer.php'; ?>
