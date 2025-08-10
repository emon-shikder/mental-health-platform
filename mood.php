<?php
require_once 'functions.php';

if (!is_logged_in()) {
    header('Location: login.php');
    exit();
}

$error = '';
$success = '';

// Handle mood submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $mood = trim($_POST['mood']);
    $date = date('Y-m-d');
    
    if (empty($mood)) {
        $error = 'Please select a mood.';
    } else {
        if (add_mood($_SESSION['user_id'], $mood, $date)) {
            $success = 'Mood saved successfully!';
        } else {
            $error = 'Failed to save mood. Please try again.';
        }
    }
}

// Get user's mood history
$moods = get_moods($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mood Tracker - Mental Health Support</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    
    <div class="main-content">
        <div class="container">
            <h1>Mood Tracker</h1>
            <p>Track your daily moods to better understand your mental health patterns.</p>
            
            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <div class="mood-form">
                <h3>How are you feeling today?</h3>
                <form method="POST" data-validate>
                    <div class="form-group">
                        <label for="mood" class="form-label">Select your mood *</label>
                        <select id="mood" name="mood" class="form-control" required>
                            <option value="">Choose a mood...</option>
                            <option value="Happy">😊 Happy</option>
                            <option value="Sad">😢 Sad</option>
                            <option value="Anxious">😰 Anxious</option>
                            <option value="Angry">😠 Angry</option>
                            <option value="Calm">😌 Calm</option>
                            <option value="Excited">🤩 Excited</option>
                            <option value="Tired">😴 Tired</option>
                            <option value="Stressed">😰 Stressed</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Save Mood</button>
                </form>
            </div>
            
            <div class="mood-history">
                <h3>Your Mood History</h3>
                
                <?php if ($moods && $moods->num_rows > 0): ?>
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="background: #f8f9fa;">
                                    <th style="padding: 0.75rem; text-align: left; border-bottom: 1px solid #e9ecef;">Date</th>
                                    <th style="padding: 0.75rem; text-align: left; border-bottom: 1px solid #e9ecef;">Mood</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($mood = $moods->fetch_assoc()): ?>
                                    <tr>
                                        <td style="padding: 0.75rem; border-bottom: 1px solid #e9ecef;">
                                            <?php echo date('M j, Y', strtotime($mood['date'])); ?>
                                        </td>
                                        <td style="padding: 0.75rem; border-bottom: 1px solid #e9ecef;">
                                            <?php echo htmlspecialchars($mood['mood']); ?>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p>No mood entries yet. Start tracking your mood today!</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <?php include 'footer.php'; ?>
    <script src="script.js"></script>
</body>
</html>
