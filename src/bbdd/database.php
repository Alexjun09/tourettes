<?php
require_once 'conecta.php';

// Obtener la conexión
$conn = getConexion();

// Ahora puedes crear tus tablas utilizando la conexión establecida
$sqlPacientes = "CREATE TABLE IF NOT EXISTS Pacientes (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    NombreCompleto VARCHAR(255),
    TelefonoMovil VARCHAR(20)
)";

$sqlCuenta = "CREATE TABLE IF NOT EXISTS Cuenta (
    Email VARCHAR(255) PRIMARY KEY,
    Contrasena VARCHAR(255),
    IDPaciente INT,
    FOREIGN KEY (IDPaciente) REFERENCES Pacientes(ID)
)";

$sqlPsicologos = "CREATE TABLE IF NOT EXISTS Psicologos (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    NombreCompleto VARCHAR(255),
    Especialidad VARCHAR(255),
    Ubicacion VARCHAR(255),
    Idiomas VARCHAR(255),
    Metodologia VARCHAR(255),
    Educacion VARCHAR(255)
)";

$sqlForo = "CREATE TABLE IF NOT EXISTS Foro (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Titulo VARCHAR(255),
    PalabrasClave VARCHAR(255),
    Archivo VARCHAR(255),
    Cuerpo TEXT
)";

$sqlRespuestas = "CREATE TABLE IF NOT EXISTS Respuestas (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Respuesta TEXT,
    IDForo INT,
    FOREIGN KEY (IDForo) REFERENCES Foro(ID)
)";

// Ejecutar las consultas para crear las tablas
if ($conn->query($sqlPacientes) === TRUE) {
    echo "Tabla 'Pacientes' creada exitosamente o ya existe.";
} else {
    echo "Error al crear la tabla 'Pacientes': " . $conn->error;
}

if ($conn->query($sqlCuenta) === TRUE) {
    echo "Tabla 'Cuenta' creada exitosamente o ya existe.";
} else {
    echo "Error al crear la tabla 'Cuenta': " . $conn->error;
}

if ($conn->query($sqlPsicologos) === TRUE) {
    echo "Tabla 'Psicologos' creada exitosamente o ya existe.";
} else {
    echo "Error al crear la tabla 'Psicologos': " . $conn->error;
}

if ($conn->query($sqlForo) === TRUE) {
    echo "Tabla 'Foro' creada exitosamente o ya existe.";
} else {
    echo "Error al crear la tabla 'Foro': " . $conn->error;
}

if ($conn->query($sqlRespuestas) === TRUE) {
    echo "Tabla 'Respuestas' creada exitosamente o ya existe.";
} else {
    echo "Error al crear la tabla 'Respuestas': " . $conn->error;
}

// Cerrar la conexión
$conn->close();
