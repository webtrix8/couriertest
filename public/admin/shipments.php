<?php
require_once __DIR__ . '/../../lib/auth.php';
require_once __DIR__ . '/../../lib/shipment.php';
require_login();

$message = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf($_POST['csrf'] ?? '')) {
        $message = ['type' => 'danger', 'text' => 'Invalid CSRF token'];
    } else {
        if (isset($_POST['create'])) {
            $data = [
                'sender' => trim($_POST['sender']),
                'receiver' => trim($_POST['receiver']),
                'origin' => trim($_POST['origin']),
                'destination' => trim($_POST['destination']),
                'weight' => (float)$_POST['weight'],
                'cod_amount' => (float)$_POST['cod_amount'],
            ];
            $tracking = create_shipment($data);
            $message = ['type' => 'success', 'text' => 'Shipment created with tracking ' . htmlspecialchars($tracking)];
        }
        if (isset($_POST['log'])) {
            $shipmentId = (int)$_POST['shipment_id'];
            $status = trim($_POST['status']);
            $location = trim($_POST['location']);
            $remarks = trim($_POST['remarks']);
            add_shipment_log($shipmentId, $status, $location, $remarks);
            $message = ['type' => 'success', 'text' => 'Status updated'];
        }
    }
}
$shipments = all_shipments();
?>
<?php include __DIR__ . '/../partials/head.php'; ?>
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Shipments</h2>
    <div>
      <a href="/admin/export.php" class="btn btn-outline-secondary">Export CSV</a>
      <a href="/admin/dashboard.php" class="btn btn-outline-dark">Back</a>
    </div>
  </div>
  <?php if ($message): ?><div class="alert alert-<?php echo $message['type']; ?>"><?php echo $message['text']; ?></div><?php endif; ?>
  <div class="row g-4">
    <div class="col-lg-4">
      <div class="card shadow-sm h-100">
        <div class="card-body">
          <h5 class="card-title">Create Shipment</h5>
          <form method="POST">
            <input type="hidden" name="csrf" value="<?php echo csrf_token(); ?>">
            <input type="hidden" name="create" value="1">
            <div class="mb-2"><input name="sender" class="form-control" placeholder="Sender" required></div>
            <div class="mb-2"><input name="receiver" class="form-control" placeholder="Receiver" required></div>
            <div class="mb-2"><input name="origin" class="form-control" placeholder="Origin" required></div>
            <div class="mb-2"><input name="destination" class="form-control" placeholder="Destination" required></div>
            <div class="mb-2"><input name="weight" type="number" step="0.1" class="form-control" placeholder="Weight (kg)" required></div>
            <div class="mb-2"><input name="cod_amount" type="number" step="0.01" class="form-control" placeholder="COD Amount" required></div>
            <button class="btn btn-danger w-100">Create</button>
          </form>
        </div>
      </div>
    </div>
    <div class="col-lg-8">
      <div class="table-responsive shadow-sm p-3 rounded">
        <table class="table align-middle">
          <thead><tr><th>Tracking</th><th>Sender</th><th>Receiver</th><th>Route</th><th>Status</th><th>COD</th><th>Label</th><th></th></tr></thead>
          <tbody>
            <?php foreach ($shipments as $s): ?>
            <tr>
              <td class="fw-bold"><?php echo htmlspecialchars($s['tracking_number']); ?></td>
              <td><?php echo htmlspecialchars($s['sender']); ?></td>
              <td><?php echo htmlspecialchars($s['receiver']); ?></td>
              <td><small><?php echo htmlspecialchars($s['origin']); ?> → <?php echo htmlspecialchars($s['destination']); ?></small></td>
              <td><span class="badge bg-danger"><?php echo htmlspecialchars($s['status']); ?></span></td>
              <td>PKR <?php echo number_format($s['cod_amount'], 2); ?></td>
              <td><a class="btn btn-sm btn-outline-secondary" href="/admin/label.php?tracking=<?php echo urlencode($s['tracking_number']); ?>">PDF</a></td>
              <td>
                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse" data-bs-target="#update-<?php echo $s['id']; ?>">Update</button>
              </td>
            </tr>
            <tr class="collapse" id="update-<?php echo $s['id']; ?>">
              <td colspan="8">
                <form method="POST" class="row g-2 align-items-end">
                  <input type="hidden" name="csrf" value="<?php echo csrf_token(); ?>">
                  <input type="hidden" name="log" value="1">
                  <input type="hidden" name="shipment_id" value="<?php echo $s['id']; ?>">
                  <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                      <option>Picked Up</option>
                      <option>In Transit</option>
                      <option>Out for Delivery</option>
                      <option>Delivered</option>
                    </select>
                  </div>
                  <div class="col-md-3">
                    <label class="form-label">Location</label>
                    <input name="location" class="form-control" required>
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Remarks</label>
                    <input name="remarks" class="form-control" required>
                  </div>
                  <div class="col-md-2 d-grid">
                    <button class="btn btn-success">Save</button>
                  </div>
                </form>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>
