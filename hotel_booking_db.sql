-- =====================================================
-- Hotel Ilham - Database SQL
-- Sistem Pemesanan Hotel (Syarat UAS Pak Raga)
-- =====================================================

CREATE DATABASE IF NOT EXISTS `hotel_booking_db`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `hotel_booking_db`;

-- =====================================================
-- Table: users
-- =====================================================
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('admin','customer') NOT NULL DEFAULT 'customer',
  `fullname` VARCHAR(255) DEFAULT NULL,
  `phone` VARCHAR(20) DEFAULT NULL,
  `created_at` DATETIME DEFAULT NULL,
  `updated_at` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- Table: categories
-- =====================================================
CREATE TABLE IF NOT EXISTS `categories` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `created_at` DATETIME DEFAULT NULL,
  `updated_at` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- Table: rooms
-- =====================================================
CREATE TABLE IF NOT EXISTS `rooms` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_id` INT(11) UNSIGNED NOT NULL,
  `room_number` VARCHAR(50) NOT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  `status` ENUM('available','booked','maintenance') NOT NULL DEFAULT 'available',
  `description` TEXT DEFAULT NULL,
  `image` VARCHAR(255) DEFAULT NULL,
  `created_at` DATETIME DEFAULT NULL,
  `updated_at` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `room_number` (`room_number`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `fk_rooms_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- Table: facilities
-- =====================================================
CREATE TABLE IF NOT EXISTS `facilities` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `created_at` DATETIME DEFAULT NULL,
  `updated_at` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- Table: room_facilities (pivot)
-- =====================================================
CREATE TABLE IF NOT EXISTS `room_facilities` (
  `room_id` INT(11) UNSIGNED NOT NULL,
  `facility_id` INT(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`room_id`,`facility_id`),
  KEY `facility_id` (`facility_id`),
  CONSTRAINT `fk_rf_room` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_rf_facility` FOREIGN KEY (`facility_id`) REFERENCES `facilities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- Table: bookings
-- =====================================================
CREATE TABLE IF NOT EXISTS `bookings` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) UNSIGNED NOT NULL,
  `room_id` INT(11) UNSIGNED NOT NULL,
  `check_in_date` DATE NOT NULL,
  `check_out_date` DATE NOT NULL,
  `total_price` DECIMAL(10,2) NOT NULL,
  `status` ENUM('pending','approved','rejected','check_in','check_out') NOT NULL DEFAULT 'pending',
  `created_at` DATETIME DEFAULT NULL,
  `updated_at` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `room_id` (`room_id`),
  CONSTRAINT `fk_bookings_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_bookings_room` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- Table: payments
-- =====================================================
CREATE TABLE IF NOT EXISTS `payments` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `booking_id` INT(11) UNSIGNED NOT NULL,
  `amount` DECIMAL(10,2) NOT NULL,
  `payment_method` VARCHAR(100) NOT NULL,
  `proof_image` VARCHAR(255) DEFAULT NULL,
  `status` ENUM('pending','verified','rejected') NOT NULL DEFAULT 'pending',
  `created_at` DATETIME DEFAULT NULL,
  `updated_at` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `booking_id` (`booking_id`),
  CONSTRAINT `fk_payments_booking` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- Seeder Data
-- =====================================================

-- Users (Admin + Customer)
INSERT INTO `users` (`username`, `email`, `password`, `role`, `fullname`, `phone`, `created_at`, `updated_at`) VALUES
('admin', 'admin@hotelilham.com', '$2y$10$p2rk0rr.Zc7ufY/x/aO5geDIA0Btx9T6QZjQgXlxYt16smQwm0602', 'admin', 'Pak Raga Admin', '081234567890', NOW(), NOW()),
('customer', 'customer@gmail.com', '$2y$10$RxsvaXRJ/PQPpYJvabtCZOz29fzPHWxgm8JVzn.Zti6aQvvARHwJC', 'customer', 'Budi Customer', '082233445566', NOW(), NOW());

-- Admin password: admin123
-- Customer password: customer123

-- Categories
INSERT INTO `categories` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Standard', 'Comfortable and affordable room featuring standard amenities, double bed, free Wi-Fi, and a desk.', NOW(), NOW()),
(2, 'Deluxe', 'More spacious room with enhanced facilities, king-sized bed, city view, mini-bar, and modern bathroom.', NOW(), NOW()),
(3, 'Suite', 'Luxurious suite with separate living area, premium entertainment system, bath tub, and complimentary room service.', NOW(), NOW());

-- Facilities
INSERT INTO `facilities` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Free Wi-Fi', 'High speed wireless internet access available throughout the room and lobby.', NOW(), NOW()),
(2, 'Air Conditioning', 'Individual climate control for comfort.', NOW(), NOW()),
(3, 'Flat-screen TV', 'Smart LED TV with premium international channels.', NOW(), NOW()),
(4, 'Mini Bar', 'Fully stocked refrigerator with refreshments and snacks.', NOW(), NOW()),
(5, 'Swimming Pool Access', 'Complimentary access to our pool.', NOW(), NOW());

-- Rooms
INSERT INTO `rooms` (`id`, `category_id`, `room_number`, `price`, `status`, `description`, `image`, `created_at`, `updated_at`) VALUES
(1, 1, '101', 250000.00, 'available', 'Cozy standard room located on the first floor. Perfect for solo travelers or couples.', NULL, NOW(), NOW()),
(2, 1, '102', 250000.00, 'available', 'Cozy standard room with twin beds on the first floor, featuring dynamic view of garden.', NULL, NOW(), NOW()),
(3, 2, '201', 500000.00, 'available', 'Spacious Deluxe room on the second floor with king-size bed and modern bathroom setup.', NULL, NOW(), NOW()),
(4, 2, '202', 500000.00, 'available', 'Spacious Deluxe room on the second floor with king-size bed and modern balcony view.', NULL, NOW(), NOW()),
(5, 3, '301', 1200000.00, 'available', 'Royal Suite room on the penthouse level. Features full living space and high-end styling.', NULL, NOW(), NOW()),
(6, 3, '302', 1200000.00, 'available', 'Presidential Suite with private terrace, pool entry access, and ultimate style and decoration.', NULL, NOW(), NOW());

-- Room Facilities pivot
INSERT INTO `room_facilities` (`room_id`, `facility_id`) VALUES
(1,1),(1,2),(1,3),
(2,1),(2,2),(2,3),
(3,1),(3,2),(3,3),(3,4),
(4,1),(4,2),(4,3),(4,4),
(5,1),(5,2),(5,3),(5,4),(5,5),
(6,1),(6,2),(6,3),(6,4),(6,5);
