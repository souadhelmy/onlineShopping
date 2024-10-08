CREATE DATABASE IF NOT EXISTS `online_shop`;

USE `online_shop`;

CREATE TABLE IF NOT EXISTS `users` (
    `id` INT(11) UNSIGNED NOT NULL  PRIMARY KEY AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `phone` VARCHAR(255) NOT NULL,
    `address` VARCHAR(255) NOT NULL,
    `type` ENUM('admin','user') DEFAULT 'user',
    `create_at` DATETIME NOT NULL DEFAULT NOW()
);

CREATE TABLE IF NOT EXISTS `products` (
    `id` INT(11) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `title` VARCHAR(255) NOT NULL,
    `price` VARCHAR(50) NOT NULL,
    `details` TEXT NOT NULL,
    `image` VARCHAR(25) NOT NULL,
    `create_at` DATETIME NOT NULL DEFAULT NOW(),
    `user_id` INT(11) UNSIGNED,
    FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE     
);