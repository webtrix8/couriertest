<?php
require_once __DIR__ . '/../../lib/auth.php';
require_once __DIR__ . '/../../lib/shipment.php';
require_login();
$stats = shipment_stats();
$user = current_user();
?>
<?php include __DIR__ . '/../partials/head.php'; ?>
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h2>Dashboard</h2>
      <small class="text-muted">Welcome, <?php echo htmlspecialchars($user['name']); ?></small>
    </div>
    <div>
      <a href="/admin/shipments.php" class="btn btn-outline-secondary">Manage Shipments</a>
      <a href="/admin/logout.php" class="btn btn-dark">Logout</a>
    </div>
  </div>
  <div class="row g-3">
    <div class="col-md-3">
      <div class="card card-kpi shadow-sm">
        <div class="card-body">
          <p class="text-muted mb-1">Total Shipments</p>
          <h3><?php echo $stats['total']; ?></h3>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card card-kpi shadow-sm">
        <div class="card-body">
          <p class="text-muted mb-1">Delivered</p>
          <h3><?php echo $stats['delivered']; ?></h3>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card card-kpi shadow-sm">
        <div class="card-body">
          <p class="text-muted mb-1">In Transit</p>
          <h3><?php echo $stats['in_transit']; ?></h3>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card card-kpi shadow-sm">
        <div class="card-body">
          <p class="text-muted mb-1">Pending</p>
          <h3><?php echo $stats['pending']; ?></h3>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>
