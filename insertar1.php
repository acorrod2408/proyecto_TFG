<?php
session_start();

// Conexión
$servidor   = "mysql-service:3306";
$usuario    = "root";
$password   = "toor";
$conexion   = new mysqli($servidor, $usuario, $password, "tienda");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Recogida de datos
$nombre      = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$precio      = $_POST['precio'];

// 1) Validación: no permitir nombre duplicado
$stmt = $conexion->prepare("SELECT COUNT(*) FROM productos WHERE nombre = ?");
$stmt->bind_param("s", $nombre);
$stmt->execute();
$stmt->bind_result($count);
$stmt->fetch();
$stmt->close();

if ($count > 0) {
    $_SESSION['flash_mensaje']      = 'Ya existe un producto con ese nombre';
    $_SESSION['flash_mensaje_tipo'] = 'error';
    header("Location: insertar.php");
    exit;
}

// 2) Procesar subida de imagen
$directorioSubida   = "imagenes/";
$max_file_size      = 5120000;
$extensionesValidas = ["jpg","png","gif"];
$nombreArchivo      = "";
$errores            = 0;

if (isset($_FILES['imagen'])) {
    $nombreArchivo = $_FILES['imagen']['name'];
    $filesize      = $_FILES['imagen']['size'];
    $tmpPath       = $_FILES['imagen']['tmp_name'];
    $ext           = strtolower(pathinfo($nombreArchivo, PATHINFO_EXTENSION));

    if (!in_array($ext, $extensionesValidas)) {
        $errores = 1;
    }
    if ($filesize > $max_file_size) {
        $errores = 1;
    }
    if ($errores === 0) {
        move_uploaded_file($tmpPath, $directorioSubida . $nombreArchivo);
    }
}

// 3) Insertar nuevo producto
$sql = "INSERT INTO productos (nombre, descripcion, precio, inventario, imagen)
        VALUES (?, ?, ?, 0, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("ssds", $nombre, $descripcion, $precio, $nombreArchivo);

if ($stmt->execute()) {
    $_SESSION['flash_mensaje']      = 'Producto añadido correctamente';
    $_SESSION['flash_mensaje_tipo'] = 'success';
} else {
    $_SESSION['flash_mensaje']      = 'Error al añadir el producto';
    $_SESSION['flash_mensaje_tipo'] = 'error';
}
$stmt->close();

header("Location: insertar.php");
exit;
?>
