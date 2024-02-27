<?php
require_once './bbdd/database.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/output.css">
    <title>Respuesta Foro</title>
    <link rel="icon" href="../media/logo.png" type="image/x-icon">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="font-extralight grid grid-rows-[1fr_min-content] text-primary w-full h-full">
    <div class="h-screen w-screen flex flex-col">
        <!--Desktop header -->
        <header class="hidden px-5 xl:px-20 sm:flex flex-row justify-between items-center py-4">
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
        <header class="sm:hidden bg-white h-20 flex flex-row justify-between items-center p-6 sm:p-10 bg-transparent absolute w-full z-50">
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
        <div class="flex font-extralight flex-col w-full h-full items-end justify-center relative overflow-hidden">
            <!-- <img src="../media/bg-index.png" alt="bgindex" class="w-full z-10"> -->
            <video src="../media/videoindex.mp4" muted autoplay loop class="w-full h-full z-10 object-cover"></video>
            <!-- <div class="flex flex-col absolute z-50 gap-10 text-4xl">
                <p class="">Centro de Excelencia en el</p>
                <p class="">Síndrome de &nbsp;<span class="font-bold">Touretteee</span></p>
                
            </div> -->
            <div class="flex flex-col text-right items-end justify-between py-24 lg:py-52 px-4 sm:px-10 xl:px-20 z-30 absolute h-full w-full">
                <div class="flex flex-col gap-2 text-center sm:text-right text-white items-end text-[40px] sm:text-[82px]">
                    <p>Centro de Excelencia en el</p>
                    <p>Síndrome de &nbsp;<span class="font-bold">Tourette</span></p>
                </div>
                <a class="rounded-full border-2 border-white text-white px-20 py-2 text-2xl w-fit" href="./listado-de-psicologos.php">Pedir Cita</a>
            </div>
        </div>
    </div>
    <!-- nuestros especialistas -->
    <br>
    <br>
    <div class="bg-contraste w-screen h-screen flex flex-col py-10 overflow-x-scroll">
        <p class="text-[50px] sm:text-title text-primary bg-[#d9d9d9] text-center">Nuestros Especialistas</p>
        <div class="w-full h-full flex flex-row items-center px-4 sm:px-20 xl:px-0 xl:justify-around gap-20 overflow-x-scroll">
            <!-- card 1 -->
            <div class="flex flex-row">
                <div class="w-[240px] sm:w-96 shadow-lg shadow-primary bg-white h-[400px] sm:h-[550px] relative flex flex-col items-center">
                    <img src="../media/elipse.png" alt="" class="absolute z-10">
                    <img src="../media/doc.png" alt="" class="absolute z-20 mt-2 sm:mt-8 sm:w-32 sm:h-32 w-24 h-24">
                    <div class="px-4 sm:px-10 flex flex-col gap-6 text-center h-full justify-center py-16">
                        <p class="text-2xl">Dra Rachel Anderson</p>
                        <p class="text-base">Psiquiatra experta en síndrome de Tourette, dedicado a mejorar las
                            estrategias de manejo de tics.</p>
                    </div>
                </div>
                <div class="flex flex-col bg-[#d9d9d9] gap-4 p-2 py-4 h-fit mt-4">
                    <a href="" target="_blank" class="w-8 h-8 sm:w-12 sm:h-12">
                        <img class="" src="../media/linkedin.png" alt="">
                    </a>
                    <a href="" target="_blank" class="w-8 h-8 sm:w-12 sm:h-12">
                        <img class="" src="../media/instafat.png" alt="">
                    </a>
                    <a href="" target="_blank" class="w-8 h-8 sm:w-12 sm:h-12">
                        <img class="" src="../media/facebookfat.png" alt="">
                    </a>
                </div>
            </div>
            <!-- card 2 -->
            <div class="flex flex-row">
                <div class="w-[240px] sm:w-96 shadow-lg shadow-primary bg-white h-[400px] sm:h-[550px] relative flex flex-col items-center">
                    <img src="../media/elipse.png" alt="" class="absolute z-10">
                    <img src="../media/face.png" alt="" class="absolute z-20 mt-2 sm:mt-8 sm:w-32 sm:h-32 w-24 h-24">
                    <div class="px-4 sm:px-10 flex flex-col gap-6 text-center h-full justify-center py-16">
                        <p class="text-2xl">Dr. Carlos Herrera</p>
                        <p class="text-base">Psicoterapia para trastornos del espectro tic y Síndrome de Tourette en
                            niños y adultos.
                        </p>
                    </div>
                </div>
                <div class="flex flex-col bg-[#d9d9d9] gap-4 p-2 py-4 h-fit mt-4">
                    <a href="" target="_blank" class="w-8 h-8 sm:w-12 sm:h-12">
                        <img class="" src="../media/linkedin.png" alt="">
                    </a>
                    <a href="" target="_blank" class="w-8 h-8 sm:w-12 sm:h-12">
                        <img class="" src="../media/instafat.png" alt="">
                    </a>
                    <a href="" target="_blank" class="w-8 h-8 sm:w-12 sm:h-12">
                        <img class="" src="../media/facebookfat.png" alt="">
                    </a>
                </div>
            </div>
            <!-- card 3 -->
            <div class="flex flex-row">
                <div class="w-[240px] sm:w-96 shadow-lg shadow-primary bg-white h-[400px] sm:h-[550px] relative flex flex-col items-center">
                    <img src="../media/elipse.png" alt="" class="absolute z-10">
                    <img src="../media/indian-guy.png" alt="" class="absolute z-20 mt-2 sm:mt-8 sm:w-32 sm:h-32 w-24 h-24">
                    <div class="px-4 sm:px-10 flex flex-col gap-6 text-center h-full justify-center py-16">
                        <p class="text-2xl">Dr. Hassan Raza</p>
                        <p class="text-base">Neuropsicólogo investigador en el impacto cognitivo y social del síndrome
                            de Tourette, creadora de programas de apoyo para pacientes y familias.</p>
                    </div>
                </div>
                <div class="flex flex-col bg-[#d9d9d9] gap-4 p-2 py-4 h-fit mt-4">
                    <a href="" target="_blank" class="w-8 h-8 sm:w-12 sm:h-12">
                        <img class="" src="../media/linkedin.png" alt="">
                    </a>
                    <a href="" target="_blank" class="w-8 h-8 sm:w-12 sm:h-12">
                        <img class="" src="../media/instafat.png" alt="">
                    </a>
                    <a href="" target="_blank" class="w-8 h-8 sm:w-12 sm:h-12">
                        <img class="" src="../media/facebookfat.png" alt="">
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- info -->
    <div class="flex flex-col w-full">
        <!-- section 1 -->
        <section class="flex flex-col lg:flex-row xl:grid grid-cols-2 row px-4 sm:px-20 xl:px-36 py-14 gap-10">
            <div class="flex flex-col items-center justify-center xl:px-20 gap-10">
                <p class="text-[40px] sm:text-[60px] text-center xl:whitespace-nowrap">¿Tienes estos Síntomas?</p>
                <div class="flex flex-row items-end">
                    <div>
                        <p class="text-2xl sm:text-4xl font-light">Reconoce los indicadores clave y aprende más sobre cómo se
                            manifiestan en el
                            día a día.</p>
                    </div>
                    <img src="../media/mareado.gif" alt="" class="hidden sm:block w-20 h-20">
                </div>
            </div>
            <div class="m-auto">
                <img src="../media/section1.png" alt="" class="w-72 lg:w-auto xl:scale-75">
            </div>
        </section>
        <!-- separator -->
        <img src="../media/separator.png" alt="" class="">
        <!-- section2 -->
        <section class="flex flex-col lg:flex-row xl:grid grid-cols-2 row px-4 sm:px-20 xl:px-36 py-14 gap-10">
            <div class="m-auto hidden lg:block">
                <img src="../media/section2.png" alt="" class="w-72 lg:w-auto xl:scale-75">
            </div>
            <div class="flex flex-col items-center justify-center  gap-10">
                <p class="text-[40px] sm:text-[60px] ">Diagnósticos por profesionales</p>
                <div class="flex flex-row items-end">
                    <div>
                        <p class="text-2xl sm:text-4xl font-light">Accede a evaluaciones detalladas y apoyo diagnóstico por parte de
                            nuestro equipo experto.</p>
                    </div>
                    <img src="../media/terapia.gif" alt="" class="hidden sm:block w-20 h-20">
                </div>
            </div>
            <div class="m-auto lg:hidden">
                <img src="../media/section2.png" alt="" class="w-72 lg:w-auto xl:scale-75">
            </div>
        </section>
        <!-- separator -->
        <img src="../media/separator.png" alt="" class="rotate-180">
        <!-- section 3 -->
        <section class="flex flex-col lg:flex-row xl:grid grid-cols-2 row px-4 sm:px-20 xl:px-36 py-14 gap-10">
            <div class="flex flex-col items-center justify-center  gap-10">
                <p class="text-[40px] sm:text-[60px]">Únete a nuestro foro GRATIS</p>
                <div class="flex flex-row items-end">
                    <div>
                        <p class="text-2xl sm:text-4xl font-light">Participa en nuestro foro comunitario para intercambiar
                            historias, consejos y obtener apoyo mutuo.</p>
                    </div>
                    <img src="../media/sociedad.gif" alt="" class="hidden sm:block w-20 h-20">
                </div>
            </div>
            <div class="m-auto">
                <img src="../media/section3.png" alt="" class="w-72 lg:w-auto xl:scale-75">
            </div>
        </section>
    </div>
    <!-- footer -->
    <div class="h-fit flex flex-col sm:flex-row bg-contraste px-4 py-4 gap-4 md:px-12 items-center justify-between">
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
        })
    };
    return false; // Evita la navegación
</script>