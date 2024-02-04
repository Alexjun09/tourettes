<?php
require_once 'connect.php'; 

session_start();

if (!isset($_SESSION['idPaciente'])) {
    die("No estás autorizado para realizar esta acción.");
}

$idPaciente = $_SESSION['idPaciente'];

$conn = getConexion();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['terminos'])) {
    $titulo = $_POST['title'];
    $palabrasClave = $_POST['palabrasclave'];
    $cuerpo = $_POST['cuerpo'];

    $archivo = "";
    if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] == 0) {
        $nombreArchivo = basename($_FILES['archivo']['name']);
        $rutaArchivo = '../media/entradaforo/' . $nombreArchivo;
        
        // Validaciones de seguridad para el archivo aquí (tipo, tamaño, etc.)

        if (move_uploaded_file($_FILES['archivo']['tmp_name'], $rutaArchivo)) {
            $archivo = $rutaArchivo;
        } else {
            die("Error al subir archivo.");
        }
    }

    $stmt = $conn->prepare("INSERT INTO Foro (Titulo, PalabrasClave, Archivo, Cuerpo, IDPaciente) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $titulo, $palabrasClave, $archivo, $cuerpo, $idPaciente);

    if ($stmt->execute()) {
        echo "Nuevo registro en el foro creado exitosamente.";
    } else {
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
} else {
    echo "Debes aceptar los términos y condiciones o hacer una solicitud POST.";
}

$conn->close();

