<?php
require_once 'bbdd/connect.php';
// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener los valores del formulario
$nombreCompleto = $_POST['nombreCompleto'];
$nombreUsuario = $_POST['nombreUsuario'];
$email = $_POST['email'];
$telefono = $_POST['telefono'];
$contrasena = $_POST['contrasena']; // Considera usar hashing para la contraseña

// Preparar la consulta SQL
$sql = "INSERT INTO Cuenta (Email, NombreUsuario, Contrasena) VALUES ('$email', '$nombreUsuario', '$contrasena')";

// Ejecutar la consulta
if ($conn->query($sql) === TRUE) {
    echo "Cuenta creada exitosamente";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Cerrar la conexión
$conn->close();
?>
