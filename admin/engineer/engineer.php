<?php
include("../connection.php");

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phonenumber = $_POST['phonenumber'];

    // Validate user input
    $errors = [];
    if (empty($name)) {
        $errors[] = "Name is required";
    }
    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }

    if (empty($password)) {
        $errors[] = "Password is required";
    } elseif (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters long";
    }
    if (empty($phonenumber)) {
        $errors[] = "Phone number is required";  
    }
    // Check if email is already taken
    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT * FROM user_table WHERE email = :email");
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $errors[] = "Email is already taken";
        }
    }
 // Insert new user data into the database
 if (empty($errors)) {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $defaultRoleId = 2;
    $stmt = $conn->prepare("INSERT INTO user_table (name, email, password, ph_number, role_id) VALUES (:name, :email, :password, :ph_number, :role_id)");
    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":password", $hashedPassword);
    $stmt->bindParam(":ph_number", $phonenumber);
    $stmt->bindParam(":role_id", $defaultRoleId); 
    $stmt->execute();
    // Redirect to login page
    header("Location: index.php");
    exit();     
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <title>Home</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<!-- Navigation Bar -->
<div class="navbar">
    <div class="logo">
        <h5>HomeFix</h5>
    </div>
    <ul class="nav-links">
        <li><a href="../index.php" class="w3-bar-item w3-button">Home</a></li>
        <li><a href="../Job/index.php" class="w3-bar-item w3-button">Jobs</a></li>
        <li><a href="index.php" class="w3-bar-item w3-button">Engineer</a></li>
        <li><a href="../category/index.php" class="w3-bar-item w3-button">Category</a></li> 
        <li> <a href="../logout.php" class="w3-bar-item w3-button">Logout</a></li>       
    </ul>
</div>

<!-- Main Content Area -->
<h2 style="text-align: center";>Engineer Registration Form</h2>

<form action="engineer.php" method="post" id="engineerForm">

            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <?php if (!empty($errors) && in_array("Email is required", $errors)): ?>
            <p class="error-message">Email is required</p>
            <?php elseif (!empty($errors) && in_array("Invalid email format", $errors)): ?>
             <p class="error-message">Invalid email format</p>
            <?php elseif (!empty($errors) && in_array("Email is already taken", $errors)): ?>
            <p class="error-message">Email is already taken</p>
             <?php endif; ?>

           
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <?php if (!empty($errors) && in_array("Password is required", $errors)): ?>
             <p class="error-message">Password is required</p>
            <?php elseif (!empty($errors) && in_array("Password must be at least 6 characters long", $errors)): ?>
             <p class="error-message">Password must be at least 6 characters long</p>
            <?php endif; ?>    

            <label for="phonenumber">Phone Number</label><br>
            <input type="tel" name="phonenumber" id="phonenumber" placeholder=" Phone Number" required>
            <button type="submit" name="submit">Submit</button>
        </form>
	</div>

<!-- Footer -->
<footer class="footer">
    <p>&copy; 2023 Homefix. All rights reserved.</p>
</footer>

</body>
</html>