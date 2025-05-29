<?php
// login1.php
session_start();
include 'includes/condb.php';

// 1) Sólo aceptamos POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

// 2) Capturamos y limpiamos
$usuario = trim($_POST['nombre_usuario'] ?? '');
$clave   = trim($_POST['contrasena']      ?? '');

// 3) Validamos no vacío
if ($usuario === '' || $clave === '') {
    $_SESSION['flash_msg']  = 'Por favor completa todos los campos.';
    $_SESSION['flash_type'] = 'error';
    header('Location: login.php');
    exit;
}

// 4) Preparamos y ejecutamos la consulta, ahora trayendo el rol
$stmt = $conexion->prepare(
    'SELECT id_usuario, contrasena, rol 
     FROM usuarios 
     WHERE nombre_usuario = ? 
     LIMIT 1'
);
$stmt->bind_param('s', $usuario);
$stmt->execute();
$stmt->bind_result($id, $hash, $rol);
$existe = $stmt->fetch();
$stmt->close();

// 5) Validamos existencia y texto plano
if (! $existe || $clave !== $hash) {
    $_SESSION['flash_msg']  = 'Usuario o contraseña incorrecta.';
    $_SESSION['flash_type'] = 'error';
    header('Location: login.php');
    exit;
}

// 6) Login correcto: guardamos también el rol
$_SESSION['id_usuario']     = $id;
$_SESSION['nombre_usuario'] = $usuario;
$_SESSION['usuario_rol']    = $rol;             // ← aquí!
$_SESSION['flash_msg']      = 'Has iniciado sesión correctamente.';
$_SESSION['flash_type']     = 'success';

$conexion->close();
header('Location: index.php');
exit;
?>
