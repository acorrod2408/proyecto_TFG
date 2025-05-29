<?php 
    if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
        header("Location: index.php");
        exit();
    } 
?>

<?php
    $servidor="mysql-service:3306";
    $usuario="root";
    $password="toor";
    $dbname="tienda";
    $conexion = new mysqli($servidor, $usuario, $password, $dbname);

    $id_producto = $_GET['id_producto'];
    $sql = "DELETE FROM productos WHERE id_producto = '$id_producto'";
    mysqli_query($conexion, $sql);
    header("Location:modificar.php");
?>
