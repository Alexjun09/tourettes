<?php
require_once './bbdd/database.php';
session_start();
?>
<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='stylesheet' href='css/output.css'>
    <link rel='icon' href='../media/logo.png' type='image/x-icon'>
    <title>Manejo de Citas</title>
    <style>
        #journal-scroll::-webkit-scrollbar {
            width: 4px;
            cursor: pointer;
        }

        #journal-scroll::-webkit-scrollbar:horizontal {
            height: 0px;
        }

        #journal-scroll::-webkit-scrollbar-track {
            background-color: rgba(229, 231, 235, var(--bg-opacity));
            cursor: pointer;
        }

        #journal-scroll::-webkit-scrollbar-thumb {
            cursor: pointer;
            background-color: #a0aec0;
        }
    </style>
</head>

<body class='font-extralight grid grid-rows-[1fr_min-content] text-primary'>
    <div class='h-screen w-screen flex flex-col'>
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
        <div class='flex font-extralight flex-col w-full h-full items-center justify-center gap-6 px-10'>
            <div class="max-w-[1000px] flex flex-col gap-5">
                <?php
                if (!isset($_SESSION['idPaciente'])) {
                    header('Location: sign-in.html');
                    exit;
                }

                $cita = $_GET['cita'] ?? '';
                if ($cita === 'exito') {
                    echo "
                <div class='w-full h-fit bg-secondary flex flex-col justify-center items-center text-white text-center text-base sm:text-body p-10 gap-2'>
                    <p>¡Muchas gracias por utilizar nuestros servicios!</p>
                    <div class=''>
                        <img src='../media/envelope.png' alt='' class='max-h-[300px]'>
                    </div>
                    <p>En breve, recibirá un correo electrónico con los datos de su cita</p>
                </div>
                ";
                } elseif ($cita === 'eliminado') {
                    echo "
                <div class='w-full h-fit bg-secondary flex flex-col justify-center items-center text-white text-center text-base sm:text-body p-10 gap-4'>
                    <h2 class='text-[24px] font-bold'>Cita Anulada con Éxito</h2>
                    <p>Tu cita ha sido anulada correctamente. Si necesitas reprogramar o tienes alguna pregunta, estamos aquí para ayudarte.</p>
                    <div class='flex flex-col gap-2 mt-4'>
                        <a href='./pedir-cita.php' class='rounded-md bg-primary text-white py-2 px-6'>Programar Nueva Cita</a>
                        <a href='./mi-cuenta.php' class='rounded-md bg-primary text-white py-2 px-6'>Ver Mis Citas</a>
                        <a href='./contacto.php' class='rounded-md bg-primary text-white py-2 px-6'>Contactar Soporte</a>
                    </div>
                </div>
                ";
                } else {
                    echo "
                <div class='w-full h-fit bg-secondary flex flex-col justify-center items-center text-white text-center text-base sm:text-body p-10 gap-2'>
                    <p>¡Lo sentimos!</p>
                    <p>No se ha podido realizar la cita en este momento.</p>
                </div>
                ";
                }
                ?>
                <div class='w-full flex items-start'>
                    <a href='./listado-de-psicologos.php' class='rounded-md border border-primary text-primary py-2 px-6'>Volver</a>
                </div>
            </div>
        </div>
    </div>
    <!-- footer -->
    <div class='h-28 flex flex-row bg-contraste px-12 items-center justify-between'>
        <p>gLabs© 2023. Todos Los Derechos Reservados</p>
        <div class='flex flex-row gap-4'>
            <a href=''>
                <img class='w-10 h-10' src='../media/x.png' alt='x'>
            </a>
            <a href=''>
                <img class='w-10 h-10' src='../media/insta.png' alt='insta'>
            </a>
            <a href=''>
                <img class='w-10 h-10' src='../media/facebook.png' alt='facebook'>
            </a>
        </div>
    </div>
</body>

</html>