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
    GoogleID VARCHAR(255),
    AuthMethod ENUM('traditional', 'google') NOT NULL,
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
    Fecha DATE,
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
('Juan Pérez', '612345678', 30, '../media/profile/profile3.jpg', '../media/bgcuenta.png'),
('Ana García', '623456789', 25, '../media/profile/profile2.jpg', '../media/bgcuenta.png'),
('Carlos Sánchez', '634567890', 40, '../media/profile/profile4.jpg', '../media/bgcuenta.png'),
('Laura Gómez', '645678901', 35, '../media/profile/profile5.jpg', '../media/bgcuenta.png'),
('María López', '656789012', 28, '../media/profile/profile1.jpg', '../media/bgcuenta.png')";
verificarEInsertar($conn, 'Pacientes', $sqlInsertPacientes);



$contrasenas = [
    'contrasena1',
    'contrasena2',
    'contrasena3',
    'contrasena4',
    'contrasena5'
];

$authMethod = 'traditional';

// Cifrar cada contraseña y preparar las consultas de inserción
foreach ($contrasenas as $indice => $contrasenaPlana) {
    // Cifrar la contraseña
    $contrasenaCifrada = password_hash($contrasenaPlana, PASSWORD_DEFAULT);

    $sqlInsertCuenta = "INSERT INTO Cuenta (Email, NombreUsuario, Contrasena, AuthMethod, IDPaciente) VALUES
    ('a@gmail.com', 'juanperez1', '$contrasenaCifrada', '$authMethod', 1),
    ('anagarcia@mail.com', 'anitagarcia2', '$contrasenaCifrada', '$authMethod', 2),
    ('carlossanchez@mail.com', 'carlosanchez3', '$contrasenaCifrada', '$authMethod', 3),
    ('lauragomez@mail.com', 'laurita4', '$contrasenaCifrada', '$authMethod', 4),
    ('pedrolopez@mail.com', 'pedrolopez5', '$contrasenaCifrada', '$authMethod', 5);";
    verificarEInsertar($conn, 'Cuenta', $sqlInsertCuenta);
}
$sqlInsertPsicologos = "INSERT INTO Psicologos (NombreCompleto, Especialidad, Ubicacion, Idiomas, Metodologia, Educacion, FotoPsicologo) VALUES
('Dr. Hassan Raza', 'Psicología Clínica con énfasis en terapias para el Síndrome de Tourette', 'Santiago de Chile, Chile', 'Español, Inglés', 'Terapias conductuales especializadas, Técnicas de relajación y control de tics', 'Doctorado en Psicología Clínica, Universidad de Santiago de Chile, 2020','../../media/psicologos/psicologo6.jpg'),
('Dra. Rachel Anderson', 'Psicología Pediátrica y Trastornos de Tic', 'Bogotá, Colombia', 'Español, Portugués', 'Intervención cognitivo-conductual, Educación y apoyo a familias', 'Máster en Psicología Pediátrica, Universidad Nacional de Colombia, 2021','../../media/psicologos/psicologa5.jpg'),
('Dr. Carlos Herrera', 'Psicoterapia para trastornos del espectro tic y Síndrome de Tourette', 'Ciudad de México, México', 'Español, Inglés', 'Intervención en psicología positiva, Estrategias de afrontamiento', 'Especialidad en Psicología Clínica, Universidad Nacional Autónoma de México, 2017','../../media/psicologos/psicologo4.jpg'),
('Dra. Laura Gómez', 'Psicología Infantil, enfocada en Síndrome de Tourette', 'Madrid, España', 'Español, Inglés', 'Terapia cognitivo-conductual, Técnicas de modificación de hábitos', 'Máster en Psicología Clínica y de la Salud, Universidad Autónoma de Madrid, 2018','../../media/psicologos/psicologa1.jpg'),
('Dra. Sofia Tan', 'Psicología del Desarrollo y Trastornos del Movimiento', 'Buenos Aires, Argentina', 'Español, Chino Mandarín', 'Terapia de aceptación y compromiso, Entrenamiento en manejo de tics', 'Máster en Psicología del Desarrollo, Universidad de Buenos Aires, 2020', '../../media/psicologos/psicologo3.jpg'),
('Dr. David Abioye', 'Psicología Clínica con subespecialidad en Neuropsicología', 'Lagos, Nigeria', 'Inglés, Yoruba, Español', 'Evaluación neuropsicológica, Intervenciones psicoeducativas', 'Doctorado en Psicología Clínica, Universidad de Ibadan, 2019','../../media/psicologos/psicologo2.jpg');";
verificarEInsertar($conn, 'Psicologos', $sqlInsertPsicologos);

