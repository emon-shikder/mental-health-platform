<?php
require_once 'functions.php';

$error = '';
$success = '';

// Handle new resource submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && is_logged_in() && is_counselor($_SESSION['user_id'])) {
    $title = trim($_POST['title']);
    $type = trim($_POST['type']);
    $description = trim($_POST['description']);
    $url = trim($_POST['url']);
    
    if (empty($title) || empty($type) || empty($description) || empty($url)) {
        $error = 'Please fill in all fields.';
    } else {
        if (add_resource($title, $type, $description, $url)) {
            $success = 'Resource added successfully!';
        } else {
            $error = 'Failed to add resource. Please try again.';
        }
    }
}

// Get all resources
$resources_list = fetch_resources();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resources - Mental Health Support</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    
    <div class="main-content">
        <div class="container">
            <h1>Mental Health Resources</h1>
            <p>Helpful articles, videos, and resources to support your mental health journey.</p>
            
            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <?php if (is_logged_in() && is_counselor($_SESSION['user_id'])): ?>
                <div class="card">
                    <h3>Add New Resource</h3>
                    <form method="POST" data-validate>
                        <div class="form-group">
                            <label for="title" class="form-label">Title *</label>
                            <input type="text" id="title" name="title" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="type" class="form-label">Type *</label>
                            <select id="type" name="type" class="form-control" required>
                                <option value="">Select type...</option>
                                <option value="Article">Article</option>
                                <option value="Video">Video</option>
                                <option value="Podcast">Podcast</option>
                                <option value="Tool">Tool</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="description" class="form-label">Description *</label>
                            <textarea id="description" name="description" class="form-control" rows="3" required></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="url" class="form-label">URL *</label>
                            <input type="url" id="url" name="url" class="form-control" required>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Add Resource</button>
                    </form>
                </div>
            <?php endif; ?>
            
            <div class="resource-grid">
                <?php if ($resources_list && $resources_list !== false && $resources_list->num_rows > 0): ?>
                    <?php while ($resource = $resources_list->fetch_assoc()): ?>
                        <div class="resource-card">
                            <div class="resource-content">
                                <span class="resource-type"><?php echo htmlspecialchars($resource['type']); ?></span>
                                <h3><?php echo htmlspecialchars($resource['title']); ?></h3>
                                <p><?php echo htmlspecialchars($resource['description']); ?></p>
                                <a href="<?php echo htmlspecialchars($resource['url']); ?>" target="_blank" class="btn btn-primary">
                                    View Resource
                                </a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="card">
                        <p>No resources available yet. Check back soon!</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <?php include 'footer.php'; ?>
    <script src="script.js"></script>
</body>
</html>
