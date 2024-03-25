<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Add necessary meta tags and stylesheets -->
    <title>Edit Category</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php
    $categoryId = $_GET['id'];

    // Fetch category details based on ID
    $mysqli = new mysqli('localhost', 'root', '', 'customerservices');
    $sql = "SELECT * FROM category WHERE id = $categoryId";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        $category = $result->fetch_assoc();
    } else {
        echo "Category not found";
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
        <li><a href="../engineer/index.php" class="w3-bar-item w3-button">Engineer</a></li>
        <li><a href="index.php" class="w3-bar-item w3-button">Category</a></li>    
        <li> <a href="../logout.php" class="w3-bar-item w3-button">Logout</a></li>    
    </ul>
</div>
    <h2 style="text-align: center;">Edit Category</h2>

    <form action="update.php" method="post">
        <input type="hidden" name="id" value="<?php echo $category['id']; ?>">
        <!-- Add form fields for editing -->
        <label for="name">Name:</label>
        <input type="text" name="name" value="<?php echo $category['name']; ?>"><br>

        <input type="submit" value="Update">
    </form>

    <?php
    $mysqli->close();
    ?>
</body>
</html>