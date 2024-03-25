<?php

include("admin/connection.php");

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['submit'])) {
    $category = $_POST['category'];
    $description = $_POST['description'];
    $userId = $_SESSION['user_id'];
    $date = date("Y-m-d"); // Get the current date

    $stmt = $conn->prepare("INSERT INTO job (description, category_id, user_id, job_status, date) VALUES (:description, :category, :userId, 'pending', :date)");
    $stmt->bindParam(":description", $description);
    $stmt->bindParam(":category", $category);
    $stmt->bindParam(":userId", $userId);
    $stmt->bindParam(":date", $date);
    $stmt->execute();

    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <title>Job request</title>
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
<br><br><br><br><br>
<h2 style="text-align: center;">Service request form</h2>
<div class="form-container">
       
        <form class="request" action="job.php" method="post">
            <label for="category">Category:</label>
            <select id="category" name="category" required>
            <?php
            $stmt = $conn->query("SELECT * FROM category");
            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($categories as $category) {
                echo "<option value='" . $category['id'] . "'>" . $category['name'] . "</option>";
            }
            ?>
        </select>
            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4" required></textarea>

            <button type="submit" name="submit">Submit Request</button>
        </form>
    </div>

<!-- Footer -->
<footer class="footer">
<p>&copy; 2023 Homefix. All rights reserved.</p>
</footer>

</body>
</html>