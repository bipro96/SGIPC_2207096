<?php
require_once 'includes/functions.php';
$pageTitle = 'Login';
$activePage = 'login';

if (isLoggedIn()) {
    header('Location: index.php');
    exit;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $userType = $_POST['user_type'] ?? 'member';

    if (empty($email) || empty($password)) {
        $errors[] = 'Please fill in all fields.';
    } else {
        if ($userType === 'admin') {
            $stmt = $pdo->prepare("SELECT * FROM admins WHERE email = ? OR username = ? LIMIT 1");
            $stmt->execute([$email, $email]);
            $user = $stmt->fetch();
        } else {
            $stmt = $pdo->prepare("SELECT * FROM members WHERE email = ? OR handle = ? LIMIT 1");
            $stmt->execute([$email, $email]);
            $user = $stmt->fetch();
        }

        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_type'] = $userType;
            $_SESSION['user_name'] = $user['full_name'];
            setFlash('success', 'Welcome back, ' . $user['full_name'] . '!');
            header('Location: ' . ($userType === 'admin' ? 'admin/' : 'index.php'));
            exit;
        } else {
            $errors[] = 'Invalid email/username or password.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — SGIPC | KUET</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;700&family=Manrope:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<nav class="navbar">
    <div class="container">
        <a href="index.php" class="logo">SGIPC</a>
    </div>
</nav>

<?php $flash = getFlash(); if ($flash): ?>
<div class="flash-message flash-<?php echo $flash['type']; ?>" style="position:fixed;top:80px;left:50%;transform:translateX(-50%);z-index:9999;max-width:500px;width:90%;padding:16px 24px;border-radius:8px;font-size:0.9375rem;font-weight:600;text-align:center;">
    <?php echo sanitize($flash['message']); ?>
</div>
<script>
    setTimeout(() => {
        const flash = document.querySelector('.flash-message');
        if (flash) { flash.style.opacity = '0'; flash.style.transition = 'opacity 0.5s'; setTimeout(() => flash.remove(), 500); }
    }, 4000);
</script>
<?php endif; ?>

<div class="auth-page">
    <div class="auth-card">
        <div class="logo" style="justify-content:center;margin-bottom:var(--space-xl);font-size:1.5rem;">SGIPC</div>
        <h1 class="auth-title">Welcome Back</h1>
        <p class="auth-subtitle">Log in to your SGIPC account</p>

        <?php if (!empty($errors)): ?>
        <div class="form-error" style="margin-bottom:var(--space-lg);">
            <?php foreach ($errors as $error): ?>
                <div><?php echo sanitize($error); ?></div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label class="form-label">Login As</label>
                <div style="display:flex;gap:var(--space-md);">
                    <label style="display:flex;align-items:center;gap:var(--space-sm);cursor:pointer;">
                        <input type="radio" name="user_type" value="member" checked style="accent-color:var(--accent-cyan);"> Member
                    </label>
                    <label style="display:flex;align-items:center;gap:var(--space-sm);cursor:pointer;">
                        <input type="radio" name="user_type" value="admin" style="accent-color:var(--accent-cyan);"> Admin
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label for="email" class="form-label">Email or Username</label>
                <input type="text" id="email" name="email" class="form-input" placeholder="your@email.com or @handle" required>
            </div>
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-input" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;">Log In</button>
        </form>

        <div class="auth-footer">
            <p>Don't have an account? <a href="register.php">Join SGIPC</a></p>
            <p style="margin-top:var(--space-md);"><a href="index.php">&larr; Back to Home</a></p>
        </div>
    </div>
</div>

</body>
</html>
