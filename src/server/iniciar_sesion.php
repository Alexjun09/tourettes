<?php
session_start(); // Inicia la sesión al principio del script

// require_once '../bbdd/connect.php';
require_once '../bbdd/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $conn = getConexion();
    
    // Modifica tu consulta para obtener también el ID del paciente
    $stmt = $conn->prepare("SELECT Contrasena, IDPaciente FROM Cuenta WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows == 1) {
        $stmt->bind_result($hashedPassword, $idPaciente); // Agrega el ID del paciente aquí
        $stmt->fetch();
        header('Content-Type: application/json');
        if (password_verify($password, $hashedPassword)) {
            $_SESSION['idPaciente'] = $idPaciente; // Guarda el ID del paciente en la sesión
            echo json_encode(['success' => true, 'redirectUrl' => 'mi-cuenta.php']);
            exit();
        } else {
            echo json_encode(['success' => false, 'error' => 'Credenciales incorrectas']);
            exit();
        }
    } else {
        // Email no encontrado
        echo "No se encontró una cuenta con ese email";
    }

    $stmt->close();
}
$conn->close();

