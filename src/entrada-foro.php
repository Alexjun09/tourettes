<?php
session_start();
require_once 'bbdd/database.php';
$conn = getConexion();


// Verificar si se ha proporcionado un ID de entrada de foro
if (isset($_GET['id'])) {
    // Obtener el ID de la entrada de foro desde la URL
    $idForo = $_GET['id'];

    // Consulta para obtener los detalles de la entrada del foro y su autor
    $queryForo = "SELECT Foro.Titulo, Foro.Cuerpo, Foro.Archivo, Foro.Fecha, Pacientes.NombreCompleto AS Autor, Pacientes.FotoPerfil AS FotoPerfilAutor, Foro.IDPaciente
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
        $stmtForo->bind_result($tituloForo, $cuerpoForo, $archivoForo, $fechaForo, $autorForo, $fotoPerfilAutor, $idPaciente);
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
            <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        </head>

        <body class="font-extralight grid grid-rows-[1fr_min-content] text-primary">
            <div class="w-screen flex flex-col pb-20">
                <!--Desktop header -->
                <header class="hidden px-5 xl:px-20 sm:flex flex-row justify-between items-center py-4 w-full">
                    <a class="h-16" href="./index.php">
                        <img src="../media/logoindex.png" alt="" class="h-full hidden lg:block">
                        <img src="../media/logo.png" alt="" class="h-full lg:hidden">
                    </a>
                    <nav class="flex flex-row gap-5 lg:gap-10 text-primary text-lg">
                        <a href="./educacion.php">Educación</a>
                        <a href="./listado-de-psicologos.php">Pedir Cita</a>
                        <a href="./comunidad.php">Comunidad</a>
                        <a href="./contacto.php">Contacto</a>
                    </nav>
                    <!-- Suponiendo que ya iniciaste la sesión con session_start(); al principio de tu script PHP -->
                    <div class="flex flex-row justify-between items-center gap-4">
                        <!-- Otros elementos del header aquí -->

                        <!-- Verificar si existe el id de paciente en la sesión -->
                        <?php if (isset($_SESSION['idPaciente'])) : ?>
                            <!-- Botón Mi Cuenta para usuarios logueados -->
                            <a class="rounded-tl-xl rounded-br-xl border-br-xl bg-primary text-white py-2 px-10" href="./mi-cuenta.php">Mi Cuenta</a>
                            <a href="#" onclick="confirmarCerrarSesion();">
                                <img src="../media/cerrar-sesion.png" alt="Cerrar Sesión" class="rounded-tl-xl rounded-br-xl h-10">
                            </a>
                        <?php else : ?>
                            <!-- Botones Sign in y Sign up para usuarios no logueados -->
                            <a class="rounded-tl-xl rounded-br-xl border-br-xl bg-primary text-white py-2 px-6" href="./sign-in.html">Sign in</a>
                            <a class="rounded-tl-xl rounded-br-xl border-br-xl bg-primary text-white py-2 px-6" href="./sign-up.html">Sign up</a>
                        <?php endif; ?>

                        <!-- Otros elementos del header aquí -->
                    </div>
                </header>
                <!-- phone header -->
                <header class="sm:hidden bg-white h-20 flex flex-row justify-between items-center p-6 sm:p-10 bg-transparent w-full z-50">
                    <a class="h-16" href="./index.php">
                        <img src="../media/logo.png" alt="" class="h-full lg:hidden">
                    </a>
                    <div class="flex">
                        <input type="checkbox" id="drawer-toggle" class="relative sr-only peer" />
                        <label for="drawer-toggle" class="top-0 left-0 inline-block transition-all duration-500 rounded-lg peer-checked:rotate-180 z-50 cursor-pointer">
                            <svg viewBox="0 0 41 27" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-10 h-10">
                                <line y1="1" x2="41" y2="1" stroke="black" stroke-width="2"></line>
                                <line y1="13" x2="41" y2="13" stroke="black" stroke-width="2"></line>
                                <line y1="26" x2="41" y2="26" stroke="black" stroke-width="2"></line>
                            </svg>
                        </label>
                        <div class="fixed top-0 right-0 w-full h-full transition-all duration-500 transform translate-x-full bg-white shadow-lg peer-checked:translate-x-0 z-40">
                            <div class="w-full h-full bg-turquoise flex flex-col sm:flex-row xl:grid grid-cols-2 items-start sm:items-center px-10 sm:px-10 xl:px-60 py-40 justify-between">
                                <div class="flex flex-col text-2xl sm:text-header gap-4">
                                    <a class="hover:font-light hover:text-solarOrange ease-in duration-100" href="index.php">Home</a>
                                    <a class="hover:font-light hover:text-solarOrange ease-in duration-100" href="educacion.php">Educacion</a>
                                    <a class="hover:font-light hover:text-solarOrange ease-in duration-100" href="pedir-cita.php">Pedir Cita</a>
                                    <a class="hover:font-light hover:text-solarOrange ease-in duration-100" href="comunidad.php">Comunidad</a>
                                    <a class="hover:font-light hover:text-solarOrange ease-in duration-100" href="contacto.php">Contacto</a>
                                </div>
                                <div class="flex flex-col justify-between items-center gap-4">
                                    <!-- Otros elementos del header aquí -->

                                    <!-- Verificar si existe el id de paciente en la sesión -->
                                    <?php if (isset($_SESSION['idPaciente'])) : ?>
                                        <!-- Botón Mi Cuenta para usuarios logueados -->
                                        <a class="rounded-tl-xl rounded-br-xl border-br-xl bg-primary text-white py-2 px-10" href="./mi-cuenta.php">Mi Cuenta</a>
                                        <a href="#" onclick="confirmarCerrarSesion();">
                                            <img src="../media/cerrar-sesion.png" alt="Cerrar Sesión" class="rounded-tl-xl rounded-br-xl h-10">
                                        </a>
                                    <?php else : ?>
                                        <!-- Botones Sign in y Sign up para usuarios no logueados -->
                                        <a class="rounded-tl-xl rounded-br-xl border-br-xl bg-primary text-white py-2 px-6" href="./sign-in.html">Sign in</a>
                                        <a class="rounded-tl-xl rounded-br-xl border-br-xl bg-primary text-white py-2 px-6" href="./sign-up.html">Sign up</a>
                                    <?php endif; ?>

                                    <!-- Otros elementos del header aquí -->
                                </div>
                                <div class="flex justify-start sm:justify-end w-min xl:w-full">
                                    <div class="flex flex-row w-40 gap-4 items-end justify-end">
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
                            </div>
                        </div>
                    </div>
                </header>
                <!-- body -->
                <div class="flex flex-col w-full h-full items-center px-4 lg:px-20 gap-5">
                    <div class="flex flex-col gap-4 text-center">
                        <p class="text-4xl sm:text-title">Comunidad</p>
                    </div>
                    <div class="w-full flex-flex-col bg-primary py-1 h-full  text-white">
                        <div class="flex flex-row w-full px-4 bg-contraste justify-between">
                            <p class=""><?php echo $fechaForo ?></p>
                            <p><?php echo $stmtRespuestas->num_rows; ?> respuestas</p>
                        </div>
                        <br>
                        <div class="flex flex-col lg:grid grid-cols-[min-content_1fr_min-content]">
                            <div class="hidden lg:block p-4">
                                <img src="<?php echo $fotoPerfilAutor; ?>" alt="Foto de perfil del autor" class="min-w-28 rounded-full object-cover aspect-square">
                            </div>
                            <div class="flex flex-col gap-4 pb-10">
                                <div class="w-full bg-secondary  p-2">
                                    <p class="text-lg"><?php echo htmlspecialchars($autorForo); ?></p>
                                </div>
                                <div class="w-full bg-secondary p-2">
                                    <p class="text-2xl sm:text-5xl font-bold text-center"><?php echo htmlspecialchars($tituloForo); ?></p>
                                </div>
                                <div class="px-4 lg:px-0">
                                    <div class="">
                                        <?php
                                        // Verificar si hay un archivo adjunto en la entrada del foro
                                        if (!empty($archivoForo)) {
                                            echo '<img src="' . htmlspecialchars($archivoForo) . '" alt="Archivo adjunto" class="sm:float-left sm:max-w-[300px] mr-4">';
                                        } else {
                                            echo '<img src="../media/index2.png" alt="" class="sm:float-left sm:max-w-[300px] mr-4">';
                                        }
                                        ?>
                                    </div>
                                    <p class="text-base sm:text-body"><?php echo htmlspecialchars($cuerpoForo); ?></p>
                                </div>
                                <div class="w-full flex flex-col bg-contraste items-center rounded-md p-4 gap-4 self-center">
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
                                            echo '<div class="rounded-md bg-primary flex flex-col sm:grid grid-cols-[1fr_6fr] max-w-[600px] p-1">';
                                            echo '<div class="flex p-3 w-full sm:w-fit items-center justify-center">';
                                            echo '<img src="' . htmlspecialchars($fotoPerfilAutor) . '" alt="" class="rounded-full object-cover  aspect-square max-w-[100px] sm:w-auto">';
                                            echo '</div>';
                                            echo '<div class="flex flex-col items-center sm:items-start px-2 sm:px-0">';
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
                                    <a href="./respuesta-foro.php?idForo=<?php echo $idForo; ?>&idPaciente=<?php echo $idPaciente; ?>" class="border-2 border-white py-2 px-8 bg-transparent rounded-full w-fit">Responder</a>
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
        <script>
            function confirmarCerrarSesion() {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¿Quieres cerrar la sesión?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#1D3A46',
                    cancelButtonColor: '#92AAB3',
                    confirmButtonText: 'Cerrar Sesión',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Asumiendo que tienes un archivo logout.php que maneja el cierre de sesión
                        window.location.href = './server/logout.php';
                    }
                });
                return false; // Evita la navegación
            }
        </script>

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