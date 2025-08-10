<?php
require_once 'functions.php';
?>
<nav class="navbar">
    <div class="container">
        <a href="index.php" class="navbar-brand">
            <img src="mental.png" alt="Logo" style="height:40px;">
        </a>
        
        <button class="mobile-menu-btn" onclick="toggle_mobile_menu()">
            ☰
        </button>
        
        <ul class="navbar-nav">
            <li><a href="index.php">Home</a></li>
            <li><a href="forum.php">Forum</a></li>
            <li><a href="chat.php">Chat</a></li>
            <li><a href="mood.php">Mood Tracker</a></li>
            <li><a href="resources.php">Resources</a></li>
            
            <?php if (is_logged_in()): ?>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php">Register</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>
