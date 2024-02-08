<?php
header('Content-Type: application/json');
require_once '../bbdd/connect.php';

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $conn = getConexion();
    // Preparar consulta SQL para verificar el email
    $stmt = $conn->prepare("SELECT COUNT(*) FROM cuenta WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    // Devolver resultado en formato JSON
    echo json_encode(['exists' => $count > 0]);
}
?>
