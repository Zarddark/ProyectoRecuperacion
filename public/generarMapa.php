<?php
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

require_once __DIR__ . '/../src/MapGenerator.php';

if (!isset($data['filas'], $data['columnas'], $data['minas'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Faltan parámetros']);
    exit;
}

$filas = (int)$data['filas'];
$columnas = (int)$data['columnas'];
$minas = (int)$data['minas'];

// Validación básica
if ($filas < 1 || $columnas < 1 || $minas < 1 || $minas >= $filas * $columnas) {
    http_response_code(400);
    echo json_encode(['error' => 'Parámetros inválidos']);
    exit;
}

$generator = new MapGenerator($filas, $columnas, $minas);
echo json_encode($generator->getMapa());
