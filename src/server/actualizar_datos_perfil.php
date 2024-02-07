<?php
session_start();

// Asegúrate de que el usuario esté logueado
if (!isset($_SESSION['idPaciente'])) {
    header('Location: ../sign-in.html');
    exit();
}

// Conexión a la base de datos
require_once '../bbdd/connect.php';
$conn = getConexion();

// Recolecta los datos del formulario
$idPaciente = $_SESSION['idPaciente'];
$nombre = $_POST['nombre'] ?? null;
$email = $_POST['email'] ?? null;
$telefono = $_POST['telefono'] ?? null;
$edad = $_POST['edad'] ?? null;

// Verifica si los datos requeridos están presentes
if ($nombre && $email && $telefono && $edad !== null) {
    // Prepara la consulta SQL para actualizar los datos del paciente
    $query = "UPDATE Pacientes SET NombreCompleto = ?, TelefonoMovil = ?, Edad = ? WHERE ID = ?";
    $stmt = $conn->prepare($query);
    if ($stmt) {
        $stmt->bind_param("ssii", $nombre, $telefono, $edad, $idPaciente);
        if ($stmt->execute()) {
            // Redirige al usuario a la página de cuenta con un mensaje de éxito
            header('Location: ../mi-cuenta.php?mensaje=Datos actualizados correctamente');
        } else {
            // Error al ejecutar la consulta
            echo "Error al actualizar los datos: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error al preparar la consulta: " . $conn->error;
    }
} else {
    echo "Todos los campos son requeridos.";
}

// Cierra la conexión a la base de datos
$conn->close();
?>
