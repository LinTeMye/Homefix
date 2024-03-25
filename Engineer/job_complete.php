<?php
session_start(); 

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id']) && is_numeric($_GET['id'])) {
    $job_id = $_GET['id'];


    $mysqli = new mysqli('localhost', 'root', '', 'customerservices');

    // Check for connection errors
    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli->connect_error;
        exit();
    }

    // Update the job status to 'Complete'
    $update_query = "UPDATE job SET job_status = 'Complete' WHERE id = ?";
    $stmt = $mysqli->prepare($update_query);
    $stmt->bind_param('i', $job_id);

    if ($stmt->execute()) {
        header('Location: job.php'); // Redirect to job page after successful completion
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
