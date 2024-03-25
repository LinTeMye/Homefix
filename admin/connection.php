<?php
try {
    $conn = new PDO('mysql:host=localhost;dbname=customerservices', 'root', '');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if connected successfully
    // if ($conn) {
    //     echo "Connected to the database successfully!";
    //     // You can perform additional operations here if needed
    // } else {
    //     echo "Failed to connect to the database!";
    // }
} catch (Exception $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>