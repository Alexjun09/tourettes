<?php
require_once './bbdd/database.php';

// Obtener la conexión
$conn = getConexion();

// Consulta para obtener los datos de los psicólogos
$sql = "SELECT * FROM Psicologos ORDER BY ID ASC"; // Ordenado por ID
$result = $conn->query($sql);

// Verifica si la consulta devolvió resultados
if ($result && $result->num_rows > 0) {
    // Los datos de los psicólogos se procesarán dentro del bucle while más adelante
} else {
    echo "0 results";
    $result = null; // Asegurarse de que result es null si no hay resultados
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/output.css">
    <title>Pedir Cita</title>
</head>

<body class="grid grid-rows-[1fr_min-content] text-primary">
    <div class="h-screen w-screen flex flex-col">
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
            <a class="rounded-tl-xl rounded-br-xl border-br-xl bg-primary text-white py-2 px-10" href="./mi-cuenta.php">Mi Cuenta</a>
        </div>
        <!-- body -->
        <div class="flex font-extralight flex-col w-full h-full items-center gap-20">
            <div class="flex flex-col gap-4 text-center">
                <p class="text-title">Pedir Cita</p>
                <p class="text-subtitle"> Listado de Psicólogos</p>
            </div>
            <?php if ($result) : ?>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <!-- Repite este bloque para cada psicólogo -->
                    <div class="flex flex-col gap-4 w-full px-48">
                        <div class="shadow-2xl grid grid-cols-[1fr_3fr] p-10 w-full gap-10 rounded-lg">
                            <div class="flex flex-col items-center gap-10">
                                <img src="../media/psicologos/<?php echo $row['FotoPsicologo']; ?>" alt="Foto del Psicólogo" class="h-[50%] aspect-square rounded-full border-2 border-white bg-white">
                                <img src="../media/starts.png" alt="Calificación" class="w-2/3">
                            </div>
                            <div class="flex flex-col gap-2">
                                <p class="text-subtitle text-center"><?php echo $row['NombreCompleto']; ?></p>
                                <ul class="list-disc">
                                    <li>Especialidad: <?php echo $row['Especialidad']; ?></li>
                                    <li>Ubicación: <?php echo $row['Ubicacion']; ?></li>
                                    <li>Idiomas: <?php echo $row['Idiomas']; ?></li>
                                    <li>Metodología: <?php echo $row['Metodologia']; ?></li>
                                    <li>Educación: <?php echo $row['Educacion']; ?></li>
                                </ul>
                                <div class="flex flex-row justify-end items-center">
                                    <form action="pedir-cita.php" method="post">
                                        <input type="hidden" name="psicologo_id" value="<?php echo $row['ID']; ?>">
                                        <button type="submit" class="rounded-tl-xl rounded-br-xl border-br-xl bg-primary text-xl text-white py-4 px-16">Pedir Cita</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
            <!-- footer -->
            <footer class="h-fit py-10 flex flex-row bg-contraste px-12 items-center justify-between w-full">
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
        </div>
</body>

</html>