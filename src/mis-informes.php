<?php
session_start();

if (!isset($_SESSION['idPaciente'])) {
    header('Location: sign-in.html');
    exit();
}

$idPaciente = $_SESSION['idPaciente'];

require_once 'bbdd/connect.php';

$conn = getConexion();

// Obtener detalles del paciente
$query = "SELECT NombreCompleto, TelefonoMovil, FotoPerfil, Banner FROM Pacientes WHERE ID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $idPaciente);
$stmt->execute();
$stmt->bind_result($nombreCompleto, $telefonoMovil, $fotoPerfil, $banner);
$stmt->fetch();
$stmt->close();

// Preparar la consulta para obtener todos los informes del paciente
$query2 = "SELECT FechaInforme, RutaPDF FROM Informes WHERE IDPaciente = ?";
$stmt2 = $conn->prepare($query2);
$stmt2->bind_param("i", $idPaciente);
$stmt2->execute();
$stmt2->bind_result($fechaInforme, $rutaPDF);

$informes = []; // Inicializar un arreglo para almacenar los resultados

// Recuperar los resultados
while ($stmt2->fetch()) {
    $informes[] = ['fechaInforme' => $fechaInforme, 'rutaPDF' => $rutaPDF];
}

$stmt2->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/output.css">
    <link rel="icon" href="../media/logo.png" type="image/x-icon">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Mis Informes</title>
</head>

<body class="font-extralight grid grid-rows-[1fr_min-content] text-primary">
    <div class="flex flex-col h-screen">
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
        <!-- phone header -->        <header class="sm:hidden bg-white h-20 flex flex-row justify-between items-center p-6 sm:p-10 bg-transparent w-full z-50">
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
                        <div class="flex flex-col text-[24px] sm:text-header gap-4">
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
        <div class="flex flex-col w-full h-full items-center justify-center">
            <p class="text-title text-center">Mis Informes</p>
            <?php
            if (count($informes) > 0) {
                foreach ($informes as $index => $informe) {
            ?>
                    <div class="flex flex-col gap-5 px-44 py-10 w-full">
                        <div class="flex flex-row gap-4 w-full items-center">
                            <div class="h-full flex flex-col py-3">
                                <img src="../media/triangle.png" alt="" class="rotate-90 w-10 cursor-pointer" id="arrow-<?php echo $index; ?>">
                            </div>
                            <div class="flex flex-col w-full">
                                <div class="w-full flex flex-row justify-between p-2 bg-primary text-white items-center">
                                    <p class="text-xl"><?php echo $informe['fechaInforme']; ?></p>
                                    <a href="<?php echo $informe['rutaPDF']; ?>" download>
                                        <img src="../media/download.png" alt="" class="w-8">
                                    </a>
                                </div>
                                <div class="w-full h-full bg-contraste hidden" id="contenido-<?php echo $index; ?>">
                                    <iframe src="<?php echo $informe['rutaPDF']; ?>" width="100%" height="100%"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        document.getElementById('arrow-<?php echo $index; ?>').addEventListener('click', function() {
                            var contenido = document.getElementById('contenido-<?php echo $index; ?>');
                            var arrow = document.getElementById('arrow-<?php echo $index; ?>');
                            if (contenido.classList.contains('hidden')) {
                                contenido.classList.remove('hidden');
                                arrow.style.transform = 'rotate(0deg)';
                            } else {
                                contenido.classList.add('hidden');
                                arrow.style.transform = 'rotate(90deg)';
                            }
                        });
                    </script>
            <?php
                }
            } else {
                echo "<h1>Aún no hay informes</h1>";
            }
            ?>
        </div>
    </div>

    <!-- footer -->
   <footer class="h-fit w-full flex flex-col sm:flex-row bg-contraste px-4 py-4 gap-4 md:px-12 items-center justify-between">
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
            </footer>
</body>

</html>
<script>
    const arrow = document.getElementById('arrow');
    arrow.style.transition = 'transform 0.5s';
    arrow.addEventListener('click', () => {
        const contenido = document.getElementById('contenido');
        if (arrow.style.transform === 'rotate(90deg)') {
            arrow.style.transform = 'rotate(0deg)';
            contenido.classList.remove('hidden');
        } else {
            arrow.style.transform = 'rotate(90deg)';
            contenido.classList.add('hidden');
        }
    });


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