-- SQL Code

CREATE DATABASE bloodbank;
USE bloodbank;

-- Admin Table
CREATE TABLE IF NOT EXISTS admin (
    id INT(11) NOT NULL AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
);

-- Donor Table
CREATE TABLE  donor (
    id INT(11) NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    age INT(11) NOT NULL,
    gender ENUM('Male', 'Female') NOT NULL,
    blood_group ENUM('A+','A-','B+','B-','O+','O-','AB+','AB-') NOT NULL,
    city VARCHAR(100) NOT NULL,
    hospital VARCHAR(100),
    contact VARCHAR(20) NOT NULL,
    PRIMARY KEY (id)
);

-- Blood Request Table
CREATE TABLE blood_request (
    id INT(11) NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    gender ENUM('Male', 'Female') NOT NULL,
    blood_group ENUM('A+','A-','B+','B-','O+','O-','AB+','AB-') NOT NULL,
    units INT(11) NOT NULL,
    contact VARCHAR(20) NOT NULL,
    request_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    status ENUM('Pending','Approved','Rejected') NOT NULL DEFAULT 'Pending',
    PRIMARY KEY (id)
);

-- Stock Table
CREATE TABLE stock (
    blood_group ENUM('A+','A-','B+','B-','O+','O-','AB+','AB-') NOT NULL,
    units INT(11) NOT NULL DEFAULT 0,
    PRIMARY KEY (blood_group)
);

-- -- Sample Insert Queries
-- INSERT INTO admin (username, password) VALUES ('admin', 'admin123');

-- INSERT INTO donor (name, age, gender, blood_group, city, hospital, contact) VALUES
-- ('Ali Khan', 30, 'Male', 'A+', 'Lahore', 'Services Hospital', '+923001234567'),
-- ('Sara Malik', 27, 'Female', 'O-', 'Karachi', 'Agha Khan Hospital', '+923004567890');

-- INSERT INTO stock (blood_group, units) VALUES
-- ('A+', 10), ('A-', 5), ('B+', 8), ('B-', 6),
-- ('O+', 12), ('O-', 4), ('AB+', 3), ('AB-', 2);

-- INSERT INTO blood_request (name, gender, blood_group, units, contact, status) VALUES
-- ('Patient 1', 'Male', 'A+', 2, '+923008888888', 'Approved'),
-- ('Patient 2', 'Female', 'B-', 3, '+923007777777', 'Pending');