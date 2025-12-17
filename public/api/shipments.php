<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../lib/shipment.php';

$apiKey = getenv('API_KEY') ?: 'demo-key';
$provided = $_SERVER['HTTP_X_API_KEY'] ?? '';
if ($provided !== $apiKey) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    echo json_encode(['success' => true, 'shipments' => all_shipments()]);
    exit;
}

if ($method === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true) ?: [];
    $required = ['sender', 'receiver', 'origin', 'destination', 'weight', 'cod_amount'];
    foreach ($required as $field) {
        if (!isset($input[$field]) || $input[$field] === '') {
            http_response_code(422);
            echo json_encode(['success' => false, 'message' => $field . ' is required']);
            exit;
        }
    }
    $tracking = create_shipment($input);
    echo json_encode(['success' => true, 'tracking_number' => $tracking]);
    exit;
}

echo json_encode(['success' => false, 'message' => 'Method not allowed']);
