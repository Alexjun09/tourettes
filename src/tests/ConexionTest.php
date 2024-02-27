<?php
use PHPUnit\Framework\TestCase;

// Asumiendo que tu script se llama `database.php` y está en el mismo directorio que tu prueba
require_once 'bbdd/connect.php';

class ConexionTest extends TestCase
{
    private $conexion = null;

    public function testConexionExitosa()
    {
        $this->conexion = getConexion();
        $this->assertInstanceOf(mysqli::class, $this->conexion);
        $this->assertEquals(0, $this->conexion->connect_errno);
    }

    public function testBaseDeDatosCreada()
    {
        $this->conexion = getConexion();
        $nombre_bd = 'tourettes'; // Asegúrate de que este nombre coincida con el de tu script
        $resultado = $this->conexion->select_db($nombre_bd);
        $this->assertTrue($resultado);
    }

    // Método para cerrar la conexión después de cada prueba, si es necesario
    protected function tearDown(): void
    {
        if ($this->conexion) {
            $this->conexion->close();
        }
    }
}

?>