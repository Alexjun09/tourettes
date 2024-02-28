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
$conn = getConexion();
$idCita = isset($_GET['cita_id']) ? $_GET['cita_id'] : null;
echo $idCita;
$cita = null; // Variable para almacenar los datos de la cita

    $sqlCita = "SELECT FechaCita, Sintomas, VisitadoAntes FROM Citas WHERE IDCita = ?";
    $stmtCita = $conn->prepare($sqlCita);
    $stmtCita->bind_param("i", $idCita);
    $stmtCita->execute();
    $resultCita = $stmtCita->get_result();

    if ($resultCita && $resultCita->num_rows > 0) {
        $cita = $resultCita->fetch_assoc(); // Datos de la cita
    } else {
        echo "No se encontró la cita";
    }

    $stmtCita->close();



$paciente_id = $_SESSION['idPaciente'];
// Obtener la conexión

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
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="scripts/procesar-cita.js"></script>
</head>
<style>
    #journal-scroll::-webkit-scrollbar {
        width: 4px;
        cursor: pointer;
        /*background-color: rgba(229, 231, 235, var(--bg-opacity));*/
    }

    #journal-scroll::-webkit-scrollbar:horizontal {
        height: 0px;
    }
    #journal-scroll::-webkit-scrollbar-track {
        background-color: rgba(229, 231, 235, var(--bg-opacity));
        cursor: pointer;
        /*background: red;*/
    }

    #journal-scroll::-webkit-scrollbar-thumb {
        cursor: pointer;
        background-color: #a0aec0;
        /*outline: 1px solid slategrey;*/
    }
</style>

<body class="font-extralight grid grid-rows-[1fr_min-content] text-primary w-full h-full " id="journal-scroll">

    <div class="h-screen w-screen flex flex-col">
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
        <!-- phone header -->        <header class="sm:hidden bg-white h-20 flex flex-row justify-between items-center p-6 sm:p-10 bg-transparent w-full z-50">
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
        <div class="flex font-extralight flex-col w-full h-full items-center justify-between">
            <div class="flex flex-col gap-4 text-center">
                <p class="text-title">Pedir Cita</p>
                <p class="text-subtitle"> Formulario para pedir una cita</p>
            </div>
            <div class="grid grid-cols-2 w-full h-full px-44 py-12">
                <!-- card -->
                <div class="w-96 shadow-md shadow-primary h-full relative flex flex-col items-center">
                    <?php if ($psicologo) : ?>
                        <img src="../media/elipse.png" alt="" class="absolute z-10">
                        <img src="../media/psicologos/<?php echo $psicologo['FotoPsicologo']; ?>" alt="" class="absolute z-20 mt-8 w-32 h-32 rounded-full border-4 border-white">
                        <div class="px-10 flex flex-col gap-6 text-center h-full justify-end py-16 pt-24">
                            <p class="text-[24px]"><?php echo $psicologo['NombreCompleto']; ?></p>
                            <p class="text-[16px]"><?php echo $psicologo['Especialidad']; ?></p>
                            <img src="../media/maps.png" alt="">
                        </div>
                    <?php else : ?>
                    <?php endif; ?>
                </div>

                <!-- form -->
                <form id="form-cita" action="server/procesar-modificar-cita.php" data-id-paciente="<?php echo $_SESSION['idPaciente']; ?>" method="post" class="flex flex-col justify-center">
                    <input type="hidden" name="psicologo_id" value="<?php echo $psicologo_id; ?>">
                    <br>
                    <input type="datetime-local" id="fecha" name="fecha" placeholder="Fecha" required min="<?php echo date('Y-m-d'); ?>" value="<?php echo isset($cita) ? date('Y-m-d\TH:i', strtotime($cita['FechaCita'])) : ''; ?>" class="outline-none border-b border-black w-full text-opacity-50">
                    <br>
                    <input type="text" name="motivo_consulta" placeholder="Motivo de la Consulta" value="<?php echo isset($cita) ? $cita['Sintomas'] : ''; ?>" class="outline-none border-b border-black w-full">
                    <br>
                    <div class="flex flex-row gap-3 "><label for="visita">¿Nos Has visitado Antes?</label>
                        <input type="radio" name="visita" id="si" value="1" <?php echo (isset($cita) && $cita['VisitadoAntes'] == 1) ? 'checked' : ''; ?>>Sí
                        <input type="radio" name="visita" id="no" value="0" <?php echo (isset($cita) && $cita['VisitadoAntes'] == 0) ? 'checked' : ''; ?>>No
                    </div>
                    <br>
                    <input type="hidden" name="idCita" value="<?php echo $idCita; ?>">
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
    </div>

    <div id="popupCitaExistente" class="popup-contenedor" style="display: none;">
    <div class="popup">
        <h2>¡Advertencia!</h2>
        <p id="popupMensaje">Ya tiene una cita programada para esta fecha.</p>
        <button onclick="cerrarPopup()">Aceptar</button>
    </div>
</div>

<style>
    .popup-contenedor {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.5);
    display: flex;
    justify-content: center;
    align-items: center;
}

.popup {
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0,0,0,0.25);
    text-align: center;
}

.popup h2 {
    margin: 0 0 10px;
}

.popup p {
    margin: 0 0 20px;
}

</style>
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