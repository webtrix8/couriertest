<?php
// Basic configuration for FastShip courier web application.
// Update values to match your environment.

return [
    'app_name' => 'FastShip Logistics',
    'base_url' => getenv('APP_URL') ?: 'http://localhost',
    'db' => [
        'host' => getenv('DB_HOST') ?: '127.0.0.1',
        'port' => getenv('DB_PORT') ?: '3306',
        'name' => getenv('DB_DATABASE') ?: 'fastship',
        'user' => getenv('DB_USERNAME') ?: 'root',
        'pass' => getenv('DB_PASSWORD') ?: '',
        'charset' => 'utf8mb4'
    ],
    'email' => [
        'from' => 'no-reply@fastship.local',
        'notifications_enabled' => getenv('EMAIL_NOTIFICATIONS_ENABLED') === 'true'
    ]
];
