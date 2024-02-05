<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./output.css">
    <title>Educacion</title>
</head>

<body class="grid grid-rows-[1fr_min-content] text-primary">
    <div class="h-screen w-screen flex flex-col">
        <!-- header -->
        <div class="px-20 flex flex-row justify-between items-center py-4">
            <a class="h-16" href="./index.php">
                <img src="../media/logoindex.png" alt="" class="h-full">
            </a>
            <nav class="flex flex-row gap-10 text-primary text-lg">
                <a href="./educacion.php">Educación</a>
                <a href="./listado-de-psicologos.php">Pedir Cita</a>
                <a href="./comunidad.html">Comunidad</a>
                <a href="./about-us.html">About Us</a>
            </nav>
            <a class="rounded-tl-xl rounded-br-xl border-br-xl bg-primary text-white py-2 px-10"
                href="./mi-cuenta.php">Mi Cuenta</a>
        </div>
        <!-- body -->
        <div class="flex flex-col w-full h-full items-center justify-between text-primary gap-4">
            <p class="text-title">Educación</p>
            <div class="w-full bg-primary py-1">
                <p class="text-white text-3xl text-center">Información Básica</p>
            </div>
            <div class="flex flex-col px-44">
                <article class="flex flex-col">
                    <div class="overflow-hidden">
                        <img src="../media/educacion1.png" alt="" class="float-left w-[500px] mb-10 mr-10">
                        <p class="text-subtitle">Entendiendo el Síndrome de Tourette</p>
                        <br>
                        <p class="text-body bg-yellow-900">El Síndrome de Tourette es un trastorno neuropsiquiátrico con inicio en la infancia,
                            caracterizado por múltiples tics motores y al menos un tic vocal. Estos tics suelen ser
                            repentinos, rápidos y recurrentes movimientos o sonidos. El trastorno lleva el nombre del médico
                            francés Georges Gilles de la Tourette, quien fue el primero en describir esta condición en 1885.
                            El síndrome es parte de un espectro de trastornos de tics, que incluye tics transitorios y
                            crónicos. Las personas con Tourette tienen tics que pueden variar en frecuencia y severidad, y a
                            menudo mejoran a medida que transitan hacia la edad adulta. La causa exacta del Síndrome de
                            Tourette no se conoce, pero se cree que es una combinación de factores genéticos y ambientales.
                        </p>
                    </div>
                    <video src=""></video>
                </article>
                <article class="flex flex-col">
                    <div class="">
                        <img src="../media/educacionseparator.png" alt="">
                        <p class="absolute text-center text-subtitle text-white">Síntomas Comunes</p>
                    </div>
                </article>
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