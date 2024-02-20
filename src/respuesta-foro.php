<?php
// Verificar si se han proporcionado los IDs de entrada de foro y de paciente en la URL
if (isset($_GET['idForo']) && isset($_GET['idPaciente'])) {
    // Obtener el ID del foro y del paciente desde la URL
    $idForo = $_GET['idForo'];
    $idPaciente = $_GET['idPaciente'];

    // Aquí puedes utilizar $idForo y $idPaciente para cualquier lógica adicional que necesites
} else {
    // Mostrar un mensaje si no se proporcionaron los IDs necesarios
    echo "<p>No se proporcionaron los IDs necesarios.</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/output.css">
    <link rel="icon" href="../media/logo.png" type="image/x-icon">
    <title>Respuesta Foro</title>
</head>
<body class="font-extralight grid grid-rows-[1fr_min-content] text-primary">
<div class="h-screen w-screen flex flex-col">
    <!-- header -->
    <div class="px-20 flex flex-row justify-between items-center py-4">
        <a class="h-16" href="./index.html">
            <img src="../media/logoindex.png" alt="" class="h-full" />
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
    <div class="flex flex-col w-full h-full items-center">
        <div class="flex flex-col gap-4 text-center">
            <p class="text-title">Comunidad</p>
            <p class="text-subtitle">Respuesta</p>
        </div>
        <div class="flex flex-col w-full h-[600px] justify-center items-center relative">
            <img src="../media/fondo-contacto.png" alt="fondo" class="w-full h-full" />
            <form action="server/procesar-respuestaforo.php" method="post" class="flex flex-col justify-center absolute z-30 text-white w-[550px]">
                <input type="hidden" name="idForo" value="<?php echo htmlspecialchars($idForo); ?>">
                <input type="hidden" name="idPaciente" value="<?php echo htmlspecialchars($idPaciente); ?>">
                <textarea name="cuerpo" id="cuerpo" class="border border-white resize-none w-full h-24 bg-transparent p-1 outline-none" placeholder="Cuerpo"></textarea>
                <br>
                <div class="flex justify-between items-center w-full">
                    <button type="submit" class="w-52 bg-transparent border-2 border-white rounded-full text-center py-2">Enviar</button>
                    <a href="./entrada-foro.php?id=<?php echo $idForo; ?>" class="w-52 bg-transparent border-2 border-white rounded-full text-center py-2">Volver</a>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- footer -->
<div class="h-28 flex flex-row bg-contraste px-12 items-center justify-between">
    <p>gLabs© 2023. Todos Los Derechos Reservados</p>
    <div class="flex flex-row gap-4">
        <a href="">
            <img class="w-10 h-10" src="../media/x.png" alt="x" />
        </a>
        <a href="">
            <img class="w-10 h-10" src="../media/insta.png" alt="insta" />
        </a>
        <a href="">
            <img class="w-10 h-10" src="../media/facebook.png" alt="facebook" />
        </a>
    </div>
</div>
<script src="scripts/procesar-respuestaforo.js"></script>
</body>
</html>
