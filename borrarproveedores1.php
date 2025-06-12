<?php
session_start();
include 'includes/condb.php';

if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
    header("Location: index.php");
    exit;
}

if (isset($_GET['NIE'])) {
    $nie = $conexion->real_escape_string($_GET['NIE']);

    $sql  = "DELETE FROM proveedores WHERE NIE = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $nie);

    if ($stmt->execute()) {
        $_SESSION['flash_proveedor_mensaje'] = 'Proveedor borrado correctamente';
        $_SESSION['flash_proveedor_tipo']    = 'success';
    } else {
        $_SESSION['flash_proveedor_mensaje'] = 'Error al borrar el proveedor';
        $_SESSION['flash_proveedor_tipo']    = 'error';
    }

    $stmt->close();
}

header("Location: proveedores.php");
exit;
