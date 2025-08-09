<?php
require_once 'functions.php';

if (!is_logged_in()) {
    header('Location: login.php');
    exit();
}

$user = get_user($_SESSION['user_id']);
$error = '';
$success = '';

// Handle password change
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] == 'change_password') {
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];
        
        if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
            $error = 'All password fields are required.';
        } elseif ($new_password !== $confirm_password) {
            $error = 'New passwords do not match.';
        } elseif (strlen($new_password) < 6) {
            $error = 'New password must be at least 6 characters long.';
        } elseif (!password_verify($current_password, $user['password'])) {
            $error = 'Current password is incorrect.';
        } else {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
            $stmt->bind_param("si", $hashed_password, $_SESSION['user_id']);
            
            if ($stmt->execute()) {
                $success = 'Password changed successfully!';
            } else {
                $error = 'Failed to change password. Please try again.';
            }
        }
    } elseif ($_POST['action'] == 'delete_account') {
        if (isset($_POST['confirm_delete']) && $_POST['confirm_delete'] == 'yes') {
            // Delete user's data
            $user_id = $_SESSION['user_id'];
            
            // Delete messages
            $conn->query("DELETE FROM messages WHERE from_user = $user_id OR to_user = $user_id");
            
            // Delete comments
            $conn->query("DELETE FROM comments WHERE user_id = $user_id");
            
            // Delete posts
            $conn->query("DELETE FROM posts WHERE user_id = $user_id");
            
            // Delete moods
            $conn->query("DELETE FROM moods WHERE user_id = $user_id");
            
            // Delete user
            $conn->query("DELETE FROM users WHERE id = $user_id");
            
            session_destroy();
            header('Location: index.php');
            exit();
        } else {
            $error = 'Please confirm account deletion.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Mental Health Support</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    
    <div class="main-content">
        <div class="container">
            <h1>My Profile</h1>
            
            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <div class="profile-section">
                <h3>Account Information</h3>
                <div class="profile-info">
                    <div>
                        <strong>Name:</strong><br>
                        <?php echo htmlspecialchars($user['name']); ?>
                    </div>
                    <div>
                        <strong>Email:</strong><br>
                        <?php echo htmlspecialchars($user['email']); ?>
                    </div>
                    <div>
                        <strong>Account Type:</strong><br>
                        <?php echo $user['is_counselor'] ? 'Counselor' : 'Student'; ?>
                    </div>
                    <div>
                        <strong>Member Since:</strong><br>
                        <?php echo date('M j, Y', strtotime($user['created_at'])); ?>
                    </div>
                </div>
            </div>
            
            <div class="profile-section">
                <h3>Change Password</h3>
                <form method="POST" data-validate>
                    <input type="hidden" name="action" value="change_password">
                    
                    <div class="form-group">
                        <label for="current_password" class="form-label">Current Password *</label>
                        <input type="password" id="current_password" name="current_password" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="new_password" class="form-label">New Password *</label>
                        <input type="password" id="new_password" name="new_password" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="confirm_password" class="form-label">Confirm New Password *</label>
                        <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Change Password</button>
                </form>
            </div>
            
            <div class="profile-section">
                <h3>Delete Account</h3>
                <p><strong>Warning:</strong> This action cannot be undone. All your data will be permanently deleted.</p>
                
                <form method="POST" onsubmit="return confirm_delete('Are you sure you want to delete your account? This action cannot be undone.')">
                    <input type="hidden" name="action" value="delete_account">
                    
                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="confirm_delete" value="yes" required>
                            I understand that this action cannot be undone
                        </label>
                    </div>
                    
                    <button type="submit" class="btn btn-danger">Delete Account</button>
                </form>
            </div>
        </div>
    </div>
    
    <?php include 'footer.php'; ?>
    <script src="script.js"></script>
</body>
</html>
