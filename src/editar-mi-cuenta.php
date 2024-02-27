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
</head>

<body class="font-extralight grid grid-rows-[1fr_min-content] text-primary">
    <!-- header -->
  <header class="px-20 flex flex-row justify-between items-center py-4">
            <a class="h-16" href="./index.php">
                <img src="../media/logoindex.png" alt="" class="h-full">
            </a>
            <nav class="flex flex-row gap-10 text-primary text-lg">
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
    <!-- body -->
    <div class="flex flex-col w-full h-screen items-center">
        <div class="relative flex flex-col justify-end items-center w-full">
            <img src="<?php echo $Banner; ?>" alt="" class="max-h-36 object-cover w-full">
            <div class="px-6 bg-contraste rounded-t-md absolute">
                <p class="text-subtitle">Editar Mi Cuenta</p>
            </div>
        </div>
        <div class="w-full h-full bg-contraste flex flex-col justify-center relative">
            <form id="uploadBannerForm" class="w-full h-full px-4 bg-transparent absolute flex flex-col items-start justify-start">
                <div class="relative flex flex-col">
                    <input type="file" id="bannerInput" name="banner" accept=".jpg, .jpeg, .png" class="bg-white italic text-primary w-fit border z-20 opacity-0">
                    <div class="absolute justify-center items-center w-full h-full z-10">
                        <p class="text-center text-xl bg-white">Editar</p>
                    </div>
                    <p id="uploadError" class="text-red-500"></p>
                </div>
            </form>
            <div class="w-[80%] bg-secondary flex flex-row rounded-r-3xl py-20 px-10 justify-between">
                <div class="flex flex-col items-center relative">
                    <div class="w-64 h-64 aspect-square z-30 ">
                        <img src="<?php echo $FotoPerfil; ?>" alt="foto perfil" class="w-full h-full object-cover border-4 rounded-full border-secondary bg-white">
                    </div>
                    <div class="absolute z-0 flex flex-col justify-end items-center w-full h-full mt-16">
                        <form id="uploadProfileForm" class="bg-white w-[90%] hover:bg-gray-300 transition-all ease-in h-1/2 text-center text-primary flex flex-col justify-end items-center pb-4">
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
                    <form id="formularioPerfil" action="server/actualizar_datos_perfil.php" method="post" class="flex flex-col w-1/2 justify-center z-40">
                        <input type="text" name="nombre" value="<?php echo $nombreCompleto; ?>" class="outline-none border-b border-black w-full text-opacity-50 bg-transparent">
                        <br>
                        <input type="email" name="email" value="<?php echo $email; ?>" class="outline-none border-b border-black w-full text-opacity-50 bg-transparent">
                        <br>
                        <input type="number" name="telefono" value="<?php echo $telefonoMovil; ?>" class="outline-none border-b border-black w-full text-opacity-50 bg-transparent">
                        <br>
                        <input type="number" name="edad" value="<?php echo $Edad; ?>" placeholder="edad" class="outline-none border-b border-black w-full text-opacity-50 bg-transparent">
                        <br>
                        <div class="flex flex-row items-center justify-between">
                            <a href="./mi-cuenta.php" class="rounded-tr-xl rounded-bl-xl border-br-xl bg-primary text-white py-2 px-10 w-fit">Cancelar</a>
                            <button type="submit" class="rounded-tl-xl rounded-br-xl border-br-xl bg-primary text-white py-2 px-10 w-fit">Guardar</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
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