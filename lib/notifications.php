<?php
$cfg = require __DIR__ . '/../config/config.php';

function notify_status_change($shipment, $status, $location, $remarks)
{
    global $cfg;
    if (!$cfg['email']['notifications_enabled']) {
        return;
    }

    $to = $shipment['receiver'];
    $subject = 'FastShip shipment update: ' . $shipment['tracking_number'];
    $message = "Status: {$status}\nLocation: {$location}\nRemarks: {$remarks}";
    @mail($to, $subject, $message, 'From: ' . $cfg['email']['from']);
    file_put_contents(__DIR__ . '/../storage/email.log', date('c') . ' ' . $to . ' ' . $subject . PHP_EOL, FILE_APPEND);
}
