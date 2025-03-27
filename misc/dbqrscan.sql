CREATE DATABASE IF NOT EXISTS dbqrscan;
USE dbqrscan;

-- Table structure for users
CREATE TABLE users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(30) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('student', 'faculty', 'admin') NOT NULL,
    points INT(6) UNSIGNED DEFAULT 0,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table structure for qr_codes
CREATE TABLE qr_codes (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    unique_text VARCHAR(255) NOT NULL UNIQUE,
    booth_name VARCHAR(50) NOT NULL,
    description TEXT,
    points INT(6) NOT NULL,
    expiration_time TIMESTAMP NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table structure for scan_history
CREATE TABLE scan_history (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT(6) UNSIGNED NOT NULL,
    qr_code_id INT(6) UNSIGNED NOT NULL,
    scan_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    points_added INT(6) NOT NULL,
    description VARCHAR(255),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (qr_code_id) REFERENCES qr_codes(id)
);
