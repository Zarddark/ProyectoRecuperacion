<?php
// Indicamos que la respuesta será JSON
header('Content-Type: application/json');

// Leemos y decodificamos el JSON recibido por POST
$data = json_decode(file_get_contents('php://input'), true);

// Verificamos que el nombre del archivo esté presente en los datos recibidos
if (!isset($data['archivo'])) {
    // Si no está, devolvemos error 400 (petición incorrecta) y mensaje
    http_response_code(400);
    echo json_encode(['error' => 'Falta el nombre del archivo']);
    exit;
}

// Guardamos el nombre del archivo solicitado
$archivo = $data['archivo'];

// Construimos la ruta absoluta al archivo en la carpeta data (hermana de public)
$ruta = __DIR__ . "/../../data/$archivo";

// Comprobamos que el archivo exista, si no, devolvemos error 404
if (!file_exists($ruta)) {
    http_response_code(404);
    echo json_encode(['error' => 'El archivo no existe']);
    exit;
}

// Incluimos la clase Loader para cargar mapas desde archivos
require_once __DIR__ . '/../../src/Loader.php';

// Obtenemos la extensión del archivo para saber si es JSON o XML
$extension = pathinfo($archivo, PATHINFO_EXTENSION);

try {
    // Según la extensión, usamos el método correspondiente para cargar el mapa
    if ($extension === 'json') {
        $mapa = Loader::cargarJSON($ruta);
    } elseif ($extension === 'xml') {
        $mapa = Loader::cargarXML($ruta);
    } else {
        // Si la extensión no es soportada, devolvemos error 400
        http_response_code(400);
        echo json_encode(['error' => 'Formato de archivo no soportado']);
        exit;
    }

    // Si todo va bien, enviamos el mapa cargado en formato JSON
    echo json_encode(['mapa' => $mapa]);

} catch (Exception $e) {
    // Si ocurre algún error inesperado al cargar el archivo, respondemos con error 500
    http_response_code(500);
    echo json_encode(['error' => 'Error al cargar el archivo']);
}
