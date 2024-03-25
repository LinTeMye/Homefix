<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $engineerId = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $ph_number = $_POST['ph_number'];

    // Update engineer details in the database
    $mysqli = new mysqli('localhost', 'root', '', 'customerservices');
    $sql = "UPDATE user_table SET name='$name', email='$email', ph_number='$ph_number' WHERE id=$engineerId";

    if ($mysqli->query($sql) === TRUE) {
        echo "Record updated successfully";
         // Redirect to index.php after successful update
         header("Location: index.php");
         exit(); // Make sure to exit after header redirection to prevent further execution
    } else {
        echo "Error updating record: " . $mysqli->error;
    }
  
    $mysqli->close();
}
?>
