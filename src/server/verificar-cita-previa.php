<?php
session_start();
require_once '../bbdd/connect.php'; // Asegúrate de que este es el path correcto al archivo de conexión.
header('Content-Type: application/json'); // Indica que la respuesta es JSON
if (!isset($_SESSION['idPaciente'])) {
    echo json_encode(['error' => 'No está autorizado para realizar esta acción.']);
    exit;
}

$psicologo_id = $_POST['psicologo_id'] ?? '';
$paciente_id = $_POST['paciente_id'] ?? '';
$fecha = $_POST['fecha'] ?? '';

// Crear conexión a la base de datos
$conn = getConexion();

// Preparar la consulta para verificar si ya existe una cita
$stmt = $conn->prepare("SELECT COUNT(*) FROM Citas WHERE IDPsicologo = ? AND IDPaciente = ? AND FechaCita = ?");
$stmt->bind_param("iis", $psicologo_id, $paciente_id, $fecha);
$stmt->execute();
$stmt->store_result(); // Necesario para obtener num_rows después de un SELECT COUNT(*)
$stmt->bind_result($count);
$stmt->fetch();

// Si $count es mayor que 0, entonces ya existe una cita
if ($count > 0) {
    echo json_encode(['yaTieneCita' => true]);
} else {
    echo json_encode(['yaTieneCita' => false]);
}

$stmt->close();
$conn->close();
