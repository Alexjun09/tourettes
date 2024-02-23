<?php
session_start();

if (!isset($_SESSION['idPaciente'])) {
    header('Location: sign-in.html');
    exit();
}

$idPaciente = $_SESSION['idPaciente'];

require_once 'bbdd/connect.php';

$conn = getConexion();

// Obtener detalles del paciente
$query = "SELECT NombreCompleto, TelefonoMovil, FotoPerfil, Banner FROM Pacientes WHERE ID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $idPaciente);
$stmt->execute();
$stmt->bind_result($nombreCompleto, $telefonoMovil, $fotoPerfil, $banner);
$stmt->fetch();
$stmt->close();

// Preparar la consulta para obtener todos los informes del paciente
$query2 = "SELECT FechaInforme, RutaPDF FROM Informes WHERE IDPaciente = ?";
$stmt2 = $conn->prepare($query2);
$stmt2->bind_param("i", $idPaciente);
$stmt2->execute();
$stmt2->bind_result($fechaInforme, $rutaPDF);

$informes = []; // Inicializar un arreglo para almacenar los resultados

// Recuperar los resultados
while ($stmt2->fetch()) {
    $informes[] = ['fechaInforme' => $fechaInforme, 'rutaPDF' => $rutaPDF];
}

$stmt2->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/output.css">
    <link rel="icon" href="../media/logo.png" type="image/x-icon">
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
                <a href="./comunidad.php">Comunidad</a>
                <a href="./contacto.php">Contacto</a>
            </nav>
            <a class="rounded-tl-xl rounded-br-xl border-br-xl bg-primary text-white py-2 px-10" href="./mi-cuenta.php">Mi
                Cuenta</a>
        </div>
        <!-- body -->
        <div class="flex flex-col w-full items-center justify-center">
            <p class="text-title text-center">Mis Informes</p>
            <?php
            if (count($informes) > 0) {
                foreach ($informes as $index => $informe) {
            ?>
                    <div class="flex flex-col gap-5 px-44 py-10 w-full">
                        <div class="flex flex-row gap-4 w-full items-center">
                            <div class="h-full flex flex-col py-3">
                                <img src="../media/triangle.png" alt="" class="rotate-90 w-10 cursor-pointer" id="arrow-<?php echo $index; ?>">
                            </div>
                            <div class="flex flex-col w-full">
                                <div class="w-full flex flex-row justify-between p-2 bg-primary text-white items-center">
                                    <p class="text-xl"><?php echo $informe['fechaInforme']; ?></p>
                                    <a href="<?php echo $informe['rutaPDF']; ?>" download>
                                        <img src="../media/download.png" alt="" class="w-8">
                                    </a>
                                </div>
                                <div class="w-full h-full bg-contraste hidden" id="contenido-<?php echo $index; ?>">
                                    <iframe src="<?php echo $informe['rutaPDF']; ?>" width="100%" height="100%"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        document.getElementById('arrow-<?php echo $index; ?>').addEventListener('click', function() {
                            var contenido = document.getElementById('contenido-<?php echo $index; ?>');
                            var arrow = document.getElementById('arrow-<?php echo $index; ?>');
                            if (contenido.classList.contains('hidden')) {
                                contenido.classList.remove('hidden');
                                arrow.style.transform = 'rotate(0deg)';
                            } else {
                                contenido.classList.add('hidden');
                                arrow.style.transform = 'rotate(90deg)';
                            }
                        });
                    </script>
            <?php
                }
            } else {
                echo "<h3>Aún no hay informes</h3>";
            }
            ?>
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