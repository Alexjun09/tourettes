<?php
function getConexion()
{
    // require '/Applications/XAMPP/xamppfiles/htdocs/tourettes/vendor/autoload.php'; // Load Composer autoloader
    // $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
    // $dotenv->load();

    // Connect to PlanetScale using credentials stored in environment variables
    $mysqli = mysqli_init();
    $mysqli->ssl_set(NULL, NULL, "/etc/ssl/cert.pem", NULL, NULL);
    $mysqli->real_connect("aws.connect.psdb.cloud", "ackaz5n11buo4g4bm03e", "pscale_pw_wQa8OpbzzQilIU58iA9JML4VPsNbON25u0EKsqfcdgw", "tourettes");

    // Check connection
    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli->connect_error;
        exit();
    }

    // Intenta crear la base de datos si no existe
    $nombre_bd = "tourettes";
    $sqlDB = "CREATE DATABASE IF NOT EXISTS $nombre_bd CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
    if ($mysqli->query($sqlDB) === TRUE) {
        $mysqli->select_db($nombre_bd);
    } else {
        echo "Error al crear la base de datos: " . $mysqli->error . "\n";
    }
    return $mysqli;
}
