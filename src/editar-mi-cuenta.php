<?php
session_start();

// Redirige si el usuario no está logueado
if (!isset($_SESSION['idPaciente'])) {
    header('Location: sign-in.html');
    exit();
}

$idPaciente = $_SESSION['idPaciente'];

// Incluye el archivo de conexión a la base de datos
require_once 'bbdd/connect.php';
$conn = getConexion();

// Primera consulta para obtener nombre completo y teléfono móvil
$query = "SELECT NombreCompleto, TelefonoMovil,Edad, FotoPerfil, Banner FROM Pacientes WHERE ID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $idPaciente);
$stmt->execute();
$stmt->bind_result($nombreCompleto, $telefonoMovil, $Edad, $FotoPerfil, $Banner);
$stmt->fetch();
$stmt->close(); // Asegura cerrar la sentencia después de su uso

// Segunda consulta para obtener el email
$query2 = "SELECT Email FROM cuenta WHERE IDPaciente = ?";
$stmt2 = $conn->prepare($query2);
$stmt2->bind_param("i", $idPaciente);
$stmt2->execute();
$stmt2->bind_result($email);
$stmt2->fetch();
$stmt2->close(); // Asegura cerrar la sentencia después de su uso

// Verifica si el formulario se ha enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recolecta los datos del formulario
    $nombre = $_POST['nombre'] ?? ''; // Utiliza el operador de fusión null para manejar valores no definidos
    $email = $_POST['email'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $edad = $_POST['edad'] ?? 0; // Asume 0 si no se proporciona edad

    // Prepara la sentencia SQL para actualizar los datos del paciente
    $query = "UPDATE Pacientes SET NombreCompleto = ?, TelefonoMovil = ?, Edad = ? WHERE ID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssii", $nombre, $telefono, $edad, $idPaciente);

    if ($stmt->execute()) {
        echo "Datos actualizados correctamente.";
        $stmt->close(); // Cierra la sentencia después de su uso
        $conn->close(); // Cierra la conexión a la base de datos
        header('Location: mi-cuenta.php');
        exit();
    } else {
        echo "Error al actualizar los datos.";
        $stmt->close(); // Asegura cerrar la sentencia incluso si hay un error
    }
}

// Cierra la conexión a la base de datos si todavía está abierta
if ($conn) {
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/output.css">
    <link rel="icon" href="../media/logo.png" type="image/x-icon">
    <title>Editar Mi Cuenta</title>
    <script src="./scripts/validacionFormularioEditarPerfil.js"> </script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="font-extralight grid grid-rows-[1fr_min-content] text-primary">
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
    <div class="flex flex-col w-full h-screen items-center">
        <div class="relative flex flex-col justify-end items-center w-full">
            <img src="<?php echo $Banner; ?>" alt="" class="max-h-36 object-cover w-full">
            <div class="px-6 bg-contraste rounded-t-md absolute hidden sm:block">
                <p class="text-[24px] lg:text-subtitle">Editar Mi Cuenta</p>
            </div>
        </div>
        <div class="w-full h-full bg-contraste px-4 sm:px-0 flex flex-col justify-center items-center lg:items-start relative">
            <p class="text-[24px] lg:text-subtitle sm:hidden">Editar Mi Cuenta</p>
            <form id="uploadBannerForm" class="w-full h-full px-4 bg-transparent absolute flex flex-col items-start justify-start">
                <div class="relative flex flex-col">
                    <input type="file" id="bannerInput" name="banner" accept=".jpg, .jpeg, .png" class="bg-white italic text-primary w-fit border z-20 opacity-0">
                    <div class="absolute justify-center items-center w-full h-full z-10">
                        <p class="text-center text-xl bg-white">Editar</p>
                    </div>
                    <p id="uploadError" class="text-red-500"></p>
                </div>
            </form>
            <div class="w-full sm:w-[80%] bg-secondary flex flex-col lg:flex-row rounded-3xl lg:rounded-r-3xl lg:py-20 p-4 sm:p-10 justify-between gap-32 lg:gap-0">
                <div class="flex flex-col items-center-center relative w-fit lg:w-auto self-center">
                    <div class="w-32 h-3w-32 sm:w-64 sm:h-64 aspect-square z-30 ">
                        <img src="<?php echo $FotoPerfil; ?>" alt="foto perfil" class="w-full h-full object-cover border-4 rounded-full border-secondary bg-white">
                    </div>
                    <div class="absolute z-0 flex flex-col justify-end items-center w-full h-full mt-12 sm:mt-16">
                        <form id="uploadProfileForm" class="bg-white w-[90%] hover:bg-gray-300 transition-all ease-in h-full sm:h-1/2 text-center text-primary flex flex-col justify-end items-center pb-4">
                            <div class="relative flex flex-col">
                                <input type="file" id="ProfileInput" name="profile" accept=".jpg, .jpeg, .png" class="italic text-primary border z-20 w-32 opacity-0">
                                <div class="absolute justify-center items-center w-full h-full z-10">
                                    <p class="text-center text-xl">Editar</p>
                                </div>
                                <p id="uploadErrorProfile" class="text-red-500"></p>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="w-full flex flex-col items-center">
                    <form id="formularioPerfil" action="server/actualizar_datos_perfil.php" method="post" class="flex flex-col sm:px-12 xl:px-0 w-full xl:w-1/2 justify-center z-40">
                        <input type="text" name="nombre" value="<?php echo $nombreCompleto; ?>" class="outline-none border-b border-black w-full text-opacity-50 bg-transparent">
                        <br>
                        <input type="email" name="email" value="<?php echo $email; ?>" class="outline-none border-b border-black w-full text-opacity-50 bg-transparent">
                        <br>
                        <input type="number" name="telefono" value="<?php echo $telefonoMovil; ?>" class="outline-none border-b border-black w-full text-opacity-50 bg-transparent">
                        <br>
                        <input type="number" name="edad" value="<?php echo $Edad; ?>" placeholder="edad" class="outline-none border-b border-black w-full text-opacity-50 bg-transparent">
                        <br>
                        <div class="flex flex-row items-center justify-between">
                            <a href="./mi-cuenta.php" class="rounded-tr-xl rounded-bl-xl border-br-xl bg-primary text-white py-2 px-4 sm:px-10 w-fit">Cancelar</a>
                            <button type="submit" class="rounded-tl-xl rounded-br-xl border-br-xl bg-primary text-white py-2 px-4 sm:px-10 w-fit">Guardar</button>
                        </div>

                    </form>
                </div>
            </div>
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

<script src="./scripts/validacionEditarPerfil.js"> </script>
<script src="./scripts/validacionEditarFotoPerfil.js"> </script>

</html>
<style>
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>

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