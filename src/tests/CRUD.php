<?php

require_once 'bbdd/connect.php';

class Paciente {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function insertarPaciente($nombre, $telefono, $edad, $fotoPerfil, $banner) {
        $sql = "INSERT INTO Pacientes (NombreCompleto, TelefonoMovil, Edad, FotoPerfil, Banner) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssiss", $nombre, $telefono, $edad, $fotoPerfil, $banner);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $stmt->close();
            return true;
        } else {
            $stmt->close();
            return false;
        }
    }

    public function actualizarPacientePorNombre($nombreActual, $nombreNuevo) {
        $sqlSelect = "SELECT ID FROM Pacientes WHERE NombreCompleto = ?";
        $stmtSelect = $this->conn->prepare($sqlSelect);
        $stmtSelect->bind_param("s", $nombreActual);
        $stmtSelect->execute();
        $resultadoSelect = $stmtSelect->get_result();

        if ($fila = $resultadoSelect->fetch_assoc()) {
            $idPaciente = $fila['ID'];
            $stmtSelect->close();

            $sqlUpdate = "UPDATE Pacientes SET NombreCompleto = ? WHERE ID = ?";
            $stmtUpdate = $this->conn->prepare($sqlUpdate);
            $stmtUpdate->bind_param("si", $nombreNuevo, $idPaciente);
            $stmtUpdate->execute();

            if ($stmtUpdate->affected_rows > 0) {
                $stmtUpdate->close();
                return true;
            } else {
                $stmtUpdate->close();
                return false;
            }
        } else {
            $stmtSelect->close();
            return false;
        }
    }

    public function eliminarPacientePorNombre($nombre) {
        $sqlSelect = "SELECT ID FROM Pacientes WHERE NombreCompleto = ?";
        $stmtSelect = $this->conn->prepare($sqlSelect);
        $stmtSelect->bind_param("s", $nombre);
        $stmtSelect->execute();
        $resultadoSelect = $stmtSelect->get_result();

        if ($fila = $resultadoSelect->fetch_assoc()) {
            $idPaciente = $fila['ID'];
            $stmtSelect->close();

            $sqlDelete = "DELETE FROM Pacientes WHERE ID = ?";
            $stmtDelete = $this->conn->prepare($sqlDelete);
            $stmtDelete->bind_param("i", $idPaciente);
            $stmtDelete->execute();

            if ($stmtDelete->affected_rows > 0) {
                $stmtDelete->close();
                return true;
            } else {
                $stmtDelete->close();
                return false;
            }
        } else {
            $stmtSelect->close();
            return false;
        }
    }
}
