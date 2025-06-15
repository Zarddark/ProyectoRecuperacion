<?php
class MapGenerator {
    private int $filas;
    private int $columnas;
    private int $minas;
    private array $mapa = [];

    public function __construct(int $filas, int $columnas, int $minas) {
        $this->filas = $filas;
        $this->columnas = $columnas;
        $this->minas = $minas;
        $this->generarMapa();
    }

    // Método para generar el mapa con minas colocadas aleatoriamente.
    private function generarMapa(): void {
        // Inicializamos el mapa con cero (sin minas).
        $this->mapa = array_fill(0, $this->filas, array_fill(0, $this->columnas, 0));

        $minasColocadas = 0;
        // Bucle que continúa hasta colocar todas las minas requeridas.
        while ($minasColocadas < $this->minas) {
            $r = rand(0, $this->filas - 1);
            $c = rand(0, $this->columnas - 1);

            // Si en esa posición no hay mina (valor 0), coloca una mina (valor 1).
            if ($this->mapa[$r][$c] === 0) {
                $this->mapa[$r][$c] = 1;
                $minasColocadas++;
            }
        }
    }

    // Método para obtener el mapa generado.
    public function getMapa(): array {
        return $this->mapa;
    }
}
