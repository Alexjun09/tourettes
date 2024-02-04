<?php
require_once './bbdd/database.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./output.css">
    <title>Respuesta Foro</title>
</head>

<body class="grid grid-rows-[1fr_min-content] text-primary">
    <div class="h-screen w-screen flex flex-col">
        <!-- header -->
        <div class="px-20 flex flex-row justify-between items-center py-4">
            <a class="h-16" href="./index.php">
                <img src="../media/logoindex.png" alt="" class="h-full">
            </a>
            <nav class="flex flex-row gap-10 text-primary text-lg">
                <a href="./educacion.html">Educación</a>
                <a href="./listado-de-psicologos.php">Pedir Cita</a>
                <a href="./comunidad.html">Comunidad</a>
                <a href="./about-us.html">About Us</a>
            </nav>
            <a class="rounded-tl-xl rounded-br-xl border-br-xl bg-primary text-white py-2 px-10" href="./mi-cuenta.php">Mi Cuenta</a>
        </div>
        <!-- body -->
        <div class="flex flex-col w-full h-full items-end justify-center relative overflow-hidden">
            <!-- <img src="../media/bg-index.png" alt="bgindex" class="w-full z-10"> -->
            <video src="../media/videoindex.mp4" muted autoplay loop class="w-full z-10"></video>
            <!-- <div class="flex flex-col absolute z-50 gap-10 text-4xl">
                <p class="">Centro de Excelencia en el</p>
                <p class="">Síndrome de &nbsp;<span class="font-bold">Touretteee</span></p>
                
            </div> -->
            <div class="flex flex-col text-right items-end justify-between py-52 px-20 z-30 absolute h-full w-full">
                <div class="flex flex-col gap-2 text-right text-white items-end">
                    <p class="text-[100px]" style="font-size: 82px;">Centro de Excelencia en el</p>
                    <p class="text-[100px]" style="font-size: 82px;">Síndrome de &nbsp;<span class="font-bold">Tourette</span></p>
                </div>
                <a class="rounded-full border-2 border-white text-white px-20 py-2 text-2xl w-fit" href="./listado-de-psicologos.php">Pedir Cita</a>
            </div>
        </div>
    </div>
    <!-- nuestros especialistas -->
    <br>
    <br>
    <div class="bg-contraste w-full h-screen flex flex-col py-10">
        <p class="text-title text-primary bg-[#d9d9d9] text-center">Nuestros Especialistas</p>
        <div class="w-full h-full flex flex-row items-center justify-around">
            <!-- card 3 -->
            <div class="flex flex-row">
                <div class="w-96 shadow-lg shadow-primary bg-white h-[550px] relative flex flex-col items-center">
                    <img src="../media/elipse.png" alt="" class="absolute z-10">
                    <img src="../media/doc.png" alt="" class="absolute z-20 mt-8 w-32 h-32">
                    <div class="px-10 flex flex-col gap-6 text-center h-full justify-center py-16">
                        <p class="text-2xl">Dra Rachel Anderson</p>
                        <p class="text-base">Psiquiatra experta en síndrome de Tourette, dedicado a mejorar las
                            estrategias de manejo de tics.</p>
                    </div>
                </div>
                <div class="flex flex-col bg-[#d9d9d9] gap-4 p-2 py-4 h-fit mt-4">
                    <a href="" target="_blank" class="w-12 h-12">
                        <img class="" src="../media/linkedin.png" alt="">
                    </a>
                    <a href="" target="_blank" class="w-12 h-12">
                        <img class="" src="../media/instafat.png" alt="">
                    </a>
                    <a href="" target="_blank" class="w-12 h-12">
                        <img class="" src="../media/facebookfat.png" alt="">
                    </a>
                </div>
            </div>
            <!-- card 2 -->
            <div class="flex flex-row">
                <div class="w-96 shadow-lg shadow-primary bg-white h-[550px] relative flex flex-col items-center">
                    <img src="../media/elipse.png" alt="" class="absolute z-10">
                    <img src="../media/face.png" alt="" class="absolute z-20 mt-8 w-32 h-32">
                    <div class="px-10 flex flex-col gap-6 text-center h-full justify-center py-16">
                        <p class="text-2xl">Dr. Carlos Herrera</p>
                        <p class="text-base">Psicoterapia para trastornos del espectro tic y Síndrome de Tourette en
                            niños y adultos.
                        </p>
                    </div>
                </div>
                <div class="flex flex-col bg-[#d9d9d9] gap-4 p-2 py-4 h-fit mt-4">
                    <a href="" target="_blank" class="w-12 h-12">
                        <img class="" src="../media/linkedin.png" alt="">
                    </a>
                    <a href="" target="_blank" class="w-12 h-12">
                        <img class="" src="../media/instafat.png" alt="">
                    </a>
                    <a href="" target="_blank" class="w-12 h-12">
                        <img class="" src="../media/facebookfat.png" alt="">
                    </a>
                </div>
            </div>
            <!-- card 3 -->
            <div class="flex flex-row">
                <div class="w-96 shadow-lg shadow-primary bg-white h-[550px] relative flex flex-col items-center">
                    <img src="../media/elipse.png" alt="" class="absolute z-10">
                    <img src="../media/indian-guy.png" alt="" class="absolute z-20 mt-8 w-32 h-32">
                    <div class="px-10 flex flex-col gap-6 text-center h-full justify-center py-16">
                        <p class="text-2xl">Dr. Hassan Raza</p>
                        <p class="text-base">Neuropsicólogo investigador en el impacto cognitivo y social del síndrome
                            de Tourette, creadora de programas de apoyo para pacientes y familias.</p>
                    </div>
                </div>
                <div class="flex flex-col bg-[#d9d9d9] gap-4 p-2 py-4 h-fit mt-4">
                    <a href="" target="_blank" class="w-12 h-12">
                        <img class="" src="../media/linkedin.png" alt="">
                    </a>
                    <a href="" target="_blank" class="w-12 h-12">
                        <img class="" src="../media/instafat.png" alt="">
                    </a>
                    <a href="" target="_blank" class="w-12 h-12">
                        <img class="" src="../media/facebookfat.png" alt="">
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- info -->
    <div class="flex flex-col w-full">
        <!-- section 1 -->
        <section class="grid grid-cols-2 row px-36 py-14 gap-10">
            <div class="flex flex-col items-center justify-center px-20 gap-10">
                <p class="text-[60px] text-center whitespace-nowrap">¿Tienes estos Síntomas?</p>
                <div class="flex flex-row items-end">
                    <div>
                        <p class="text-4xl font-light">Reconoce los indicadores clave y aprende más sobre cómo se
                            manifiestan en el
                            día a día.</p>
                    </div>
                    <img src="../media/mareado.gif" alt="" class="w-20 h-20">
                </div>
            </div>
            <div>
                <img src="../media/section1.png" alt="" class="scale-75">
            </div>
        </section>
        <!-- separator -->
        <img src="../media/separator.png" alt="" class="">
        <!-- section2 -->
        <section class="grid grid-cols-2 row px-36 py-14 gap-10">
            <div>
                <img src="../media/section2.png" alt="" class="scale-75">
            </div>
            <div class="flex flex-col items-center justify-center  gap-10">
                <p class="text-[60px] ">Diagnósticos por profesionales</p>
                <div class="flex flex-row items-end">
                    <div>
                        <p class="text-4xl font-light">Accede a evaluaciones detalladas y apoyo diagnóstico por parte de
                            nuestro equipo experto.</p>
                    </div>
                    <img src="../media/terapia.gif" alt="" class="w-20 h-20">
                </div>
            </div>
        </section>
        <!-- separator -->
        <img src="../media/separator.png" alt="" class="rotate-180">
        <!-- section 3 -->
        <section class="grid grid-cols-2 row px-36 py-14 gap-10">
            <div class="flex flex-col items-center justify-center  gap-10">
                <p class="text-[60px]">Únete a nuestro foro GRATIS</p>
                <div class="flex flex-row items-end">
                    <div>
                        <p class="text-4xl font-light">Participa en nuestro foro comunitario para intercambiar
                            historias, consejos y obtener apoyo mutuo.</p>
                    </div>
                    <img src="../media/sociedad.gif" alt="" class="w-20 h-20">
                </div>
            </div>
            <div>
                <img src="../media/section3.png" alt="" class="scale-75">
            </div>
        </section>
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