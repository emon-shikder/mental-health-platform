<?php
require_once 'functions.php';

if (!is_logged_in()) {
    http_response_code(401);
    exit('Not authorized');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $from_user = isset($_POST['from_user']) ? (int)$_POST['from_user'] : 0;
    $to_user = isset($_POST['to_user']) ? (int)$_POST['to_user'] : 0;
    $content = trim($_POST['content']);
    
    // Validate input
    if (!$from_user || !$to_user || empty($content)) {
        http_response_code(400);
        exit('Invalid parameters');
    }
    
    // Additional validation
    if ($from_user != $_SESSION['user_id']) {
        http_response_code(403);
        exit('Unauthorized');
    }
    
    if (strlen($content) > 1000) {
        http_response_code(400);
        exit('Message too long');
    }
    
    // Attempt to add message
    if (add_message($from_user, $to_user, $content)) {
        http_response_code(200);
        echo 'success';
    } else {
        http_response_code(500);
        echo 'error';
    }
} else {
    http_response_code(405);
    echo 'Method not allowed';
}
?>
