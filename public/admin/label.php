<?php
require_once __DIR__ . '/../../lib/auth.php';
require_once __DIR__ . '/../../lib/shipment.php';
require_login();

$tracking = $_GET['tracking'] ?? '';
$shipment = $tracking ? get_shipment_by_tracking($tracking) : null;
if (!$shipment) {
    http_response_code(404);
    exit('Label not found');
}

$label = "FastShip Logistics\nTracking: {$shipment['tracking_number']}\nFrom: {$shipment['origin']}\nTo: {$shipment['destination']}\nWeight: {$shipment['weight']} kg\nCOD: PKR {$shipment['cod_amount']}\n";

// Minimal PDF structure
$content = "%PDF-1.4\n";
$content .= "1 0 obj<</Type/Catalog/Pages 2 0 R>>endobj\n";
$content .= "2 0 obj<</Type/Pages/Count 1/Kids[3 0 R]>>endobj\n";
$stream = "BT /F1 12 Tf 50 750 Td ({$label}) Tj ET";
$content .= "3 0 obj<</Type/Page/Parent 2 0 R/MediaBox[0 0 612 792]/Contents 4 0 R/Resources<</Font<</F1 5 0 R>>>>>>endobj\n";
$content .= "4 0 obj<</Length " . strlen($stream) . ">>stream\n{$stream}\nendstream endobj\n";
$content .= "5 0 obj<</Type/Font/Subtype/Type1/BaseFont/Helvetica>>endobj\n";
$content .= "xref\n0 6\n0000000000 65535 f \n0000000010 00000 n \n0000000061 00000 n \n0000000116 00000 n \n0000000275 00000 n \n0000000400 00000 n \ntrailer<</Size 6/Root 1 0 R>>\nstartxref\n500\n%%EOF";

header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="label-' . $shipment['tracking_number'] . '.pdf"');
echo $content;
exit;
