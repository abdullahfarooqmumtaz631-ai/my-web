<?php
// Start session for login functionality
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ============================================
// LOGOUT HANDLER
// ============================================
if (isset($_GET['logout']) && $_GET['logout'] === 'true') {
    session_destroy();
    header('Location: index.php');
    exit();
}

if (isset($_GET['page']) && $_GET['page'] === 'logout') {
    session_destroy();
    header('Location: index.php');
    exit();
}

// ============================================
// ROUTING SYSTEM
// ============================================
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Define allowed pages
$allowed_pages = ['home', 'about', 'services', 'portfolio', 'contact', 'login', 'dashboard'];

if (!in_array($page, $allowed_pages)) {
    $page = 'home';
}

// ============================================
// INCLUDE CONFIGURATIONS
// ============================================
include 'includes/config.php';
include 'includes/db.php';
include 'includes/functions.php';
include 'includes/header.php';

// ============================================
// PROTECTED PAGE CHECK
// ============================================
if ($page === 'dashboard') {
    if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
        header('Location: ?page=login');
        exit();
    }
}

// ============================================
// LOAD PAGE CONTENT
// ============================================
$page_file = "pages/{$page}.php";

if (file_exists($page_file)) {
    include $page_file;
} else {
    include 'pages/home.php';
}

// ============================================
// INCLUDE FOOTER
// ============================================
include 'includes/footer.php';
?>