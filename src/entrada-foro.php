<?php
require_once 'bbdd/database.php';
$conn = getConexion();

// Verificar si se ha proporcionado un ID de entrada de foro
if (isset($_GET['id'])) {
    // Obtener el ID de la entrada de foro desde la URL
    $idForo = $_GET['id'];

    // Consulta para obtener los detalles de la entrada del foro y su autor
    $queryForo = "SELECT Foro.Titulo, Foro.Cuerpo, Pacientes.NombreCompleto AS Autor, Pacientes.FotoPerfil AS FotoPerfilAutor
                  FROM Foro
                  JOIN Pacientes ON Foro.IDPaciente = Pacientes.ID
                  WHERE Foro.ID = ?";
    $stmtForo = $conn->prepare($queryForo);
    $stmtForo->bind_param('i', $idForo);
    $stmtForo->execute();
    $stmtForo->store_result();

    // Consulta para obtener las respuestas asociadas a la entrada del foro
    $queryRespuestas = "SELECT Respuesta, Pacientes.NombreCompleto AS AutorRespuesta
                        FROM Respuestas
                        JOIN Pacientes ON Respuestas.IDPaciente = Pacientes.ID
                        WHERE IDForo = ?";
    $stmtRespuestas = $conn->prepare($queryRespuestas);
    $stmtRespuestas->bind_param('i', $idForo);
    $stmtRespuestas->execute();
    $stmtRespuestas->store_result();

    // Verificar si se encontraron resultados para la entrada del foro
    if ($stmtForo->num_rows > 0) {
        $stmtForo->bind_result($tituloForo, $cuerpoForo, $autorForo, $fotoPerfilAutor);
        $stmtForo->fetch();

?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="css/output.css">
            <link rel="icon" href="../media/logo.png" type="image/x-icon">
            <title>Entrada al Foro</title>
            <script src="scripts/procesar-entradaforo.js"></script>
        </head>

        <body class="font-extralight grid grid-rows-[1fr_min-content] text-primary">
            <div class="w-screen flex flex-col pb-20">
                <!-- header -->
                <div class="px-20 flex flex-row justify-between items-center py-4">
                    <a class="h-16" href="./index.php">
                        <img src="../media/logoindex.png" alt="Foto de perfil del autor" class="h-full">
                    </a>
                    <nav class="flex flex-row gap-10 text-primary text-lg">
                        <a href="./educacion.php">Educación</a>
                        <a href="./listado-de-psicologos.php">Pedir Cita</a>
                        <a href="./comunidad.php">Comunidad</a>
                        <a href="./contacto.html">Contacto</a>
                    </nav>
                    <a class="rounded-tl-xl rounded-br-xl border-br-xl bg-primary text-white py-2 px-10" href="./mi-cuenta.php">Mi Cuenta</a>
                </div>
                <!-- body -->
                <div class="flex flex-col w-full h-full items-center px-20 gap-5">
                    <div class="flex flex-col gap-4 text-center">
                        <p class="text-title">Comunidad</p>
                    </div>
                    <div class="w-full flex-flex-col bg-primary py-1 h-full  text-white">
                        <div class="flex flex-row w-full px-4 bg-contraste justify-between">
                            <p class="">fecha</p>
                            <p>Respuestas</p>
                        </div>
                        <br>
                        <div class="grid grid-cols-[min-content_1fr_min-content]">
                            <div class=" p-4">
                                <img src="<?php echo $fotoPerfilAutor; ?>" alt="Foto de perfil del autor" class="min-w-28 rounded-full">
                            </div>
                            <div class="flex flex-col gap-4 pb-10">
                                <div class="w-full bg-secondary  p-2">
                                    <p class="text-lg"><?php echo htmlspecialchars($autorForo); ?></p>
                                </div>
                                <div class="w-full bg-secondary p-2">
                                    <p class="text-5xl font-bold text-center"><?php echo htmlspecialchars($tituloForo); ?></p>
                                </div>
                                <div class="">
                                    <div class="">
                                        <img src="../media/index2.png" alt="" class="float-left max-w-[300px] mr-4">
                                    </div>
                                    <p class="text-body"><?php echo htmlspecialchars($cuerpoForo); ?></p>
                                </div>
                                <div class="w-full flex flex-col bg-contraste items-center rounded-md p-4 gap-4">
                                    <div class="w-[80%] bg-secondary rounded-md">
                                        <p class="text-4xl text-center">Respuestas</p>
                                    </div>
                                    <?php
                                    // Verificar si hay respuestas asociadas
                                    if ($stmtRespuestas->num_rows > 0) {
                                        $stmtRespuestas->bind_result($respuesta, $autorRespuesta);
                                        while ($stmtRespuestas->fetch()) {
                                            $queryFotoPerfil = "SELECT FotoPerfil FROM Pacientes WHERE NombreCompleto = ?";
                                            $stmtFotoPerfil = $conn->prepare($queryFotoPerfil);
                                            $stmtFotoPerfil->bind_param('s', $autorRespuesta);
                                            $stmtFotoPerfil->execute();
                                            $stmtFotoPerfil->bind_result($fotoPerfilAutor);
                                            $stmtFotoPerfil->fetch();
                                            $stmtFotoPerfil->close();

                                            // Ahora puedes mostrar la foto del perfil del autor correspondiente
                                            echo '<div class="rounded-md bg-primary grid grid-cols-[1fr_6fr] w-[650px] p-1">';
                                            echo '<div class="p-3">';
                                            echo '<img src="' . htmlspecialchars($fotoPerfilAutor) . '" alt="" class="rounded-full">';
                                            echo '</div>';
                                            echo '<div class="flex flex-col">';
                                            echo '<p class="text-white bg-secondary w-fit px-2">' . htmlspecialchars($autorRespuesta) . '</p>';
                                            echo '<p>' . htmlspecialchars($respuesta) . '</p>';
                                            echo '</div>';
                                            echo '</div>';
                                        }
                                    } else {
                                        echo "<p>No hay respuestas para esta entrada del foro.</p>";
                                    }
                                    ?>

                                </div>
                                <div class="w-full flex flex-row justify-end h-fit">
                                    <a href="./respuesta-foro.php?id=<?php echo $idForo; ?>" class="border-2 border-white py-2 px-8 bg-transparent rounded-full w-fit">Responder</a>
                                </div>
                            </div>
                            <div class="w-32">
                            </div>
                        </div>
                    </div>
                    <div class="w-full flex flex-row">
                        <a class="rounded-tl-xl rounded-br-xl border-br-xl bg-primary text-white py-2 px-10" href="./comunidad.php">Volver</a>
                    </div>
                </div>
            </div>
            <!-- footer -->
            <div class="h-28 flex flex-row bg-contraste px-12 items-center justify-between">
                <p>gLabs© 2023. Todos Los Derechos Reservados</p>
                <div class="flex flex-row gap-4">
                    <a href="">
                        <img class="w-10 h-10" src="../media/x.png" alt="x">
                    </a>
                    <a href="">
                        <img class="w-10 h-10" src="../media/insta.png" alt="insta">
                    </a>
                    <a href="">
                        <img class="w-10 h-10" src="../media/facebook.png" alt="facebook">
                    </a>
                </div>
            </div>
        </body>

        </html>

<?php
    } else {
        // Mostrar un mensaje si no se encontró la entrada del foro
        echo "<p>No se encontró la entrada del foro.</p>";
    }

    // Cerrar las consultas y la conexión a la base de datos
    $stmtForo->close();
    $stmtRespuestas->close();
    $conn->close();
} else {
    // Mostrar un mensaje si no se proporcionó un ID de entrada de foro
    echo "<p>No se proporcionó un ID de entrada de foro.</p>";
}
?>