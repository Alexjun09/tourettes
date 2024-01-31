<?php
require_once './bbdd/connect.php'; // Asegúrate de que este es el archivo correcto para la conexión a la base de datos.

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    $fechaCita = $_POST['fecha']; // Asegúrate de que el nombre de 'name' en el input del formulario coincida
    $fechaCita = str_replace('T', ' ', $fechaCita) . ":00";
    $motivoConsulta = $_POST['motivo_consulta'];
    $visitadoAntes = isset($_POST['visita']) ? $_POST['visita'] : 0; 

    // Aquí deberías validar los datos recibidos (por ejemplo, asegurarte de que la fecha no esté en el pasado, etc.)

    // Establecer la conexión
    $conn = getConexion();

    // Preparar la consulta SQL para evitar inyecciones SQL
    $stmt = $conn->prepare("INSERT INTO Citas (IDPaciente, IDPsicologo, FechaCita, Sintomas, VisitadoAntes) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iissi", $idPaciente, $idPsicologo, $fechaCita, $motivoConsulta, $visitadoAntes);

    // Definir variables y ejecutar
    $idPaciente = 1; // Aquí deberías tener el ID del paciente. Esto dependerá de cómo estés manejando las sesiones o identificaciones de usuarios.
    $idPsicologo = 2; // Debes obtener este valor según la lógica de tu aplicación.
    if ($stmt->execute()) {
        echo "Cita registrada exitosamente";
    } else {
        echo "Error al registrar la cita: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}

