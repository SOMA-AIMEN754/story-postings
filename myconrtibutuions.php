<?php
session_start();
require 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
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

//count stories
$stmt = $pdo->prepare('SELECT COUNT(*) AS allstoriescount FROM posts WHERE user_id = ?');
$stmt->execute([$_SESSION['user_id']]);
$allstoriescount = $stmt->fetchColumn();

//count contributions
$cstmt = $pdo->prepare('SELECT COUNT(*) AS allcontributionscount FROM comments WHERE user_id = ?');
$cstmt->execute([$_SESSION['user_id']]);
$allcontributionscount = $cstmt->fetchColumn();

//count shares
$shstmt = $pdo->prepare('SELECT COUNT(shared_post_id) AS allsharescount FROM posts WHERE user_id = ?');
$shstmt->execute([$_SESSION['user_id']]);
$allsharescount = $shstmt->fetchColumn();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Stories - Contributions</title>
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
        <div class="row">
            <div class="col-md-4">
                <div class="userprofilecard sticky-top p-5">
                    <div class="userprofile">
                        <div class="d-flex justify-content-center pb-2">
                            <img class="userprofileimg" src="<?php echo htmlspecialchars($_SESSION['user_image']); ?>" alt="">
                        </div>
                        <div class="d-flex justify-content-center">
                            <h3><?php echo htmlspecialchars($_SESSION['username']); ?></h3>
                        </div>
                        <hr style="color: 2pc solid #bebbb0;">
                    </div>
                    <div class="userprofileitems">
                        <div class="upitem"><a href="userprofile.php">Info</a></div>
                        <div class="upitem"><a href="mystories.php">Stories &nbsp;&nbsp;<span><?php echo $allstoriescount; ?></span></a></div>
                        <div class="upitem active"><a href="#">Contributions &nbsp;&nbsp;<span><?php echo $allcontributionscount; ?></span></a></div>
                        <div class="upitem"><a href="myshares.php">Shares &nbsp;&nbsp;<span><?php echo $allsharescount; ?></span></a></div>
                        <div class="upitem"><a href="logout.php ">Logout</a></div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="userprofilecard p-5">
                    <div class="userinfo pt-4">
                        <?php
                        $contributions = $pdo->prepare('SELECT comments.*, users.username, users.image AS user_image FROM comments JOIN users ON comments.user_id = users.id WHERE comments.user_id = ? ORDER BY created_at DESC');
                        $contributions->execute([$_SESSION['user_id']]);
                        ?>
                        <?php if ($contributions) : ?>
                            <?php foreach ($contributions as $post) : ?>
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
                                            
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <p>No posts found.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="bootstrap/js/scripts.js"></script>
</body>

</html>