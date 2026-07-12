# Dees Boutique Hotel — Full-Stack Website

A responsive hotel website with a PHP/MySQL-driven admin panel, built with Bootstrap 5, vanilla JS, and PDO.

## Stack
- **Frontend:** HTML5, CSS3 (Bootstrap 5), vanilla JavaScript
- **Backend:** PHP 8 (PDO, procedural style with session-based auth)
- **Database:** MySQL

## 1. Setup

1. **Copy the project** into your local server directory (e.g. `htdocs/dees_hotel` for XAMPP, or `www/dees_hotel` for WAMP/MAMP).
2. **Create the database:** open phpMyAdmin (or the MySQL CLI) and import `database/dees_hotel.sql`. This creates the `dees_hotel` database, all tables, and seed data (sample rooms, facilities, gallery images, and one admin account).
3. **Configure the connection:** open `config/db.php` and update `DB_HOST`, `DB_USER`, `DB_PASS` to match your environment (defaults are `localhost` / `root` / empty password, which works out-of-the-box on most XAMPP/WAMP setups).
4. **Set `BASE_URL`:** in the same file, set `BASE_URL` to match your folder name, e.g. `/dees_hotel/`. If the site sits at your web root, use `/`.
5. **Folder permissions:** make sure the `uploads/` subfolders (`slideshow`, `rooms`, `facilities`, `gallery`) are writable by the web server, since the admin panel uploads images there.
6. Visit `http://localhost/dees_hotel/` to view the site.

## 2. Admin Panel

- URL: `http://localhost/dees_hotel/admin/login.php`
- Default login: **username** `admin` / **password** `Admin@123`
- **Change this password immediately** — either add a "change password" page, or generate a new hash:
  ```php
  echo password_hash('YourNewPassword', PASSWORD_DEFAULT);
  ```
  Then update the `admin` table's `password` column with the resulting hash.

From the dashboard you can:
- **Slideshow** — upload/delete homepage hero images
- **Rooms** — full CRUD (add, edit, delete) for room types, prices, descriptions, features, and photos
- **Facilities** — full CRUD for hotel amenities (Fitness Center, Sauna, Bar, etc.)
- **Gallery** — add/remove gallery images with categories (used for the filterable gallery + lightbox)
- View recent **Contact form submissions** on the dashboard

## 3. Notes on Placeholder Images

The seed data references image filenames like `uploads/rooms/deluxe.jpg` that don't exist yet — the frontend pages include an `onerror` fallback that swaps in a stock Unsplash photo automatically, so the site looks complete immediately. Once you upload real photos through the admin panel (or manually place files matching the paths in the SQL), those will display instead.

## 4. Structure

```
dees_hotel/
├── admin/                  # Admin dashboard (session-protected)
│   ├── includes/           # auth_check.php, admin_header.php, admin_footer.php
│   ├── login.php / logout.php
│   ├── dashboard.php
│   ├── slideshow.php       # CRUD
│   ├── rooms.php           # CRUD
│   ├── facilities.php      # CRUD
│   └── gallery.php         # CRUD
├── config/db.php           # PDO connection + BASE_URL
├── includes/                header.php, footer.php (public site)
├── css/style.css           # Copper/gold luxury theme
├── js/script.js            # Slideshow, lightbox, filters, AJAX contact form
├── uploads/                # slideshow/, rooms/, facilities/, gallery/
├── database/dees_hotel.sql
├── index.php                Home
├── accommodations.php       Rooms (dynamic)
├── facilities.php           Facilities (dynamic)
├── gallery.php               Gallery + lightbox (dynamic)
├── contact.php               Contact form + map
└── contact_process.php       AJAX form handler → messages table
```

## 5. Security Notes

- Passwords are hashed with `password_hash()` / verified with `password_verify()`.
- All database queries use PDO prepared statements (no raw SQL concatenation).
- `admin/includes/auth_check.php` guards every admin page and includes a 60-minute session timeout.
- `uploads/.htaccess` blocks PHP execution inside the uploads folder (Apache only — if you're on Nginx, add an equivalent rule in your server block).
- Uploaded file extensions are restricted to `.jpg/.jpeg/.png/.webp`.
- The "Book Now" button is intentionally a placeholder (shows a toast: "Online booking is coming soon...") per the project spec — wire it up to a real booking engine when ready.

## 6. Customization

- **Colors:** all theme colors live as CSS variables at the top of `css/style.css` (`--color-copper`, `--color-gold`, etc.) — adjust these to match your exact logo swatch.
- **Fonts:** currently Cormorant Garamond (headings), Great Vibes (script/logo accent), Jost (body) via Google Fonts — swap the `<link>` in `includes/header.php` and the `--font-*` variables if you'd like different faces.
