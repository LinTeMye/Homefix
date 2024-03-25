<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Customer Profile</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Navigation Bar -->
    <div class="navbar">
    <div class="logo">
        <h5>HomeFix</h5>
    </div>
    <ul class="nav-links">
        <li><a href="index.php" class="w3-bar-item w3-button">Home</a></li>
        <li><a href="job.php" class="w3-bar-item w3-button">Jobs</a></li>
        <li><a href="my_request.php" class="w3-bar-item w3-button">My Request</a></li>
        <li><a href="profile.php" class="w3-bar-item w3-button">Profile</a></li>
        <li> <a href="logout.php" class="w3-bar-item w3-button">Logout</a></li>
    </ul>
</div>
<?php
// Fetch engineer details based on ID
$mysqli = new mysqli('localhost', 'root', '', 'customerservices');

// Check for connection errors
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

session_start(); // Start the session (if not already started)
$loggedInUserID = $_SESSION['user_id']; // Replace 'user_id' with your actual session variable

// Use a prepared statement to prevent SQL injection
$sql = "SELECT * FROM user_table WHERE id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $loggedInUserID); // Use $loggedInUserID instead of $user_Id

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    // ... rest of your code to display user details
} else {
    echo "User not found";
}

// Close the prepared statement
$stmt->close();

// Close the database connection
$mysqli->close();
?>


<h2 style="text-align: center";>Edit Customer Profile</h2>

<form action="update_profile.php" method="POST">
    <!-- Hidden input to store user_id -->
    <input type="hidden" name="user_id" value="<?php echo $loggedInUserID; ?>"> <!-- Use $loggedInUserID instead of $user_Id -->

    <label for="name">Name:</label>
    <input type="text" id="name" name="name" value="<?php echo $user['name']; ?>" required><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required><br>

    <label for="ph_number">Phone Number:</label>
    <input type="text" id="ph_number" name="ph_number" value="<?php echo $user['ph_number']; ?>"><br>

    <label for="address">Address:</label>
    <input type="text" id="address" name="address" value="<?php echo $user['address']; ?>"><br>

    <label for="postcode">Postcode:</label>
    <input type="text" id="postcode" name="postcode" value="<?php echo $user['postcode']; ?>"><br>

    <input type="submit" value="Save Changes">
</form>
<!-- Footer -->
<footer class="footer">
<p>&copy; 2023 Homefix. All rights reserved.</p>
</footer>
</body>

</html>
