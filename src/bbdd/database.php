<?php
require_once 'connect.php';

// Obtener la conexión
$conn = getConexion();

// Scripts para crear las tablas
$sqlPacientes = "CREATE TABLE IF NOT EXISTS Pacientes (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    NombreCompleto VARCHAR(255),
    TelefonoMovil VARCHAR(20),
    Edad INT,
    FotoPerfil VARCHAR(255),
    Banner VARCHAR(255)
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
    Educacion VARCHAR(255),
    FotoPsicologo VARCHAR(255)
)";

$sqlForo = "CREATE TABLE IF NOT EXISTS Foro (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Titulo VARCHAR(255),
    PalabrasClave VARCHAR(255),
    Archivo VARCHAR(255),
    Cuerpo TEXT,
    IDPaciente INT,
    FOREIGN KEY (IDPaciente) REFERENCES Pacientes(ID)
)";

$sqlRespuestas = "CREATE TABLE IF NOT EXISTS Respuestas (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Respuesta TEXT,
    IDForo INT,
    IDPaciente INT,
    FOREIGN KEY (IDForo) REFERENCES Foro(ID),
    FOREIGN KEY (IDPaciente) REFERENCES Pacientes(ID)
)";

$sqlCitas = "CREATE TABLE IF NOT EXISTS Citas (
    IDCita INT AUTO_INCREMENT PRIMARY KEY,
    IDPaciente INT,
    IDPsicologo INT,
    FechaCita DATETIME,
    Sintomas TEXT,
    VisitadoAntes TINYINT NOT NULL DEFAULT 0,
    FOREIGN KEY (IDPaciente) REFERENCES Pacientes(ID),
    FOREIGN KEY (IDPsicologo) REFERENCES Psicologos(ID)
)";

$sqlInformes = "CREATE TABLE IF NOT EXISTS Informes (
    IDInforme INT AUTO_INCREMENT PRIMARY KEY,
    IDPaciente INT,
    FechaInforme DATE,
    RutaPDF VARCHAR(255),
    FOREIGN KEY (IDPaciente) REFERENCES Pacientes(ID)
)";

$sqlContacto = "CREATE TABLE IF NOT EXISTS Contacto (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    NombreCompleto VARCHAR(255) NOT NULL,
    Telefono VARCHAR(20) NOT NULL,
    Email VARCHAR(255) NOT NULL,
    Motivo TEXT NOT NULL,
    AceptaTerminos TINYINT NOT NULL DEFAULT 0
)";

// Ejecutar las consultas para crear las tablas
if ($conn->query($sqlPacientes) === TRUE) {
    //echo "Tabla 'Pacientes' creada exitosamente o ya existe.<br>";
} else {
    echo "Error al crear la tabla 'Pacientes': " . $conn->error . "<br>";
}

if ($conn->query($sqlCuenta) === TRUE) {
    //echo "Tabla 'Cuenta' creada exitosamente o ya existe.<br>";
} else {
    echo "Error al crear la tabla 'Cuenta': " . $conn->error . "<br>";
}

if ($conn->query($sqlPsicologos) === TRUE) {
    //echo "Tabla 'Psicologos' creada exitosamente o ya existe.<br>";
} else {
    echo "Error al crear la tabla 'Psicologos': " . $conn->error . "<br>";
}

if ($conn->query($sqlForo) === TRUE) {
    //echo "Tabla 'Foro' creada exitosamente o ya existe.<br>";
} else {
    echo "Error al crear la tabla 'Foro': " . $conn->error . "<br>";
}

if ($conn->query($sqlRespuestas) === TRUE) {
    //echo "Tabla 'Respuestas' creada exitosamente o ya existe.<br>";
} else {
    echo "Error al crear la tabla 'Respuestas': " . $conn->error . "<br>";
}

if ($conn->query($sqlCitas) === TRUE) {
    //echo "Tabla 'Citas' creada exitosamente.<br>";
} else {
    echo "Error al crear la tabla 'Citas': " . $conn->error . "<br>";
}

if ($conn->query($sqlInformes) === TRUE) {
    //echo "Tabla 'Informes' creada exitosamente.<br>";
} else {
    echo "Error al crear la tabla 'Informes': " . $conn->error . "<br>";
}

