<?php
header('Content-Type: application/json');
require_once '../bbdd/connect.php';

if (isset($_POST['nombreUsuario'])) {
    $nombreUsuario = $_POST['nombreUsuario'];
    $conn = getConexion();
    // Preparar consulta SQL para verificar el nombre de usuario
    $stmt = $conn->prepare("SELECT COUNT(*) FROM cuenta WHERE NombreUsuario = ?");
    $stmt->bind_param("s", $nombreUsuario);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    // Devolver resultado en formato JSON
    echo json_encode(['exists' => $count > 0]);


}

?>
