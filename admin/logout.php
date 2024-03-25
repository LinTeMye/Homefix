<?php
session_start(); // Start the session

// Check if the user is logged in and unset all session variables
if (isset($_SESSION['user_id'])) {
    // Unset all of the session variables
    $_SESSION = array();

    // Destroy the session cookie
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }

    // Destroy the session
    session_destroy();
}

// Redirect to a login page or any other page after logout
header("Location: ../login.php"); // Replace 'login.php' with your login page URL
exit;
?>