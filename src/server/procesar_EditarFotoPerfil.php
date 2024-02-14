<?php
session_start();

// Comprobar si la sesión de idPaciente está establecida
error_log('Chequeo de sesión iniciado.');

if (!isset($_SESSION['idPaciente'])) {
    error_log('Usuario no logueado, redirigiendo...');
    header('Location: ../sign-in.html');
    exit();
}

header('Content-Type: application/json');
$idPaciente = $_SESSION['idPaciente']; 

// Conexión a la base de datos
require_once '../bbdd/connect.php'; 
$conn = getConexion(); 

error_log('Conexión de base de datos realizada.');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    error_log('Inicio de procesamiento de POST.');

    if (isset($_FILES['profile'])) {
        error_log('Archivo profile recibido.');

        if ($_FILES['profile']['error'] == UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['profile']['tmp_name'];
            $fileName = $_FILES['profile']['name'];
            $fileSize = $_FILES['profile']['size'];
            $fileType = $_FILES['profile']['type'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));

            // Sanitiza el nombre del archivo aquí
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

            // Directorio donde se va a guardar el archivo
            $uploadFileDir = '../../media/';
            $dest_path = $uploadFileDir . $newFileName;

            // Mueve el archivo
            if(move_uploaded_file($fileTmpPath, $dest_path)) {
                error_log('Archivo movido con éxito.');

                // Actualizar la base de datos
                $query = "UPDATE Pacientes SET FotoPerfil = ? WHERE ID = ?";
                if ($stmt = $conn->prepare($query)) {
                    error_log('Consulta preparada con éxito.');

                    $newFilePath = '../media/' . $newFileName;
                    $stmt->bind_param("si", $newFilePath, $idPaciente);

                    if ($stmt->execute()) {
                        error_log('Actualización de la base de datos exitosa.');
                    } else {
                        error_log('Error al actualizar la base de datos: ' . $stmt->error);
                    }
                    $stmt->close();
                } else {
                    error_log('Error al preparar la consulta: ' . $conn->error);
                }
                
                echo json_encode(['bannerPath' => $newFilePath]);
            
            } else {
                error_log('Error al mover el archivo al directorio de carga.');
                echo json_encode(['error' => 'Hubo un error al mover el archivo al directorio de carga.']);
            }
        } else {
            error_log('Error en el archivo banner: ' . $_FILES['banner']['error']);
            echo json_encode(['error' => 'Error en el archivo enviado.']);
        }
    } else {
        error_log('No se ha recibido el archivo banner.');
        echo json_encode(['error' => 'No se ha recibido ningún archivo.']);
    }
} else {
    error_log('No se ha realizado una petición POST.');
    echo json_encode(['error' => 'Error en la carga del archivo.']);
}

?>
