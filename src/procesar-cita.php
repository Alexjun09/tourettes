<?php
session_start(); // Iniciar la sesión al principio de tu script
require_once './bbdd/connect.php'; // Asegúrate de que este es el archivo correcto para la conexión a la base de datos.

// Verificar que hay una sesión de paciente y que el método de solicitud es POST
if (isset($_SESSION['idPaciente']) && $_SERVER["REQUEST_METHOD"] == "POST") {

    $idPaciente = $_SESSION['idPaciente'];

    $idPsicologo = isset($_POST['psicologo_id']) ? $_POST['psicologo_id'] : null;

    // Aquí deberías validar los datos recibidos
    // ...

    // Establecer la conexión
    $conn = getConexion();

    // Asegúrate de que tienes todos los datos necesarios antes de proceder
    if ($idPaciente && $idPsicologo) {
        // Preparar la consulta SQL para evitar inyecciones SQL
        $stmt = $conn->prepare("INSERT INTO Citas (IDPaciente, IDPsicologo, FechaCita, Sintomas, VisitadoAntes) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iissi", $idPaciente, $idPsicologo, $fechaCita, $motivoConsulta, $visitadoAntes);

        // Definir variables y ejecutar
        $fechaCita = $_POST['fecha']; // Asegúrate de que el nombre de 'name' en el input del formulario coincida
        $fechaCita = str_replace('T', ' ', $fechaCita) . ":00";
        $motivoConsulta = $_POST['motivo_consulta'];
        $visitadoAntes = isset($_POST['visita']) ? 1 : 0; 

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "Cita registrada exitosamente";
        } else {
            echo "Error al registrar la cita: " . $stmt->error;
        }

        // Cerrar la declaración y la conexión
        $stmt->close();
        $conn->close();
    } else {
        echo "Error: No se han proporcionado todos los datos necesarios.";
    }
} else {
    echo "No está autorizado para ver esta página.";
    exit;
}
?>
