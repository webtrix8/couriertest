<?php
require_once __DIR__ . '/../../lib/auth.php';
require_once __DIR__ . '/../../lib/shipment.php';
require_login();
export_shipments_csv();
