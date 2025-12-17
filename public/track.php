<?php include __DIR__ . '/partials/head.php'; ?>
<?php include __DIR__ . '/partials/navbar.php'; ?>
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card shadow-sm">
        <div class="card-body">
          <h3 class="card-title">Track your shipment</h3>
          <p class="text-muted">Enter the tracking number provided by FastShip (e.g., FS-PK-123456).</p>
          <form id="trackingForm" class="row g-2">
            <div class="col-md-9">
              <input id="trackingNumber" type="text" class="form-control form-control-lg" placeholder="Tracking number" required>
            </div>
            <div class="col-md-3 d-grid">
              <button class="btn btn-danger btn-lg" type="submit">Track</button>
            </div>
          </form>
          <div id="trackingResult" class="mt-3"></div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/partials/footer.php'; ?>
