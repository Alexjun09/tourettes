<?php
require_once 'bbdd/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $conn = getConexion();
    $stmt = $conn->prepare("SELECT Contrasena FROM Cuenta WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows == 1) {
        $stmt->bind_result($hashedPassword);
        $stmt->fetch();
        header('Content-Type: application/json');
        if (password_verify($password, $hashedPassword)) {
            echo json_encode(['success' => true, 'redirectUrl' => 'index.php']);
            exit();
        } else {
            echo json_encode(['success' => false, 'error' => 'Credenciales incorrectas']);
            exit();
        }
    } else {
        // Email no encontrado
        echo "No se encontró una cuenta con ese email";
    }

    $stmt->close();
}
$conn->close();
?>
