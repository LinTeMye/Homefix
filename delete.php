<?php
include("admin/connection.php");
if (isset($_GET['id'])) {
    // Sanitize the input to prevent SQL injection
    $id = intval($_GET['id']);

    try {
        // Prepare and execute the SQL query to delete the user
        $query = "DELETE FROM job WHERE id = :id";
        $stmt = $conn->prepare($query);

        // Bind the parameter
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        // Execute the statement
        $stmt->execute();
        header("location:index.php");
        // Check if the delete operation was successful
        if ($stmt->rowCount() > 0) {
            echo "Job with ID $id has been deleted successfully.";
        } else {
            echo "No job found with ID $id.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request. Please provide a valid job ID.";
}
?>