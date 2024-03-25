<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Add necessary meta tags and stylesheets -->
    <title>Edit Engineer</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php
    $engineerId = $_GET['id'];

    // Fetch engineer details based on ID
    $mysqli = new mysqli('localhost', 'root', '', 'customerservices');
    $sql = "SELECT * FROM user_table WHERE id = $engineerId";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        $engineer = $result->fetch_assoc();
    } else {
        echo "Engineer not found";
        exit();
    }
    ?>
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
    <h2 style="text-align: center;">Edit Engineer</h2>

    <form action="update.php" method="post">
        <input type="hidden" name="id" value="<?php echo $engineer['id']; ?>">
        <!-- Add form fields for editing -->
        <label for="name">Name:</label>
        <input type="text" name="name" value="<?php echo $engineer['name']; ?>"><br>

        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo $engineer['email']; ?>"><br>

        <label for="ph_number">Phone Number:</label>
        <input type="text" name="ph_number" value="<?php echo $engineer['ph_number']; ?>"><br>

        <input type="submit" value="Update">
    </form>

    <?php
    $mysqli->close();
    ?>
</body>
</html>
