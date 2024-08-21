<?php
session_start();
require 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usernameOrEmail = $_POST['username_or_email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ? OR email = ?');
    $stmt->execute([$usernameOrEmail, $usernameOrEmail]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['useremail'] = $user['email'];
        $_SESSION['user_image'] = $user['image'];
        header('Location: index.php');
        exit();
    } else {
        $error = 'Invalid username/email or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap/css/mainstyle.css">
</head>

<body>
    <div class="loginmaindiv d-flex justify-content-center align-items-center">
        <div class="card loginformdiv p-5 shadow-lg">
            <h3 class="d-flex justify-content-center align-items-center">Login</h3>
            <form method="POST" action="login.php">
                <div class="row">
                    <div class="col-md-12">
                        <input class="w-100 mt-3" type="text" name="username_or_email" id="" placeholder="Full Name or Email">
                    </div>
                    <div class="col-md-12">
                        <input class="w-100 mt-3" type="password" name="password" id="" placeholder="password">
                    </div>
                    <div class="col-md-12">
                        <button class="w-100 mt-3" type="submit">Login</button>
                    </div>
                    <div class="col-md-12 p-3">
                        Don't have an account click <a href="register.php">here</a>
                    </div>
                </div>
                
                
            </form>
        </div>
    </div>


<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>