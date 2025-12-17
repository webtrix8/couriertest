document.addEventListener('DOMContentLoaded', () => {
    const trackingForm = document.getElementById('trackingForm');
    const trackingInput = document.getElementById('trackingNumber');
    const trackingResult = document.getElementById('trackingResult');

    if (trackingForm && trackingInput && trackingResult) {
        const submitHandler = (event) => {
            event.preventDefault();
            const value = trackingInput.value.trim();
            if (!value) {
                trackingResult.innerHTML = '<div class="alert alert-warning">Enter a tracking number.</div>';
                return;
            }
            trackingResult.innerHTML = '<div class="alert alert-info">Loading...</div>';
            fetch(`/api/track.php?number=${encodeURIComponent(value)}`)
                .then(resp => resp.json())
                .then(data => {
                    if (!data.success) {
                        trackingResult.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
                        return;
                    }
                    renderTracking(data);
                })
                .catch(() => trackingResult.innerHTML = '<div class="alert alert-danger">Unable to fetch tracking.</div>');
        };

        trackingForm.addEventListener('submit', submitHandler);
        trackingInput.addEventListener('keyup', (e) => {
            if (e.key === 'Enter') {
                submitHandler(e);
            }
        });
    }
});

function renderTracking(data) {
    const trackingResult = document.getElementById('trackingResult');
    const timeline = data.logs.map(log => {
        return `<div class="timeline-item">
            <div class="d-flex justify-content-between align-items-center">
              <div><span class="badge bg-danger status-badge">${log.status}</span> ${log.remarks}</div>
              <small class="text-muted">${log.created_at} - ${log.location}</small>
            </div>
          </div>`;
    }).join('');

    trackingResult.innerHTML = `
      <div class="card shadow-sm">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start mb-3">
            <div>
              <h5 class="card-title mb-0">${data.shipment.tracking_number}</h5>
              <small class="text-muted">${data.shipment.origin} → ${data.shipment.destination}</small>
            </div>
            <span class="badge bg-dark">${data.shipment.status}</span>
          </div>
          <div class="timeline">
            ${timeline}
          </div>
        </div>
      </div>`;
}
