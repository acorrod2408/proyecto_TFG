<?php include 'includes/condb.php'; ?>
<?php include 'includes/header.php'; ?>
<?php 
    if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
        header("Location: index.php");
        exit();
    } 
?>
<br>
<h2>Inventario de productos</h2>
<a href="historial_compras.php" class="add-cart-btn" style="margin-bottom:1rem; display:inline-block;">Historial de actualizar stock</a><br><br>

<div class="table-container">
    <table class="products-table" border="1">
        <thead>
            <tr>
                <th>ID Producto</th>
                <th>Nombre</th>
                <th>Stock Actual</th>
                <th>Agregar Stock</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Consulta para obtener los productos y su stock actual
            $consulta = "SELECT id_producto, nombre, inventario FROM productos";
            $resultados = $conexion->query($consulta);

            // Recorre los resultados y muestra cada producto en una fila de la tabla
            while ($producto = $resultados->fetch_assoc()) {
            ?>
                <tr>
                    <td><?php echo $producto['id_producto']; ?></td>
                    <td><?php echo $producto['nombre']; ?></td>
                    <td><?php echo $producto['inventario']; ?></td>

                    <td>
                        <form method="POST" action="actualizar_stock.php">
                            <input type="hidden" name="id_producto" value="<?php echo $producto['id_producto']; ?>"> <!-- Campo oculto con el ID del producto -->

                            <label for="cantidad">Cantidad:</label>
                            <input type="number" name="cantidad" min="1" required> <!-- Campo para introducir la cantidad a agregar -->

                            <label for="NIE">Proveedor:</label>
                            <select name="NIE" required>
                                <?php
                                // Obtiene la lista de proveedores de la base de datos
                                $proveedores = $conexion->query("SELECT NIE, nombre FROM proveedores");
                                while ($proveedor = $proveedores->fetch_assoc()) {
                                    echo "<option value='" . $proveedor['NIE'] . "'>" . $proveedor['nombre'] . "</option>";
                                }
                                ?>
                            </select>

                            <label for="precio">Precio Total:</label>
                            <input type="number" name="precio" min="0.01" step="0.01" required>

                            <input type="submit" class="add-cart-btn" value="Agregar Stock">
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php include 'includes/footer.php'; ?>
