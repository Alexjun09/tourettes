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
    <div class="h-fit w-screen flex flex-col pb-20">
        <!-- header -->
        <div class="px-20 flex flex-row justify-between items-center py-4">
            <a class="h-16" href="./index.php">
                <img src="../media/logoindex.png" alt="" class="h-full">
            </a>
            <nav class="flex flex-row gap-10 text-primary text-lg">
                <a href="./educacion.php">Educación</a>
                <a href="./listado-de-psicologos.php">Pedir Cita</a>
                <a href="./comunidad.php">Comunidad</a>
                <a href="./contacto.php">Contacto</a>
            </nav>
            <a class="rounded-tl-xl rounded-br-xl border-br-xl bg-primary text-white py-2 px-10"
                href="./mi-cuenta.php">Mi Cuenta</a>
        </div>
        <!-- body -->
        <div class="flex flex-col w-full h-full items-center">
            <div class="flex flex-col gap-4 text-center">
                <p class="text-title">Comunidad</p>
                <p class="text-subtitle"> Añadir una Entrada al Foro</p>
            </div>
            <div class="flex flex-col w-full h-[600px] justify-center items-center relative">
                <img src="../media/fondo-contacto.png" alt="fondo" class="w-full h-full">
                <form id="form-foro" action="server/procesar-entradaforo.php" method="post"
                    enctype="multipart/form-data"
                    class="flex flex-col justify-center absolute z-30 text-white w-[550px]">
                    <input type="text" name="title" id="titulo" placeholder="Titulo"
                        class="outline-none border-b border-white w-full py-1 bg-transparent">
                    <br>
                    <input type="text" name="palabrasclave" id="clave"
                        placeholder="Palabras Clave (Separadas por un espacio)"
                        class="outline-none border-b border-white w-full py-1 bg-transparent">
                    <br>
                    <textarea name="cuerpo" id="cuerpo"
                        class="border border-white resize-none w-full h-24 bg-transparent p-1 outline-none"
                        placeholder="Cuerpo"></textarea>
                    <br>
                    <input type="file" name="archivo">
                    <br>
                    <div class="flex flex-row items-center gap-2">
                        <input type="checkbox" name="terminos">
                        <p>Terminos y condiciones</p>
                    </div>
                    <br>
                    <div class="flex justify-between items-center w-full">
                        <button type="submit"
                            class="w-52 bg-transparent border-2 border-white rounded-full text-center py-2">Enviar</button>
                        <a href="./comunidad.php"
                            class="w-52 bg-transparent border-2 border-white rounded-full text-center py-2">Volver</a>
                    </div>
                </form>
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