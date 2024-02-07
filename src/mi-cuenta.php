<?php
session_start();

if (!isset($_SESSION['idPaciente'])) {

    header('Location: sign-in.html');
    exit();
}

$idPaciente = $_SESSION['idPaciente'];

require_once 'bbdd/connect.php';

$conn = getConexion();

// 
$query = "SELECT NombreCompleto, TelefonoMovil FROM Pacientes WHERE ID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $idPaciente);
$stmt->execute();
$stmt->bind_result($nombreCompleto, $telefonoMovil);
$stmt->fetch();
$stmt->close();

$query2 = "SELECT Email FROM cuenta WHERE IDPaciente = ?";
$stmt2 = $conn->prepare($query2);
$stmt2->bind_param("i", $idPaciente);
$stmt2->execute();
$stmt2->bind_result($email);
$stmt2->fetch();
$stmt2->close();
$conn->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./output.css">
    <title>Mi Cuenta</title>
</head>

<body class="grid grid-rows-[1fr_min-content] text-primary">
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
    <div class="flex flex-col w-full h-screen items-center justify-center relative">
        <div class="px-6 bg-contraste rounded-t-md">
            <p class="text-subtitle">Mi Cuenta</p>
        </div>
        <img src="../media/bgcuenta.png" alt="" class="max-h-36 object-cover w-full">
        <div class="h-0 px-5 w-full flex items-center justify-start">
            <img src="../media/imgmicuenta.png" alt="" class="h-36 rounded-full border-4 border-secondary absolute z-50">
        </div>
        <div class="w-full h-full bg-contraste flex flex-col items-center gap-10">
            <div class="flex flex-row w-full">
                <div class="p-20 flex flex-col bg-secondary rounded-r-[30px] w-min h-min text-white text-[24px] text-left relative gap-2 min-w-[400px]">
                    <p><?php echo $nombreCompleto; ?></p>
                    <p><?php echo $email; ?></p>
                    <p><?php echo $telefonoMovil; ?></p>
                    <br><br>
                    <div class="w-full flex flex-row items-center justify-center">
                        <a class="rounded-tl-xl rounded-br-xl border-br-xl bg-primary text-white py-2 px-8 w-fit" href="./editar-mi-cuenta.php">Editar</a>

                    </div>
                </div>
                <div class="flex flex-col w-full h-full gap-10">
                    <!-- mis citas -->
                    <div class="flex flex-col gap-[10px] items-center ">
                        <p class="text-body">Mis Citas</p>
                        <!-- div de dani para el calendario -->
                        <div class="rounded-3xl bg-white w-[60%] h-72">

                        </div>

                    </div>
                    <div class="w-full flex flex-row justify-end items-end">
                                                <!-- div de dani para el cita -->
                        <div class="flex flex-row gap-2 w-[1000px] h-[150px] bg-secondary rounded-l-3xl">

                        </div>
                    </div>
                </div>
            </div>
            <a class="bg-transparent border-2 border-primary px-20 p-1 rounded-full w-fit text-body" href="./mis-informes.html">Mis Informes</a>
        </div>
    </div>
    <!-- footer -->
    <br><br>
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