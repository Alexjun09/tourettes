<?php
require_once 'connect.php'; 

// Iniciar sesión para usar `$_SESSION`
session_start();

// Obtener la conexión
$conn = getConexion();

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Asegúrate de que el usuario aceptó los términos
    if (!isset($_POST['terminos'])) {
        die("Debes aceptar los términos y condiciones.");
    }

    // Obtener datos del formulario
    $titulo = $conn->real_escape_string($_POST['title']);
    $palabrasClave = $conn->real_escape_string($_POST['palabrasclave']);
    $cuerpo = $conn->real_escape_string($_POST['cuerpo']);
    $idPaciente = $_SESSION['idPaciente']; // Reemplaza esto con la lógica adecuada para obtener el ID del paciente

    // Procesar archivo subido si existe
    $archivo = "";
    if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] == 0) {
        $archivo = '../media/entradaforo' . basename($_FILES['archivo']['name']);
        if (!move_uploaded_file($_FILES['archivo']['tmp_name'], $archivo)) {
            die("Error al subir archivo.");
        }
    }

    // Crear consulta para insertar los datos en la base de datos
    $sqlInsertForo = "INSERT INTO Foro (Titulo, PalabrasClave, Archivo, Cuerpo, IDPaciente) VALUES ('$titulo', '$palabrasClave', '$archivo', '$cuerpo', $idPaciente)";

    // Ejecutar la consulta
    if ($conn->query($sqlInsertForo) === TRUE) {
        echo "Nuevo registro en el foro creado exitosamente.";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Cerrar la conexión
$conn->close();
