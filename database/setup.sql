-- ============================================================
-- Prefab Wooden Homes — Database Setup
-- Run this in phpMyAdmin or MySQL CLI
-- ============================================================

CREATE DATABASE IF NOT EXISTS `prefab_wooden_homes`
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE `prefab_wooden_homes`;

-- Enquiries table (contact form submissions)
CREATE TABLE IF NOT EXISTS `enquiries` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(150) NOT NULL,
    `phone` VARCHAR(20) DEFAULT NULL,
    `project_type` VARCHAR(50) DEFAULT NULL,
    `location` VARCHAR(100) DEFAULT NULL,
    `message` TEXT NOT NULL,
    `ip_address` VARCHAR(45) DEFAULT NULL,
    `is_read` TINYINT(1) DEFAULT 0,
    `is_replied` TINYINT(1) DEFAULT 0,
    `admin_notes` TEXT DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,

    INDEX `idx_created_at` (`created_at`),
    INDEX `idx_is_read` (`is_read`),
    INDEX `idx_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Projects table (for dynamic project gallery)
CREATE TABLE IF NOT EXISTS `projects` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(200) NOT NULL,
    `slug` VARCHAR(200) NOT NULL UNIQUE,
    `project_type` VARCHAR(50) NOT NULL,
    `location` VARCHAR(100) DEFAULT NULL,
    `built_area` VARCHAR(50) DEFAULT NULL,
    `description` TEXT DEFAULT NULL,
    `image_primary` VARCHAR(500) DEFAULT NULL,
    `images` JSON DEFAULT NULL,
    `is_featured` TINYINT(1) DEFAULT 0,
    `sort_order` INT DEFAULT 0,
    `is_active` TINYINT(1) DEFAULT 1,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,

    INDEX `idx_featured` (`is_featured`),
    INDEX `idx_active` (`is_active`),
    INDEX `idx_type` (`project_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Testimonials table
CREATE TABLE IF NOT EXISTS `testimonials` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `client_name` VARCHAR(100) NOT NULL,
    `client_role` VARCHAR(100) DEFAULT NULL,
    `testimonial_text` TEXT NOT NULL,
    `rating` TINYINT UNSIGNED DEFAULT 5,
    `is_active` TINYINT(1) DEFAULT 1,
    `sort_order` INT DEFAULT 0,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Site visits requests
CREATE TABLE IF NOT EXISTS `site_visits` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `enquiry_id` INT UNSIGNED DEFAULT NULL,
    `name` VARCHAR(100) NOT NULL,
    `phone` VARCHAR(20) NOT NULL,
    `site_location` VARCHAR(200) NOT NULL,
    `preferred_date` DATE DEFAULT NULL,
    `status` ENUM('pending', 'scheduled', 'completed', 'cancelled') DEFAULT 'pending',
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,

    INDEX `idx_status` (`status`),
    FOREIGN KEY (`enquiry_id`) REFERENCES `enquiries`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Admin users (for future admin panel)
CREATE TABLE IF NOT EXISTS `admin_users` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(50) NOT NULL UNIQUE,
    `email` VARCHAR(150) NOT NULL UNIQUE,
    `password_hash` VARCHAR(255) NOT NULL,
    `role` ENUM('admin', 'editor') DEFAULT 'editor',
    `is_active` TINYINT(1) DEFAULT 1,
    `last_login` DATETIME DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default admin (password: change-this-password)
-- In production, change this immediately after setup
INSERT INTO `admin_users` (`username`, `email`, `password_hash`, `role`)
VALUES ('admin', 'aman@prefabwoodenhomes.com', '$2y$12$placeholder.hash.change.this.in.production', 'admin')
ON DUPLICATE KEY UPDATE `username` = `username`;
