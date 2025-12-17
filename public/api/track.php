<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../lib/shipment.php';

$trackingNumber = $_GET['number'] ?? '';
if (!$trackingNumber && isset($_SERVER['PATH_INFO'])) {
    $parts = explode('/', trim($_SERVER['PATH_INFO'], '/'));
    $trackingNumber = $parts[0] ?? '';
}
$trackingNumber = trim($trackingNumber);
if (!$trackingNumber) {
    echo json_encode(['success' => false, 'message' => 'Tracking number required']);
    exit;
}

$shipment = get_shipment_by_tracking($trackingNumber);
if (!$shipment) {
    echo json_encode(['success' => false, 'message' => 'Shipment not found']);
    exit;
}
$logs = get_shipment_logs($shipment['id']);

echo json_encode(['success' => true, 'shipment' => $shipment, 'logs' => $logs]);
