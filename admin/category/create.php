<?php
include("../connection.php");
if (isset($_POST['submit'])) {
        $name = $_POST['name'];

        // Validate input
        $errors = [];

        if (empty($name)) {
            $errors[] = "Name is required";
        }

        // Check if there are no validation errors
        if (empty($errors)) {
            // Prepare and execute the SQL query to insert the category into the database
            $stmt = $conn->prepare("INSERT INTO category (name) VALUES (:name)");
            $stmt->bindParam(":name", $name);
            $stmt->execute();

            // Redirect to a success page or perform other actions
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
        <li><a href="job.php" class="w3-bar-item w3-button">Jobs</a></li>
        <li><a href="../engineer/index.php" class="w3-bar-item w3-button">Engineer</a></li>
        <li><a href="index.php" class="w3-bar-item w3-button">Category</a></li>   
        <li> <a href="../logout.php" class="w3-bar-item w3-button">Logout</a></li>     
    </ul>
</div>
<br><br><br><br><br><br><br><br>
<h2 style="text-align: center;">Create new category</h2>
<form action="create.php" method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
                    
            <div class="category">
            <button type="submit" name="submit">Submit</button>
</form>
<!-- Footer -->
<footer class="footer">
    <p>&copy; 2023 Homefix. All rights reserved.</p>
</footer>
</body>
</html>