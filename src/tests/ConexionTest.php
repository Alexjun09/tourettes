<?php

use PHPUnit\Framework\TestCase;

require_once 'bbdd/connect.php';

class ConexionTest extends TestCase {
    private $conexion = null;

    protected function setUp(): void {
        // Inicializamos la conexión con la bbdd
        $this->conexion = getConexion();
    }

    protected function tearDown(): void {
        // Cerramos la conexión después de cada prueba para que las pruebas no afecten al funcionamiento de la web
        if ($this->conexion) {
            $this->conexion->close();
            $this->conexion = null;
        }
    }

    public function testConexionExitosa() {
        
        //Nos aseguramos que la conexión devuelva un objeto 
        $this->assertInstanceOf(mysqli::class, $this->conexion);

        //Comprobamos que el número de errores devueltos son 0
        $this->assertEquals(0, $this->conexion->connect_errno);
    }

    public function testBaseDeDatosCreada() {
        $nombre_bd = 'tourettes'; 
        $resultado = $this->conexion->select_db($nombre_bd);
        //Si devuelve un true, la bbdd ha sido creada correctamente
        $this->assertTrue($resultado);
    }
}
