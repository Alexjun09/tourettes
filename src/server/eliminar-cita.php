<?php
session_start();

if (!isset($_SESSION['idPaciente'])) {
    echo "No está autorizado para ver esta página.";
    exit;
}

require_once '../bbdd/connect.php';
$conn = getConexion();

$idCita = isset($_GET['idCita']) ? $_GET['idCita'] : null;

if ($idCita) {
    $stmt = $conn->prepare("DELETE FROM Citas WHERE IDCita = ? AND IDPaciente = ?");
    $stmt->bind_param("ii", $idCita, $_SESSION['idPaciente']);
    if ($stmt->execute()) {
        // Redirigir a la página de confirmación con mensaje de éxito
        header("Location: ../confirmacion-cita.php?cita=eliminado");
    } else {
        // Si hay un error en la consulta, redirigir con mensaje de error
        header("Location: ../confirmacion-cita.php?cita=error");
    }
    $stmt->close();
} else {
    echo "ID de cita no proporcionado.";
}

$conn->close();
?>
