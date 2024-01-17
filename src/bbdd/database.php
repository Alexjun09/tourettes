<?php
require_once 'conecta.php';

// Obtener la conexión
$conn = getConexion();

// Scripts para crear las tablas
$sqlPacientes = "CREATE TABLE IF NOT EXISTS Pacientes (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    NombreCompleto VARCHAR(255),
    TelefonoMovil VARCHAR(20)
)";
$sqlCuenta = "CREATE TABLE IF NOT EXISTS Cuenta (
    Email VARCHAR(255) PRIMARY KEY,
    NombreUsuario VARCHAR(255) UNIQUE,
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
    echo "Tabla 'Pacientes' creada exitosamente o ya existe.<br>";
} else {
    echo "Error al crear la tabla 'Pacientes': " . $conn->error . "<br>";
}

if ($conn->query($sqlCuenta) === TRUE) {
    echo "Tabla 'Cuenta' creada exitosamente o ya existe.<br>";
} else {
    echo "Error al crear la tabla 'Cuenta': " . $conn->error . "<br>";
}

if ($conn->query($sqlPsicologos) === TRUE) {
    echo "Tabla 'Psicologos' creada exitosamente o ya existe.<br>";
} else {
    echo "Error al crear la tabla 'Psicologos': " . $conn->error . "<br>";
}

if ($conn->query($sqlForo) === TRUE) {
    echo "Tabla 'Foro' creada exitosamente o ya existe.<br>";
} else {
    echo "Error al crear la tabla 'Foro': " . $conn->error . "<br>";
}

if ($conn->query($sqlRespuestas) === TRUE) {
    echo "Tabla 'Respuestas' creada exitosamente o ya existe.<br>";
} else {
    echo "Error al crear la tabla 'Respuestas': " . $conn->error . "<br>";
}

// Función para verificar e insertar datos
function verificarEInsertar($conn, $tabla, $sqlInsert)
{
    $checkTabla = "SELECT COUNT(*) FROM $tabla";
    $result = $conn->query($checkTabla);

    if ($result) {
        $row = $result->fetch_row();
        if ($row[0] == 0) {
            if ($conn->query($sqlInsert) === TRUE) {
                echo "Datos insertados en '$tabla' exitosamente.<br>";
            } else {
                echo "Error al insertar datos en '$tabla': " . $conn->error . "<br>";
            }
        } else {
            echo "La tabla '$tabla' ya tiene datos.<br>";
        }
    } else {
        echo "Error al verificar datos en la tabla '$tabla': " . $conn->error . "<br>";
    }
}

// Insertar datos en 'Pacientes'
$sqlInsertPacientes = "INSERT INTO Pacientes (NombreCompleto, TelefonoMovil) VALUES
('Juan Pérez', '612345678'),
('Ana García', '623456789'),
('Carlos Sánchez', '634567890'),
('Laura Gómez', '645678901'),
('Pedro López', '656789012')";
verificarEInsertar($conn, 'Pacientes', $sqlInsertPacientes);

$sqlInsertCuenta = "INSERT INTO Cuenta (Email, NombreUsuario, Contrasena, IDPaciente) VALUES
('juanperez@mail.com','juanperez01','a8]F{d!(5A', 1),
('anagarcia@mail.com', 'anitagarcia09','N:>m.uu3.', 2),
('carlossanchez@mail.com','carlosanchezz_1','1tE:3ZpNX', 3),
('lauragomez@mail.com', 'lauriita01','d&5?;0?1ts', 4),
('pedrolopez@mail.com', 'pedro_lopez19','euiULE?.1', 5);";
verificarEInsertar($conn, 'Cuenta', $sqlInsertCuenta);

$sqlInsertPsicologos = "INSERT INTO Psicologos (NombreCompleto, Especialidad, Ubicacion, Idiomas, Metodologia, Educacion) VALUES
('Dr. Hassan Raza', 'Psicología Clínica con énfasis en terapias para el Síndrome de Tourette', 'Santiago de Chile, Chile', 'Español, Inglés', 'Terapias conductuales especializadas, Técnicas de relajación y control de tics', 'Doctorado en Psicología Clínica, Universidad de Santiago de Chile, 2020'),
('Dra. Rachel Anderson', 'Psicología Pediátrica y Trastornos de Tic', 'Bogotá, Colombia', 'Español, Portugués', 'Intervención cognitivo-conductual, Educación y apoyo a familias', 'Máster en Psicología Pediátrica, Universidad Nacional de Colombia, 2021'),
('Dr. Carlos Herrera', 'Psicoterapia para trastornos del espectro tic y Síndrome de Tourette', 'Ciudad de México, México', 'Español, Inglés', 'Intervención en psicología positiva, Estrategias de afrontamiento', 'Especialidad en Psicología Clínica, Universidad Nacional Autónoma de México, 2017'),
('Dra. Laura Gómez', 'Psicología Infantil, enfocada en Síndrome de Tourette', 'Madrid, España', 'Español, Inglés', 'Terapia cognitivo-conductual, Técnicas de modificación de hábitos', 'Máster en Psicología Clínica y de la Salud, Universidad Autónoma de Madrid, 2018'),
('Dr. David Abioye', 'Psicología Clínica con subespecialidad en Neuropsicología', 'Lagos, Nigeria', 'Inglés, Yoruba, Español', 'Evaluación neuropsicológica, Intervenciones psicoeducativas', 'Doctorado en Psicología Clínica, Universidad de Ibadan, 2019');";
verificarEInsertar($conn, 'Psicologos', $sqlInsertPsicologos);

$sqlInsertForo = "INSERT INTO Foro (Titulo, PalabrasClave, Archivo, Cuerpo) VALUES
('Ansiedad y estrés', 'ansiedad, estrés, salud mental', 'archivo1.pdf', 'Contenido del tema sobre ansiedad...'),
('Depresión en adolescentes', 'depresión, adolescentes', 'archivo2.pdf', 'Contenido del tema sobre depresión...'),
('Autoestima y autoconcepto', 'autoestima, autoconcepto', 'archivo3.pdf', 'Contenido sobre autoestima...'),
('Gestión de emociones', 'emociones, gestión, inteligencia emocional', 'archivo4.pdf', 'Contenido sobre gestión de emociones...'),
('Mindfulness y meditación', 'mindfulness, meditación, relajación', 'archivo5.pdf', 'Contenido sobre mindfulness...');";
verificarEInsertar($conn, 'Foro', $sqlInsertForo);

$sqlInsertRespuestas = "INSERT INTO Respuestas (Respuesta, IDForo) VALUES
('Estoy de acuerdo con el tema de ansiedad...', 1),
('En mi experiencia, la depresión adolescente...', 2),
('El autoconcepto es fundamental...', 3),
('La gestión de emociones es clave...', 4),
('He practicado mindfulness y realmente ayuda...', 5);";
verificarEInsertar($conn, 'Respuestas', $sqlInsertRespuestas);

// Cerrar la conexión
$conn->close();
