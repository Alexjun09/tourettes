<?php
session_start();

// Redirige si el usuario no está logueado
if (!isset($_SESSION['idPaciente'])) {
    header('Location: ../sign-in.html');
    exit();
}

$idPaciente = $_SESSION['idPaciente']; 

// Incluye el archivo de conexión a la base de datos
require_once '../bbdd/connect.php'; 
$conn = getConexion(); 

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['banner']) && $_FILES['banner']['error'] == UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['banner']['tmp_name'];
    $fileName = $_FILES['banner']['name'];
    $fileSize = $_FILES['banner']['size'];
    $fileType = $_FILES['banner']['type'];
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));

    // Sanitiza el nombre del archivo aquí
    $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

    // Directorio donde se va a guardar el archivo
    $uploadFileDir = '../media/';
    $dest_path = $uploadFileDir . $newFileName;

    // Mueve el archivo
    if(move_uploaded_file($fileTmpPath, $dest_path)) 
    {
        // Actualizar la base de datos
        $query = "UPDATE Pacientes SET Banner = ? WHERE ID = ?";
        $stmt = $conn->prepare($query);
        $newFilePath = '../media/' . $newFileName;
        $stmt->bind_param("si", $newFilePath, $idPaciente);
        $stmt->execute();
        $stmt->close();
        
    
        echo json_encode(['bannerPath' => $newFilePath]);
    }
    else
    {
        echo json_encode(['error' => 'Hubo un error al mover el archivo al directorio de carga.']);    }
} else {
    echo 'Error en la carga del archivo.';
}

?>
