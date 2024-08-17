<?php
session_start();
require 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Handle like form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['like_post_id'])) {
    $postId = $_POST['like_post_id'];
    $userId = $_SESSION['user_id'];

    // Check if the user has already liked the post
    $stmt = $pdo->prepare('SELECT * FROM likes WHERE user_id = ? AND post_id = ?');
    $stmt->execute([$userId, $postId]);
    $liked = $stmt->fetch();

    if ($liked) {
        // Unlike
        $stmt = $pdo->prepare('DELETE FROM likes WHERE user_id = ? AND post_id = ?');
        $stmt->execute([$userId, $postId]);
    } else {

        $dstmt = $pdo->prepare('SELECT * FROM dislikes WHERE user_id = ? AND post_id = ?');
        $dstmt->execute([$userId, $postId]);
        $disliked = $dstmt->fetch();

        if ($disliked) {
            // Undislike
            $dstmt = $pdo->prepare('DELETE FROM dislikes WHERE user_id = ? AND post_id = ?');
            $dstmt->execute([$userId, $postId]);

            // Like
            $stmt = $pdo->prepare('INSERT INTO likes (user_id, post_id) VALUES (?, ?)');
            $stmt->execute([$userId, $postId]);
        } else {
            // Like
            $stmt = $pdo->prepare('INSERT INTO likes (user_id, post_id) VALUES (?, ?)');
            $stmt->execute([$userId, $postId]);
        }
    }

    header('Location: index.php');
    exit();
}

// Handle dislike form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['dislike_post_id'])) {
    $postId = $_POST['dislike_post_id'];
    $userId = $_SESSION['user_id'];

    // Check if the user has already liked the post
    $dstmt = $pdo->prepare('SELECT * FROM dislikes WHERE user_id = ? AND post_id = ?');
    $dstmt->execute([$userId, $postId]);
    $disliked = $dstmt->fetch();

    if ($disliked) {
        // Undislike
        $dstmt = $pdo->prepare('DELETE FROM dislikes WHERE user_id = ? AND post_id = ?');
        $dstmt->execute([$userId, $postId]);
    } else {

        $stmt = $pdo->prepare('SELECT * FROM likes WHERE user_id = ? AND post_id = ?');
        $stmt->execute([$userId, $postId]);
        $liked = $stmt->fetch();

        if ($liked) {
            // Unlike
            $stmt = $pdo->prepare('DELETE FROM likes WHERE user_id = ? AND post_id = ?');
            $stmt->execute([$userId, $postId]);
            // disike
            $dstmt = $pdo->prepare('INSERT INTO dislikes (user_id, post_id) VALUES (?, ?)');
            $dstmt->execute([$userId, $postId]);
        } else {
            // disike
            $dstmt = $pdo->prepare('INSERT INTO dislikes (user_id, post_id) VALUES (?, ?)');
            $dstmt->execute([$userId, $postId]);
        }
    }

    header('Location: index.php');
    exit();
}

// Handle comment form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment_post_id'])) {
    $postId = $_POST['comment_post_id'];
    $userId = $_SESSION['user_id'];
    $content = $_POST['comment_content'];

    $stmt = $pdo->prepare('INSERT INTO comments (user_id, post_id, content) VALUES (?, ?, ?)');
    $stmt->execute([$userId, $postId, $content]);

    header('Location: index.php');
    exit();
}

// Handle share form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['share_post_id'])) {
    $postId = $_POST['share_post_id'];
    $userId = $_SESSION['user_id'];
    $content = $_POST['share_content'];

    $stmt = $pdo->prepare('INSERT INTO posts (user_id, content, shared_post_id) VALUES (?, ?, ?)');
    $stmt->execute([$userId, $content, $postId]);

    header('Location: index.php');
    exit();
}

// Handle new post submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['content'])) {
    $userId = $_SESSION['user_id'];
    $content = $_POST['content'];

    $stmt = $pdo->prepare('INSERT INTO posts (user_id, content) VALUES (?, ?)');
    $stmt->execute([$userId, $content]);

    header('Location: index.php');
    exit();
}

