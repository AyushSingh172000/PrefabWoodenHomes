-- ============================================================
-- Prefab Wooden Homes — Services & Branding Schema Extension
-- ============================================================

USE `prefab_wooden_homes`;

-- 1. Services & Construction Types table
CREATE TABLE IF NOT EXISTS `services` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `slug` VARCHAR(100) NOT NULL UNIQUE,
    `title` VARCHAR(200) NOT NULL,
    `badge` VARCHAR(100) DEFAULT NULL,
    `subtitle` VARCHAR(255) DEFAULT NULL,
    `description` TEXT NOT NULL,
    `features` TEXT DEFAULT NULL,
    `image` VARCHAR(500) DEFAULT NULL,
    `sort_order` INT DEFAULT 0,
    `is_active` TINYINT(1) DEFAULT 1,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Seed default 7 Construction Services
INSERT INTO `services` (`id`, `slug`, `title`, `badge`, `subtitle`, `description`, `features`, `image`, `sort_order`, `is_active`) VALUES
(1, 'prefab-houses', 'Prefab Wooden Houses', 'Turnkey Precision', 'Factory-engineered timber components assembled on-site in 8–12 weeks.', 
'Prefabricated wooden homes are designed and manufactured off-site in a controlled factory environment, then transported and assembled at your chosen location. This method ensures consistent quality, reduced waste and significantly faster construction timelines compared to traditional building.\n\nOur prefab homes range from compact single-bedroom cottages to spacious family residences, all fully customisable in layout, design and finish.',
'Factory-built precision with on-site assembly\nMove-in ready in 8–12 weeks\nFully customisable floor plans and interiors\nTransportable to any location across India\n100% Termite Treated & FSC Certified Pine',
'https://images.unsplash.com/photo-1449158743715-0a90ebb6d2d8?w=900&q=80', 1, 1),

(2, 'cottages', 'Wooden Cottages', 'Charming Retreats', 'Charming retreats for hill stations, farms, and weekend getaways.',
'Our wooden cottages are charming, compact structures that blend beautifully with natural surroundings. Whether nestled in the hills, by a lake, or on a farm, these cottages offer a cosy retreat with modern comforts.\n\nBuilt with premium imported pine and engineered to handle India\'s diverse climatic conditions, our cottages are both beautiful and practical.',
'Ideal for hill stations, farms and weekend getaways\nCompact yet comfortable living spaces\nDesigned for Indian weather conditions\nLog and timber frame construction options',
'https://images.unsplash.com/photo-1510798831971-661eb04b3739?w=900&q=80', 2, 1),

(3, 'farmhouses', 'Wooden Farmhouses', 'Country Living', 'European-style timber farmhouses with wrap-around verandas.',
'A wooden farmhouse is the ultimate expression of country living — spacious, elegant and deeply connected to nature. Our farmhouse designs combine European chalet aesthetics with practical features suited to Indian farmland and climate.',
'Expansive layouts with open-plan living areas\nWrap-around verandas and terraces\nSuitable for large farm plots across India\nPremium wood with complete waterproofing and termite treatment',
'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?w=900&q=80', 3, 1),

(4, 'villas', 'Wooden Villas', 'Luxury Residences', 'Luxury timber residences with cathedral ceilings and scenic decks.',
'Our wooden villas are luxury timber residences designed for those who want the finest in wooden architecture. With high ceilings, premium finishes and intelligent use of natural light, these homes are a statement of refined living.',
'Luxury specifications and premium finishes\nMulti-level designs with panoramic views\nIdeal for resort locations and premium residential plots\nComplete interior and exterior design packages',
'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=900&q=80', 4, 1),

(5, 'stilt-houses', 'Wooden Stilt Houses', 'Elevated Living', 'Elevated wooden living for slopes, flood plains, and scenic hill plots.',
'Stilt houses elevate the structure above ground level, protecting it from moisture, uneven terrain and flooding while capturing better views and natural ventilation. Ideal for coastal zones, hilly regions and plantation estates across India.',
'Perfect for sloped terrain, coastal areas and flood plains\nMinimal land disturbance — eco-friendly foundation\nSuperior natural air circulation and humidity protection\nTreated water-resistant timber columns and framing',
'https://images.unsplash.com/photo-1542718610-a1d656d1884c?w=900&q=80', 5, 1),

(6, 'resort-cottages', 'Resort Cottages', 'Hospitality Clusters', 'Durable, high-occupancy timber chalets engineered for boutique resorts.',
'Designed specifically for resort and hospitality properties, our commercial wooden chalets deliver the warm, rustic ambiance that guests adore, paired with the structural durability required for high-occupancy commercial use.',
'Quick deployment to start earning revenue sooner\nLow maintenance with long-lasting weather-sealed timber\nModular designs that scale as your resort expands\nProven ROI for eco-resorts and jungle lodges across India',
'https://images.unsplash.com/photo-1587061949409-02df41d5e562?w=900&q=80', 6, 1),

(7, 'tree-houses', 'Wooden Tree Houses', 'Canopy Experience', 'Engineered architectural treehouses for experiential stays.',
'Tree houses create an unforgettable hospitality experience or a magical personal retreat. Built either within mature tree canopies or elevated on natural timber stilts to mimic a treehouse feel, these structures offer panoramic views and childlike wonder.',
'Engineered for structural safety and tree health\nIdeal attraction for boutique resorts and luxury homestays\nCustom architectural shapes, rope bridges and wrap-around decks\nBuilt with lightweight yet exceptionally strong treated timber',
'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=900&q=80', 7, 1)
ON DUPLICATE KEY UPDATE `title` = VALUES(`title`), `description` = VALUES(`description`);

-- 3. Seed Branding & Marketing Settings
INSERT INTO `site_settings` (`setting_key`, `setting_value`, `setting_group`, `label`) VALUES
('site_logo', '', 'branding', 'Website Logo Image Path'),
('site_favicon', '', 'branding', 'Website Favicon Path'),
('hero_title', 'Build Your Dream\nWooden Home', 'marketing', 'Homepage Hero Main Headline'),
('hero_subtitle', 'Custom-designed, premium wooden homes engineered for comfort, durability and timeless beauty. From concept to handover, we manage every detail.', 'marketing', 'Homepage Hero Subtitle'),
('experience_years', '15+', 'marketing', 'Years of Experience Badge')
ON DUPLICATE KEY UPDATE `label` = VALUES(`label`);
