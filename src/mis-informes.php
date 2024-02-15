<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/output.css">
    <title>Mis Informes</title>
</head>

<body class="font-extralight grid grid-rows-[1fr_min-content] text-primary">
    <div class="flex flex-col h-screen">
        <!-- header -->
        <div class="px-20 flex flex-row justify-between items-center py-4">
            <a class="h-16" href="./index.php">
                <img src="../media/logoindex.png" alt="" class="h-full">
            </a>
            <nav class="flex flex-row gap-10 text-primary text-lg">
                <a href="./educacion.php">Educación</a>
                <a href="./listado-de-psicologos.php">Pedir Cita</a>
                <a href="./comunidad.html">Comunidad</a>
                <a href="./contacto.html">Contacto</a>
            </nav>
            <a class="rounded-tl-xl rounded-br-xl border-br-xl bg-primary text-white py-2 px-10" href="./mi-cuenta.php">Mi
                Cuenta</a>
        </div>
        <!-- body -->
        <div class="flex flex-col w-full items-center justify-center">
            <p class="text-title text-center">Mis Informes</p>
            <div class="flex flex-col gap-5 px-44 py-20 w-full">
                <div class="flex flex-row gap-4 w-full items-center">
                    <div class="h-full flex flex-col py-3">
                        <img src="../media/triangle.png" alt="" class="rotate-90 w-10 cursor-pointer" id="arrow">
                    </div>
                    <div class="flex flex-col w-full">
                        <div class="w-full flex flex-row justify-between p-2 bg-primary text-white items-center">
                            <p class="text-xl">Date</p>
                            <button>
                                <img src="../media/download.png" alt="" class="w-8">
                            </button>
                        </div>
                        <div class="w-full h-96 bg-contraste hidden" id="contenido">

                        </div>
                    </div>
                </div>
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
</script>