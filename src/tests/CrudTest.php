<?php

use PHPUnit\Framework\TestCase;

require_once 'CRUD.php';

class PacienteTest extends TestCase
{
    private $paciente;
    private $conn;

    protected function setUp(): void
    {
        $conn = getConexion();
        $this->paciente = new Paciente($conn);
    }

    public function testInsertarPaciente()
    {
        // Insertamos un paciente y lo comprobamos
        $resultadoInsertar = $this->paciente->insertarPaciente('Prueba Insertar', '000000000', 25, 'ruta/foto.jpg', 'ruta/banner.jpg');
        //si resultadoInsertar no es true, muestra el mensaje de fallido
        $this->assertTrue($resultadoInsertar, "Inserción de paciente fallida.");
        // Verificar la inserción realizando una consulta SELECT
        $pacienteEncontrado = $this->paciente->buscarPacientePorNombre('Prueba Insertar');

        $this->assertNotNull($pacienteEncontrado, "El paciente insertado no se pudo encontrar.");
    }

    public function testActualizarPaciente()
    {
        // Actualizamos el paciente y lo comprobamos
        $resultadoActualizar = $this->paciente->actualizarPacientePorNombre('Prueba Insertar', 'Prueba Actualizada');
        $this->assertTrue($resultadoActualizar, "Actualización de paciente fallida.");

        // Verificar la inserción realizando una consulta SELECT
        $pacienteEncontrado = $this->paciente->buscarPacientePorNombre('Prueba Actualizada');

        $this->assertNotNull($pacienteEncontrado, "El paciente insertado no se pudo actualizar.");
    }

    public function testEliminarPaciente()
    {
        //Con TearDown volvemos a reiniciar nuestras pruebas para que no afecten a nuestra web
        $resultadoEliminar = $this->paciente->eliminarPacientePorNombre("Prueba Actualizada");
        $this->assertTrue($resultadoEliminar, "Eliminación de paciente fallida.");
        // Verificar la inserción realizando una consulta SELECT
        $pacienteEncontrado = $this->paciente->buscarPacientePorNombre('Prueba Actualizada');

        $this->assertNull($pacienteEncontrado, "El paciente insertado no se pudo eliminar.");
    }

    protected function tearDown(): void
    {
        // Cerramos la conexión después de cada prueba para que las pruebas no afecten al funcionamiento de la web
        if ($this->conn) {
            $this->conn->close();
            $this->conn = null;
        }
    }
}
