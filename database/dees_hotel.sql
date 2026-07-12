-- =====================================================
-- Dees Boutique Hotel — Database Schema
-- =====================================================

CREATE DATABASE IF NOT EXISTS dees_hotel CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE dees_hotel;

-- ---------------------------------------------------
-- Table: slideshow  (Home page hero slider)
-- ---------------------------------------------------
CREATE TABLE IF NOT EXISTS slideshow (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image_path VARCHAR(255) NOT NULL,
    caption VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ---------------------------------------------------
-- Table: rooms  (Accommodations)
-- ---------------------------------------------------
CREATE TABLE IF NOT EXISTS rooms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type VARCHAR(100) NOT NULL,            -- e.g. Deluxe, Super Deluxe, Suite
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(255) NOT NULL,
    features TEXT,                          -- comma-separated: "Free WiFi,AC,Breakfast Included"
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ---------------------------------------------------
-- Table: facilities
-- ---------------------------------------------------
CREATE TABLE IF NOT EXISTS facilities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,             -- e.g. Fitness Center, Sauna
    image VARCHAR(255) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ---------------------------------------------------
-- Table: gallery
-- ---------------------------------------------------
CREATE TABLE IF NOT EXISTS gallery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image_path VARCHAR(255) NOT NULL,
    category VARCHAR(100) DEFAULT 'General',  -- e.g. Rooms, Facilities, Events, Exterior
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ---------------------------------------------------
-- Table: admin
-- ---------------------------------------------------
CREATE TABLE IF NOT EXISTS admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,          -- stored as password_hash()
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ---------------------------------------------------
-- Table: messages (Contact form submissions)
-- ---------------------------------------------------
CREATE TABLE IF NOT EXISTS messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    phone VARCHAR(30),
    subject VARCHAR(150),
    message TEXT NOT NULL,
    is_read TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- =====================================================
-- SEED DATA
-- =====================================================

-- Default admin login: username = admin / password = Admin@123
-- (This hash below corresponds to "Admin@123" — change immediately after first login)
INSERT INTO admin (username, password) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

INSERT INTO slideshow (image_path, caption) VALUES
('uploads/slideshow/slide1.jpg', 'Welcome to Dees Boutique Hotel'),
('uploads/slideshow/slide2.jpg', 'Luxury Redefined in the Heart of Kathmandu'),
('uploads/slideshow/slide3.jpg', 'Where Comfort Meets Elegance');

INSERT INTO rooms (type, description, price, image, features) VALUES
('Deluxe Room', 'Spacious and elegantly furnished room with modern amenities, perfect for solo travelers or couples.', 4500.00, 'uploads/rooms/deluxe.jpg', 'Free WiFi,Air Conditioning,32" LED TV,Breakfast Included,Daily Housekeeping'),
('Super Deluxe Room', 'A step above, offering extra space, premium furnishings, and a stunning city view.', 6500.00, 'uploads/rooms/super-deluxe.jpg', 'Free WiFi,Air Conditioning,Mini Bar,City View,Breakfast Included,Work Desk'),
('Suite', 'Our finest offering — a lavish suite with a separate living area, ideal for extended stays and special occasions.', 9500.00, 'uploads/rooms/suite.jpg', 'Free WiFi,Air Conditioning,Separate Living Room,Mini Bar,Jacuzzi,Complimentary Breakfast,Butler Service');

INSERT INTO facilities (name, image, description) VALUES
('Fitness Center', 'uploads/facilities/fitness.jpg', 'A fully equipped modern gym open 24/7 to keep up with your wellness routine while you travel.'),
('Banquet Hall', 'uploads/facilities/banquet.jpg', 'An elegant hall perfect for weddings, corporate events, and celebrations of every scale.'),
('Sauna', 'uploads/facilities/sauna.jpg', 'Relax and unwind in our soothing sauna after a long day of exploring the city.'),
('Bar', 'uploads/facilities/bar.jpg', 'A sophisticated bar offering fine wines, crafted cocktails, and a curated spirits selection.'),
('Swimming Pool', 'uploads/facilities/pool.jpg', 'A serene pool area to relax, unwind, and soak in the boutique ambience.'),
('Restaurant', 'uploads/facilities/restaurant.jpg', 'Savor authentic Nepali and international cuisine prepared by our expert culinary team.');

INSERT INTO gallery (image_path, category) VALUES
('uploads/gallery/g1.jpg', 'Exterior'),
('uploads/gallery/g2.jpg', 'Rooms'),
('uploads/gallery/g3.jpg', 'Rooms'),
('uploads/gallery/g4.jpg', 'Facilities'),
('uploads/gallery/g5.jpg', 'Facilities'),
('uploads/gallery/g6.jpg', 'Dining'),
('uploads/gallery/g7.jpg', 'Events'),
('uploads/gallery/g8.jpg', 'Lobby'),
('uploads/gallery/g9.jpg', 'Exterior'),
('uploads/gallery/g10.jpg', 'Dining');
