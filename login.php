<?php
include("admin/connection.php");
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if user exists
    $stmt = $conn->prepare("SELECT * FROM user_table WHERE email = :email");
    $stmt->bindParam(":email", $email);
    $stmt->execute();

    $user = $stmt->fetch();

    if ($user) {
        // Verify password
        if (password_verify($password, $user['password'])) {
            // Successful login
            session_start();
            $_SESSION['user_id'] = $user['id'];

            // Check role_id and redirect accordingly
            if ($user['role_id'] == 1) {
                header("Location: index.php");
            } elseif ($user['role_id'] == 3) {
                header("Location: admin/index.php");
            }
            elseif ($user['role_id'] == 2) {
                header("Location: engineer/job.php");
            }
            exit();
        } else {
            $error = "Incorrect password";
        }
    } else {
        $error = "User not found";
    }
    echo '<script>alert("' . $error . '");</script>';
}


?>

<!DOCTYPE html>
<html lang="en">
<head >
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="homefix photo/techny-signing-in-to-user-account.png" type="image/x-icon">
</head>
<body class="login">
        <div class="container">
            <div class="left-form-container">
            </div>
            <div class="right-form-container">
                <div class="arrange-head">
                    <h1>Login Page</h1>
                    
                    <form action="login.php" method="post">
                        <div class="email-pass">
                      
                        <label for="email">Email Address</label><br>
                        <input type="email" id="email" name="email" placeholder=" Email@gmail.com"required><br><br>
                        <label for="password">Password</label><br>
                        <input type="password" id="password" name="password"  placeholder=" Enter Password"required><br>
                        </div>
                        <p class="signup-work"><a href="sign_up.php">Sign Up to Register!</a></p>
                    <div class="sign-in-button">
                    <button type="submit" name="submit">Sign In</button>
                    </div>
                    </div>
                    </form>
                </div>
                
            </div>
        </div>
</body>
</html>