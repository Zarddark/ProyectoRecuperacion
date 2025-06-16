<?php
use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../src/MapGenerator.php';
require_once __DIR__ . '/../src/Saver.php';
require_once __DIR__ . '/../src/Loader.php';

class LoaderIntegrationTest extends TestCase
{
    // Rutas de los archivos que se usarán en las pruebas
    private string $jsonFile = __DIR__ . '/../data/test_integracion.json';
    private string $xmlFile = __DIR__ . '/../data/test_integracion.xml';

    // Método que se ejecuta después de cada test para limpiar archivos temporales
    protected function tearDown(): void
    {
        if (file_exists($this->jsonFile)) unlink($this->jsonFile);
        if (file_exists($this->xmlFile)) unlink($this->xmlFile);
    }

    // Test que verifica que se puede generar, guardar y leer un mapa en formato JSON
    public function testGenerarGuardarYLeerJSON()
    {
        // Crear un mapa de 3x3 con 3 minas
        $generador = new MapGenerator(3, 3, 3);
        $mapa = $generador->getMapa();

        // Guardar el mapa como JSON
        Saver::guardarJSON($mapa, $this->jsonFile);

        // Cargar el mapa desde el archivo
        $mapaCargado = Loader::cargarJSON($this->jsonFile);

        // Verificamos que el mapa original y el cargado sean iguales
        $this->assertEquals($mapa, $mapaCargado);
    }

    // Test que verifica que se puede generar, guardar y leer un mapa en formato XML
    public function testGenerarGuardarYLeerXML()
    {
        $generador = new MapGenerator(3, 3, 3);
        $mapa = $generador->getMapa();

        Saver::guardarXML($mapa, $this->xmlFile);
        $mapaCargado = Loader::cargarXML($this->xmlFile);

        $this->assertEquals($mapa, $mapaCargado);
    }
}
