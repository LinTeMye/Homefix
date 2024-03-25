<?php
session_start(); // Start the session (if not already started)

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id']) && is_numeric($_GET['id'])) {
    $job_id = $_GET['id'];


    $mysqli = new mysqli('localhost', 'root', '', 'customerservices');

   
    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli->connect_error;
        exit();
    }

    $engineer_id = $_SESSION['user_id']; 

    $update_query = "UPDATE job SET engineer_id = ?, job_status = 'Accepted' WHERE id = ?";
    $stmt = $mysqli->prepare($update_query);
    $stmt->bind_param('ii', $engineer_id, $job_id);

    if ($stmt->execute()) {
        header('Location: job.php'); 
        exit();
    } else {
        echo "Error: " . $mysqli->error;
    }

    // Close the database connection
    $mysqli->close();
} else {
    // Handle invalid request
    echo "Invalid request.";
}
?>
