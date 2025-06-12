<?php
// anadir_al_carrito.php

session_start();
include 'includes/condb.php';  // define $conexion

// 1) Sólo usuarios autenticados
if (!isset($_SESSION['id_usuario'])) {
    $_SESSION['flash_msg']  = 'Debes iniciar sesión para añadir al carrito.';
    $_SESSION['flash_type'] = 'error';
    header('Location: login.php');
    exit;
}

// 2) Sólo vía POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$id_usuario  = $_SESSION['id_usuario'];
$id_producto = intval($_POST['id_producto'] ?? 0);
$cantidad     = max(1, intval($_POST['cantidad'] ?? 1));
$estado      = 'pendiente';

// 3) Si ya existe ese producto pendiente, sumamos cantidad
$stmt = $conexion->prepare("
    SELECT id_carrito 
      FROM carrito 
     WHERE id_usuario = ? 
       AND id_producto = ? 
       AND estado     = 'pendiente'
    LIMIT 1
");
$stmt->bind_param('ii', $id_usuario, $id_producto);
$stmt->execute();
$res = $stmt->get_result();

if ($res && $res->num_rows > 0) {
    $row = $res->fetch_assoc();
    $stmt->close();

    $upd = $conexion->prepare("
        UPDATE carrito 
           SET cantidad = cantidad + ? 
         WHERE id_carrito = ?
    ");
    $upd->bind_param('ii', $cantidad, $row['id_carrito']);
    $upd->execute();
    $upd->close();
} else {
    $stmt->close();
    // 4) Insertamos nuevo registro
    $ins = $conexion->prepare("
        INSERT INTO carrito
            (id_usuario, id_producto, cantidad, estado)
        VALUES (?, ?, ?, ?)
    ");
    $ins->bind_param('iiis', $id_usuario, $id_producto, $cantidad, $estado);
    $ins->execute();
    $ins->close();
}

// 5) Flash y redirect
$_SESSION['flash_msg']  = 'Producto agregado al carrito con éxito.';
$_SESSION['flash_type'] = 'success';
header('Location: carrito.php');
exit;
