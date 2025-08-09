<?php
require_once 'functions.php';

$error = '';
$success = '';

// Handle new post submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && is_logged_in()) {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    
    if (empty($title) || empty($content)) {
        $error = 'Please fill in all fields.';
    } else {
        if (add_post($_SESSION['user_id'], $title, $content)) {
            $success = 'Post created successfully!';
        } else {
            $error = 'Failed to create post. Please try again.';
        }
    }
}

// Get all posts
$posts = get_posts();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum - Mental Health Support</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    
    <div class="main-content">
        <div class="container">
            <h1>Community Forum</h1>
            <p>Share your thoughts, experiences, and support others in the community.</p>
            
            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <?php if (is_logged_in()): ?>
                <div class="card">
                    <h3>Create New Post</h3>
                    <form method="POST" data-validate>
                        <div class="form-group">
                            <label for="title" class="form-label">Title *</label>
                            <input type="text" id="title" name="title" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="content" class="form-label">Content *</label>
                            <textarea id="content" name="content" class="form-control" rows="5" required></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Create Post</button>
                    </form>
                </div>
            <?php else: ?>
                <div class="alert alert-info">
                    <a href="login.php">Login</a> to create posts and participate in discussions.
                </div>
            <?php endif; ?>
            
            <div class="card">
                <h3>Recent Posts</h3>
                
                <?php if ($posts && $posts->num_rows > 0): ?>
                    <?php while ($post = $posts->fetch_assoc()): ?>
                        <div class="post">
                            <h4>
                                <a href="post.php?id=<?php echo $post['id']; ?>" class="post-title">
                                    <?php echo htmlspecialchars($post['title']); ?>
                                </a>
                            </h4>
                            <p><?php echo htmlspecialchars(substr($post['content'], 0, 200)) . (strlen($post['content']) > 200 ? '...' : ''); ?></p>
                            <div class="post-meta">
                                By <?php echo htmlspecialchars($post['author_name']); ?> 
                                on <?php echo date('M j, Y', strtotime($post['created_at'])); ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No posts yet. Be the first to share!</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <?php include 'footer.php'; ?>
    <script src="script.js"></script>
</body>
</html>
