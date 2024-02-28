<?php

use PHPUnit\Framework\TestCase;

require_once 'bbdd/connect.php'; // Asegúrate de que la ruta es correcta

class ConexionTest extends TestCase {
    private $conexion = null;

    protected function setUp(): void {
        // Inicializa la conexión antes de cada prueba
        $this->conexion = getConexion();
    }

    protected function tearDown(): void {
        // Cierra la conexión después de cada prueba
        if ($this->conexion) {
            $this->conexion->close();
            $this->conexion = null;
        }
    }

    public function testConexionExitosa() {
        // No necesitas inicializar la conexión aquí ya que se hace en setUp
        $this->assertInstanceOf(mysqli::class, $this->conexion);
        $this->assertEquals(0, $this->conexion->connect_errno);
    }

    public function testBaseDeDatosCreada() {
        // Asegura que la base de datos específica exista
        $nombre_bd = 'tourettes'; // Nombre de tu base de datos
        $resultado = $this->conexion->select_db($nombre_bd);
        $this->assertTrue($resultado);
    }
}
