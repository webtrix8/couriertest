<?php include __DIR__ . '/partials/head.php'; ?>
<?php include __DIR__ . '/partials/navbar.php'; ?>
<section class="hero">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-6">
        <h1>Fast, reliable courier and logistics.</h1>
        <p class="lead">FastShip delivers packages across the globe with real-time tracking, secure handling, and responsive support.</p>
        <div class="tracking-box mt-4">
          <form id="trackingForm" class="row g-2">
            <div class="col-md-8">
              <input id="trackingNumber" type="text" class="form-control form-control-lg" placeholder="Enter your tracking number" required>
            </div>
            <div class="col-md-4 d-grid">
              <button class="btn btn-danger btn-lg" type="submit">Track Shipment</button>
            </div>
          </form>
          <div id="trackingResult" class="mt-3"></div>
        </div>
      </div>
      <div class="col-lg-6 text-center">
        <img src="https://dummyimage.com/560x360/e2231a/ffffff&text=FastShip+Network" class="img-fluid rounded shadow" alt="Logistics illustration">
      </div>
    </div>
  </div>
</section>

<section class="py-5 bg-light">
  <div class="container">
    <div class="row g-4">
      <div class="col-md-4">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <h5 class="card-title">Express Delivery</h5>
            <p class="card-text">Next-day delivery across major cities with time-definite options.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <h5 class="card-title">E-commerce Logistics</h5>
            <p class="card-text">COD handling, returns management, and branded notifications for your store.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <h5 class="card-title">International Freight</h5>
            <p class="card-text">Door-to-door freight with customs clearance and proactive updates.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="py-5">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-6">
        <h2>Track every milestone</h2>
        <p>Stay in control with transparent status updates from pickup to last-mile delivery.</p>
        <ul>
          <li>Unique tracking numbers with live status history</li>
          <li>Service-level agreements for predictable arrivals</li>
          <li>Customer notifications at every handoff</li>
        </ul>
      </div>
      <div class="col-md-6">
        <div class="card shadow-sm">
          <div class="card-body">
            <h5 class="card-title">Shipment timeline</h5>
            <div class="timeline">
              <div class="timeline-item"><strong>Picked Up</strong> <small class="text-muted">Rider: Ali Khan</small></div>
              <div class="timeline-item"><strong>In Transit</strong> <small class="text-muted">Karachi Hub</small></div>
              <div class="timeline-item"><strong>Out for Delivery</strong> <small class="text-muted">Islamabad</small></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include __DIR__ . '/partials/footer.php'; ?>
