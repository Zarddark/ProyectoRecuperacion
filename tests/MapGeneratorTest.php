<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/MapGenerator.php';

class MapGeneratorTest extends TestCase
{
    public function testMapaGeneradoCorrectamente()
    {
        $filas = 9;
        $columnas = 9;
        $minas = 10;

        $mapGen = new MapGenerator($filas, $columnas, $minas);
        $mapa = $mapGen->getMapa();

        // Verificar dimensiones
        $this->assertCount($filas, $mapa, "El número de filas no es correcto.");
        $this->assertCount($columnas, $mapa[0], "El número de columnas no es correcto.");

        // Contar minas y comprobar valores
        $contadorMinas = 0;
        foreach ($mapa as $fila) {
            foreach ($fila as $casilla) {
                $this->assertContains($casilla, [0, 1], "Valor inválido encontrado en el mapa.");
                if ($casilla === 1) {
                    $contadorMinas++;
                }
            }
        }
        $this->assertEquals($minas, $contadorMinas, "El número de minas no coincide.");
    }
}
