<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/MapGenerator.php';
require_once __DIR__ . '/../src/Saver.php';

class SaverTest extends TestCase
{
    private string $jsonPath;
    private string $xmlPath;
    private array $mapa;

    protected function setUp(): void
    {
        // Mapa de prueba generado
        $this->mapa = (new MapGenerator(5, 5, 5))->getMapa();

        // Rutas de prueba
        $this->jsonPath = __DIR__ . '/../data/test_map.json';
        $this->xmlPath = __DIR__ . '/../data/test_map.xml';
    }

    public function testGuardarJSON()
    {
        Saver::guardarJSON($this->mapa, $this->jsonPath);
        $this->assertFileExists($this->jsonPath, 'El archivo JSON no fue creado.');
        
        $contenido = json_decode(file_get_contents($this->jsonPath), true);
        $this->assertIsArray($contenido, 'El contenido del JSON no es un array.');
        $this->assertEquals($this->mapa, $contenido, 'El contenido del JSON no coincide con el mapa original.');
    }

    public function testGuardarXML()
    {
        Saver::guardarXML($this->mapa, $this->xmlPath);
        $this->assertFileExists($this->xmlPath, 'El archivo XML no fue creado.');

        $xml = simplexml_load_file($this->xmlPath);
        $this->assertEquals(count($this->mapa), count($xml->fila), 'El número de filas en el XML no coincide.');
    }

    protected function tearDown(): void
    {
        // Limpieza: eliminar archivos de prueba si existen
        if (file_exists($this->jsonPath)) {
            unlink($this->jsonPath);
        }

        if (file_exists($this->xmlPath)) {
            unlink($this->xmlPath);
        }
    }
}
