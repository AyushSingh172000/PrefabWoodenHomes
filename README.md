# Prefab Wooden Homes — Website

Premium website for **prefabwoodenhomes.com** — wooden home construction company.

## Tech Stack
- **Frontend:** HTML5, CSS3 (custom properties), Vanilla JS
- **Backend:** PHP 8+
- **Database:** MySQL 8+ (via PDO)
- **Server:** Apache (XAMPP for local dev)

---

## Setup Instructions (XAMPP)

### 1. Copy Files
Copy the entire `prefabwoodenhomes` folder to:
```
C:\xampp\htdocs\prefabwoodenhomes\
```

### 2. Create Database
- Open **phpMyAdmin** → `http://localhost/phpmyadmin`
- Click **Import** → select `database/setup.sql`
- Or run the SQL manually in the SQL tab

### 3. Configure Database
Edit `config/database.php` if your MySQL credentials differ:
```php
'host' => 'localhost',
'name' => 'prefab_wooden_homes',
'user' => 'root',
'pass' => ''          // default XAMPP has no password
```

### 4. Configure App Settings
Edit `config/app.php`:
- Update `RECAPTCHA_SITE_KEY` and `RECAPTCHA_SECRET_KEY` (get from Google reCAPTCHA)
- Verify contact details are correct

### 5. Enable Apache Modules
In XAMPP, ensure these modules are enabled in `httpd.conf`:
- `mod_rewrite`
- `mod_deflate`
- `mod_expires`
- `mod_headers`

### 6. Access the Site
```
http://localhost/prefabwoodenhomes/
```

---

## Folder Structure
```
prefabwoodenhomes/
├── index.php                 # Homepage
├── .htaccess                 # URL rewriting & security
├── robots.txt                # SEO crawl rules
├── sitemap.xml               # SEO sitemap
├── README.md                 # This file
├── config/
│   ├── app.php               # Site constants
│   └── database.php          # PDO connection
├── includes/
│   ├── header.php            # Shared header/nav
│   ├── footer.php            # Shared footer
│   ├── functions.php         # Helper functions
│   └── security.php          # CSRF, sanitization, rate limiting
├── pages/
│   ├── about.php
│   ├── construction.php
│   ├── projects.php
│   ├── process.php
│   ├── why-wooden.php
│   ├── faq.php
│   ├── contact.php
│   ├── submit-enquiry.php    # Form handler (POST only)
│   ├── 404.php
│   └── 500.php
├── assets/
│   ├── css/style.css
│   ├── js/main.js
│   ├── images/               # Add project photos here
│   └── fonts/                # Custom fonts (if any)
├── database/
│   └── setup.sql             # DB schema + seed data
├── admin/                    # Future admin panel
└── logs/                     # Error/access logs
```

---

## Image Replacement
All pages currently use Unsplash placeholder URLs. Replace with actual project photos:
- Place images in `assets/images/`
- Update `src` attributes in PHP files
- Recommended sizes: Hero 1920×1080, Cards 800×600, Thumbnails 400×300
- Use WebP format for best performance

---

## Going Live Checklist
- [ ] Replace placeholder images with real project photos
- [ ] Add reCAPTCHA keys in `config/app.php`
- [ ] Change admin password hash in `database/setup.sql`
- [ ] Uncomment HTTPS redirect in `.htaccess`
- [ ] Uncomment HSTS and CSP headers in `.htaccess`
- [ ] Update `SITE_URL` in `config/app.php` to `https://prefabwoodenhomes.com`
- [ ] Set `ENVIRONMENT` to `production` in `config/app.php`
- [ ] Add Google Analytics tracking code
- [ ] Submit `sitemap.xml` to Google Search Console
- [ ] Test all forms and email delivery
- [ ] Add favicon.ico and apple-touch-icon.png
- [ ] Run Google PageSpeed Insights
