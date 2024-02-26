<?php
session_start(); // Iniciar la sesión al principio de tu script

// Redirige si el usuario no está logueado
if (!isset($_SESSION['idPaciente'])) {
    header('Location: sign-in.html');
    exit;
}

require_once 'bbdd/database.php';
$conn = getConexion();

// he quitado Foro.Fecha
$query = "SELECT Foro.id, Foro.Titulo, Pacientes.NombreCompleto AS Autor, Foro.Fecha
          FROM Foro
          JOIN Pacientes ON Foro.IDPaciente = Pacientes.ID";


$stmt = $conn->prepare($query);

// Ejecutar la consulta
$stmt->execute();

// Vincular los resultados a variables
$stmt->bind_result($id, $titulo, $autor, $fecha);
$stmt->store_result(); // Almacenar el resultado para poder contar las filas
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/output.css">
    <link rel="icon" href="../media/logo.png" type="image/x-icon">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Comunidad</title>
</head>

<body class="font-extralight grid grid-rows-[1fr_min-content] text-primary">
    <div class="h-fit w-screen flex flex-col pb-20">
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
        <div class="flex font-extralight flex-col w-full h-full items-center gap-10 px-64">
            <p class="text-title">Comunidad</p>
            <div class="flex flex-col gap-5 max-w-[1500px]">
                <div class="max-h-[1500px] flex flex-col shadow-lg shadow-primary rounded-md">
                    <div class="col-span-3 grid grid-cols-[6fr_3fr_1fr] bg-primary text-white gap-5 rounded-t-md px-5">
                        <p class="text-body px-4 p-1 ">Tema</p>
                        <p class="text-body px-4 p-1 text-center">Autor</p>
                        <p class="text-body px-4 p-1 text-center">Fecha</p>
                    </div>
                    <div class="grid grid-cols-[6fr_3fr_1fr] gap-5 p-5 overflow-y-auto">
                        <?php
                        if ($stmt->num_rows > 0) {
                            // Imprimir las entradas como filas de la tabla
                            while ($stmt->fetch()) {
                                echo "<a href='entrada-foro.php?id=$id'><p class='text-start p-1 px-4 bg-contraste rounded-md shadow-sm shadow-black'>$titulo</p></a>";
                                echo "<p class='text-center p-1 px-4 bg-contraste rounded-md shadow-sm shadow-black'>$autor</p>";
                                echo "<p class='text-center p-1 px-4 bg-contraste rounded-md shadow-sm shadow-black'> $fecha</p>";
                            }
                        } else {
                            echo "<p>No hay entradas en el foro.</p>";
                        }
                        $conn->close();
                        ?>
                    </div>
                </div>
                <div class="w-full flex justify-end items-end h-fit">
                    <a class="rounded-tl-xl rounded-br-xl border-br-xl bg-primary text-white py-2 px-10" href="./formulario-entrada-foro.php">Añadir Entrada</a>
                </div>
                <!-- graficas chart.js -->
                <div class="grid grid-cols-2 gap-20 w-full mt-10">
                    <div class="flex flex-col shadow-sm shadow-black">
                        <div class="px-10 p-4 flex flex-col border-b-2">
                            <div class="flex flex-row justify-between items-center">
                                <p>Participación</p>
                                <img src="../media/info.png" alt="" class="h-5 w-5">
                            </div>
                            <p class="text-3xl font-bold">102</p>
                        </div>
                        <div class="p-6">
                            <canvas id="myChart1"></canvas>
                        </div>
                    </div>
                    <div class="flex flex-col shadow-sm shadow-black">
                        <div class="px-10 p-4 flex flex-col border-b-2">
                            <div class="flex flex-row justify-between items-center">
                                <p>Participación</p>
                                <img src="../media/info.png" alt="" class="h-5 w-5">
                            </div>
                            <p class="text-3xl font-bold">102</p>
                            <p>Tratamientos y esperiencias</p>
                        </div>
                        <div class="p-6">
                            <canvas id="myChart2"></canvas>
                        </div>
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
    <!-- Script de Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('myChart1');

        new Chart(ctx, {
            type: 'radar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: '# of Votes',
                    data: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
                    borderWidth: 1
                }]
            },
            options: {
                elements: {
                    line: {
                        borderWidth: 3
                    }
                },
                interaction: {
                    mode: "index",
                    intersect: false,
                },
                legend: {
                    position: "bottom",
                },
            },
        });

        const ctx2 = document.getElementById('myChart2');

        new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: '# of Votes',
                    data: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
                    borderWidth: 1
                }]
            },
            options: {
                elements: {
                    line: {
                        borderWidth: 3
                    }
                },
                interaction: {
                    mode: "index",
                    intersect: false,
                },
                legend: {
                    position: "bottom",
                },
            },
        });
        
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
</body>

</html>