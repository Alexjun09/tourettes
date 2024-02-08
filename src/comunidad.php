<?php
session_start(); // Iniciar la sesión al principio de tu script

// Redirige si el usuario no está logueado
if (!isset($_SESSION['idPaciente'])) {
    header('Location: sign-in.html');
    exit;
}

require_once './bbdd/database.php';
$conn = getConexion();

$query = "SELECT Foro.id, Foro.Titulo, Pacientes.NombreCompleto AS Autor, Foro.Fecha
          FROM Foro
          JOIN Pacientes ON Foro.IDPaciente = Pacientes.ID
          ORDER BY Foro.Fecha DESC";

$stmt = $conn->prepare($query);

// Ejecutar la consulta
$stmt->execute();

// Vincular los resultados a variables
$stmt->bind_result($id,$titulo, $autor, $fecha);
$stmt->store_result(); // Almacenar el resultado para poder contar las filas

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/output.css">
    <title>Comunidad</title>
</head>

<body class="font-extralight grid grid-rows-[1fr_min-content] text-primary">
    <div class="h-screen w-screen flex flex-col">
        <!-- header -->
        <div class="px-20 flex flex-row justify-between items-center py-4">
            <a class="h-16" href="./index.php">
                <img src="../media/logoindex.png" alt="" class="h-full">
            </a>
            <nav class="flex flex-row gap-10 text-primary text-lg">
                <a href="./educacion.php">Educación</a>
                <a href="./listado-de-psicologos.php">Pedir Cita</a>
                <a href="./comunidad.php">Comunidad</a>
                <a href="./contacto.html">Contacto</a>
            </nav>
            <a class="rounded-tl-xl rounded-br-xl border-br-xl bg-primary text-white py-2 px-10" href="./mi-cuenta.php">Mi Cuenta</a>
        </div>
        <!-- body -->
        <div class="flex font-extralight flex-col w-full h-full items-center justify-between">
        <table>
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($stmt->num_rows > 0) {
                    // Imprimir las entradas como filas de la tabla
                    while ($stmt->fetch()) {
                        echo "<tr>";
                        echo "<td><a href='entrada-foro.php?id=" .$id. "'>" . $titulo . "</td>";
                        echo "<td>" . $autor. "</td>";
                        echo "<td>" . $fecha. "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No hay entradas en el foro.</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <!-- Cierre de la conexión -->
        <?php $conn->close(); ?>
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