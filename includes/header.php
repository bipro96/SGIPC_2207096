<?php

if (!isset($pageTitle)) $pageTitle = 'SGIPC';
if (!isset($activePage)) $activePage = '';

$currentUser = getCurrentUser();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo sanitize($pageTitle); ?> — SGIPC | KUET</title>

    <meta name="description" content="SGIPC - The premier competitive programming community at Khulna University of Engineering & Technology.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;700&family=Manrope:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/style.css?v=<?php echo filemtime('assets/css/style.css'); ?>">
</head>
<body>

<nav class="navbar">
    <div class="container">

        <a href="index.php" class="logo">
            SGIPC
        </a>

        <button class="nav-toggle" aria-label="Toggle navigation">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <ul class="nav-links">

            <li>
                <a href="index.php"
                   class="nav-link <?php echo $activePage === 'home' ? 'active' : ''; ?>">
                    Home
                </a>
            </li>

            <li>
                <a href="about.php"
                   class="nav-link <?php echo $activePage === 'about' ? 'active' : ''; ?>">
                    About
                </a>
            </li>

            <li>
                <a href="events.php"
                   class="nav-link <?php echo $activePage === 'events' ? 'active' : ''; ?>">
                    Events
                </a>
            </li>

            <li>
                <a href="members.php"
                   class="nav-link <?php echo $activePage === 'members' ? 'active' : ''; ?>">
                    Members
                </a>
            </li>

            <li>
                <a href="resources.php"
                   class="nav-link <?php echo $activePage === 'resources' ? 'active' : ''; ?>">
                    Resources
                </a>
            </li>

            <li>
                <a href="contact.php"
                   class="nav-link <?php echo $activePage === 'contact' ? 'active' : ''; ?>">
                    Contact
                </a>
            </li>

            <?php if (isLoggedIn()): ?>

                <?php if (isAdmin()): ?>
                    <li>
                        <a href="admin/" class="nav-link">
                            Admin
                        </a>
                    </li>
                <?php endif; ?>

                <li>
                    <a href="logout.php" class="nav-link">
                        Logout (<?php echo sanitize($currentUser['handle'] ?? $currentUser['username']); ?>)
                    </a>
                </li>

            <?php else: ?>

                <li>
                    <a href="login.php"
                       class="nav-link <?php echo $activePage === 'login' ? 'active' : ''; ?>">
                        Login
                    </a>
                </li>

            <?php endif; ?>

        </ul>

    </div>
</nav>

<?php
$flash = getFlash();

if ($flash):
?>
<div class="flash-message flash-<?php echo $flash['type']; ?>"
     style="position:fixed;top:80px;left:50%;transform:translateX(-50%);
     z-index:9999;max-width:500px;width:90%;padding:16px 24px;
     border-radius:8px;font-size:0.9375rem;font-weight:600;
     text-align:center;animation:fadeInUp 0.4s ease;">

    <?php echo sanitize($flash['message']); ?>

</div>

<script>
setTimeout(() => {
    const flash = document.querySelector('.flash-message');

    if (flash) {
        flash.style.opacity = '0';
        flash.style.transition = 'opacity 0.5s';

        setTimeout(() => {
            flash.remove();
        }, 500);
    }
}, 4000);
</script>
<?php endif; ?>
