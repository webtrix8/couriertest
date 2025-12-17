<?php
require_once __DIR__ . '/database.php';
require_once __DIR__ . '/notifications.php';

function generate_tracking_number($pdo)
{
    $random = random_int(100000, 999999);
    return 'FS-PK-' . $random;
}

function create_shipment($data)
{
    global $pdo;
    $trackingNumber = generate_tracking_number($pdo);
    $stmt = $pdo->prepare('INSERT INTO shipments (tracking_number, sender, receiver, origin, destination, status, weight, cod_amount) VALUES (:tracking_number, :sender, :receiver, :origin, :destination, :status, :weight, :cod_amount)');
    $stmt->execute([
        'tracking_number' => $trackingNumber,
        'sender' => $data['sender'],
        'receiver' => $data['receiver'],
        'origin' => $data['origin'],
        'destination' => $data['destination'],
        'status' => 'Booked',
        'weight' => $data['weight'],
        'cod_amount' => $data['cod_amount'],
    ]);

    $shipmentId = (int)$pdo->lastInsertId();
    add_shipment_log($shipmentId, 'Booked', $data['origin'], 'Shipment booked');
    return $trackingNumber;
}

function add_shipment_log($shipmentId, $status, $location, $remarks)
{
    global $pdo;
    $stmt = $pdo->prepare('INSERT INTO shipment_logs (shipment_id, status, location, remarks, created_at) VALUES (:shipment_id, :status, :location, :remarks, NOW())');
    $stmt->execute([
        'shipment_id' => $shipmentId,
        'status' => $status,
        'location' => $location,
        'remarks' => $remarks,
    ]);

    $update = $pdo->prepare('UPDATE shipments SET status = :status WHERE id = :id');
    $update->execute(['status' => $status, 'id' => $shipmentId]);

    $shipment = get_shipment_by_id($shipmentId);
    notify_status_change($shipment, $status, $location, $remarks);
}

function get_shipment_by_tracking($tracking)
{
    global $pdo;
    $stmt = $pdo->prepare('SELECT * FROM shipments WHERE tracking_number = :tracking LIMIT 1');
    $stmt->execute(['tracking' => $tracking]);
    return $stmt->fetch();
}

function get_shipment_by_id($id)
{
    global $pdo;
    $stmt = $pdo->prepare('SELECT * FROM shipments WHERE id = :id LIMIT 1');
    $stmt->execute(['id' => $id]);
    return $stmt->fetch();
}

function get_shipment_logs($shipmentId)
{
    global $pdo;
    $stmt = $pdo->prepare('SELECT * FROM shipment_logs WHERE shipment_id = :id ORDER BY created_at ASC');
    $stmt->execute(['id' => $shipmentId]);
    return $stmt->fetchAll();
}

function shipment_stats()
{
    global $pdo;
    $statuses = ['Delivered', 'In Transit', 'Pending', 'Booked', 'Out for Delivery', 'Picked Up'];
    $stats = [
        'total' => (int)$pdo->query('SELECT COUNT(*) FROM shipments')->fetchColumn(),
        'delivered' => 0,
        'in_transit' => 0,
        'pending' => 0,
    ];

    $stmt = $pdo->query('SELECT status, COUNT(*) as count FROM shipments GROUP BY status');
    foreach ($stmt->fetchAll() as $row) {
        if ($row['status'] === 'Delivered') {
            $stats['delivered'] = (int)$row['count'];
        }
        if ($row['status'] === 'In Transit') {
            $stats['in_transit'] = (int)$row['count'];
        }
        if (in_array($row['status'], ['Booked', 'Picked Up', 'Out for Delivery'])) {
            $stats['pending'] += (int)$row['count'];
        }
    }
    return $stats;
}

function all_shipments()
{
    global $pdo;
    $stmt = $pdo->query('SELECT * FROM shipments ORDER BY created_at DESC');
    return $stmt->fetchAll();
}

function update_shipment($id, $data)
{
    global $pdo;
    $stmt = $pdo->prepare('UPDATE shipments SET sender=:sender, receiver=:receiver, origin=:origin, destination=:destination, weight=:weight, cod_amount=:cod_amount WHERE id = :id');
    $stmt->execute([
        'sender' => $data['sender'],
        'receiver' => $data['receiver'],
        'origin' => $data['origin'],
        'destination' => $data['destination'],
        'weight' => $data['weight'],
        'cod_amount' => $data['cod_amount'],
        'id' => $id
    ]);
}

function export_shipments_csv()
{
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="shipments.csv"');
    $output = fopen('php://output', 'w');
    fputcsv($output, ['Tracking', 'Sender', 'Receiver', 'Origin', 'Destination', 'Status', 'Weight', 'COD Amount']);
    foreach (all_shipments() as $shipment) {
        fputcsv($output, [
            $shipment['tracking_number'],
            $shipment['sender'],
            $shipment['receiver'],
            $shipment['origin'],
            $shipment['destination'],
            $shipment['status'],
            $shipment['weight'],
            $shipment['cod_amount'],
        ]);
    }
    fclose($output);
    exit;
}
