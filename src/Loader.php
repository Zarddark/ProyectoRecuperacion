<?php

class Loader {
    /**
     * Devuelve la ruta completa al archivo desde /data si no se especifica ruta.
     */
    private static function rutaConDirectorio(string $archivo): string {
        if (strpos($archivo, '/') !== false || strpos($archivo, '\\') !== false) {
            return $archivo;
        }
        return __DIR__ . '/../data/' . $archivo;
    }

    /**
     * Carga un mapa desde un archivo JSON y lo devuelve como array.
     */
    public static function cargarJSON(string $archivo): array {
        $ruta = self::rutaConDirectorio($archivo);
        if (!file_exists($ruta)) {
            throw new Exception("Archivo JSON no encontrado: $ruta");
        }

        $contenido = file_get_contents($ruta);
        return json_decode($contenido, true);
    }

    /**
     * Carga un mapa desde un archivo XML y lo devuelve como array.
     */
    public static function cargarXML(string $archivo): array {
        $ruta = self::rutaConDirectorio($archivo);
        if (!file_exists($ruta)) {
            throw new Exception("Archivo XML no encontrado: $ruta");
        }

        $xml = simplexml_load_file($ruta);
        $mapa = [];

        // Recorremos cada <fila>
        foreach ($xml->fila as $fila) {
            $filaArray = [];
            // Recorremos cada <celda> dentro de la fila
            foreach ($fila->celda as $celda) {
                $filaArray[] = (int) $celda;  // Convertir a entero
            }
            $mapa[] = $filaArray;
        }

        return $mapa;
    }
}
