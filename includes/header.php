<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda de Componentes</title>

    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap"
        rel="stylesheet"
    />


    <style>
        <?php include('./css/styles.css'); ?>
    </style>
</head>
<body>
    <header class="site-header">
        <button class="menu-toggle" aria-label="Abrir menú">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <!-- Menú principal -->
        <nav class="main-nav nav-menu">
            <ul class="nav-bar">
                <li><a href="index.php">Inicio</a></li>
                <li><a href="productos.php">Productos</a></li>
                <li><a href="carrito.php">Carrito</a></li>
                <?php if (isset($_SESSION['usuario_rol']) && $_SESSION['usuario_rol'] === 'admin'): ?>
                    <li><a href="modificar.php">Modificar</a></li>
                    <li class="divider">|</li>
                    <li><a href="inventario.php">Inventario</a></li>
                    <li><a href="proveedores.php">Proveedores</a></li>
                    <li><a href="usuarios.php">Usuarios</a></li>
                    <li class="divider">|</li>
                    <li><a href="historialcompras.php">Historial Compras</a></li>
                <?php endif; ?>
            </ul>
            <div class="user-session">
                <?php if (isset($_SESSION['id_usuario'])): ?>
                    <span>Bienvenido, <?= htmlspecialchars($_SESSION['nombre_usuario']); ?></span>
                    <a class="login-btn" href="logout.php">Cerrar sesión</a>
                <?php else: ?>
                    <a class="login-btn" href="login.php">Iniciar sesión</a>
                <?php endif; ?>
            </div>
        </nav>
    </header>
    <main>
        <script>
      document.addEventListener('DOMContentLoaded', function() {
        const btn  = document.querySelector('.menu-toggle');
        const nav  = document.querySelector('.main-nav');
        btn.addEventListener('click', () => nav.classList.toggle('open'));
      });
    </script>
