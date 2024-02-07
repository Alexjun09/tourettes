<?php
require_once '../bbdd/connect.php';

// Obtener la conexión
$conn = getConexion();

// Verificar si hay datos enviados por POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los valores del formulario y asegurar de limpiarlos para prevenir inyecciones SQL
    $nombreCompleto = $conn->real_escape_string($_POST['nombre_completo']);
    $telefono = $conn->real_escape_string($_POST['telefono']);
    $email = $conn->real_escape_string($_POST['email']);
    $motivo = $conn->real_escape_string($_POST['motivo']);
    $terminos = isset($_POST['terminos']) ? 1 : 0; // Se asume que si el checkbox está marcado, se envía el valor

    // Crear la consulta SQL para insertar los datos
    $sqlInsertContacto = "INSERT INTO Contacto (NombreCompleto, Telefono, Email, Motivo, AceptaTerminos) VALUES ('$nombreCompleto', '$telefono', '$email', '$motivo', $terminos)";

    // Ejecutar la consulta y verificar si fue exitosa
    if ($conn->query($sqlInsertContacto) === TRUE) {
        echo "Nuevo registro de contacto creado exitosamente.";
    } else {
        echo "Error: " . $sqlInsertContacto . "<br>" . $conn->error;
    }
} else {
    echo "No se recibieron datos por POST.";
}

// Cerrar la conexión
$conn->close();

