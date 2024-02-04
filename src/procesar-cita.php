<?php
session_start(); // Iniciar la sesión al principio de tu script
echo $_SESSION['idPaciente']; 
// Verificar que hay una sesión de paciente y que el método de solicitud es POST
if (!isset($_SESSION['idPaciente'])) {
    // Si no se cumple alguna de las condiciones, mostrar un mensaje de error y salir del script
    echo "No está autorizado para ver esta página.";
    exit;
}

// Si llegamos aquí, es porque existe una sesión de paciente y la solicitud es POST
require_once './bbdd/connect.php'; // Conectar a la base de datos

$idPaciente = $_SESSION['idPaciente'];
$idPsicologo = isset($_POST['psicologo_id']) ? $_POST['psicologo_id'] : null;

// Inicializar el array de errores
$errores = [];

// Definir y validar la fecha de la cita
$fechaCita = isset($_POST['fecha']) ? $_POST['fecha'] : null;
if (!$fechaCita || new DateTime($fechaCita) < new DateTime()) {
    $errores[] = "La fecha de la cita no es válida o ya ha pasado.";
} else {
    $fechaCita = str_replace('T', ' ', $fechaCita) . ":00"; // Formatear la fecha para la base de datos
}

// Definir y validar el motivo de la consulta
$motivoConsulta = isset($_POST['motivo_consulta']) ? trim($_POST['motivo_consulta']) : '';
if (empty($motivoConsulta)) {
    $errores[] = "El motivo de la consulta no puede estar vacío.";
}

// Definir y validar si ha visitado antes
$visitadoAntes = isset($_POST['visita']) ? (int)$_POST['visita'] : 0;

// Verificar si hay errores
if (!empty($errores)) {
    // Si hay errores, redirigir al formulario y pasar los mensajes de error
    $_SESSION['errores'] = $errores;
    header('Location: pedir-cita.php');
    exit;
}

// Establecer la conexión a la base de datos
$conn = getConexion();

// Preparar la consulta SQL para evitar inyecciones SQL
$stmt = $conn->prepare("INSERT INTO Citas (IDPaciente, IDPsicologo, FechaCita, Sintomas, VisitadoAntes) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("iissi", $idPaciente, $idPsicologo, $fechaCita, $motivoConsulta, $visitadoAntes);

// Ejecutar la consulta
if ($stmt->execute()) {
    // Redirigir a la página de confirmación con mensaje de éxito
    header('Location: perfil-paciente.php?cita=exito');
} else {
    // Si hay un error en la consulta, redirigir con mensaje de error
    header('Location: pedir-cita.php?error=registro');
}

// Cerrar la declaración y la conexión
$stmt->close();
$conn->close();

