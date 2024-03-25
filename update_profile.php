<?php
// Include your database connection script
$mysqli = new mysqli('localhost', 'root', '', 'customerservices');

// Check for connection errors
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];

    // Sanitize and get other form values
    $name = $mysqli->real_escape_string($_POST['name']);
    $email = $mysqli->real_escape_string($_POST['email']);
    $ph_number = $mysqli->real_escape_string($_POST['ph_number']);
    $address = $mysqli->real_escape_string($_POST['address']);
    $postcode = $mysqli->real_escape_string($_POST['postcode']);

    // Update customer details in the database
    $update_query = "UPDATE user_table SET name = '$name', email = '$email', ph_number = '$ph_number', 
                     address = '$address', postcode = '$postcode' WHERE id = '$user_id'";

    if ($mysqli->query($update_query)) {
        echo "Profile updated successfully!";
        // You can redirect the user or perform other actions here after successful update
    } else {
        echo "Error updating profile: " . $mysqli->error;
    }
}

// Close the database connection
$mysqli->close();
?>
