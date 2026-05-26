<?php
require_once 'includes/functions.php';


$_SESSION = [];


if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

session_destroy();

setFlash('success', 'You have been logged out successfully.');
header('Location: index.php');
exit;
