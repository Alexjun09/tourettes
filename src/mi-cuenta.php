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
$query = "SELECT NombreCompleto, TelefonoMovil, FotoPerfil, Banner FROM Pacientes WHERE ID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $idPaciente);
$stmt->execute();
$stmt->bind_result($nombreCompleto, $telefonoMovil, $FotoPerfil, $Banner);
$stmt->fetch();
$stmt->close();

$query2 = "SELECT Email FROM cuenta WHERE IDPaciente = ?";
$stmt2 = $conn->prepare($query2);
$stmt2->bind_param("i", $idPaciente);
$stmt2->execute();
$stmt2->bind_result($email,);
$stmt2->fetch();
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
    <title>Mi Cuenta</title>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .fc {
            border-radius: 20px;
        }

        .fc .fc-toolbar.fc-header-toolbar {
            margin-bottom: 0;
            padding: 10px;
            padding-left: 30px;
            padding-right: 30px;
        }

        .fc-theme-standard td {
            border-radius: 20px;
        }

        .fc .fc-scrollgrid {
            border-left-width: 0px;
            border-right-width: 0px;
        }

        .fc-daygrid-dot-event {
            flex-direction: column;
            gap: 2px;
            white-space: normal;
            text-align: center;
        }

        .fc-daygrid-event-dot {
            opacity: 0;
            max-height: 0px;
            display: none;
        }
    </style>
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
    <div class="flex flex-col w-full items-center justify-center relative">

        <div class="relative flex flex-col justify-end items-center w-full">
            <img src="<?php echo $Banner; ?>" alt="" class="max-h-36 object-cover w-full">
            <div class="px-6 bg-contraste rounded-t-md absolute">
                <p class="text-subtitle">Mi Cuenta</p>
            </div>
        </div>
        <div class="h-0 px-5 w-full flex items-center justify-start">
            <img src="<?php echo $FotoPerfil; ?>" alt="" class="h-36 w-36 aspect-square object-cover rounded-full border-4 border-secondary absolute z-50 bg-white">
        </div>
        <div class="w-full h-screen bg-contraste flex flex-col items-center gap-10 relative">
            <div class="flex flex-row w-full ">
                <div class="flex flex-col justify-between">
                    <div class="pt-20 px-20 pb-10 flex flex-col bg-secondary rounded-r-[30px] w-min h-min text-white text-[24px] text-left relative gap-8 min-w-[400px]">
                        <div class="flex flex-col">
                            <p><?php echo $nombreCompleto; ?></p>
                            <p><?php echo $email; ?></p>
                            <p>+34 <?php echo $telefonoMovil; ?></p>
                        </div>
                        <div class="w-full flex flex-row items-center justify-center">
                            <a class="rounded-tl-xl rounded-br-xl border-br-xl bg-primary text-white py-2 px-8 w-fit" href="./editar-mi-cuenta.php">Editar</a>
                        </div>
                    </div>
                    <div class="w-full flex flex-row justify-start items-end min-h-[150px] relative">
                        <!-- div de dani para el cita -->
                        <div class="absolute" id="citaClickada">
                        </div>
                    </div>
                    <div class="w-full flex flex-row items-center justify-center h-fit">
                        <a class="bg-transparent border-2 border-primary px-20 p-1 rounded-full w-fit text-body" href="./mis-informes.php">Mis Informes</a>
                    </div>
                </div>

                <div class="flex flex-col w-full h-full gap-10 pt-6">
                    <!-- mis citas -->
                    <div class="flex flex-col gap-[20px] items-center ">
                        <p class="text-[40px]">Mis Citas</p>
                        <!-- div de dani para el calendario -->
                        <div class="bg-white w-[60%] h-fit" id='calendar'>
                        </div>
                    </div>
                </div>
            </div>
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

<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
<script>
    function dayOfTheWeekWords(day) {
        switch (day) {
            case 0:
                return "Domingo";
            case 1:
                return "Lunes";
            case 2:
                return "Martes";
            case 3:
                return "Miércoles";
            case 4:
                return "Jueves";
            case 5:
                return "Viernes";
            case 6:
                return "Sábado";
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var divCitaClickada = document.getElementById('citaClickada');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: './server/citasCalendario.php', // URL del endpoint que devuelve los eventos en JSON
            eventColor: '#92AAB3',
            eventClick: function(info) {
                // Crear y mostrar un desplegable con la información del evento
                const idCita = info.event.id; // `id` directamente contiene el ID de la cita
                const idPsicologo = info.event.extendedProps.idPsicologo;
                const day = new Date(info.event.start).getDate();
                const dayOfTheWeek = dayOfTheWeekWords(new Date(info.event.start).getDay());
                const doctor = info.event.title;
                const address = info.event.extendedProps.direccion;
                const time = info.event.start.toLocaleTimeString()
                var details = `
                <div id="event-details" class="grid grid-cols-4 gap-4 px-8 p-4 w-[600px] h-[150px] bg-secondary rounded-r-3xl">
                    <div class="flex flex-col justify-between items-center p-4 bg-contraste rounded-3xl text-white">
                        <p class="text-5xl">${day}</p>
                        <p class="text-2xl">${dayOfTheWeek}</p>
                    </div>
                    <div class="flex flex-col justify-between text-white col-span-2">
                        <p class="text-3xl text-primary">${doctor}</p>
                        <p class="text-3xl">${time.substr(0, 5)}</p>
                        <p class="text-lg">${address}</p>
                    </div>
                    <div class="flex flex-col gap-4 h-full justify-center items-center">
                    <a href="modificar-cita.php?psicologo_id=${idPsicologo}&cita_id=${idCita}" class="rounded-tl-xl rounded-br-xl border-br-xl bg-primary text-white py-2 px-8 w-[120px] text-center">Modificar</a>                        
                    <a href="#" onclick="confirmarAnulacion('${idCita}');" class="rounded-tl-xl rounded-br-xl border-br-xl bg-primary text-white py-2 px-8 w-[120px] text-center">Anular</a>
                    </div>
                </div>`;
                // Asegúrate de que solo se muestre un desplegable a la vez
                var existingDetails = document.querySelector('#event-details');
                if (existingDetails) {
                    existingDetails.parentNode.removeChild(existingDetails);
                }
                // Insertar el nuevo desplegable
                divCitaClickada.insertAdjacentHTML('beforeend', details);
            }
        });
        calendar.render();
    });

    function confirmarAnulacion(idCita) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¿Quieres anular esta cita?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1D3A46',
            cancelButtonColor: '#92AAB3',
            confirmButtonText: 'Anular',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `./server/eliminar-cita.php?idCita=${idCita}`;
            }
        });
        return false; // Evita la navegación
    }


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