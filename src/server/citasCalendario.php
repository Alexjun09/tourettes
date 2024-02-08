<?php
session_start();

if (!isset($_SESSION['idPaciente'])) {

    header('Location: sign-in.html');
    exit();
}

$idPaciente = $_SESSION['idPaciente'];

require_once '../bbdd/connect.php';

$conn = getConexion();
header('Content-Type: application/json');

// Preparar la consulta SQL para obtener los eventos de citas para un paciente específico
$query = "SELECT Citas.IDCita, Citas.FechaCita, Citas.Sintomas, Psicologos.NombreCompleto AS NombrePsicologo 
          FROM Citas 
          INNER JOIN Psicologos ON Citas.IDPsicologo = Psicologos.ID
          WHERE Citas.IDPaciente = ?";

$stmt = $conn->prepare($query);

// Vincular el ID del paciente como parámetro a la consulta
$stmt->bind_param("i", $idPaciente);

$stmt->execute();

$result = $stmt->get_result();

$events = [];

// Verificar si la consulta devolvió filas
if ($result->num_rows > 0) {
    // Recorrer los resultados y agregarlos al array de eventos
    while($row = $result->fetch_assoc()) {
        $events[] = [
            'id' => $row['IDCita'],
            'title' => $row['NombrePsicologo'], // Combinamos los síntomas y el nombre del psicólogo
            'start' => $row['FechaCita'], // Fecha y hora de inicio del evento
            // Puedes agregar más campos aquí según necesites
        ];
    }
}

// Cerrar la sentencia preparada y la conexión a la base de datos
$stmt->close();
$conn->close();

// Devolver los eventos en formato JSON
echo json_encode($events);
?>
