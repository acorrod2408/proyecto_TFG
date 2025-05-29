<?php
    if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
        header("Location: index.php");
        exit();
    }
?>
<?php include './includes/header.php'; ?>

<?php
    $servidor = "mysql-service:3306";
    $usuario = "root";
    $password = "toor";
    $dbname = "tienda";
    $conexion = new mysqli($servidor, $usuario, $password, $dbname);

    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    $id_producto = $_GET['id_producto'];
    $sql = "SELECT * FROM productos WHERE id_producto = '$id_producto'";
    $resultado = $conexion->query($sql);

    if ($resultado->num_rows > 0) {
        $producto = $resultado->fetch_assoc();
    } else {
        echo "Producto no encontrado.";
        exit();
    }
?>
<div class="info-adicional">
    <form method="POST" action="modificar2.php?id_producto=<?php echo $id_producto; ?>" enctype="multipart/form-data">
        <label for="nombre">Nombre: </label>
        <input type="text" name="nombre" value="<?php echo $producto['nombre']; ?>" required><br><br>

        <label for="descripcion">Descripción: </label>
        <input type="text" name="descripcion" value="<?php echo $producto['descripcion']; ?>" required><br><br>

        <label for="precio">Precio: </label>
        <input type="number" name="precio" value="<?php echo $producto['precio']; ?>" step="0.01" required><br><br>

        <label for="inventario">Inventario: </label>
        <input type="number" name="inventario" value="<?php echo $producto['inventario']; ?>" readonly><br><br>

        <label for="imagen">Imagen actual:</label><br>
        <?php echo '<img src="imagenes/' . $producto['imagen'] . '" width="150">'; ?><br><br>

        <label for="imagen">Cambiar imagen: </label>
        <input type="file" name="imagen" accept="image/*"><br><br>

        <input type="submit" name="submit" value="Actualizar">
    </form>
</div>


<?php include './includes/footer.php'; ?>