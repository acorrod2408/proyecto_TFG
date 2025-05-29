<?php include 'includes/condb.php'; ?>
<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (!isset($_GET['id_producto'])) {
            die("Error: ID del producto no recibido.");
        }
        $id_producto = $_GET['id_producto'];

        $nombre = $conexion->real_escape_string($_POST['nombre']);
        $descripcion = $conexion->real_escape_string($_POST['descripcion']);
        $precio = $conexion->real_escape_string($_POST['precio']);
        $inventario = $conexion->real_escape_string($_POST['inventario']);


        $imagen = $_FILES['imagen']['name'];
        if (!empty($imagen)) {
            $imagen_tmp = $_FILES['imagen']['tmp_name'];
            $ruta_destino = "imagenes/" . basename($imagen);
            move_uploaded_file($imagen_tmp, $ruta_destino);

            $sql = "UPDATE productos 
                    SET nombre='$nombre', descripcion='$descripcion', precio='$precio', inventario='$inventario', imagen='$imagen' 
                    WHERE id_producto='$id_producto'";
        } else {
            $sql = "UPDATE productos 
                    SET nombre='$nombre', descripcion='$descripcion', precio='$precio', inventario='$inventario' 
                    WHERE id_producto='$id_producto'";
        }
        if ($conexion->query($sql) === TRUE) {
            header("Location: modificar.php");
            exit();
        } else {
            echo "Error al actualizar el registro: " . $conexion->error;
        }
    }

    $conexion->close();
?>
