<?php
// Shared header partial
// Usage: set $basePath = '' for root pages, or '..' for pages in Users/ before including
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
$isLoggedIn = isset($_SESSION['user_id']);
if (!isset($basePath)) {
    $basePath = '';
}
// Ensure proper prefix (no leading slash when basePath is empty)
$pfx = ($basePath === '') ? '' : rtrim($basePath, '/') . '/';
?>
<header class="navbar">
    <div class="brand">JobLaunch</div>
    <button class="nav-toggle" aria-label="Toggle navigation" aria-expanded="false"><span></span></button>
    <div class="nav-drawer">
        <div class="auth-links">
            <?php if ($isLoggedIn): ?>
                <a href="<?php echo $pfx; ?>backendwithphp/logout.php">Logout</a>
            <?php else: ?>
                <a href="<?php echo $pfx; ?>login.html">Login</a>
                <span class="divider">|</span>
                <a href="<?php echo $pfx; ?>register.html">Register</a>
            <?php endif; ?>
        </div>
        <div class="nav-links">
            <a class="active" href="<?php echo $pfx; ?>index.php">Home</a>
            <a href="<?php echo $pfx; ?>catagories.php">Categories</a>
            <a href="<?php echo $pfx; ?>about.php">AboutUs</a>
            <a href="<?php echo $pfx; ?>contact.php">ContactUs</a>
        </div>
    </div>
</header>
<script src="<?php echo $pfx; ?>assets/js/responsive.js" defer></script> 