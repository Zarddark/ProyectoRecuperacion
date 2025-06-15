<?php

class Saver {
    /**
     * Obtiene la ruta completa para guardar un archivo.
     * 
     * Si el nombre de archivo ya contiene una ruta (tiene '/' o '\'), devuelve tal cual.
     * Si solo es un nombre simple, lo guarda dentro de la carpeta `/data` (relativa a este archivo).
     *
     * @param string $archivo Nombre o ruta del archivo
     * @return string Ruta completa del archivo
     */
    private static function rutaConDirectorio(string $archivo): string {
        // Verifica si $archivo ya contiene una ruta (barra / o \)
        if (strpos($archivo, '/') !== false || strpos($archivo, '\\') !== false) {
            return $archivo; // ya es ruta completa o relativa, no modificar
        }
        // Si es solo nombre, concatenamos la carpeta /data para guardar ahí
        return __DIR__ . '/../data/' . $archivo;
    }

    /**
     * Guarda el array $mapa en formato JSON en el archivo indicado.
     * 
     * @param array $mapa Mapa que se quiere guardar
     * @param string $archivo Nombre o ruta del archivo JSON destino
     * @return void
     */
    public static function guardarJSON(array $mapa, string $archivo): void {
        // Obtiene la ruta completa para el archivo
        $rutaFinal = self::rutaConDirectorio($archivo);
        // Codifica el array $mapa a JSON con formato legible y lo escribe en el archivo
        file_put_contents($rutaFinal, json_encode($mapa, JSON_PRETTY_PRINT));
    }

    /**
     * Guarda el array $mapa en formato XML en el archivo indicado.
     * 
     * La estructura XML será:
     * <mapa>
     *   <fila>
     *     <celda>valor</celda>
     *     ...
     *   </fila>
     *   ...
     * </mapa>
     *
     * @param array $mapa Mapa que se quiere guardar
     * @param string $archivo Nombre o ruta del archivo XML destino
     * @return void
     */
    public static function guardarXML(array $mapa, string $archivo): void {
        // Obtiene la ruta completa para el archivo
        $rutaFinal = self::rutaConDirectorio($archivo);

        // Crea el elemento raíz <mapa>
        $xml = new SimpleXMLElement('<mapa/>');

        // Por cada fila en el mapa, crea un elemento <fila>
        foreach ($mapa as $fila) {
            $filaXML = $xml->addChild('fila');

            // Por cada celda en la fila, crea un elemento <celda> con el valor
            foreach ($fila as $celda) {
                $filaXML->addChild('celda', $celda);
            }
        }

        // Guarda el XML en el archivo
        $xml->asXML($rutaFinal);
    }
}
