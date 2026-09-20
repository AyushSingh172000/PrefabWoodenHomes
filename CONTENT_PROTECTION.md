# Content & Source Code Protection System

## Overview
This document outlines the content and source code protection system implemented for **Prefab Wooden Homes**. The protection layer prevents unauthorized copying of text, downloading of assets via context menu, viewing source code, or inspecting elements via browser developer tools.

When a restricted action is detected, the website displays a floating warning toast notification:

> ⚠️ **ALERT:** You are not allowed to copy content or view source

---

## Visual Design & Behavior
The warning toast notification is styled to match the custom alert card:
- **Card Styling**: Pill container with rounded corners (`14px`), soft red-tinted pastel background (`#fff0f0`), and subtle red border (`rgba(220, 53, 69, 0.35)`).
- **Ambient Shadow**: Deep crimson glow (`box-shadow: 0 12px 35px rgba(220, 53, 69, 0.22)`).
- **Warning Icon**: Crisp vector warning triangle (`#F4B400` with dark exclamation indicator).
- **Typography**: Bold `ALERT:` in dark charcoal followed by the notification message.
- **Position & Animation**: Fixed at the bottom-center of the viewport, with smooth cubic-bezier slide-up and fade-out animation. Automatically dismisses after 3 seconds. Rapid triggers reset the timer cleanly without stacking multiple popups.

---

## Protected Actions & Shortcuts

| Restricted Action | Trigger | Action Taken |
| :--- | :--- | :--- |
| **Right-Click Context Menu** | Right-click anywhere on the webpage | Default menu suppressed, Alert Toast displayed |
| **View Source** | `Ctrl + U` / `Cmd + U` | Blocked, Alert Toast displayed |
| **Developer Tools** | `F12` | Blocked, Alert Toast displayed |
| **Inspect Element** | `Ctrl + Shift + I` / `Cmd + Option + I` | Blocked, Alert Toast displayed |
| **Console Window** | `Ctrl + Shift + J` / `Cmd + Option + J` | Blocked, Alert Toast displayed |
| **DOM Element Selector** | `Ctrl + Shift + C` / `Cmd + Option + C` | Blocked, Alert Toast displayed |
| **Save Webpage** | `Ctrl + S` / `Cmd + S` | Blocked, Alert Toast displayed |
| **Copy Page Content** | `Ctrl + C` or Clipboard Copy | Blocked, Alert Toast displayed |
| **Cut Page Content** | `Ctrl + X` or Clipboard Cut | Blocked, Alert Toast displayed |

---

## Form Usability Safeguard
To guarantee genuine visitors and leads can seamlessly submit quotation requests and contact forms:
- Form fields (`<input>`, `<textarea>`, or `contenteditable` elements) are **exempt** from copy/cut prevention.
- Visitors can freely paste phone numbers, email addresses, and type notes into forms without receiving alerts.

---

## Files Modified
1. **[`assets/css/style.css`](file:///c:/xampp/htdocs/Prefab-Wooden-Homes/assets/css/style.css)**:
   - Added `.copy-alert-toast`, `.copy-alert-toast.active`, and responsive mobile rules for the public website.
2. **[`assets/js/main.js`](file:///c:/xampp/htdocs/Prefab-Wooden-Homes/assets/js/main.js)**:
   - Added `initContentProtection()` module handling event listeners for `contextmenu`, `copy`, `cut`, and `keydown`.
3. **[`admin/assets/css/admin.css`](file:///c:/xampp/htdocs/Prefab-Wooden-Homes/admin/assets/css/admin.css)**:
   - Added `.copy-alert-toast` and `.copy-alert-toast.active` styles for the Admin Console.
4. **[`admin/assets/js/admin.js`](file:///c:/xampp/htdocs/Prefab-Wooden-Homes/admin/assets/js/admin.js)**:
   - Added `initAdminProtection()` module guarding the Admin Console against right-click, inspection, devtools, and copying outside form fields.
5. **[`admin/login.php`](file:///c:/xampp/htdocs/Prefab-Wooden-Homes/admin/login.php)**:
   - Included `admin.js` to protect the admin login screen.
6. **[`config/app.php`](file:///c:/xampp/htdocs/Prefab-Wooden-Homes/config/app.php)** & **[`database/admin_seed.sql`](file:///c:/xampp/htdocs/Prefab-Wooden-Homes/database/admin_seed.sql)**:
   - Updated client YouTube channel URL (`https://www.youtube.com/channel/UCFWuLZvWxsbdPaR2N35682w`).
