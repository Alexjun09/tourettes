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
    <div class="h-fit w-screen flex flex-col pb-20 items-center">
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
        <div class="flex font-extralight flex-col w-full h-full items-center gap-10 max-w-[1200px] px-4">
            <p class="text-[36px] sm:text-title">Comunidad</p>
            <div class="flex flex-col gap-5 w-full">
                <div class="max-h-[1500px] flex flex-col shadow-lg shadow-primary rounded-md">
                    <div class="col-span-3 flex sm:grid grid-cols-[5fr_3fr_2fr] bg-primary text-white gap-5 rounded-t-md px-5">
                        <p class="text-[16px] sm:text-body px-4 p-1 self-center">Tema</p>
                        <p class="hidden sm:block text-body px-4 p-1">Autor</p>
                        <p class="hidden sm:block text-[16px] sm:text-body px-4 p-1 self-center">Fecha</p>
                    </div>
                    <div class="flex flex-col sm:grid grid-cols-[5fr_3fr_2fr] gap-2 sm:gap-5 p-5 overflow-y-auto">
                        <?php
                        if ($stmt->num_rows > 0) {
                            // Imprimir las entradas como filas de la tabla
                            while ($stmt->fetch()) {
                                echo "<a href='entrada-foro.php?id=$id'><p class='text-start p-1 px-1 sm:px-4 bg-contraste rounded-md shadow-sm shadow-black'>$titulo</p></a>";
                                echo "<p class='text-center p-1 px-1 sm:px-4 bg-contraste rounded-md shadow-sm shadow-black hidden sm:block'>$autor</p>";
                                echo "<p class='text-center p-1 px-1 sm:px-4 bg-contraste rounded-md shadow-sm shadow-black hidden sm:block'> $fecha</p>";
                            }
                        } else {
                            echo "<p>No hay entradas en el foro.</p>";
                        }
                        $conn->close();
                        ?>
                    </div>
                </div>
                <div class="w-full flex justify-end items-end h-fit">
                    <a class="text-[16px] sm:text-body rounded-tl-xl rounded-br-xl border-br-xl bg-primary text-white py-2 px-10" href="./formulario-entrada-foro.php">Añadir Entrada</a>
                </div>
                <!-- graficas chart.js -->
                <div class="flex flex-col sm:grid grid-cols-2 gap-20 w-full mt-10">
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