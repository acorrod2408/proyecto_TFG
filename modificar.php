<?php
declare(strict_types=1);
session_start();
include 'includes/condb.php';

// Control de acceso: solo admin
if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Construcción de la condición de búsqueda
$condicion = "";
if (isset($_GET['buscar']) && $_GET['buscar'] !== '') {
    $b         = $conexion->real_escape_string($_GET['buscar']);
    $condicion = "WHERE nombre LIKE '%$b%' OR id_producto = '$b'";
}

// Consulta de productos
$reg = $conexion->query("SELECT * FROM productos $condicion");
include './includes/header.php';
?>

<div class="productos-container">
    <h2>Modificar Productos</h2><br>

    <form class="search-form" method="GET" action="">
        <label for="buscar">Buscar por Nombre o ID:</label>
        <input type="text" id="buscar" name="buscar" placeholder="Nombre o ID del producto" required>
        <button type="submit">Buscar</button>
    </form>

    <a href="insertar.php" class="add-cart-btn" style="margin-bottom:1rem; display:inline-block;">
        Insertar producto
    </a>

    <div class="table-container">
        <table class="products-table" border="1">
            <thead>
                <tr>
                    <th>ID Producto</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Imagen</th>
                    <th>Editar</th>
                    <th>Borrar</th>
                </tr>
            </thead>
            <tbody>
            <?php if ($reg && $reg->num_rows > 0): ?>
                <?php while ($registros = $reg->fetch_row()): ?>
              <tr>
                  <td><?php echo $registros[0]; ?></td>
                  <td><?php echo $registros[1]; ?></td>
                  <td><?php echo $registros[2]; ?></td>
                  <td><?php echo $registros[3]; ?>€</td>
                  <td><?php echo $registros[4]; ?></td>
                  <td><?php echo '<img width="100px" src="imagenes/' . $registros[5] . '">'; ?></td>
                  <td><a href="modificar1.php?id_producto=<?php echo $registros[0]; ?>"><img src="./images/lapiz.png" width=20px></a></td>
                  <td><a href="borrar1.php?id_producto=<?php echo $registros[0]; ?>"><img src="./images/basura.jpg" width=20px></a></td>
              </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8">No se encontraron resultados.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include './includes/footer.php'; ?>
