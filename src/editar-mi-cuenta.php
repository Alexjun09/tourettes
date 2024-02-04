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
$query = "SELECT NombreCompleto, TelefonoMovil FROM Pacientes WHERE ID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $idPaciente);
$stmt->execute();
$stmt->bind_result($nombreCompleto, $telefonoMovil);
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
    <link rel="stylesheet" href="./output.css">
    <title>Editar Mi Cuenta</title>
</head>

<body class="grid grid-rows-[1fr_min-content] text-primary">
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
        <a class="rounded-tl-xl rounded-br-xl border-br-xl bg-primary text-white py-2 px-10" href="./mi-cuenta.php">Mi
            Cuenta</a>
    </div>
    <!-- body -->
    <div class="flex flex-col w-full h-screen items-center">
        <div class="px-6 bg-contraste rounded-t-md">
            <p class="text-subtitle">Editar Mi Cuenta</p>
        </div>
        <img src="../media/bgcuenta.png" alt="">

        <div class="w-full h-full bg-contraste flex flex-col justify-center relative">
            <form class="w-full h-full px-4 bg-transparent absolute flex flex-col items-start justify-start">
                <div class="relative flex flex-col">
                    <input type="file" class="bg-white italic text-primary w-fit border z-20 opacity-0">
                    <div class="absolute justify-center items-center w-full h-full z-10">
                        <p class="text-center bg-white">Editar</p>
                    </div>
                </div>
            </form>
            <div class="w-[80%] bg-secondary flex flex-row rounded-r-3xl py-20 px-10 justify-between">
                <div class="flex flex-col items-center relative">
                    <img src="../media/imgmicuenta.png" alt="" class="z-30 w-64">
                    <div class="absolute z-0 flex flex-col justify-end items-center w-full h-full">
                        <form
                            class="bg-white w-[90%] hover:bg-gray-300 transition-all ease-in h-1/2 text-center text-primary flex flex-col justify-end items-center pb-4">
                            <div class="relative flex flex-col">
                                <input type="file" class="italic text-primary border z-20 w-32 opacity-0">
                                <div class="absolute justify-center items-center w-full h-full z-10">
                                    <p class="text-center">Editar</p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="w-full flex flex-col items-center">
                    <form action="" class="flex flex-col gap-8 w-1/2 justify-center z-40">
                        <input type="text" value="<?php echo $nombreCompleto; ?>"
                            class="outline-none border-b border-black w-full text-opacity-50 bg-transparent">
                        <input type="email" value="<?php echo $email; ?>"
                            class="outline-none border-b border-black w-full text-opacity-50 bg-transparent">
                        <input type="number" value="<?php echo $telefonoMovil; ?>"
                            class="outline-none border-b border-black w-full text-opacity-50 bg-transparent">
                        <input type="number"  placeholder="Edad"
                            class="outline-none border-b border-black w-full text-opacity-50 bg-transparent">
                        <div class="flex flex-row items-center justify-between">
                            <a href="./mi-cuenta.php"
                                class="rounded-tr-xl rounded-bl-xl border-br-xl bg-primary text-white py-2 px-10 w-fit">Cancelar</a>
                            <button type="submit"
                                class="rounded-tl-xl rounded-br-xl border-br-xl bg-primary text-white py-2 px-10 w-fit">Editar</button>
                        </div>

                    </form>
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
<style>
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>