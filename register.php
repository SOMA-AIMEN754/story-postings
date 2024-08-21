<?php
require 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ? OR email = ?');
    $stmt->execute([$username, $email]);
    $user = $stmt->fetch();

    if (!$user) {
        // Handle image upload
        $imagePath = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $imageFileName = $_FILES['image']['name'];
            $imageTmpName = $_FILES['image']['tmp_name'];
            $imagePath = 'uploads/' . $imageFileName; // Adjust folder as needed

            move_uploaded_file($imageTmpName, $imagePath);
        }

        $stmt = $pdo->prepare('INSERT INTO users (username, email, password, image) VALUES (?, ?, ?, ?)');
        $stmt->execute([$username, $email, $password, $imagePath]);

        header('Location: login.php');
        exit();
        
    } else {
        echo '<script>alert("User already exist")</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap/css/mainstyle.css">
</head>

<body>
    <div class="loginmaindiv d-flex justify-content-center align-items-center">
        <div class="card loginformdiv p-5 shadow-lg">
            <h3 class="d-flex justify-content-center align-items-center">Register</h3>
            <form method="POST" action="register.php" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-12">
                        <input class="w-100 mt-3" type="text" name="username" id="" placeholder="Full Name" required>
                    </div>
                    <div class="col-md-12">
                        <input class="w-100 mt-3" type="email" name="email" id="" placeholder="Email" required>
                    </div>

                    <div class="col-md-12">
                        <input class="w-100 mt-3" type="password" name="password" id="" placeholder="password" required>
                    </div>
                    <div class="col-md-12">
                        <p class= "mb-0" style="margin-left: 5px"> Profile Pic:</p>
                        <input class="w-100 mt-0  bg-white" type="file" name="image" id="" placeholder="image" required>
                    </div>
                    <div class="col-md-12">
                        <button class="w-100 mt-3" type="submit">Register</button>
                    </div>
                    <div class="col-md-12 p-3">
                        Already have an account click <a href="login.php">here</a>
                    </div>
                </div>


            </form>
        </div>
    </div>


    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>