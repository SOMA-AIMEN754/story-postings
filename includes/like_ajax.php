<?php
require 'includes/db.php';
require 'includes/functions.php';

if (!isLoggedIn()) {
    http_response_code(403);
    exit();
}

$post_id = $_GET['post_id'];
$stmt = $pdo->prepare('INSERT INTO likes (user_id, post_id) VALUES (?, ?)');
$stmt->execute([$_SESSION['user_id'], $post_id]);
echo 'Success';
?>
