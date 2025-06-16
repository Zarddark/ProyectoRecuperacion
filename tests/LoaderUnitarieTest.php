<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/Loader.php';

class LoaderTest extends TestCase {
    private string $jsonPath;
    private string $xmlPath;
    private string $mapaJSON = 'mapa_test.json';
    private string $mapaXML = 'mapa_test.xml';

    protected function setUp(): void {
        // Crea un mapa de prueba
        $mapa = [
            [0, 1, 0],
            [1, 0, 1],
            [0, 1, 0]
        ];

        // JSON creaado manualemnte
        $this->jsonPath = __DIR__ . '/../data/' . $this->mapaJSON;
        file_put_contents($this->jsonPath, json_encode($mapa));

        // XML creado manualemnte
        $xml = new SimpleXMLElement('<mapa/>');
        foreach ($mapa as $fila) {
            $filaXML = $xml->addChild('fila');
            foreach ($fila as $celda) {
                $filaXML->addChild('celda', $celda);
            }
        }
        $this->xmlPath = __DIR__ . '/../data/' . $this->mapaXML;
        $xml->asXML($this->xmlPath);
    }

    protected function tearDown(): void {
        // Borra los archivos de prueba después de cada test
        if (file_exists($this->jsonPath)) unlink($this->jsonPath);
        if (file_exists($this->xmlPath)) unlink($this->xmlPath);
    }

    public function testCargarJSON(): void {
        $resultado = Loader::cargarJSON($this->mapaJSON);
        $this->assertIsArray($resultado);
        $this->assertCount(3, $resultado);
        $this->assertSame(1, $resultado[0][1]); // Verificamos una celda concreta
    }

    public function testCargarXML(): void {
        $resultado = Loader::cargarXML($this->mapaXML);
        $this->assertIsArray($resultado);
        $this->assertCount(3, $resultado);
        $this->assertSame(1, $resultado[1][0]); // Otra celda concreta
    }

    public function testArchivoNoExiste(): void {
        $this->expectException(Exception::class);
        Loader::cargarJSON('inexistente.json');
    }
}
