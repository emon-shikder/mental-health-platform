<?php
require_once 'functions.php';

if (!is_logged_in()) {
    header('Location: login.php');
    exit();
}

$current_user = get_user($_SESSION['user_id']);
$is_counselor = is_counselor($_SESSION['user_id']);

// Get users for sidebar
if ($is_counselor) {
    $users = get_students(); // Counselors see all students
} else {
    $users = get_counselors(); // Students see all counselors
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat - Mental Health Support</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    
    <div class="main-content">
        <div class="container">
            <h1>Chat</h1>
            <p>Connect with <?php echo $is_counselor ? 'students' : 'counselors'; ?> for support and guidance.</p>
            
            <div class="chat-container">
                <div class="chat-sidebar">
                    <h3 style="padding: 1rem; margin: 0; border-bottom: 1px solid #e9ecef;">
                        <?php echo $is_counselor ? 'Students' : 'Counselors'; ?>
                    </h3>
                    
                    <?php if ($users && $users->num_rows > 0): ?>
                        <?php while ($user = $users->fetch_assoc()): ?>
                            <div class="chat-user" onclick="select_chat_user(<?php echo $user['id']; ?>, '<?php echo htmlspecialchars($user['name']); ?>')">
                                <strong><?php echo htmlspecialchars($user['name']); ?></strong>
                                <br>
                                <small><?php echo htmlspecialchars($user['email']); ?></small>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div style="padding: 1rem; color: #6c757d;">
                            No <?php echo $is_counselor ? 'students' : 'counselors'; ?> available.
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="chat-main">
                    <div class="chat-messages" id="chat-messages">
                        <div style="text-align: center; color: #6c757d; margin-top: 2rem;">
                            Select a user from the sidebar to start chatting.
                        </div>
                    </div>
                    
                    <div class="chat-input">
                        <form id="message-form" method="POST" action="send_message.php">
                            <input type="hidden" name="from_user" value="<?php echo $_SESSION['user_id']; ?>">
                            <input type="hidden" name="to_user" id="selected-user-id" value="">
                            
                            <div style="display: flex; gap: 1rem;">
                                <input type="text" id="message-input" name="content" class="form-control" placeholder="Type your message..." style="flex: 1;">
                                <button type="button" onclick="send_message()" class="btn btn-primary">Send</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <input type="hidden" id="current-user-id" value="<?php echo $_SESSION['user_id']; ?>">
            <div id="selected-user-name" style="display: none;"></div>
        </div>
    </div>
    
    <?php include 'footer.php'; ?>
    <script src="script.js"></script>
</body>
</html>
