# FastShip Courier & Logistics (PHP)

FastShip is a DHL-inspired courier and logistics demo built with PHP 8, Bootstrap 5, and MySQL. It includes a public website, shipment tracking, admin panel, REST APIs, CSV export, and a lightweight PDF label generator.

## Features
- Public marketing pages (Home, About, Services, Contact)
- AJAX shipment tracking widget and dedicated tracking page
- Unique tracking number generator (FS-PK-XXXXXX pattern)
- Shipment status timeline with location and remarks
- Admin portal with secure login (bcrypt) and role support (Admin, Operator)
- Shipment CRUD (create, update status/logs), KPI dashboard
- CSV export, minimal PDF label download, email notification hook
- REST API endpoints for public tracking and shipment creation/listing
- CSRF protection, prepared statements, server-side validation

## Tech Stack
- PHP 8.1+
- MySQL 8+
- Bootstrap 5, HTML5, CSS3, JavaScript (fetch/AJAX)

## Getting Started
1. **Clone & install**
   ```bash
   git clone <repo> fastship
   cd fastship
   ```
2. **Configure environment**
   - Copy/update `config/config.php` for your DB credentials and base URL.
   - Optional: set `API_KEY` env var for secured shipment API (defaults to `demo-key`).
   - Optional: set `EMAIL_NOTIFICATIONS_ENABLED=true` to send emails (uses PHP `mail`).
3. **Import database**
   ```bash
   mysql -u root -p < database.sql
   ```
4. **Serve the app**
   ```bash
   php -S localhost:8000 -t public
   ```
   Visit `http://localhost:8000` for the public site and `http://localhost:8000/admin/login.php` for the admin panel.

## Admin Credentials
- Email: `admin@fastship.local`
- Password: `Admin@123`

## Sample Tracking Numbers
- `FS-PK-100001`
- `FS-PK-100002`
- `FS-PK-100003`

## API Endpoints
- `GET /api/track.php?number=FS-PK-100001` — Public shipment status and logs.
- `GET /api/shipments.php` — Authenticated list (header `X-API-KEY`).
- `POST /api/shipments.php` — Authenticated create. JSON body:
  ```json
  {"sender":"ACME","receiver":"Customer","origin":"Karachi","destination":"Lahore","weight":1.5,"cod_amount":500}
  ```

## Security Notes
- Bcrypt password hashing via `password_hash`/`password_verify`
- CSRF tokens on all forms
- Parameterized SQL via PDO prepared statements
- Session-based authentication and role checks

## Extras
- **PDF label**: `/admin/label.php?tracking=FS-PK-100001` produces a minimal PDF for printing.
- **CSV export**: `/admin/export.php`
- **Email hooks**: enable with `EMAIL_NOTIFICATIONS_ENABLED=true` to deliver or log email notices on status change (`storage/email.log`).

## Folder Structure
```
config/          # App configuration
lib/             # Auth, DB, shipment, notification helpers
public/          # Web root (public site, admin, APIs, assets)
storage/         # Email log
```

## Notes
- Replace placeholder branding and contact info for production use.
- Do not use DHL logos or trademarks; this demo uses FastShip branding only.
