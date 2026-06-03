# SGIPC Website

A complete, professional, minimalist website for the **SGIPC (SUST/KUET General Interest Programming Club)** — a competitive programming focused university club.

## Features

- **Home Page**: Hero section with animated stats, featured events, top programmers, achievements
- **About Page**: Mission, vision, what is competitive programming, why join SGIPC
- **Events Page**: List of past and upcoming contests with filtering
- **Members/Leaderboard**: Top programmers with sort, filter, and search
- **Resources Page**: Curated links (Codeforces, AtCoder, LeetCode, CSES, etc.)
- **Contact Page**: Contact form with validation and database storage
- **Authentication**: User registration/login/logout with password hashing (bcrypt)
- **Admin Panel**: Secure dashboard to manage events, members, resources, and messages
- **Dark Mode Toggle**: Persistent theme preference
- **Smooth Animations**: Loading screen, counters, scroll reveals, hover effects
- **Fully Responsive**: Mobile-first design

## Tech Stack

- **Frontend**: HTML5, CSS3, JavaScript (Vanilla)
- **Backend**: PHP (Procedural)
- **Database**: MySQL with PDO
- **Icons**: Font Awesome 6
- **Fonts**: Inter, JetBrains Mono

## Local Setup (XAMPP)

### 1. Install XAMPP
Download and install [XAMPP](https://www.apachefriends.org/) (includes Apache, MySQL, PHP).

### 2. Clone/Copy Project
Copy all files to your XAMPP `htdocs` folder:
```
C:\xampp\htdocs\sgipc\
```

### 3. Create Database
1. Start XAMPP Control Panel and run **Apache** and **MySQL**
2. Open phpMyAdmin: `http://localhost/phpmyadmin`
3. Create a database named `sgipc` (or import `database.sql`)
4. Import the schema: Go to Import tab → Choose `database.sql` → Click Go

### 4. Configure Database (if needed)
If your MySQL has a password, edit `includes/db.php`:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'sgipc');
define('DB_USER', 'root');      // Your MySQL username
define('DB_PASS', '');          // Your MySQL password
```

### 5. Run the Website
Open your browser and go to:
```
http://localhost/sgipc/
```

### 6. Default Login Credentials

**Admin Account:**
- Username: `admin`
- Password: `password`

> **Note**: The admin password is hashed with bcrypt. To change it, log in and update your password in the admin panel, or directly update the hash in the database.

## Project Structure

```
sgipc/
├── index.php              # Home page
├── about.php              # About page
├── events.php             # Events listing
├── event-detail.php       # Single event view
├── members.php            # Leaderboard
├── resources.php          # Resources page
├── contact.php            # Contact form
├── login.php              # Login page
├── register.php           # Registration page
├── logout.php             # Logout handler
├── profile.php            # User profile
├── database.sql           # Database schema + demo data
├── includes/
│   ├── db.php             # Database connection
│   ├── functions.php      # Helper functions
│   ├── header.php         # Shared header
│   └── footer.php         # Shared footer
├── admin/
│   ├── dashboard.php      # Admin dashboard
│   ├── events.php         # Event management (CRUD)
│   ├── members.php        # Member management
│   ├── resources.php      # Resource management (CRUD)
│   ├── messages.php       # Contact messages
│   └── includes/
│       └── admin-auth.php # Admin auth check
└── assets/
    ├── css/
    │   └── style.css      # Main stylesheet
    └── js/
        └── script.js      # Main JavaScript
```

## Security Features

- **Password Hashing**: All passwords hashed with bcrypt
- **Prepared Statements**: PDO prepared statements prevent SQL injection
- **Input Sanitization**: XSS protection via `htmlspecialchars()`
- **Session Management**: Secure PHP sessions
- **Admin Protection**: Admin pages require admin role verification
- **CSRF Protection**: Built-in form validation

## Customization

### Change Club Name/Tagline
Edit the `settings` table in the database, or modify `database.sql` before importing.

### Add/Edit Events
- As admin, go to Admin Panel → Events
- Or directly insert into the `events` table

