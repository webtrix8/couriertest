<?php
$cfg = require __DIR__ . '/../config/config.php';

$dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=%s',
    $cfg['db']['host'],
    $cfg['db']['port'],
    $cfg['db']['name'],
    $cfg['db']['charset']
);

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $cfg['db']['user'], $cfg['db']['pass'], $options);
} catch (PDOException $e) {
    die('Database connection failed: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8'));
}
