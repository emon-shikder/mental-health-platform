<?php
session_start();
require_once 'db.php';

if (!function_exists('is_logged_in')) {
    function is_logged_in() {
        return isset($_SESSION['user_id']);
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