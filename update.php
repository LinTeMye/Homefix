<?php
// Assuming you have a database connection established
$mysqli = new mysqli('localhost', 'root', '', 'customerservices');

// Check for connection errors
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['job_id'])) {
    $job_id = $_POST['job_id'];

    // Sanitize and get other form values
    $category_id = $mysqli->real_escape_string($_POST['category']);
    $description = $mysqli->real_escape_string($_POST['description']);
    // Add other fields like job_status, engineer_id, etc., in a similar manner

    // Update job details in the database
    $update_query = "UPDATE job SET category_id = '$category_id', description = '$description' WHERE id = '$job_id'";
    // Add other fields to the update query as needed

    if ($mysqli->query($update_query)) {
        echo "Record updated successfully";
        // Redirect to index.php after successful update
        header("Location: index.php");
        exit(); // Make sure to exit after header redirection to prevent further execution
    } else {
        echo "Error updating record: " . $mysqli->error;
    }
}

// Close the database connection
$mysqli->close();
?>
