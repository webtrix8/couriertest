CREATE DATABASE IF NOT EXISTS fastship CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE fastship;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('Admin','Operator') NOT NULL DEFAULT 'Operator'
);

CREATE TABLE shipments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tracking_number VARCHAR(20) NOT NULL UNIQUE,
    sender VARCHAR(120) NOT NULL,
    receiver VARCHAR(120) NOT NULL,
    origin VARCHAR(120) NOT NULL,
    destination VARCHAR(120) NOT NULL,
    status VARCHAR(60) NOT NULL DEFAULT 'Booked',
    weight DECIMAL(10,2) DEFAULT 0,
    cod_amount DECIMAL(10,2) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE shipment_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    shipment_id INT NOT NULL,
    status VARCHAR(60) NOT NULL,
    location VARCHAR(120) NOT NULL,
    remarks VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (shipment_id) REFERENCES shipments(id) ON DELETE CASCADE
);

INSERT INTO users (name, email, password, role) VALUES
('Admin User', 'admin@fastship.local', '$2y$12$4KdoAZSsTGqtVlS8ch2EsebqQHV.968sGLR6djmc0fK1FfhnA.Lqi', 'Admin'),
('Operations', 'ops@fastship.local', '$2y$12$4KdoAZSsTGqtVlS8ch2EsebqQHV.968sGLR6djmc0fK1FfhnA.Lqi', 'Operator');

INSERT INTO shipments (tracking_number, sender, receiver, origin, destination, status, weight, cod_amount) VALUES
('FS-PK-100001', 'Ayesha Traders', 'Bilal Stores', 'Karachi', 'Lahore', 'In Transit', 2.5, 1500.00),
('FS-PK-100002', 'Alpha Corp', 'Zara Khan', 'Islamabad', 'Karachi', 'Out for Delivery', 1.2, 750.00),
('FS-PK-100003', 'Book Bazaar', 'Hassan Ali', 'Lahore', 'Islamabad', 'Delivered', 0.8, 0.00);

INSERT INTO shipment_logs (shipment_id, status, location, remarks, created_at) VALUES
(1, 'Booked', 'Karachi', 'Shipment booked', NOW() - INTERVAL 2 DAY),
(1, 'Picked Up', 'Karachi', 'Picked by rider Salman', NOW() - INTERVAL 1 DAY),
(1, 'In Transit', 'Karachi Hub', 'Departed origin facility', NOW()),
(2, 'Booked', 'Islamabad', 'Shipment booked', NOW() - INTERVAL 2 DAY),
(2, 'Picked Up', 'Islamabad', 'Collected from sender', NOW() - INTERVAL 1 DAY),
(2, 'Out for Delivery', 'Karachi', 'Rider Ali en route', NOW()),
(3, 'Booked', 'Lahore', 'Shipment booked', NOW() - INTERVAL 3 DAY),
(3, 'Picked Up', 'Lahore', 'Collected', NOW() - INTERVAL 2 DAY),
(3, 'In Transit', 'Islamabad Hub', 'Line haul', NOW() - INTERVAL 1 DAY),
(3, 'Delivered', 'Islamabad', 'Delivered to receiver', NOW());
