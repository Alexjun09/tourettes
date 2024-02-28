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
    <link rel="icon" href="../media/logo.png" type="image/x-icon">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Educacion</title>
</head>
<style>
    #journal-scroll::-webkit-scrollbar {
        width: 4px;
        cursor: pointer;
        /*background-color: rgba(229, 231, 235, var(--bg-opacity));*/
    }

    #journal-scroll::-webkit-scrollbar:horizontal {
        height: 0px;
    }
    #journal-scroll::-webkit-scrollbar-track {
        background-color: rgba(229, 231, 235, var(--bg-opacity));
        cursor: pointer;
        /*background: red;*/
    }

    #journal-scroll::-webkit-scrollbar-thumb {
        cursor: pointer;
        background-color: #a0aec0;
        /*outline: 1px solid slategrey;*/
    }
</style>

<body class="font-extralight grid grid-rows-[1fr_min-content] text-primary w-full h-full " id="journal-scroll">

    <div class="min-h-screen w-screen flex flex-col">
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
        <div class="flex font-extralight flex-col w-full h-full items-center justify-between text-primary gap-4">
            <p class="text-subtitle sm:text-title">Educación</p>
            <div class="w-full bg-primary py-1">
                <p class="text-white text-3xl text-center">Información Básica</p>
            </div>
            <div class="flex flex-col gap-20">
                <article class="flex flex-col px-4 sm:px-10 xl:px-44 gap-5">
                    <div class="overflow-hidden">
                        <img src="../media/educacion1.png" alt="" class="float-left w-[500px] mb-10 mr-10">
                        <p class="text-[24px] sm:text-subtitle">Entendiendo el Síndrome de Tourette</p>
                        <br>
                        <p class="text-[16px] sm:text-body">El Síndrome de Tourette es un trastorno neuropsiquiátrico con inicio en la infancia,
                            caracterizado por múltiples tics motores y al menos un tic vocal. Estos tics suelen ser
                            repentinos, rápidos y recurrentes movimientos o sonidos. El trastorno lleva el nombre del médico
                            francés Georges Gilles de la Tourette, quien fue el primero en describir esta condición en 1885.
                            El síndrome es parte de un espectro de trastornos de tics, que incluye tics transitorios y
                            crónicos. Las personas con Tourette tienen tics que pueden variar en frecuencia y severidad, y a
                            menudo mejoran a medida que transitan hacia la edad adulta. La causa exacta del Síndrome de
                            Tourette no se conoce, pero se cree que es una combinación de factores genéticos y ambientales.
                        </p>
                    </div>
                    <div class="w-full sm:h-[800px]">
                        <iframe class="w-full h-full" src="https://www.youtube.com/embed/irlCibk2Bmw?si=8ZgeuW8K2ZT8jv3W" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                    </div>
                </article>
                <article class="flex flex-col w-full gap-10">
                    <div class="flex justify-center items-center h-fit relative">
                        <img src="../media/educacionseparator.png" alt="">
                        <p class="absolute text-center text-[24px] sm:text-subtitle text-white asbolute">Síntomas Comunes</p>
                    </div>
                    <div class="overflow-hidden px-4 sm:px-10 xl:px-44">
                        <img src="../media/educacion2.png" alt="" class="lg:float-right w-[500px] mb-10 ml-10">
                        <p class="text-[24px] sm:text-subtitle">Reconociendo los Síntomas del Síndrome de Tourette</p>
                        <p class="text-[16px] sm:text-body">Reconocer y entender los síntomas del Síndrome de Tourette es el primer paso para vivir con el trastorno o apoyar a alguien que lo tiene. Es fundamental acercarse a este conocimiento con empatía y el deseo de comprender, para fomentar un entorno de aceptación y apoyo.
                        </p>
                    </div>
                    <div class="flex flex-col px-4 sm:px-20 lg:px-44 text-body gap-5">
                        <ul class="list-disc">
                            <li class="text-[16px] sm:text-body"><span class="font-bold">Tics Motores:</span> Los tics motores son movimientos involuntarios que pueden ser simples o complejos. Los simples incluyen gestos breves como parpadeo rápido, encogimiento de hombros, o muecas faciales.</li>
                            <li class="text-[16px] sm:text-body"><span class="font-bold">Tics Vocales: </span> Los tics vocales también tienen una gama que va de lo simple a lo complejo. Los simples pueden ser sonidos repentinos como carraspeos, gruñidos, o chasquidos. Los complejos pueden involucrar la repetición de palabras, la enunciación de frases fuera de contexto, o incluso la repetición de palabras o frases dichas por otros (ecolalia). </li>
                        </ul>
                        <div class="w-full sm:h-[800px]">
                            <iframe class="w-full h-full" src="https://www.youtube.com/embed/_XXnnlVEKAw?si=7bxi3HQCwImrY8MI" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                        </div>
                    </div>
                </article>
                <article class="flex flex-col gap-10">
                    <div class="flex justify-center items-center h-fit relative">
                        <img src="../media/educacionbg.png" alt="">
                        <p class="absolute text-center text-[24px] sm:text-subtitle text-white asbolute">Guías Educativas</p>
                    </div>
                    <div class="flex flex-col gap-5 px-4 sm:px-20 lg:px-40">
                        <div class="flex flex-col lg:grid grid-cols-3 text-[16px] sm:text-body justify-center items-center">
                            <p>Navegar por el mundo educativo puede ser un desafío para quienes viven con el Síndrome de Tourette.</p>
                            <div class="flex items-center justify-center">
                                <img src="../media/educacion3.png" alt="" class="w-[300px]">
                            </div>
                            <p class="">Nuestras guías están diseñadas para empoderar tanto a los afectados como a los educadores con herramientas y conocimientos para crear entornos inclusivos y comprensivos.</p>
                        </div>
                        <p class="text-[16px] sm:text-body">La sección "Guías Educativas y Estrategias de Manejo" en nuestra web está dedicada a mejorar el entendimiento y manejo del Síndrome de Tourette en contextos educativos, enfatizando la importancia de educar y sensibilizar a compañeros y profesores para fomentar la empatía y la comprensión, ofreciendo materiales informativos para desmitificar los tics y promover la inclusión.</p>
                        <div class="bg-white p-4 sm:p-16 rounded">
                            <div id="accordion-collapse" data-accordion="collapse">
                                <!-- Guia 1 -->
                                <h2 id="accordion-collapse-heading-1">
                                    <button type="button" class="flex items-center justify-between p-5 w-full font-medium text-left border border-gray-200 border-b-0 text-contraste bg-gray-100 rounded-t-xl" data-accordion-target="#accordion-collapse-body-1" aria-expanded="true" aria-controls="accordion-collapse-body-1">
                                        <span class="text-2xl">Guía 1: Navegando el Síndrome de Tourette</span>
                                    </button>
                                </h2>
                                <div id="accordion-collapse-body-1" aria-labelledby="accordion-collapse-heading-1">
                                    <div class="p-5 border border-gray-200 border-b-0">
                                        <!-- Embed del PDF -->
                                        <embed src="./../media/guias/guia1.pdf" type="application/pdf" width="100%" height="600px">
                                    </div>
                                </div>
                                <!-- Guia 2 -->
                                <h2 id="accordion-collapse-heading-2">
                                    <button type="button" class="flex items-center justify-between p-5 w-full font-medium border border-gray-200 border-b-0 text-left text-contraste bg-gray-100 " data-accordion-target="#accordion-collapse-body-2" aria-expanded="false" aria-controls="accordion-collapse-body-2">
                                        <span class="text-2xl">Guía 2: Diagnóstico y tratamiento del síndrome de Tourette y trastornos de tics</span>
                                    </button>
                                </h2>
                                <div id="accordion-collapse-body-2" class="hidden" aria-labelledby="accordion-collapse-heading-2">
                                    <div class="p-5 border border-gray-200 border-b-0">
                                        <!-- Embed del PDF -->
                                        <embed src="./../media/guias/guia2.pdf" type="application/pdf" width="100%" height="600px">
                                    </div>
                                </div>
                                <!-- Guia 3 -->
                                <h2 id="accordion-collapse-heading-3">
                                    <button type="button" class="flex items-center justify-between p-5 w-full font-medium border border-gray-200 border-b-0 text-left text-contraste bg-gray-100 " data-accordion-target="#accordion-collapse-body-3" aria-expanded="false" aria-controls="accordion-collapse-body-3">
                                        <span class="text-2xl">Guía 3: Estrategias educativas para el alumnado con Tics y Síndrome de Tourette</span>
                                    </button>
                                </h2>
                                <div id="accordion-collapse-body-3" class="hidden" aria-labelledby="accordion-collapse-heading-3">
                                    <div class="p-5 border border-gray-200 border-b-0">
                                        <!-- Embed del PDF -->
                                        <embed src="./../media/guias/guia3.pdf" type="application/pdf" width="100%" height="600px">
                                    </div>
                                </div>
                                <!-- Guia 4 -->
                                <h2 id="accordion-collapse-heading-4">
                                    <button type="button" class="flex items-center justify-between p-5 w-full font-medium border border-gray-200 border-b-0 text-left text-contraste bg-gray-100 " data-accordion-target="#accordion-collapse-body-4" aria-expanded="false" aria-controls="accordion-collapse-body-4">
                                        <span class="text-2xl">Guía 4: La tartamudez y el Síndrome de Tourette</span>
                                    </button>
                                </h2>
                                <div id="accordion-collapse-body-4" class="hidden" aria-labelledby="accordion-collapse-heading-4">
                                    <div class="p-5 border border-gray-200 border-b-0">
                                        <!-- Embed del PDF -->
                                        <embed src="./../media/guias/guia4.pdf" type="application/pdf" width="100%" height="600px">
                                    </div>
                                </div>
                                <!-- Guia 5 -->
                                <h2 id="accordion-collapse-heading-5">
                                    <button type="button" class="flex items-center justify-between p-5 w-full font-medium border border-gray-200 border-b-0 text-left text-contraste bg-gray-100 " data-accordion-target="#accordion-collapse-body-5" aria-expanded="false" aria-controls="accordion-collapse-body-5">
                                        <span class="text-2xl">Guía 5: El trastorno de Tourette a lo largo de la historia</span>
                                    </button>
                                </h2>
                                <div id="accordion-collapse-body-5" class="hidden" aria-labelledby="accordion-collapse-heading-5">
                                    <div class="p-5 border border-gray-200 border-b-0">
                                        <!-- Embed del PDF -->
                                        <embed src="./../media/guias/guia5.pdf" type="application/pdf" width="100%" height="600px">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
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
<script src="https://unpkg.com/flowbite@1.3.3/dist/flowbite.js"></script>
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