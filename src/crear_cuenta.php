<?php
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
$stmt = $conn->prepare("INSERT INTO Pacientes (NombreCompleto, TelefonoMovil) VALUES (?, ?)");
$stmt->bind_param("ss", $nombreCompleto, $telefono);
$stmt->execute();
$idPaciente = $stmt->insert_id; // Obtener el ID del paciente insertado
$stmt->close();

// Insertar en la tabla Cuenta
$stmt = $conn->prepare("INSERT INTO Cuenta (Email, NombreUsuario, Contrasena, IDPaciente) VALUES (?, ?, ?, ?)");
$stmt->bind_param("sssi", $email, $nombreUsuario, $contrasenaHash, $idPaciente);
$stmt->execute();
$stmt->close();

// Cerrar la conexión
$conn->close();
?>
