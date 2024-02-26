<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

require_once './vendor/autoload.php';
require_once './bbdd/connect.php';

$response = ['success' => false, 'message' => 'Un error inesperado ocurrió.'];

$client = new Google_Client(['client_id' => '553895664817-aqvkmv0qtacbbsob3963tq4h9sq609j6.apps.googleusercontent.com']);

if (isset($_POST['credential'])) {
    $jwt = $_POST['credential'];
    $payload = $client->verifyIdToken($jwt);
    if ($payload) {
        $userid = $payload['sub'];
        $email = $payload['email'];
        $name = $payload['name'];
        $picture = $payload['picture'];

        $conn = getConexion();

        // Verifica si el usuario ya existe en la tabla Cuenta por GoogleID
        $stmtVerificar = $conn->prepare("SELECT IDPaciente FROM Cuenta WHERE GoogleID = ?");
        $stmtVerificar->bind_param('s', $userid);
        $stmtVerificar->execute();
        $resultado = $stmtVerificar->get_result();
        
        if ($resultado->num_rows > 0) {
            // Usuario ya existe, obtén el IDPaciente existente
            $fila = $resultado->fetch_assoc();
            $idPaciente = $fila['IDPaciente'];
            $_SESSION['idPaciente'] = $idPaciente;
            $response = ['success' => true, 'message' => "Inicio de sesión exitoso.", 'redirect' => 'index.php'];
        } else {
            // Usuario nuevo, inserta primero en Pacientes
            $stmtPaciente = $conn->prepare("INSERT INTO Pacientes (NombreCompleto, FotoPerfil, Banner) VALUES (?, ?, '../media/bannerNuevo.jpg')");
            $stmtPaciente->bind_param('ss', $name, $picture);
            
            if ($stmtPaciente->execute()) {
                $idPaciente = $conn->insert_id;
                
                // Inserta ahora en Cuenta con el IDPaciente obtenido
                $stmtCuenta = $conn->prepare("INSERT INTO Cuenta (GoogleID, Email, NombreUsuario, AuthMethod, IDPaciente) VALUES (?, ?, ?, 'google', ?)");
                $stmtCuenta->bind_param('sssi', $userid, $email, $name, $idPaciente);
                
                if ($stmtCuenta->execute()) {
                    $_SESSION['idPaciente'] = $idPaciente;
                    $response = ['success' => true, 'message' => "Usuario registrado con éxito.", 'redirect' => 'index.php'];
                } else {
                    $response['message'] = "Error al insertar en Cuenta: " . $conn->error;
                }
                $stmtCuenta->close();
            } else {
                $response['message'] = "Error al insertar en Pacientes: " . $conn->error;
            }
            $stmtPaciente->close();
        }
        $stmtVerificar->close();
        $conn->close();
    } else {
        $response['message'] = 'La verificación del JWT ha fallado.';
    }
} else {
    $response['message'] = 'No se ha proporcionado JWT.';
}

echo json_encode($response);
?>
