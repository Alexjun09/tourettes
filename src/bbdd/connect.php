<?php
function getConexion()
{
    // Configuración de la conexión a la base de datos
    $servidor = "localhost";
    $usuario = "root";
    $contrasena = "";

    // Intenta establecer la conexión solo al servidor de MySQL
    $conexion = new mysqli($servidor, $usuario, $contrasena);

    // Verifica si hay algún error en la conexión
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Intenta crear la base de datos si no existe
    $nombre_bd = "tourette";
    $sqlDB = "CREATE DATABASE IF NOT EXISTS $nombre_bd CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
    if ($conexion->query($sqlDB) === TRUE) {
        //echo "Base de datos creada exitosamente o ya existe.\n";
        // Si se creó la base de datos, ahora sí seleccionarla
        $conexion->select_db($nombre_bd);
    } else {
        echo "Error al crear la base de datos: " . $conexion->error . "\n";
    }

    return $conexion;
}

