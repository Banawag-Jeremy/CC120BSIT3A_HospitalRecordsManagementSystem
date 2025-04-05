CREATE DATABASE IF NOT EXISTS harms;
USE harms;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    password VARCHAR(50),
    role VARCHAR(20)
);

CREATE TABLE appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_name VARCHAR(100),
    doctor VARCHAR(100),
    date DATE
);

CREATE TABLE bills (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient VARCHAR(100),
    amount DECIMAL(10,2)
);

INSERT INTO users (username, password, role) VALUES ('admin', 'admin', 'admin');