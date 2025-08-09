<?php
require_once 'functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mental Health Support Platform</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'navbar.php'; ?>
    
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title fade-in-up">Welcome to Student Mental Health Support</h1>
                <p class="hero-subtitle fade-in-up delay-1">A safe, supportive space where students can connect, share experiences, and access professional mental health resources. You're not alone in your journey.</p>
                
                <?php if (!is_logged_in()): ?>
                    <div class="hero-buttons fade-in-up delay-2">
                        <a href="register.php" class="hero-btn hero-btn-primary">
                            <i class="fas fa-user-plus"></i>
                            Get Started
                        </a>
                        <a href="login.php" class="hero-btn hero-btn-secondary">
                            <i class="fas fa-sign-in-alt"></i>
                            Login
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    
    <!-- Features Section -->
    <section class="features-section">
        <div class="container">
            <h2 class="section-title fade-in-up">What We Offer</h2>
            <div class="features-grid">
                <div class="feature-card fade-in-up delay-1">
                    <div class="feature-icon">
                        <i class="fas fa-comments"></i>
                    </div>
                    <h3 class="feature-title">Community Forum</h3>
                    <p class="feature-description">Share your thoughts and experiences in a supportive community. Connect with peers who understand what you're going through.</p>
                </div>
                
                <div class="feature-card fade-in-up delay-2">
                    <div class="feature-icon">
                        <i class="fas fa-comment-dots"></i>
                    </div>
                    <h3 class="feature-title">Private Chat</h3>
                    <p class="feature-description">Private conversations with counselors or other students. Get immediate support when you need it most.</p>
                </div>
                
                <div class="feature-card fade-in-up delay-3">
                    <div class="feature-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h3 class="feature-title">Mood Tracker</h3>
                    <p class="feature-description">Track your daily moods and emotions to better understand your mental health patterns over time.</p>
                </div>
                
                <div class="feature-card fade-in-up delay-4">
                    <div class="feature-icon">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <h3 class="feature-title">Mental Health Resources</h3>
                    <p class="feature-description">Access helpful articles, videos, and resources about mental health, stress management, and wellness.</p>
                </div>
            </div>
        </div>
    </section>
    
    <?php if (is_logged_in()): ?>
        <!-- Quick Actions Section -->
        <section class="quick-actions">
            <div class="container">
                <h2 class="section-title fade-in-up">Quick Actions</h2>
                <div class="actions-grid">
                    <a href="forum.php" class="action-card fade-in-up delay-1">
                        <div class="action-content">
                            <div class="action-icon">
                                <i class="fas fa-comments"></i>
                            </div>
                            <div class="action-title">Visit Forum</div>
                            <div class="action-description">Join the community discussion</div>
                        </div>
                    </a>
                    
                    <a href="chat.php" class="action-card fade-in-up delay-2">
                        <div class="action-content">
                            <div class="action-icon">
                                <i class="fas fa-comment-dots"></i>
                            </div>
                            <div class="action-title">Start Chat</div>
                            <div class="action-description">Connect with counselors</div>
                        </div>
                    </a>
                    
                    <a href="mood.php" class="action-card fade-in-up delay-3">
                        <div class="action-content">
                            <div class="action-icon">
                                <i class="fas fa-heart"></i>
                            </div>
                            <div class="action-title">Track Mood</div>
                            <div class="action-description">Log your daily emotions</div>
                        </div>
                    </a>
                    
                    <a href="resources.php" class="action-card fade-in-up delay-4">
                        <div class="action-content">
                            <div class="action-icon">
                                <i class="fas fa-book-open"></i>
                            </div>
                            <div class="action-title">Browse Resources</div>
                            <div class="action-description">Access helpful materials</div>
                        </div>
                    </a>
                </div>
            </div>
        </section>
    <?php endif; ?>
    
    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <h2 class="section-title fade-in-up">Platform Impact</h2>
            <div class="stats-grid">
                <div class="stat-item fade-in-up delay-1">
                    <div class="stat-number">500+</div>
                    <div class="stat-label">Students Supported</div>
                </div>
                <div class="stat-item fade-in-up delay-2">
                    <div class="stat-number">50+</div>
                    <div class="stat-label">Professional Counselors</div>
                </div>
                <div class="stat-item fade-in-up delay-3">
                    <div class="stat-number">1000+</div>
                    <div class="stat-label">Resources Available</div>
                </div>
                <div class="stat-item fade-in-up delay-4">
                    <div class="stat-number">24/7</div>
                    <div class="stat-label">Support Available</div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Emergency Section -->
    <section class="emergency-section">
        <div class="container">
            <div class="emergency-content">
                <h2 class="emergency-title fade-in-up">Need Immediate Help?</h2>
                <p class="emergency-text fade-in-up delay-1">If you're experiencing a mental health crisis or having thoughts of self-harm, please reach out to these resources immediately:</p>
                
                <div class="emergency-list">
                    <div class="emergency-item fade-in-up delay-2">
                        <strong>National Suicide Prevention Lifeline</strong>
                        988
                    </div>
                    <div class="emergency-item fade-in-up delay-3">
                        <strong>Crisis Text Line</strong>
                        Text HOME to 741741
                    </div>
                    <div class="emergency-item fade-in-up delay-4">
                        <strong>Emergency Services</strong>
                        911
                    </div>
                </div>
                
                <p style="margin-top: 2rem; font-style: italic; opacity: 0.9;" class="fade-in-up delay-4">
                    Remember, you're not alone, and it's okay to ask for help.
                </p>
            </div>
        </div>
    </section>
    
    <?php include 'footer.php'; ?>
    <script src="script.js"></script>
</body>
</html>
