<?php 

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/output.css">
    <link rel="icon" href="../media/logo.png" type="image/x-icon">
    <title>Pedir Cita</title>
</head>

<body class="font-extralight grid grid-rows-[1fr_min-content] text-primary">
    <div class="h-screen w-screen flex flex-col">
        <!-- header -->
        <div class="px-20 flex flex-row justify-between items-center py-4">
            <a class="h-16" href="./index.php">
                <img src="../media/logoindex.png" alt="" class="h-full">
            </a>
            <nav class="flex flex-row gap-10 text-primary text-lg">
                <a href="./educacion.php">Educación</a>
                <a href="./pedir-cita.php">Pedir Cita</a>
                <a href="./comunidad.php">Comunidad</a>
                <a href="./about-us.php">About Us</a>
            </nav>
            <a class="rounded-tl-xl rounded-br-xl border-br-xl bg-primary text-white py-2 px-10"
                href="./mi-cuenta.php">Mi Cuenta</a>
        </div>
        <!-- body -->
        <div class="flex font-extralight flex-col w-full h-full items-center justify-center gap-6 px-72">
            <div class="w-full h-fit bg-secondary flex flex-col justify-center items-center text-white text-center text-body p-10 gap-2">
                <p>!Muchas gracias por utilizar nuestros servicios!</p>
                <div class="">
                    <img src="../media/envelope.png" alt="" class="max-h-[300px]">
                </div>
                <p>En breve, recibirá un correo electronico con los datos de su cita</p>
            </div>
            <div class="w-full flex items-start">
                <a href="./listado-de-psicologos.php"
                    class="rounded-md border border-primary text-primary py-2 px-6">Volver</a>
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