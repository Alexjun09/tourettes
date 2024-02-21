<?php
session_start(); // Iniciar la sesión al principio de tu script

// Verificar que hay una sesión de paciente
if (!isset($_SESSION['idPaciente'])) {
    echo "No está autorizado para ver esta página.";
    exit;
}

require_once '../bbdd/connect.php'; // Conectar a la base de datos

$idPaciente = $_SESSION['idPaciente'];
$idPsicologo = isset($_POST['psicologo_id']) ? $_POST['psicologo_id'] : null;
$idCita = isset($_POST['idCita']) ? $_POST['idCita'] : null; // Asegúrate de incluir este campo en tu formulario

$errores = [];

$fechaCita = isset($_POST['fecha']) ? $_POST['fecha'] : null;
if (!$fechaCita || new DateTime($fechaCita) < new DateTime()) {
    $errores[] = "La fecha de la cita no es válida o ya ha pasado.";
} else {
    $fechaCita = str_replace('T', ' ', $fechaCita) . ":00";
}

$motivoConsulta = isset($_POST['motivo_consulta']) ? trim($_POST['motivo_consulta']) : '';
if (empty($motivoConsulta)) {
    $errores[] = "El motivo de la consulta no puede estar vacío.";
}

$visitadoAntes = isset($_POST['visita']) ? (int)$_POST['visita'] : 0;

if (!empty($errores)) {
    $_SESSION['errores'] = $errores;
    header('Location: ../confirmacion-cita.php?cita=error');
    exit;
}

$conn = getConexion();

// Asegúrate de tener el ID de la cita que vas a actualizar
if ($idCita !== null) {
    $stmt = $conn->prepare("UPDATE Citas SET IDPsicologo = ?, FechaCita = ?, Sintomas = ?, VisitadoAntes = ? WHERE IDCita = ? AND IDPaciente = ?");
    $stmt->bind_param("issiii", $idPsicologo, $fechaCita, $motivoConsulta, $visitadoAntes, $idCita, $idPaciente);
} else {
    $errores[] = "No se especificó el ID de la cita.";
    $_SESSION['errores'] = $errores;
    header('Location: ../confirmacion-cita.php?cita=error');
    exit;
}

if ($stmt->execute()) {
    header('Location: ../confirmacion-cita.php?cita=exito');
} else {
    header('Location: ../confirmacion-cita.php?cita=error');
}

$stmt->close();
$conn->close();
?>
