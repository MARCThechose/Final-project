-- Create the database
CREATE DATABASE IF NOT EXISTS `inventory_db`;

-- Use the newly created database
USE `inventory_db`;

-- Create the users table
CREATE TABLE IF NOT EXISTS `users` (
    `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(255) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `role` ENUM('user', 'admin') NOT NULL DEFAULT 'user'
);

-- Create the inventory table
CREATE TABLE IF NOT EXISTS `inventory` (
    `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `quantity` INT(11) NOT NULL,
    `description` TEXT,
    `origin` VARCHAR(255),
    `date_of_arrival` DATE,
    `last_updated` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