if ($conn->query($sqlContacto) === TRUE) {
    //echo "Tabla 'Contacto' creada exitosamente o ya existe.<br>";
} else {
    echo "Error al crear la tabla 'Contacto': " . $conn->error . "<br>";
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
                //echo "Datos insertados en '$tabla' exitosamente.<br>";
            } else {
                echo "Error al insertar datos en '$tabla': " . $conn->error . "<br>";
            }
        } else {
            //echo "La tabla '$tabla' ya tiene datos.<br>";
        }
    } else {
        echo "Error al verificar datos en la tabla '$tabla': " . $conn->error . "<br>";
    }
}

$sqlInsertPacientes = "INSERT INTO Pacientes (NombreCompleto, TelefonoMovil, Edad, FotoPerfil, Banner) VALUES
('Juan Pérez', '612345678', 30, '../../media/profile/image.jpg', '../../media/banner/image.jpg'),
('Ana García', '623456789', 25, '../../media/profile/image.jpg', '../../media/banner/image.jpg'),
('Carlos Sánchez', '634567890', 40, '../../media/profile/image.jpg', '../../media/banner/image.jpg'),
('Laura Gómez', '645678901', 35, '../../media/profile/image.jpg', '../../media/banner/image.jpg'),
('Pedro López', '656789012', 28, '../../media/profile/image.jpg', '../../media/banner/image.jpg')";
verificarEInsertar($conn, 'Pacientes', $sqlInsertPacientes);


$sqlInsertCuenta = "INSERT INTO Cuenta (Email, NombreUsuario, Contrasena, IDPaciente) VALUES
('juanperez@mail.com','juanperez1','contrasena1', 1),
('anagarcia@mail.com', 'anitagarcia2','contrasena2', 2),
('carlossanchez@mail.com','carlosanchez3','contrasena3', 3),
('lauragomez@mail.com', 'laurita4','contrasena4', 4),
('pedrolopez@mail.com', 'pedrolopez5','contrasena5', 5);";
verificarEInsertar($conn, 'Cuenta', $sqlInsertCuenta);

$sqlInsertPsicologos = "INSERT INTO Psicologos (NombreCompleto, Especialidad, Ubicacion, Idiomas, Metodologia, Educacion, FotoPsicologo) VALUES
('Dr. Hassan Raza', 'Psicología Clínica con énfasis en terapias para el Síndrome de Tourette', 'Santiago de Chile, Chile', 'Español, Inglés', 'Terapias conductuales especializadas, Técnicas de relajación y control de tics', 'Doctorado en Psicología Clínica, Universidad de Santiago de Chile, 2020','../../media/psicologos/psicologo6.jpg'),
('Dra. Rachel Anderson', 'Psicología Pediátrica y Trastornos de Tic', 'Bogotá, Colombia', 'Español, Portugués', 'Intervención cognitivo-conductual, Educación y apoyo a familias', 'Máster en Psicología Pediátrica, Universidad Nacional de Colombia, 2021','../../media/psicologos/psicologa5.jpg'),
('Dr. Carlos Herrera', 'Psicoterapia para trastornos del espectro tic y Síndrome de Tourette', 'Ciudad de México, México', 'Español, Inglés', 'Intervención en psicología positiva, Estrategias de afrontamiento', 'Especialidad en Psicología Clínica, Universidad Nacional Autónoma de México, 2017','../../media/psicologos/psicologo4.jpg'),
('Dra. Laura Gómez', 'Psicología Infantil, enfocada en Síndrome de Tourette', 'Madrid, España', 'Español, Inglés', 'Terapia cognitivo-conductual, Técnicas de modificación de hábitos', 'Máster en Psicología Clínica y de la Salud, Universidad Autónoma de Madrid, 2018','../../media/psicologos/psicologa1.jpg'),
('Dra. Sofia Tan', 'Psicología del Desarrollo y Trastornos del Movimiento', 'Buenos Aires, Argentina', 'Español, Chino Mandarín', 'Terapia de aceptación y compromiso, Entrenamiento en manejo de tics', 'Máster en Psicología del Desarrollo, Universidad de Buenos Aires, 2020', '../../media/psicologos/psicologo3.jpg'),
('Dr. David Abioye', 'Psicología Clínica con subespecialidad en Neuropsicología', 'Lagos, Nigeria', 'Inglés, Yoruba, Español', 'Evaluación neuropsicológica, Intervenciones psicoeducativas', 'Doctorado en Psicología Clínica, Universidad de Ibadan, 2019','../../media/psicologos/psicologo2.jpg');";
verificarEInsertar($conn, 'Psicologos', $sqlInsertPsicologos);