//Search Qurey
$searchQuery = '';
if (isset($_GET['search'])) {
    $searchQuery = $_GET['search'];
    $stmt = $pdo->prepare('SELECT posts.*, users.username, users.image AS user_image FROM posts JOIN users ON posts.user_id = users.id WHERE posts.content LIKE ? ORDER BY created_at DESC');
    $stmt->execute(['%' . $searchQuery . '%']);
    $posts = $stmt->fetchAll();
} else {
    $posts = $pdo->query('SELECT posts.*, users.username, users.image AS user_image FROM posts JOIN users ON posts.user_id = users.id ORDER BY created_at DESC')->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Storiers - Home</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap/css/mainstyle.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="#">Daily Stories</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <form class="d-flex me-auto" method="GET" action="index.php">
                    <input class="form-control searchinput me-2" type="search" placeholder="Search" value="<?php echo htmlspecialchars($searchQuery); ?>" name="search">
                    <button class="btn btn searchbtn" type="submit"><img src="assets/img/searchicon.png" alt=""></button>
                </form>
                <span class="navbar-text userdetails">Hi,
                    <?php echo htmlspecialchars($_SESSION['username']); ?>
                </span>
                <div class="dropdown">
                    <?php if (isset($_SESSION['user_image'])) : ?>
                        <img class="usersessionimg dropdown-toggle" type="button" data-bs-toggle="dropdown" src="<?php echo htmlspecialchars($_SESSION['user_image']); ?>" height="50px" alt="">
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="index.php">Home</a></li>
                            <li><a class="dropdown-item" href="userprofile.php">Profile</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                        </ul>
                </div>
            <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="container p-5">
        <div class="row postings">
            <div class="col-md-12">
                <form action="index.php" method="POST" class="postform">
                    <textarea name="content" placeholder="What's on your mind?" rows="7" required></textarea>
                    <div class="row">
                        <div class="col-md-6">
                            <button class="btn btn postbtn w-100" type="submit">Post</button>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn postbtn w-100" type="reset">Discard</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="p-3">
                <hr>
            </div>
        </div>

        <!-- posts -->
        <div class="col-md-12">
            <div class="heading">
                <h3>All Stories</h3>
            </div>
        </div>
        <?php if ($posts) : ?>
            <?php foreach ($posts as $post) : ?>
                <div class="row allposts pt-3 pb-5">
                    <div class="col-md-12">
                        <div class="postuserdetails d-flex align-items-center w-100">
                            <?php if ($post['user_image']) : ?>
                                <img src="<?php echo htmlspecialchars($post['user_image']); ?>" alt="">
                            <?php endif; ?>
                            <h6 class="fw-bold"><?php echo htmlspecialchars($post['username']); ?></h6>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card postcontent w-100">
                            <p><?php echo htmlspecialchars($post['content']); ?></p>
                            <?php if ($post['shared_post_id']) : ?>
                                <?php
                                $sharedPost = $pdo->prepare('SELECT posts.*, users.username, users.image AS user_image FROM posts JOIN users ON posts.user_id = users.id WHERE posts.id = ?');
                                $sharedPost->execute([$post['shared_post_id']]);
                                $sharedPost = $sharedPost->fetch();
                                ?>
                                <div style="border: 1px solid #737f7d; border-radius: 5px; padding: 10px;">
                                    <div class="col-md-12">
                                        <div class="postuserdetails d-flex align-items-center w-100">
                                            <?php if ($sharedPost['user_image']) : ?>
                                                <img src="<?php echo htmlspecialchars($sharedPost['user_image']); ?>" alt="">
                                            <?php endif; ?>
                                            <h6 class="fw-bold"><?php echo htmlspecialchars($sharedPost['username']); ?></h6>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="card postcontent w-100">
                                            <p><?php echo htmlspecialchars($sharedPost['content']); ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row mt-1">
                            <div class="col-md-4">
                                <div class="likedislike">
                                    <?php
                                    // likes
                                    $stmt = $pdo->prepare('SELECT COUNT(*) AS like_count FROM likes WHERE post_id = ?');
                                    $stmt->execute([$post['id']]);
                                    $likeCount = $stmt->fetchColumn();

                                    $stmt = $pdo->prepare('SELECT COUNT(*) AS comment_count FROM comments WHERE post_id = ?');
                                    $stmt->execute([$post['id']]);
                                    $commentCount = $stmt->fetchColumn();

                                    $stmt = $pdo->prepare('SELECT * FROM likes WHERE user_id = ? AND post_id = ?');
                                    $stmt->execute([$_SESSION['user_id'], $post['id']]);
                                    $liked = $stmt->fetch();
                                    ?>
                                    <form method="POST" action="index.php" style="display: inline;" id="like-form-<?php echo $post['id']; ?>">
                                        <input type="hidden" name="like_post_id" value="<?php echo $post['id']; ?>">
                                        <button class="btn btn likebtn like-button w-100" style="color: <?php echo $liked ? '#bebbb0' : '#e4e3e0'; ?>" data-post-id="<?php echo $post['id']; ?>"><img src="assets/img/<?php echo $liked ? 'Hliked' : 'Hlike'; ?>.png" alt=""> <span><?php echo $likeCount; ?></span></button>
                                    </form>

                                    <?php
                                    // dislikes
                                    $dstmt = $pdo->prepare('SELECT COUNT(*) AS dislike_count FROM dislikes WHERE post_id = ?');
                                    $dstmt->execute([$post['id']]);
                                    $dislikeCount = $dstmt->fetchColumn();

                                    $dstmt = $pdo->prepare('SELECT * FROM dislikes WHERE user_id = ? AND post_id = ?');
                                    $dstmt->execute([$_SESSION['user_id'], $post['id']]);
                                    $disliked = $dstmt->fetch();
                                    ?>
                                    <form method="POST" action="index.php" style="display: inline;" id="dislike-form-<?php echo $post['id']; ?>">
                                        <input type="hidden" name="dislike_post_id" value="<?php echo $post['id']; ?>">
                                        <button class="btn btn dislikebtn like-button w-100" style="color: <?php echo $disliked ? '#bebbb0' : '#e4e3e0'; ?>" data-post-id="<?php echo $post['id']; ?>"><img src="assets/img/<?php echo $disliked ? 'Hdisliked' : 'Hdislike'; ?>.png" alt=""> <span><?php echo $dislikeCount; ?></span></button>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn postcommentbtn comment-count comment-toggle w-100" data-post-id="<?php echo $post['id']; ?>"><img src="assets/img/contribution.png" alt=""> Contributions <span><?php echo $commentCount; ?></span></button>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn postcommentbtn share-button w-100" data-post-id="<?php echo $post['id']; ?>"><img src="assets/img/share.png" alt=""> Share</button>
                            </div>
                        </div>
                        <form method="POST" action="index.php" class="share-form" id="share-form-<?php echo $post['id']; ?>" style="display: none;">
                            <textarea name="share_content" placeholder="Say something about this post..." required></textarea>
                            <input type="hidden" name="share_post_id" value="<?php echo $post['id']; ?>">
                            <button type="submit">Share</button>
                        </form>
                        <form method="POST" action="index.php" class="comment-form-<?php echo $post['id']; ?> commentform" id="comment-form-<?php echo $post['id']; ?>" style="display: none;">
                            <textarea name="comment_content" placeholder="Write something..." required></textarea>
                            <input type="hidden" name="comment_post_id" value="<?php echo $post['id']; ?>">
                            <button type="submit">Add Contribution </button>
                        </form>
                        <div id="comments-<?php echo $post['id']; ?>" class="commentsection" style="display: none;">
                            <?php
                            $comments = $pdo->prepare('SELECT comments.*, users.username, users.image AS user_image FROM comments JOIN users ON comments.user_id = users.id WHERE post_id = ? ORDER BY created_at DESC');
                            $comments->execute([$post['id']]);
                            foreach ($comments as $comment) {
                                echo '<div class="usersreviews">';
                                if ($comment['user_image']) {
                                    echo '<img src="' . htmlspecialchars($comment['user_image']) . '" alt="User Image" style="width: 30px; height: 30px; border-radius: 50%; margin-right: 5px;">';
                                }
                                echo '<strong>' . htmlspecialchars($comment['username']) . '</strong>: ' . htmlspecialchars($comment['content']) . ' <button class="reply-button" data-comment-id="' . $comment['id'] . '">Reply</button>';

                                $replies = $pdo->prepare('SELECT COUNT(*) AS reply_count FROM replies WHERE comment_id = ?');
                                $replies->execute([$comment['id']]);
                                $replyCount = $replies->fetchColumn();

                                if ($replyCount > 0) {
                                    echo ' <span class="reply-count" data-comment-id="' . $comment['id'] . '">(' . $replyCount . ' replies)</span>';
                                } else {
                                    echo ' <span class="reply-count" data-comment-id="' . $comment['id'] . '">(0 replies)</span>';
                                }

                                echo '<div class="replies" id="replies-' . $comment['id'] . '" style="display:none;">';

                                $replies = $pdo->prepare('SELECT replies.*, users.username, users.image AS user_image FROM replies JOIN users ON replies.user_id = users.id WHERE comment_id = ? ORDER BY created_at DESC');
                                $replies->execute([$comment['id']]);
                                foreach ($replies as $reply) {
                                    echo '<div style="margin-left: 20px; margin-top: 5px;">';
                                    if ($reply['user_image']) {
                                        echo '<img src="' . htmlspecialchars($reply['user_image']) . '" alt="User Image" style="width: 30px; height: 30px; border-radius: 50%; margin-right: 5px;">';
                                    }
                                    echo '<strong>' . htmlspecialchars($reply['username']) . '</strong>: ' . htmlspecialchars($reply['content']) . '</div>';
                                }

                                echo '</div></div>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p class="nopostfound">Sorry, No posts found.</p>
        <?php endif; ?>
    </div>

    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="bootstrap/js/scripts.js"></script>
</body>

</html>