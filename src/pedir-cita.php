<?php
session_start(); // Iniciar la sesión al principio de tu script

// Redirige si el usuario no está logueado
if (!isset($_SESSION['idPaciente'])) {
    header('Location: sign-in.html');
    exit;
}

require_once './bbdd/database.php';
$psicologo_id;
// Comprueba si el ID del psicólogo se ha pasado a través de POST
if (isset($_POST['psicologo_id'])) {
    $psicologo_id = $_POST['psicologo_id'];
} elseif (isset($_GET['psicologo_id'])) {
    $psicologo_id = $_GET['psicologo_id'];
} else {
    // Redirige al usuario de vuelta al listado de psicólogos si no se encuentra psicologo_id
    header('Location: listado-de-psicologos.php');
    exit;
}


$paciente_id = $_SESSION['idPaciente'];
// Obtener la conexión
$conn = getConexion();

// Consulta para obtener los datos del psicólogo seleccionado
$sql = "SELECT NombreCompleto, Especialidad, FotoPsicologo FROM Psicologos WHERE ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $psicologo_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $psicologo = $result->fetch_assoc(); // Datos del psicólogo
} else {
    echo "No se encontró el psicólogo";
    $psicologo = null; // Asegurarse de que psicologo es null si no hay resultados
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/output.css">
    <link rel="icon" href="../media/logo.png" type="image/x-icon">
    <title>Pedir Cita</title>
    <script src="scripts/procesar-cita.js"></script>
</head>

<body class="font-extralight grid grid-rows-[1fr_min-content] text-primary">
    <div class="h-screen w-full flex flex-col relative">
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
        <div class="flex font-extralight flex-col w-full h-full items-center justify-between">
            <div class="flex flex-col text-center">
                <p class="text-title">Pedir Cita</p>
                <p class="text-subtitle"> Formulario para pedir una cita</p>
            </div>
            <div class="grid grid-cols-2 w-full h-full px-44 py-12">
                <!-- card -->
                <div class="w-96 shadow-md shadow-primary h-full relative flex flex-col items-center">
                    <?php if ($psicologo) : ?>
                        <img src="../media/elipse.png" alt="" class="absolute z-10">
                        <img src="../media/psicologos/<?php echo $psicologo['FotoPsicologo']; ?>" alt="" class="absolute z-20 mt-8 w-32 h-32 rounded-full border-4 border-white">
                        <div class="px-10 flex flex-col gap-6 text-center h-full justify-end pb-16 pt-40">
                            <p class="text-2xl"><?php echo $psicologo['NombreCompleto']; ?></p>
                            <p class="text-base"><?php echo $psicologo['Especialidad']; ?></p>
                            <img src="../media/maps.png" alt="">
                        </div>
                    <?php else : ?>
                    <?php endif; ?>
                </div>

                <!-- form -->
                <form id="form-cita" action="server/procesar-cita.php" data-id-paciente="<?php echo $_SESSION['idPaciente']; ?>" method="post" class="flex flex-col justify-center">
                    <input type="hidden" name="psicologo_id" value="<?php echo $psicologo_id; ?>">
                    <br>
                    <input type="datetime-local" id="fecha" name="fecha" placeholder="Fecha" required min="<?php echo date('Y-m-d'); ?>" class="outline-none border-b border-black w-full text-opacity-50">
                    <br>
                    <input type="text" name="motivo_consulta" placeholder="Motivo de la Consulta" class="outline-none border-b border-black w-full">
                    <br>
                    <div class="flex flex-row gap-3 "><label for="visita">¿Nos Has visitado Antes?</label>
                        <input type="radio" name="visita" id="si" value="1">Sí
                        <input type="radio" name="visita" id="no" value="0">No
                    </div>
                    <br>
                    <div class="flex flex-row items-center gap-2">
                        <input type="checkbox">
                        <p>Terminos y condiciones</p>
                    </div>
                    <br>
                    <div class="flex justify-center w-full">
                        <button type="submit" class="rounded-tl-xl rounded-br-xl border-br-xl bg-primary text-white py-4 px-20 w-fit">Pedir
                            Cita</button>
                    </div>
                </form>
                <div id="div-errores"></div>
            </div>
        </div>
        <div id="popupCitaExistente" class="absolute w-full h-full bg-black bg-opacity-50 flex justify-center items-center z-40" style="display: none;">
            <div class="flex flex-col gap-4 justify-center items-center bg-white p-5 rounded-2xl shadow-lg shadow-black z-50">
                <p class="font-bold text-red-600">¡Advertencia!</p>
                <p id="popupMensaje">Ya tiene una cita programada para esta fecha.</p>
                <button onclick="cerrarPopup()" class="rounded-tl-xl rounded-br-xl border-br-xl bg-primary text-white py-2 px-10 w-fit">Aceptar</button>
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