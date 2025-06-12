<?php
    $servidor="mysql-service:3306";
    $usuario="root";
    $password="toor";
    $dbname="tienda";
    $conexion = new mysqli($servidor, $usuario, $password, $dbname);
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }
?>