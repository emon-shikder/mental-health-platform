<?php
require_once 'functions.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $name = trim($_POST['name']);
    $is_counselor = isset($_POST['is_counselor']) ? 1 : 0;
    
    // Validate input
    if (empty($email) || empty($password) || empty($name)) {
        $error = 'All fields are required.';
    } elseif ($password !== $confirm_password) {
        $error = 'Passwords do not match.';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters long.';
    } else {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $error = 'Email already exists.';
        } else {
            // Hash password and insert user
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (email, password, name, is_counselor, created_at) VALUES (?, ?, ?, ?, NOW())");
            $stmt->bind_param("sssi", $email, $hashed_password, $name, $is_counselor);
            
            if ($stmt->execute()) {
                $success = 'Registration successful! You can now login.';
            } else {
                $error = 'Registration failed. Please try again.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Mental Health Support</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    
    <div class="main-content">
        <div class="container">
            <div class="card" style="max-width: 500px; margin: 0 auto;">
                <h2 class="text-center mb-3">Create Account</h2>
                
                <?php if ($error): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <?php if ($success): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>
                
                <form method="POST" data-validate>
                    <div class="form-group">
                        <label for="name" class="form-label">Full Name *</label>
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email" class="form-label">Email *</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password" class="form-label">Password *</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="confirm_password" class="form-label">Confirm Password *</label>
                        <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="is_counselor" value="1">
                            Register as Counselor
                        </label>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" style="width: 100%;">Register</button>
                    </div>
                </form>
                
                <div class="text-center mt-3">
                    <p>Already have an account? <a href="login.php">Login here</a></p>
                </div>
            </div>
        </div>
    </div>
    
    <?php include 'footer.php'; ?>
    <script src="script.js"></script>
</body>
</html>
