<?php

use PHPUnit\Framework\TestCase;

require_once 'CRUD.php';

class PacienteTest extends TestCase
{
    private $paciente;

    protected function setUp(): void
    {
        $conn = getConexion(); 
        $this->paciente = new Paciente($conn);
    }

    public function testInsertarYEliminarPaciente()
    {
        // Insertamos un paciente y lo comprobamos
        $resultadoInsertar = $this->paciente->insertarPaciente('Prueba Insertar', '000000000', 25, 'ruta/foto.jpg', 'ruta/banner.jpg');
        //si resultadoInsertar no es true, muestra el mensaje de fallido
        $this->assertTrue($resultadoInsertar, "Inserción de paciente fallida.");

        // Actualizamos el paciente y lo comprobamos
        $resultadoActualizar = $this->paciente->actualizarPacientePorNombre('Prueba Insertar', 'Prueba Actualizada');
        $this->assertTrue($resultadoActualizar, "Actualización de paciente fallida.");

    }

    protected function tearDown(): void
    {
        //Con TearDown volvemos a reiniciar nuestras pruebas para que no afecten a nuestra web
        $resultadoEliminar = $this->paciente->eliminarPacientePorNombre("Prueba Actualizada");
        $this->assertTrue($resultadoEliminar, "Eliminación de paciente fallida.");
    }
}
