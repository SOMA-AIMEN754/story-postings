<?php
require 'includes/db.php';
require 'includes/functions.php';

if (!isLoggedIn()) {
    http_response_code(403);
    exit();
}

$post_id = $_POST['post_id'];
$content = $_POST['content'];
$stmt = $pdo->prepare('INSERT INTO comments (user_id, post_id, content) VALUES (?, ?, ?)');
$stmt->execute([$_SESSION['user_id'], $post_id, $content]);
echo 'Success';
?>
