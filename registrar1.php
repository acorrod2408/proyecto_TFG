<?php
session_start();
include 'includes/condb.php';

$nombre_usuario = trim($_POST['nombre_usuario'] ?? '');
$contrasena     = trim($_POST['contrasena']      ?? '');
$correo         = trim($_POST['correo']          ?? '');

// Validamos campos obligatorios
if ($nombre_usuario === '' || $contrasena === '' || $correo === '') {
    $_SESSION['flash_msg']  = 'Por favor, completa todos los campos.';
    $_SESSION['flash_type'] = 'error';
    header('Location: registrar.php');
    exit;
}

// Comprobamos si ya existe el usuario o el correo
$stmt = $conexion->prepare(
    'SELECT id_usuario
     FROM usuarios
     WHERE nombre_usuario = ?
        OR correo         = ?
     LIMIT 1'
);
$stmt->bind_param('ss', $nombre_usuario, $correo);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    // Ya existe nombre de usuario o correo
    $_SESSION['flash_msg']  = 'El nombre de usuario o el correo ya están registrados.';
    $_SESSION['flash_type'] = 'error';
    $stmt->close();
    $conexion->close();
    header('Location: registrar.php');
    exit;
}
$stmt->close();

// Insertamos el nuevo usuario (rol = cliente)
$stmt = $conexion->prepare(
    'INSERT INTO usuarios (nombre_usuario, contrasena, correo, rol)
     VALUES (?, ?, ?, ?)'
);
$rol = 'cliente';
$stmt->bind_param('ssss', $nombre_usuario, $contrasena, $correo, $rol);

if ($stmt->execute()) {
    // Registro exitoso
    $_SESSION['flash_msg']  = 'Usuario creado correctamente.';
    $_SESSION['flash_type'] = 'success';
    $stmt->close();
    $conexion->close();
    header('Location: login.php');
    exit;
} else {
    // Error al insertar
    $_SESSION['flash_msg']  = 'Error al crear el usuario. Intenta de nuevo.';
    $_SESSION['flash_type'] = 'error';
    $stmt->close();
    $conexion->close();
    header('Location: registrar.php');
    exit;
}
