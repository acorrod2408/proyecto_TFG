<?php
// comprar.php

session_start();
include 'includes/condb.php';  // Define $conexion

// 1) Sólo usuarios logueados
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}

$id_usuario = $_SESSION['id_usuario'];

// 2) Obtenemos TODOS los ítems "pendiente" de este usuario
$sql = "
  SELECT 
    c.id_carrito, 
    c.id_producto, 
    c.cantidad, 
    p.inventario,
    p.nombre
  FROM carrito c
  JOIN productos p ON c.id_producto = p.id_producto
  WHERE c.id_usuario = ? 
    AND c.estado = 'pendiente'
";
$stmt = $conexion->prepare($sql);
$stmt->bind_param('i', $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

// Si no hay nada en el carrito
if ($result->num_rows === 0) {
    $_SESSION['flash_msg']  = 'Tu carrito está vacío.';
    $_SESSION['flash_type'] = 'error';
    header("Location: carrito.php");
    exit;
}

// 3) Procesamos cada producto
$sin_stock = [];
while ($row = $result->fetch_assoc()) {
    $id_carrito    = $row['id_carrito'];
    $id_producto   = $row['id_producto'];
    $cantidad      = $row['cantidad'];
    $inventario    = $row['inventario'];
    $nombre_prod   = $row['nombre'];

    if ($inventario >= $cantidad) {
        // a) Restar inventario
        $nuevo_inv = $inventario - $cantidad;
        $u1 = $conexion->prepare(
            "UPDATE productos 
             SET inventario = ? 
             WHERE id_producto = ?"
        );
        $u1->bind_param('ii', $nuevo_inv, $id_producto);
        $u1->execute();
        $u1->close();

        // b) Marcar carrito como comprado
        $u2 = $conexion->prepare(
            "UPDATE carrito 
             SET estado = 'comprado' 
             WHERE id_carrito = ?"
        );
        $u2->bind_param('i', $id_carrito);
        $u2->execute();
        $u2->close();
    } else {
        // No hay suficiente stock para este producto
        $sin_stock[] = $nombre_prod;
    }
}
$stmt->close();

// 4) Preparamos mensaje flash
if (empty($sin_stock)) {
    $_SESSION['flash_msg']  = 'Compra completada exitosamente.';
    $_SESSION['flash_type'] = 'success';
} else {
    $lista = implode(', ', $sin_stock);
    $_SESSION['flash_msg']  = 
      'No se pudo comprar por falta de stock: ' . $lista;
    $_SESSION['flash_type'] = 'error';
}

// 5) Redirigimos al carrito para mostrar el resultado
$conexion->close();
header("Location: carrito.php");
exit;
?>
