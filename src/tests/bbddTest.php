<?php

require_once 'bbdd/connect.php';

// Obtener la conexión
$conn = getConexion();

// Funciones para operaciones CRUD
function insertarPaciente($conn, $nombre, $telefono, $edad, $fotoPerfil, $banner) {
    $sql = "INSERT INTO Pacientes (NombreCompleto, TelefonoMovil, Edad, FotoPerfil, Banner) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiss", $nombre, $telefono, $edad, $fotoPerfil, $banner);
    $stmt->execute();
    if ($stmt->affected_rows > 0) {
        echo "Paciente insertado exitosamente.\n";
    } else {
        echo "Error al insertar paciente: " . $conn->error . "\n";
    }
    $stmt->close();
}



function actualizarPacientePorNombre($conn, $nombreActual, $nombreNuevo) {
    // Primero, buscar el ID del paciente basado en el nombre actual
    $sqlSelect = "SELECT ID FROM Pacientes WHERE NombreCompleto = ?";
    $stmtSelect = $conn->prepare($sqlSelect);
    $stmtSelect->bind_param("s", $nombreActual);
    $stmtSelect->execute();
    $resultadoSelect = $stmtSelect->get_result();

    if ($fila = $resultadoSelect->fetch_assoc()) {
        $idPaciente = $fila['ID'];
        $stmtSelect->close();

        // Ahora, actualizar el nombre del paciente usando el ID obtenido
        $sqlUpdate = "UPDATE Pacientes SET NombreCompleto = ? WHERE ID = ?";
        $stmtUpdate = $conn->prepare($sqlUpdate);
        $stmtUpdate->bind_param("si", $nombreNuevo, $idPaciente);
        $stmtUpdate->execute();

        if ($stmtUpdate->affected_rows > 0) {
            echo "Paciente actualizado exitosamente.\n";
        } else {
            echo "No se realizó ninguna actualización. Es posible que el nombre proporcionado ya sea el actual.\n";
        }
        $stmtUpdate->close();
    } else {
        echo "No se encontró un paciente con el nombre especificado.\n";
        $stmtSelect->close();
    }
}


function eliminarPaciente($conn, $id) {
    $sql = "DELETE FROM Pacientes WHERE ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    if ($stmt->affected_rows > 0) {
        echo "Paciente eliminado exitosamente.\n";
    } else {
        echo "Error al eliminar paciente: " . $conn->error . "\n";
    }
    $stmt->close();
}

// Ejemplo de uso
insertarPaciente($conn, 'Prueba Insertar', '000000000', 25, 'ruta/foto.jpg', 'ruta/banner.jpg');
actualizarPacientePorNombre($conn,'NombreCompleto','NombreActualizado');
eliminarPaciente($conn, 1);

// No olvides cerrar la conexión al final del script
$conn->close();