$sqlInsertForo = "INSERT INTO Foro (Titulo, PalabrasClave, Archivo, Cuerpo, Fecha, IDPaciente) VALUES
    ('Ansiedad y estrés', 'ansiedad, estrés, salud mental', '../media/entradaforo/tourette1.jpg', 'La ansiedad y el estrés son problemas comunes en la sociedad moderna. La ansiedad se manifiesta de diferentes formas y puede afectar significativamente la vida diaria de una persona. Puede ser causada por una variedad de factores, como el trabajo, las relaciones personales, la salud y otros aspectos de la vida. El estrés, por otro lado, es una respuesta natural del cuerpo a situaciones desafiantes o amenazantes. Aunque el estrés puede ser útil en pequeñas dosis, el estrés crónico puede tener efectos negativos en la salud física y mental. En este tema, exploraremos los síntomas, las causas y las estrategias de afrontamiento para la ansiedad y el estrés.','2024-01-02', 1),
    ('Depresión en adolescentes', 'depresión, adolescentes', '../media/entradaforo/tourette2.jpg', 'La depresión en adolescentes es un tema importante en la salud mental. Los adolescentes enfrentan una variedad de desafíos durante esta etapa de la vida, incluidos cambios hormonales, presiones académicas, problemas familiares y cambios en las relaciones sociales. Estos factores pueden contribuir al desarrollo de la depresión. La depresión puede manifestarse de diferentes maneras en los adolescentes, como cambios en el estado de ánimo, pérdida de interés en actividades que solían disfrutar, problemas de sueño y pensamientos suicidas. Es importante abordar la depresión en los adolescentes de manera temprana y brindarles el apoyo necesario para superar esta dificultad.', '2024-01-14', 2),
    ('Autoestima y autoconcepto', 'autoestima, autoconcepto', '../media/entradaforo/tourette3.jpg', 'La autoestima y el autoconcepto son aspectos fundamentales de la salud mental y el bienestar. La autoestima se refiere a la valoración que una persona tiene de sí misma, mientras que el autoconcepto se refiere a la percepción que una persona tiene de sus habilidades, características y roles en la vida. Ambos juegan un papel importante en la forma en que una persona se ve a sí misma y cómo interactúa con el mundo que la rodea. Una autoestima y un autoconcepto saludables pueden contribuir a una mayor confianza, resiliencia y satisfacción con la vida. En este tema, exploraremos estrategias para mejorar la autoestima y el autoconcepto, así como la importancia de cultivar una imagen positiva de uno mismo.','2024-02-02', 3),
    ('Gestión de emociones', 'emociones, gestión, inteligencia emocional', '../media/entradaforo/tourette4.jpg', 'La gestión de emociones es un componente crucial de la inteligencia emocional y el bienestar emocional. Consiste en reconocer, comprender y regular las propias emociones de manera efectiva. La capacidad de gestionar adecuadamente las emociones puede ayudar a reducir el estrés, mejorar las relaciones interpersonales y promover un mayor bienestar psicológico. En este tema, exploraremos diversas estrategias para la gestión de emociones, como la práctica de la atención plena, la expresión emocional saludable y el desarrollo de habilidades de afrontamiento efectivas.','2024-02-10', 4),
    ('Mindfulness y meditación', 'mindfulness, meditación, relajación', '../media/entradaforo/tourette5.jpg', 'El mindfulness y la meditación son prácticas ancestrales que han ganado popularidad en el mundo moderno debido a sus beneficios para la salud mental y el bienestar. El mindfulness se refiere a la conciencia plena del momento presente, sin juzgar los pensamientos o sentimientos que surgen. La meditación, por otro lado, implica dedicar tiempo a prácticas específicas que fomentan la relajación, la atención y la claridad mental. Ambas prácticas han demostrado ser eficaces para reducir el estrés, mejorar la concentración y promover una mayor sensación de calma y equilibrio interior. En este tema, exploraremos los fundamentos del mindfulness y la meditación, así como las diversas técnicas que se pueden utilizar para incorporar estas prácticas en la vida cotidiana.','2024-02-22', 5)";

