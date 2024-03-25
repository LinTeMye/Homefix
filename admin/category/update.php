<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categoryId = $_POST['id'];
    $name = $_POST['name'];

    // Update category details in the database
    $mysqli = new mysqli('localhost', 'root', '', 'customerservices');
    $sql = "UPDATE category SET name='$name' WHERE id=$categoryId";

    if ($mysqli->query($sql) === TRUE) {
        echo "Record updated successfully";

        // Redirect to category index.php after successful update
        header("Location: index.php");
        exit(); // Make sure to exit after header redirection to prevent further execution
    } else {
        echo "Error updating record: " . $mysqli->error;
    }

    $mysqli->close();
}
?>
