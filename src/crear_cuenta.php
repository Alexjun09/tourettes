<?php
session_start();
require_once 'bbdd/connect.php';

// Obtener los valores del formulario
$nombreCompleto = $_POST['nombreCompleto'];
$nombreUsuario = $_POST['nombreUsuario'];
$email = $_POST['email'];
$telefono = $_POST['telefono'];
$contrasena = $_POST['contrasena'];
$conn = getConexion();
// Hash de la contraseña
$contrasenaHash = password_hash($contrasena, PASSWORD_DEFAULT);

// Insertar en la tabla Pacientes
$stmt = $conn->prepare("INSERT INTO Pacientes (NombreCompleto, TelefonoMovil, FotoPerfil, Banner) VALUES (?, ?, 
'../../media/perfilNuevo.jpg', '../../media/bannerNuevo.jpg')");
$stmt->bind_param("ss", $nombreCompleto, $telefono);
$stmt->execute();
$idPaciente = $stmt->insert_id; // Obtener el ID del paciente insertado
$_SESSION['idPaciente'] = $idPaciente;
$stmt->close();

// Insertar en la tabla Cuenta
$stmt = $conn->prepare("INSERT INTO Cuenta (Email, NombreUsuario, Contrasena, IDPaciente) VALUES (?, ?, ?, ?)");
$stmt->bind_param("sssi", $email, $nombreUsuario, $contrasenaHash, $idPaciente);

if ($stmt->execute()) {
    // Redirigir a editar-mi-cuenta.html después del registro exitoso
    header("Location: editar-mi-cuenta.php");
    exit();
} else {
    echo "Error al crear la cuenta: " . $stmt->error;
}

$stmt->close();

// Cerrar la conexión
$conn->close();
?>
