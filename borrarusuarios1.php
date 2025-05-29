<?php
// borrarusuarios1.php
session_start();
include './includes/condb.php';

// Sólo admin
if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
    header("Location: index.php");
    exit;
}

if (empty($_GET['id'])) {
    header("Location: usuarios.php");
    exit;
}
$id = (int)$_GET['id'];

// Iniciar transacción
$conexion->begin_transaction();

$ok = true;
// 1) Borrar carrito asociado
if (!$conexion->query("DELETE FROM carrito WHERE id_usuario = $id")) {
    $ok = false;
    $error = "No se pudo vaciar el carrito: " . $conexion->error;
}

// 2) Borrar usuario
if ($ok && !$conexion->query("DELETE FROM usuarios WHERE id_usuario = $id")) {
    $ok = false;
    $error = "Error al borrar usuario: " . $conexion->error;
}

if ($ok) {
    $conexion->commit();
    header("Location: usuarios.php?msg=borrado");
    exit;
} else {
    $conexion->rollback();
    include './includes/header.php';
    echo '<main class="container">';
    echo '<div class="mensaje-error">' . htmlspecialchars($error) . '</div>';
    echo '<a href="usuarios.php" class="btn-link">Volver a Usuarios</a>';
    echo '</main>';
    include './includes/footer.php';
    exit;
}