$sqlInsertForo = "INSERT INTO Foro (Titulo, PalabrasClave, Archivo, Cuerpo, IDPaciente) VALUES
('Ansiedad y estrés', 'ansiedad, estrés, salud mental', 'archivo1.pdf', 'Contenido del tema sobre ansiedad...', 1),
('Depresión en adolescentes', 'depresión, adolescentes', 'archivo2.pdf', 'Contenido del tema sobre depresión...', 2),
('Autoestima y autoconcepto', 'autoestima, autoconcepto', 'archivo3.pdf', 'Contenido sobre autoestima...', 3),
('Gestión de emociones', 'emociones, gestión, inteligencia emocional', 'archivo4.pdf', 'Contenido sobre gestión de emociones...', 4),
('Mindfulness y meditación', 'mindfulness, meditación, relajación', 'archivo5.pdf', 'Contenido sobre mindfulness...', 5)";
verificarEInsertar($conn, 'Foro', $sqlInsertForo);

$sqlInsertRespuestas = "INSERT INTO Respuestas (Respuesta, IDForo, IDPaciente) VALUES
('Estoy de acuerdo con el tema de ansiedad...', 1, 1),
('En mi experiencia, la depresión adolescente...', 2, 2),
('El autoconcepto es fundamental...', 3, 3),
('La gestión de emociones es clave...', 4, 4),
('He practicado mindfulness y realmente ayuda...', 5, 5),
('El apoyo grupal en el foro es muy beneficioso...', 1, 2),
('La terapia cognitiva ha sido un cambio de juego para mí...', 2, 3),
('Es importante entender la diferencia entre autoestima y autoeficacia...', 3, 4),
('Aprendiendo a meditar, he encontrado mucha paz...', 4, 5),
('El manejo del estrés es vital para el bienestar diario...', 5, 1),
('El ejercicio regular ha mejorado mi salud mental...', 1, 3),
('La calidad del sueño puede afectar enormemente tu estado de ánimo...', 2, 4),
('Los ejercicios de respiración pueden ayudar con la ansiedad...', 3, 5),
('La nutrición juega un papel importante en la salud mental...', 4, 1),
('Hablar abiertamente sobre problemas es el primer paso para resolverlos...', 5, 2)";
verificarEInsertar($conn, 'Respuestas', $sqlInsertRespuestas);

$sqlInsertCitas = "INSERT INTO Citas (IDPaciente, IDPsicologo, FechaCita, Sintomas, VisitadoAntes) VALUES
(1, 2, '2024-01-30 09:00:00', 'Ansiedad y dificultad para dormir',1),
(2, 3, '2024-02-05 15:00:00', 'Sentimientos de tristeza y aislamiento',0),
(3, 1, '2024-02-15 11:00:00', 'Estrés y problemas de concentración',1),
(4, 5, '2024-03-01 14:00:00', 'Baja autoestima y ansiedad social',0),
(5, 4, '2024-03-20 16:30:00', 'Dificultades en la gestión de la ira',0)";
verificarEInsertar($conn, 'Citas', $sqlInsertCitas);

$sqlInsertInformes = "INSERT INTO Informes (IDPaciente, FechaInforme, RutaPDF) VALUES
(1, '2024-01-30', '../../informes/informe_001.pdf'),
(2, '2024-02-28', '../../informes/informe_002.pdf'),
(3, '2024-03-01', '../../informes/informe_003.pdf');";
verificarEInsertar($conn, 'Informes', $sqlInsertInformes);

// Cerrar la conexión
$conn->close();