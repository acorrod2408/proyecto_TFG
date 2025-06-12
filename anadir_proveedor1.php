<?php
session_start();
include 'includes/condb.php';

if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
    header("Location: index.php");
    exit();
}

$nie       = $conexion->real_escape_string($_POST['nie']       ?? '');
$nombre    = $conexion->real_escape_string($_POST['nombre']    ?? '');
$direccion = $conexion->real_escape_string($_POST['direccion'] ?? '');
$telefono  = $conexion->real_escape_string($_POST['telefono']  ?? '');

$error_fields = [];

$stmt = $conexion->prepare("SELECT COUNT(*) FROM proveedores WHERE NIE = ?");
$stmt->bind_param("s", $nie);
$stmt->execute();
$stmt->bind_result($count_nie);
$stmt->fetch();
$stmt->close();
if ($count_nie > 0) {
    $error_fields[] = 'nie';
}

$stmt = $conexion->prepare("SELECT COUNT(*) FROM proveedores WHERE nombre = ?");
$stmt->bind_param("s", $nombre);
$stmt->execute();
$stmt->bind_result($count_nom);
$stmt->fetch();
$stmt->close();
if ($count_nom > 0) {
    $error_fields[] = 'nombre';
}

if (!empty($error_fields)) {
    $campo = [];
    if (in_array('nie', $error_fields))   $campo[] = 'NIE';
    if (in_array('nombre', $error_fields)) $campo[] = 'Nombre';

    $_SESSION['flash_proveedor_mensaje'] = 'Error: ya existe un proveedor con ese ' . implode(' y ', $campo);
    $_SESSION['flash_proveedor_tipo']    = 'error';
    $_SESSION['old_inputs']              = [
        'nie'       => $_POST['nie']       ?? '',
        'nombre'    => $_POST['nombre']    ?? '',
        'direccion' => $_POST['direccion'] ?? '',
        'telefono'  => $_POST['telefono']  ?? '',
    ];
    $_SESSION['error_fields'] = $error_fields;

    header("Location: anadir_proveedor.php");
    exit;
}

$sql = "INSERT INTO proveedores (nie, nombre, direccion, telefono)
        VALUES ('$nie', '$nombre', '$direccion', '$telefono')";

if ($conexion->query($sql) === TRUE) {
    $_SESSION['flash_proveedor_mensaje'] = 'Proveedor añadido correctamente';
    $_SESSION['flash_proveedor_tipo']    = 'success';
} else {
    $_SESSION['flash_proveedor_mensaje'] = 'Error al añadir proveedor';
    $_SESSION['flash_proveedor_tipo']    = 'error';
}

header("Location: proveedores.php");
exit;
?>
