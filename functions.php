<?php
session_start();
require_once 'db.php';

if (!function_exists('is_logged_in')) {
    function is_logged_in() {
        return isset($_SESSION['user_id']);
    }
}

if (!function_exists('is_counselor')) {
    function is_counselor($user_id) {
        $user = get_user($user_id);
        return $user && $user['is_counselor'] == 1;
    }
}

// Get all posts
if (!function_exists('get_posts')) {
    function get_posts() {
        global $conn;
        $sql = "SELECT p.*, u.name as author_name FROM posts p 
                JOIN users u ON p.user_id = u.id 
                ORDER BY p.created_at DESC";
        $result = $conn->query($sql);
        return $result;
    }
}

// Add new post
if (!function_exists('add_post')) {
    function add_post($user_id, $title, $content) {
        global $conn;
        $user_id = (int)$user_id;
        $title = $conn->real_escape_string($title);
        $content = $conn->real_escape_string($content);
        $sql = "INSERT INTO posts (user_id, title, content, created_at) 
                VALUES ($user_id, '$title', '$content', NOW())";
        return $conn->query($sql);
    }
}

// Get comments for a post
if (!function_exists('get_comments')) {
    function get_comments($post_id) {
        global $conn;
        $post_id = (int)$post_id;
        $sql = "SELECT c.*, u.name as author_name FROM comments c 
                JOIN users u ON c.user_id = u.id 
                WHERE c.post_id = $post_id 
                ORDER BY c.created_at ASC";
        $result = $conn->query($sql);
        return $result;
    }
}

// Add comment
if (!function_exists('add_comment')) {
    function add_comment($post_id, $user_id, $text) {
        global $conn;
        $post_id = (int)$post_id;
        $user_id = (int)$user_id;
        $text = $conn->real_escape_string($text);
        $sql = "INSERT INTO comments (post_id, user_id, comment, created_at) 
                VALUES ($post_id, $user_id, '$text', NOW())";
        return $conn->query($sql);
    }
}

if (!function_exists('get_user')) {
    function get_user($id) {
        global $conn;
        $id = (int)$id;
        $sql = "SELECT * FROM users WHERE id = $id";
        $result = $conn->query($sql);
        return $result->fetch_assoc();
    }
}


// Get user moods
if (!function_exists('get_moods')) {
    function get_moods($user_id) {
        global $conn;
        $user_id = (int)$user_id;
        $sql = "SELECT * FROM moods WHERE user_id = $user_id ORDER BY date DESC";
        $result = $conn->query($sql);
        return $result;
    }
}

// Add mood
if (!function_exists('add_mood')) {
    function add_mood($user_id, $mood, $date) {
        global $conn;
        $user_id = (int)$user_id;
        $mood = $conn->real_escape_string($mood);
        $date = $conn->real_escape_string($date);
        $sql = "INSERT INTO moods (user_id, mood, date) VALUES ($user_id, '$mood', '$date')";
        return $conn->query($sql);
    }
}


// Get messages between two users
if (!function_exists('get_messages')) {
    function get_messages($user1, $user2) {
        global $conn;
        $user1 = (int)$user1;
        $user2 = (int)$user2;
        $sql = "SELECT m.*, u.name as sender_name FROM messages m 
                JOIN users u ON m.from_user = u.id 
                WHERE (m.from_user = $user1 AND m.to_user = $user2) 
                OR (m.from_user = $user2 AND m.to_user = $user1) 
                ORDER BY m.created_at ASC";
        $result = $conn->query($sql);
        return $result;
    }
}

// Add message
if (!function_exists('add_message')) {
    function add_message($from_user, $to_user, $content) {
        global $conn;
        $from_user = (int)$from_user;
        $to_user = (int)$to_user;
        $content = $conn->real_escape_string($content);
        $sql = "INSERT INTO messages (from_user, to_user, content, created_at) 
                VALUES ($from_user, $to_user, '$content', NOW())";
        return $conn->query($sql);
    }
}

// Get all users (for chat)
if (!function_exists('get_users')) {
    function get_users() {
        global $conn;
        $sql = "SELECT * FROM users ORDER BY name";
        $result = $conn->query($sql);
        return $result;
    }
}

// Get counselors
if (!function_exists('get_counselors')) {
    function get_counselors() {
        global $conn;
        $sql = "SELECT * FROM users WHERE is_counselor = 1 ORDER BY name";
        $result = $conn->query($sql);
        return $result;
    }
}

// Get students
if (!function_exists('get_students')) {
    function get_students() {
        global $conn;
        $sql = "SELECT * FROM users WHERE is_counselor = 0 ORDER BY name";
        $result = $conn->query($sql);
        return $result;
    }
}

// Get all resources
if (!function_exists('get_resources')) {
    function get_resources() {
        global $conn;
        $sql = "SELECT * FROM resources ORDER BY id DESC";
        $result = $conn->query($sql);
        if ($result === false) {
            // Table might not exist, return empty result
            return false;
        }
        return $result;
    }
}

// Alternative function name to avoid conflicts
if (!function_exists('fetch_resources')) {
    function fetch_resources() {
        global $conn;
        $sql = "SELECT * FROM resources ORDER BY id DESC";
        $result = $conn->query($sql);
        if ($result === false) {
            // Table might not exist, return empty result
            return false;
        }
        return $result;
    }
}

// Add resource 
if (!function_exists('add_resource')) {
    function add_resource($title, $type, $description, $url) {
        global $conn;
        $title = $conn->real_escape_string($title);
        $type = $conn->real_escape_string($type);
        $description = $conn->real_escape_string($description);
        $url = $conn->real_escape_string($url);
        $sql = "INSERT INTO resources (title, type, description, url) 
                VALUES ('$title', '$type', '$description', '$url')";
        return $conn->query($sql);
    }
}
?>

