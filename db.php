<?php


$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'mental_health_platform';


$conn = new mysqli($host, $user, $pass, $db);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8");

error_reporting(0);
ini_set('display_errors', 0);
?>
