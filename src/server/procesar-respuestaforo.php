<?php
session_start();
require_once '../bbdd/connect.php'; 

$idForo = $_POST['idForo'];
$idPaciente = $_SESSION['idPaciente'];

// Verificar si el usuario está logueado y si el ID del foro está establecido en la sesión
if (!isset($_SESSION['idPaciente']) || !isset($_POST['idForo'])) {
    echo "No está autorizado para ver esta página.";
    exit;
}

// Obtener la conexión a la base de datos
$conn = getConexion();

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Escapar el contenido del cuerpo para evitar inyecciones SQL
    $cuerpo = $conn->real_escape_string($_POST['cuerpo']);
    
    // Preparar la consulta SQL usando sentencias preparadas para evitar inyecciones SQL
    $stmt = $conn->prepare("INSERT INTO Respuestas (Respuesta, IDForo, IDPaciente) VALUES (?, ?, ?)");
    $stmt->bind_param("sii", $cuerpo, $idForo, $idPaciente);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Redirigir a entrada-foro.php en caso de éxito
        header('Location: ../entrada-foro.php?id=' . $idForo);
        exit; // Asegurar que el script se detenga después de la redirección
    } else {
        echo "Error: " . $stmt->error;
    }

    // Cerrar la sentencia preparada
    $stmt->close();
} else {
    echo "Error en el envío de la respuesta";
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
