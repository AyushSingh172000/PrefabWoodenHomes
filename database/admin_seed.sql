-- ============================================================
-- Prefab Wooden Homes — Admin & Dynamic Settings Schema Update
-- ============================================================

USE `prefab_wooden_homes`;

-- 1. Site Settings table (key-value configuration)
CREATE TABLE IF NOT EXISTS `site_settings` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `setting_key` VARCHAR(100) NOT NULL UNIQUE,
    `setting_value` TEXT DEFAULT NULL,
    `setting_group` VARCHAR(50) DEFAULT 'general',
    `label` VARCHAR(150) NOT NULL,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Seed default site settings
INSERT INTO `site_settings` (`setting_key`, `setting_value`, `setting_group`, `label`) VALUES
('site_name', 'Prefab Wooden Homes', 'general', 'Company / Brand Name'),
('site_tagline', 'Design • Manufacture • Construct', 'general', 'Brand Tagline'),
('contact_phone_aman', '+91 98104 33120', 'contact', 'Phone (Aman Jha)'),
('contact_phone_rajeev', '+91 95404 89349', 'contact', 'Phone (Rajeev Jha)'),
('contact_email', 'sales@prefabwoodenhomes.com', 'contact', 'Sales Email'),
('contact_email_founder', 'aman@prefabwoodenhomes.com', 'contact', 'Founder Email'),
('contact_whatsapp', '919810433120', 'contact', 'WhatsApp Number (without +)'),
('contact_address', '206 Fauzi Chowk, Dera Village, Near Fatehpur, Chhatarpur, New Delhi - 110074', 'contact', 'Office Address'),
('office_hours', 'Mon – Sat: 9:30 AM – 7:00 PM', 'contact', 'Office Operating Hours'),
('social_facebook', 'https://www.facebook.com/prefabwoodenhomes/', 'social', 'Facebook URL'),
('social_instagram', 'https://www.instagram.com/prefabwoodenhomes/', 'social', 'Instagram URL'),
('social_youtube', 'https://www.youtube.com/channel/UCFWuLZvWxsbdPaR2N35682w', 'social', 'YouTube URL'),
('social_twitter', 'https://twitter.com/', 'social', 'Twitter URL')
ON DUPLICATE KEY UPDATE `label` = VALUES(`label`);

-- 2. Update Admin Password (username: admin, pass: Admin@123)
INSERT INTO `admin_users` (`username`, `email`, `password_hash`, `role`, `is_active`)
VALUES ('admin', 'aman@prefabwoodenhomes.com', '$2y$10$P5XCVqgislW4dps7aUikvOLqvLRr6SC2yfUqLQChFprpmKWfT/ZWS', 'admin', 1)
ON DUPLICATE KEY UPDATE 
    `password_hash` = '$2y$10$P5XCVqgislW4dps7aUikvOLqvLRr6SC2yfUqLQChFprpmKWfT/ZWS',
    `is_active` = 1;

-- 3. Seed Initial Projects if table is empty
INSERT IGNORE INTO `projects` (`id`, `title`, `slug`, `project_type`, `location`, `built_area`, `description`, `image_primary`, `is_featured`, `sort_order`, `is_active`) VALUES
(1, 'Mountain Resort Cottage', 'mountain-resort-cottage', 'resort', 'Manali, Himachal Pradesh', '1,200 sq ft', 'A cluster of three resort cottages built with imported pine logs, designed for year-round mountain hospitality with high thermal insulation.', 'https://images.unsplash.com/photo-1542718610-a1d656d1884c?w=900&q=80', 1, 1, 1),
(2, 'European Timber Farmhouse', 'european-timber-farmhouse', 'farmhouse', 'Lonavala, Maharashtra', '2,500 sq ft', 'European-style wooden farmhouse with wrap-around veranda, built on a 2-acre plot with panoramic valley views.', 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=900&q=80', 1, 2, 1),
(3, 'Luxury Timber Villa', 'luxury-timber-villa', 'villa', 'Goa', '3,200 sq ft', 'A premium two-storey timber villa with high ceilings, open-plan living areas and an outdoor deck overlooking a tropical garden.', 'https://images.unsplash.com/photo-1588880331179-bc9b93a8cb5e?w=900&q=80', 1, 3, 1),
(4, 'Nordic Pine Chalet', 'nordic-pine-chalet', 'cottage', 'Rishikesh, Uttarakhand', '1,800 sq ft', 'Scandinavian-inspired log chalet with pitched roof, panoramic triple-glazed windows and an open timber deck by the riverside.', 'https://images.unsplash.com/photo-1510798831971-661eb04b3739?w=900&q=80', 1, 4, 1),
(5, 'Contemporary A-Frame Cabin', 'contemporary-a-frame-cabin', 'aframe', 'Coorg, Karnataka', '950 sq ft', 'Modern architectural A-frame wooden cabin featuring cathedral-height ceilings, a loft bedroom, and expansive forest vistas.', 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=900&q=80', 1, 5, 1),
(6, 'Eco Stilt Resort Cottages', 'eco-stilt-resort-cottages', 'resort', 'Wayanad, Kerala', '850 sq ft each', 'Elevated stilt cottages nestled within plantation greenery, constructed with treated water-resistant timber and zero foundation damage.', 'https://images.unsplash.com/photo-1449158743715-0a90ebb6d2d8?w=900&q=80', 0, 6, 1);

-- 4. Seed Initial Testimonials if table is empty
INSERT IGNORE INTO `testimonials` (`id`, `client_name`, `client_role`, `testimonial_text`, `rating`, `is_active`, `sort_order`) VALUES
(1, 'Vikram Malhotra', 'Farmhouse Owner, Lonavala', 'Prefab Wooden Homes completed our 2,500 sq ft farmhouse in just under 3 months. The quality of Canadian pine and craftsmanship exceeded all our expectations. It stays cozy in winter and naturally cool in summer.', 5, 1, 1),
(2, 'Sunita & Rahul Singhal', 'Resort Directors, Manali', 'We contracted them to construct 6 luxury log cottages for our boutique retreat in Himachal. From engineering plans to handover, Aman and his crew were thoroughly professional. Our guests are constantly raving about the timber finish.', 5, 1, 2),
(3, 'Col. Arvind Mehra (Retd.)', 'Villa Owner, Dehradun', 'Their factory-prefabricated timber system meant zero construction clutter or long delays on our hillside plot. Termite treatment and water-proofing standards are truly world class.', 5, 1, 3);