// Verificar e insertar
verificarEInsertar($conn, 'Foro', $sqlInsertForo);


$sqlInsertRespuestas = "INSERT INTO Respuestas (Respuesta, IDForo, IDPaciente) VALUES
    ('Estoy de acuerdo con el tema de ansiedad. La ansiedad es una respuesta natural del cuerpo frente a situaciones estresantes, pero cuando se vuelve excesiva puede afectar seriamente la calidad de vida. Personalmente, he experimentado momentos de ansiedad intensa y he encontrado útil aprender técnicas de respiración y mindfulness para gestionarla. Además, creo que es importante buscar apoyo en personas cercanas y profesionales de la salud mental.', 1, 1),
    ('La depresión en adolescentes es un tema que me toca de cerca. Durante mi adolescencia, experimenté períodos de profunda tristeza y desesperanza. Afortunadamente, pude encontrar ayuda en terapia y medicación, lo que me permitió superar esos momentos difíciles. Sin embargo, reconozco lo crucial que es el apoyo de amigos y familiares durante este proceso. Es importante destigmatizar la depresión y fomentar un ambiente de apertura y comprensión para que los adolescentes se sientan cómodos buscando ayuda.', 2, 2),
    ('El autoconcepto es un aspecto fundamental de la salud mental y el bienestar emocional. Durante años luché con una baja autoestima y una imagen negativa de mí mismo. Sin embargo, a través de la terapia y el autodescubrimiento, he aprendido a valorarme y aceptarme tal como soy. Creo que es importante que las personas trabajen en desarrollar una autoimagen positiva y cultivar la confianza en sí mismas para vivir una vida plena y satisfactoria.', 3, 3),
    ('La gestión de emociones es una habilidad vital para navegar por los desafíos de la vida cotidiana. A lo largo de los años, he aprendido a identificar mis emociones y a expresarlas de manera saludable. Esto ha sido fundamental para mantener relaciones saludables y manejar el estrés. La terapia cognitivo-conductual ha sido especialmente útil para mí en este proceso, ya que me ha proporcionado herramientas prácticas para regular mis emociones y mejorar mi bienestar general.', 4, 4),
    ('El mindfulness y la meditación son prácticas que han transformado mi vida. A través de la meditación regular, he aprendido a cultivar la atención plena y a vivir en el momento presente. Esto me ha ayudado a reducir el estrés, mejorar mi concentración y encontrar una mayor paz interior. Recomiendo encarecidamente a cualquier persona que esté lidiando con la ansiedad o el estrés que pruebe la meditación como una herramienta para promover el bienestar mental.', 5, 5),
    ('He encontrado un gran apoyo en este foro mientras navego por mi viaje de recuperación de la ansiedad. Leer las experiencias y consejos de otras personas que están pasando por situaciones similares me ha ayudado a sentirme menos sola y más esperanzada en mi capacidad para superar los desafíos. Agradezco profundamente la comunidad que se ha formado aquí y espero poder devolver el favor compartiendo mi propia experiencia y conocimiento.', 1, 2),
    ('La terapia cognitiva ha sido un verdadero cambio de juego para mí en mi lucha contra la depresión. A través de la terapia, he aprendido a desafiar y cambiar mis pensamientos negativos, lo que ha tenido un impacto significativo en mi estado de ánimo y mi calidad de vida. Si estás luchando con la depresión, te animo a que consideres buscar ayuda profesional. La terapia puede marcar la diferencia.', 2, 3),
    ('Entender la diferencia entre autoestima y autoeficacia ha sido fundamental en mi viaje de autoaceptación y crecimiento personal. Mientras que la autoestima se refiere a la valoración global de uno mismo, la autoeficacia se trata de la confianza en la capacidad de uno para enfrentar desafíos y alcanzar metas. Trabajar en desarrollar ambas áreas puede ser transformador y empoderador.', 3, 4),
    ('La práctica regular de mindfulness y meditación ha sido una verdadera bendición en mi vida. A través de la meditación, he aprendido a cultivar la calma interior y a encontrar un sentido de paz y equilibrio en medio del caos. Recomiendo encarecidamente la meditación a cualquier persona que busque reducir el estrés y mejorar su bienestar emocional.', 4, 5),
    ('El manejo del estrés es una habilidad vital en el mundo actual, donde las demandas y presiones pueden ser abrumadoras. Para mí, el ejercicio regular ha sido una forma efectiva de reducir el estrés y mejorar mi salud mental. Ya sea caminar, correr o practicar yoga, encontrar una actividad que te ayude a liberar tensiones puede marcar una gran diferencia en tu bienestar general.', 5, 1),
    ('El ejercicio regular ha sido una parte integral de mi estrategia de cuidado personal para mantener una buena salud mental. Además de los beneficios físicos, como la liberación de endorfinas, el ejercicio también puede mejorar el estado de ánimo y reducir los síntomas de ansiedad y depresión. Te animo a que encuentres una actividad física que disfrutes y la integres en tu rutina diaria.', 1, 3),
    ('La calidad del sueño juega un papel crucial en el bienestar emocional y mental. Durante períodos de depresión, el sueño puede verse afectado, lo que puede empeorar los síntomas. He descubierto que establecer una rutina de sueño consistente y crear un ambiente propicio para dormir puede mejorar significativamente la calidad de mi sueño y mi estado de ánimo en general.', 2, 4),
    ('Los ejercicios de respiración son una herramienta simple pero efectiva para reducir la ansiedad y promover la relajación. Durante momentos de estrés o angustia, dedicar unos minutos a practicar la respiración profunda puede ayudar a calmar la mente y el cuerpo. Te animo a que pruebes diferentes técnicas de respiración y encuentres la que mejor funcione para ti.', 3, 5),
    ('La nutrición adecuada es esencial para mantener una buena salud mental. Una dieta equilibrada que incluya una variedad de alimentos ricos en nutrientes puede tener un impacto positivo en el estado de ánimo y la función cognitiva. Personalmente, he notado una mejora en mi bienestar emocional al priorizar alimentos frescos y nutritivos en mi dieta diaria.', 4, 1),
    ('Hablar abiertamente sobre los problemas es el primer paso para superarlos. A lo largo de mi viaje de salud mental, he aprendido la importancia de expresar mis emociones y compartir mis preocupaciones con personas de confianza. La terapia de grupo ha sido especialmente beneficiosa para mí, ya que me ha brindado un espacio seguro para conectarme con otras personas que entienden mis luchas.', 5, 2)";

