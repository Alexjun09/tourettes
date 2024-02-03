<?php
require_once 'connect.php'; 

// Iniciar sesión para usar `$_SESSION`
session_start();

// Obtener la conexión
$conn = getConexion();

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener datos del formulario
    $cuerpo = $conn->real_escape_string($_POST['cuerpo']);
    $idForo = $_SESSION['idForo']; // Este valor debería establecerse de alguna manera, tal vez mantenido en la sesión o pasado en el formulario como un campo oculto
    $idPaciente = $_SESSION['idPaciente']; // Asume que has almacenado el ID del paciente en la sesión

    // Procesar archivo subido si existe
    $archivo = "";
    if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] == 0) {
        $archivo = '../media/respuestaforo' . basename($_FILES['archivo']['name']);
        if (!move_uploaded_file($_FILES['archivo']['tmp_name'], $archivo)) {
            die("Error al subir archivo.");
        }
    }

    // Crear consulta para insertar los datos en la base de datos
    $sqlInsertRespuesta = "INSERT INTO Respuestas (Respuesta, IDForo, IDPaciente) VALUES ('$cuerpo', $idForo, $idPaciente)";

    // Ejecutar la consulta
    if ($conn->query($sqlInsertRespuesta) === TRUE) {
        echo "Nueva respuesta en el foro creada exitosamente.";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Cerrar la conexión
$conn->close();
