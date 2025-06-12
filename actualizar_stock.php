<?php include 'includes/condb.php'; ?>
<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_producto = $_POST['id_producto'];
    $cantidad    = $_POST['cantidad'];
    $NIE         = $_POST['NIE'];
    $precio      = $_POST['precio'];
    $fecha_compra = date('Y-m-d H:i:s');

    $sql_update = "UPDATE productos SET inventario = inventario + $cantidad WHERE id_producto = $id_producto";
    if ($conexion->query($sql_update) === TRUE) {
        $sql_insert = "INSERT INTO productos_proveedores (id_producto, NIE, fecha_compra, precio, cantidad) 
                       VALUES ($id_producto, '$NIE', '$fecha_compra', $precio, $cantidad)";
        if ($conexion->query($sql_insert) === TRUE) {
            $_SESSION['flash_msg']  = "Se ha añadido el stock correctamente.";
            $_SESSION['flash_type'] = "success";
        } else {
            $_SESSION['flash_msg']  = "Error al registrar la compra: " . $conexion->error;
            $_SESSION['flash_type'] = "error";
        }
    } else {
        $_SESSION['flash_msg']  = "Error al actualizar el inventario: " . $conexion->error;
        $_SESSION['flash_type'] = "error";
    }

    header("Location: inventario.php");
    exit();
}

$conexion->close();
?>