// Verificar e insertar
verificarEInsertar($conn, 'Respuestas', $sqlInsertRespuestas);

$sqlInsertCitas = "INSERT INTO Citas (IDPaciente, IDPsicologo, FechaCita, Sintomas, VisitadoAntes) VALUES
(1, 2, '2024-01-30 09:00:00', 'Ansiedad y dificultad para dormir',1),
(2, 3, '2024-02-05 15:00:00', 'Sentimientos de tristeza y aislamiento',0),
(3, 1, '2024-02-15 11:00:00', 'Estrés y problemas de concentración',1),
(4, 5, '2024-03-01 14:00:00', 'Baja autoestima y ansiedad social',0),
(5, 4, '2024-03-20 16:30:00', 'Dificultades en la gestión de la ira',0)";
verificarEInsertar($conn, 'Citas', $sqlInsertCitas);

$sqlInsertInformes = "INSERT INTO Informes (IDPaciente, FechaInforme, RutaPDF) VALUES
(1, '2024-01-30', '../informes/informe1.pdf'),
(1, '2024-02-10', '../informes/informe2.pdf'),
(2, '2024-02-28', '../informes/informe1.pdf'),
(3, '2024-03-01', '../informes/informe1.pdf');";
verificarEInsertar($conn, 'Informes', $sqlInsertInformes);

// Cerrar la conexión
$conn->close();
