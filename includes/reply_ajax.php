<?php
require 'db.php';
require 'functions.php';

if (!isLoggedIn()) {
    echo json_encode(['success' => false, 'error' => 'User not logged in.']);
    exit();
}

$comment_id = $_POST['comment_id'];
$content = $_POST['content'];
$user_id = $_SESSION['user_id'];

// Insert the reply into the database
$stmt = $pdo->prepare('INSERT INTO replies (user_id, comment_id, content) VALUES (?, ?, ?)');
$stmt->execute([$user_id, $comment_id, $content]);

// Get the username of the replier
$stmt = $pdo->prepare('SELECT username FROM users WHERE id = ?');
$stmt->execute([$user_id]);
$username = $stmt->fetchColumn();

echo json_encode(['success' => true, 'username' => $username, 'content' => htmlspecialchars($content)]);
?>
