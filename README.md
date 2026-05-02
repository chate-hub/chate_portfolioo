# ⚡ DevPortfolio — PHP Portfolio

A beautifully designed, interactive developer portfolio built with PHP and SQLite.

## Features

- 🎨 **Terminal/hacker aesthetic** with neon green accents, custom cursor, animated grid
- ✍️ **Typing animation** cycling through your titles
- 📁 **Projects page** with tech stack filtering
- 📝 **Blog system** powered by SQLite — no database server needed
- 🔒 **Admin panel** with login, create, edit, and delete posts
- 📱 **Fully responsive** with mobile navigation
- ✨ **Scroll animations**, animated counters, glitch effects

## Setup

### Requirements
- PHP 8.0+
- SQLite3 extension enabled (usually on by default)
- Apache/Nginx with mod_rewrite (for .htaccess)

### Installation

1. **Clone/download** this project to your web server root
2. **Ensure `data/` directory is writable** by your web server:
   ```bash
   mkdir -p data
   chmod 755 data
   ```
3. **Visit your site** — the SQLite DB is auto-created on first load
4. **Login to admin panel**: `yoursite.com/admin/login.php`
   - Username: `admin`
   - Password: `admin123`

### ⚠️ IMPORTANT: Change Admin Password

After first login, update the password in `includes/db.php`:

```php
$hash = password_hash('YOUR_NEW_SECURE_PASSWORD', PASSWORD_DEFAULT);
$db->exec("UPDATE admin_users SET password = '$hash' WHERE username = 'admin'");
```

Or add a change-password page to the admin panel.

## Customization

### Personal Info
Edit `index.php` to update:
- Your name in the hero section
- Hero stats (years of experience, projects, clients)
- About text and terminal window content
- Contact information

### Projects
Edit the `$projects` array in `projects.php` to add your real projects.

### Styling
All styles are in `assets/css/style.css` — CSS variables at the top:
```css
:root {
    --accent: #00ff88;     /* Main green accent */
    --accent2: #00d4ff;    /* Blue accent */
    --bg: #080b10;         /* Background */
}
```

## File Structure

```
portfolio/
├── index.php              # Home page
├── projects.php           # Projects page
├── blog.php               # Blog listing
├── post.php               # Single post view
├── .htaccess              # Apache config
├── admin/
│   ├── login.php          # Admin login
│   ├── dashboard.php      # Admin dashboard
│   ├── new-post.php       # Create post
│   ├── edit-post.php      # Edit post
│   ├── delete-post.php    # Delete handler
│   └── logout.php         # Logout
├── includes/
│   ├── db.php             # SQLite database
│   ├── auth.php           # Session auth
│   ├── header.php         # Shared nav/head
│   └── footer.php         # Shared footer
├── assets/
│   ├── css/style.css      # All styles
│   └── js/main.js         # Interactions
└── data/                  # Auto-created, holds portfolio.db
```

## Security Notes

- Change the default admin password immediately
- Set `display_errors = Off` in production
- Keep the `data/` directory outside public web root if possible
- The `.htaccess` blocks direct access to `.db` files

## License

MIT — use it, customize it, make it yours.
