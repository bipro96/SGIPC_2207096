<?php
require_once 'includes/functions.php';
$pageTitle = 'Join SGIPC';
$activePage = 'register';

if (isLoggedIn()) {
    header('Location: index.php');
    exit;
}

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = trim($_POST['full_name'] ?? '');
    $handle = trim($_POST['handle'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    $department = trim($_POST['department'] ?? '');
    $studentId = trim($_POST['student_id'] ?? '');

    if (empty($fullName) || strlen($fullName) < 2) {
        $errors[] = 'Full name is required (at least 2 characters).';
    }
    if (empty($handle) || strlen($handle) < 3) {
        $errors[] = 'Handle/username must be at least 3 characters.';
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please provide a valid email address.';
    }
    if (strlen($password) < 6) {
        $errors[] = 'Password must be at least 6 characters long.';
    }
    if ($password !== $confirmPassword) {
        $errors[] = 'Passwords do not match.';
    }

    
    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT id FROM members WHERE email = ? OR handle = ? LIMIT 1");
        $stmt->execute([$email, $handle]);
        if ($stmt->fetch()) {
            $errors[] = 'An account with this email or handle already exists.';
        }
    }

    if (empty($errors)) {
        createMember([
            'full_name' => $fullName,
            'handle' => $handle,
            'email' => $email,
            'password' => $password,
            'department' => $department,
            'student_id' => $studentId
        ]);
        $success = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join SGIPC — SGIPC | KUET</title>
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

<div class="auth-page">
    <div class="auth-card">
        <div class="logo" style="justify-content:center;margin-bottom:var(--space-xl);font-size:1.5rem;">SGIPC</div>
        <h1 class="auth-title">Join the Community</h1>
        <p class="auth-subtitle">Create your SGIPC member account</p>

        <?php if ($success): ?>
            <div class="form-success visible" style="margin-bottom:var(--space-lg);">
                Registration successful! You can now <a href="login.php" style="color:var(--accent-green);font-weight:700;">log in</a>.
            </div>
        <?php else: ?>

        <?php if (!empty($errors)): ?>
        <div class="form-error" style="margin-bottom:var(--space-lg);">
            <?php foreach ($errors as $error): ?>
                <div><?php echo sanitize($error); ?></div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="grid-2" style="gap:var(--space-md);">
                <div class="form-group">
                    <label for="full_name" class="form-label">Full Name *</label>
                    <input type="text" id="full_name" name="full_name" class="form-input" placeholder="Your full name" required>
                </div>
                <div class="form-group">
                    <label for="handle" class="form-label">Handle / Username *</label>
                    <input type="text" id="handle" name="handle" class="form-input" placeholder="@yourhandle" required>
                </div>
            </div>
            <div class="form-group">
                <label for="email" class="form-label">Email *</label>
                <input type="email" id="email" name="email" class="form-input" placeholder="your@email.com" required>
            </div>
            <div class="grid-2" style="gap:var(--space-md);">
                <div class="form-group">
                    <label for="department" class="form-label">Department</label>
                    <input type="text" id="department" name="department" class="form-input" placeholder="e.g., CSE">
                </div>
                <div class="form-group">
                    <label for="student_id" class="form-label">Student ID</label>
                    <input type="text" id="student_id" name="student_id" class="form-input" placeholder="e.g., 2007001">
                </div>
            </div>
            <div class="grid-2" style="gap:var(--space-md);">
                <div class="form-group">
                    <label for="password" class="form-label">Password *</label>
                    <input type="password" id="password" name="password" class="form-input" placeholder="Min 6 characters" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password" class="form-label">Confirm Password *</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="form-input" placeholder="Repeat password" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;">Create Account</button>
        </form>

        <?php endif; ?>

        <div class="auth-footer">
            <p>Already have an account? <a href="login.php">Log In</a></p>
            <p style="margin-top:var(--space-md);"><a href="index.php">&larr; Back to Home</a></p>
        </div>
    </div>
</div>

</body>
</html>
