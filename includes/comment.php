<?php
require 'includes/db.php';
require 'includes/functions.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}

$post_id = $_GET['post_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $content = $_POST['content'];
    $stmt = $pdo->prepare('INSERT INTO comments (user_id, post_id, content) VALUES (?, ?, ?)');
    $stmt->execute([$_SESSION['user_id'], $post_id, $content]);
    header('Location: post.php?post_id=' . $post_id);
}

$comments = $pdo->prepare('SELECT comments.*, users.username FROM comments JOIN users ON comments.user_id = users.id WHERE post_id = ? ORDER BY created_at DESC');
$comments->execute([$post_id]);
$comments = $comments->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Comment</title>
</head>
<body>
    <form method="POST">
        <textarea name="content" placeholder="Write a comment..." required></textarea>
        <button type="submit">Comment</button>
    </form>

    <?php foreach ($comments as $comment): ?>
        <div>
            <p><?php echo htmlspecialchars($comment['username']); ?>: <?php echo htmlspecialchars($comment['content']); ?></p>
        </div>
    <?php endforeach; ?>
</body>
</html>
