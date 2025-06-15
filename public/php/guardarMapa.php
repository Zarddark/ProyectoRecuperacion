<?php
header('Content-Type: application/json');

// Leer datos enviados por POST (JSON)
$data = json_decode(file_get_contents('php://input'), true);

// Verificar que se recibieron los campos necesarios
if (!isset($data['mapa'], $data['formato'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Faltan datos (mapa o formato)']);
    exit;
}

require_once __DIR__ . '/../../src/Saver.php';

$mapa = $data['mapa'];
$formato = strtolower($data['formato']);

// Validar formato solicitado
if (!in_array($formato, ['json', 'xml'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Formato inválido']);
    exit;
}

// Generar nombre de archivo único con timestamp y sufijo aleatorio
$timestamp = date('Ymd_His');
$randomId = bin2hex(random_bytes(4)); // 8 caracteres hex
$nombreArchivo = "mapa_{$timestamp}_{$randomId}." . $formato;

try {
    if ($formato === 'json') {
        Saver::guardarJSON($mapa, $nombreArchivo);
    } else {
        Saver::guardarXML($mapa, $nombreArchivo);
    }

    echo json_encode([
        'exito' => true,
        'archivo' => $nombreArchivo
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error al guardar el archivo']);
}
