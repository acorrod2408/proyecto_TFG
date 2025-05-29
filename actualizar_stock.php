<?php 
    if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
        header("Location: index.php");
        exit();
    } 
?>
<?php include 'includes/condb.php'; ?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener datos del formulario
    $id_producto = $_POST['id_producto'];
    $cantidad = $_POST['cantidad'];
    $NIE = $_POST['NIE'];
    $precio = $_POST['precio'];
    $fecha_compra = date('Y-m-d H:i:s');

    // Actualizar inventario
    $sql_update = "UPDATE productos SET inventario = inventario + $cantidad WHERE id_producto = $id_producto";
    if ($conexion->query($sql_update) === TRUE) {

        // Insertar en productos_proveedores con la nueva columna 'cantidad'
        $sql_insert = "INSERT INTO productos_proveedores (id_producto, NIE, fecha_compra, precio, cantidad) VALUES ($id_producto, '$NIE', '$fecha_compra', $precio, $cantidad)";
        
        if ($conexion->query($sql_insert) === TRUE) {
            header("Location: inventario.php");
            exit();
        } else {
            echo "Error al insertar en productos_proveedores: " . $conexion->error;
        }
    } else {
        echo "Error al actualizar el inventario: " . $conexion->error;
    }
}

$conexion->close();
?>
