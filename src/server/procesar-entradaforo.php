<?php
session_start();
require_once '../bbdd/connect.php';

if (!isset($_SESSION['idPaciente'])) {
    echo "No está autorizado para ver esta página.";
    exit;
}

// Establecer la conexión a la base de datos
$conn = getConexion();

// Asegurarse de que el método de solicitud es POST y que se han aceptado los términos
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['terminos'])) {
    // Asegurarse de que el ID del paciente existe
    $idPaciente = $_SESSION['idPaciente'];
    $stmt = $conn->prepare("SELECT ID FROM pacientes WHERE ID = ?");
    $stmt->bind_param("i", $idPaciente);
    $stmt->execute();
    if ($stmt->get_result()->num_rows == 0) {
        echo "El ID del paciente no existe en la tabla pacientes.";
        exit;
    }
    $stmt->close();

    // Recoger los datos del formulario
    $titulo = $_POST['title'];
    $palabrasClave = $_POST['palabrasclave'];
    $cuerpo = $_POST['cuerpo'];

    // Manejo de la carga del archivo
    $archivo = NULL;
    if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] === UPLOAD_ERR_OK) {
        $nombreArchivo = basename($_FILES['archivo']['name']);
        $rutaArchivo = '../../media/entradaforo/' . $nombreArchivo;
        if (move_uploaded_file($_FILES['archivo']['tmp_name'], $rutaArchivo)) {
            $archivo = '../media/entradaforo/' . $nombreArchivo;
        } else {
            echo "Error al subir archivo.";
            exit;
        }
    } elseif ($_FILES['archivo']['error'] !== UPLOAD_ERR_NO_FILE) {
        echo "Error en la carga del archivo: " . $_FILES['archivo']['error'];
        exit;
    }

    // Preparar la consulta SQL para la inserción
    $stmt = $conn->prepare("INSERT INTO Foro (Titulo, PalabrasClave, Archivo, Cuerpo, IDPaciente) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $titulo, $palabrasClave, $archivo, $cuerpo, $idPaciente);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Redirigir al usuario a comunidad.php
        header('Location: ../comunidad.php');
        exit; // Asegúrate de salir del script después de la redirección
    } else {
        echo "Error: " . $stmt->error;
    }

    // Cerrar la declaración
    $stmt->close();
} else {
    echo "Debes aceptar los términos y condiciones o hacer una solicitud POST.";
}

// Cerrar la conexión a la base de datos
$conn->close();
