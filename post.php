<?php
require_once 'functions.php';

$error = '';
$success = '';

// Get post ID
$post_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if (!$post_id) {
    header('Location: forum.php');
    exit();
}

// Get post details
$stmt = $conn->prepare("SELECT p.*, u.name as author_name FROM posts p 
                        JOIN users u ON p.user_id = u.id 
                        WHERE p.id = ?");
$stmt->bind_param("i", $post_id);
$stmt->execute();
$post = $stmt->get_result()->fetch_assoc();

if (!$post) {
    header('Location: forum.php');
    exit();
}

// Handle comment submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && is_logged_in()) {
    $comment = trim($_POST['comment']);
    
    if (empty($comment)) {
        $error = 'Please enter a comment.';
    } else {
        if (add_comment($post_id, $_SESSION['user_id'], $comment)) {
            $success = 'Comment added successfully!';
        } else {
            $error = 'Failed to add comment. Please try again.';
        }
    }
}

// Get comments
$comments = get_comments($post_id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($post['title']); ?> - Mental Health Support</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    
    <div class="main-content">
        <div class="container">
            <div class="card">
                <h1><?php echo htmlspecialchars($post['title']); ?></h1>
                <div class="post-meta mb-3">
                    By <?php echo htmlspecialchars($post['author_name']); ?> 
                    on <?php echo date('M j, Y g:i A', strtotime($post['created_at'])); ?>
                </div>
                <div style="line-height: 1.8;">
                    <?php echo nl2br(htmlspecialchars($post['content'])); ?>
                </div>
            </div>
            
            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <div class="card">
                <h3>Comments (<?php echo $comments ? $comments->num_rows : 0; ?>)</h3>
                
                <?php if (is_logged_in()): ?>
                    <form method="POST" data-validate style="margin-bottom: 2rem;">
                        <div class="form-group">
                            <label for="comment" class="form-label">Add Comment *</label>
                            <textarea id="comment" name="comment" class="form-control" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Post Comment</button>
                    </form>
                <?php else: ?>
                    <div class="alert alert-info">
                        <a href="login.php">Login</a> to add comments.
                    </div>
                <?php endif; ?>
                
                <?php if ($comments && $comments->num_rows > 0): ?>
                    <?php while ($comment = $comments->fetch_assoc()): ?>
                        <div class="comment">
                            <div class="comment-meta">
                                <strong><?php echo htmlspecialchars($comment['author_name']); ?></strong>
                                on <?php echo date('M j, Y g:i A', strtotime($comment['created_at'])); ?>
                            </div>
                            <div><?php echo nl2br(htmlspecialchars($comment['comment'])); ?></div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No comments yet. Be the first to comment!</p>
                <?php endif; ?>
            </div>
            
            <div class="text-center mt-3">
                <a href="forum.php" class="btn btn-secondary">Back to Forum</a>
            </div>
        </div>
    </div>
    
    <?php include 'footer.php'; ?>
    <script src="script.js"></script>
</body>
</html>
