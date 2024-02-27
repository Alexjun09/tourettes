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
        <div class="flex flex-col w-full h-full items-center">
            <div class="flex flex-col gap-4 text-center">
                <p class="text-[36px] sm:text-title">Comunidad</p>
                <p class="text-[24px] sm:text-subtitle"> Añadir una Entrada al Foro</p>
            </div>
            <div class="flex flex-col w-full h-[600px] justify-center items-center relative">
                <img src="../media/fondo-contacto.png" alt="fondo" class="w-full h-full">
                <form id="form-foro" action="server/procesar-entradaforo.php" method="post" enctype="multipart/form-data" class="flex flex-col justify-center absolute z-30 text-white w-full sm:w-[550px] px-4 sm:px-0">
                    <input type="text" name="title" id="titulo" placeholder="Titulo" class="outline-none border-b border-white w-full py-1 bg-transparent">
                    <br>
                    <input type="text" name="palabrasclave" id="clave" placeholder="Palabras Clave (Separadas por un espacio)" class="outline-none border-b border-white w-full py-1 bg-transparent">
                    <br>
                    <textarea name="cuerpo" id="cuerpo" class="border border-white resize-none w-full h-24 bg-transparent p-1 outline-none" placeholder="Cuerpo"></textarea>
                    <br>
                    <input type="file" name="archivo">
                    <br>
                    <div class="flex flex-row items-center gap-2">
                        <input type="checkbox" name="terminos">
                        <p>Terminos y condiciones</p>
                    </div>
                    <br>
                    <div class="flex justify-between items-center w-full">
                        <button type="submit" class="sm:w-52 bg-transparent border-2 border-white rounded-full text-center py-2 px-8 sm:px-0">Enviar</button>
                        <a href="./comunidad.php" class="sm:w-52 bg-transparent border-2 border-white rounded-full text-center py-2 px-8 sm:px-0">Volver</a>
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