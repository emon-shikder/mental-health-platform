<?php
require_once 'functions.php';

if (!is_logged_in()) {
    http_response_code(401);
    exit('Not authorized');
}

$from_user = isset($_GET['from']) ? (int)$_GET['from'] : 0;
$to_user = isset($_GET['to']) ? (int)$_GET['to'] : 0;

// Validate parameters
if (!$from_user || !$to_user) {
    http_response_code(400);
    exit('Invalid parameters');
}

// Additional validation
if ($from_user != $_SESSION['user_id']) {
    http_response_code(403);
    exit('Unauthorized');
}

$messages = get_messages($from_user, $to_user);

if ($messages && $messages->num_rows > 0) {
    while ($message = $messages->fetch_assoc()) {
        $is_sent = $message['from_user'] == $_SESSION['user_id'];
        $message_class = $is_sent ? 'sent' : 'received';
        ?>
        <div class="message <?php echo $message_class; ?>">
            <div class="message-content">
                <?php echo htmlspecialchars($message['content']); ?>
            </div>
            <div class="message-time">
                <?php echo date('g:i A', strtotime($message['created_at'])); ?>
            </div>
        </div>
        <?php
    }
} else {
    echo '<div style="text-align: center; color: #6c757d; margin-top: 2rem;">No messages yet. Start the conversation!</div>';
}
?>
