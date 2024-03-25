<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Add necessary meta tags and stylesheets -->
    <title>Edit</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php
    $jobId = $_GET['id'];

    // Fetch engineer details based on ID
    $mysqli = new mysqli('localhost', 'root', '', 'customerservices');
    $sql = "SELECT * FROM job WHERE id = $jobId";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        $job = $result->fetch_assoc();
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
        <li><a href="index.php" class="w3-bar-item w3-button">Home</a></li>
        <li><a href="job.php" class="w3-bar-item w3-button">Jobs</a></li>
        <li><a href="my_request.php" class="w3-bar-item w3-button">My Request</a></li>
        <li> <a href="logout.php" class="w3-bar-item w3-button">Logout</a></li>
    </ul>
</div>
<?php
// Assuming you have a database connection established
$mysqli = new mysqli('localhost', 'root', '', 'customerservices');

// Check for connection errors
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

if (isset($_GET['id'])) {
    $job_id = $_GET['id'];

    // Fetch job details based on ID
    $query = "SELECT * FROM job WHERE id = $job_id";
    $result = $mysqli->query($query);

    if ($result && $result->num_rows > 0) {
        $job_details = $result->fetch_assoc();

        // Form to edit job details
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <h2 style="text-align: center";>Edit Job</h2>
            <form action="update.php" method="post">
                <input type="hidden" name="job_id" value="<?php echo $job_details['id']; ?>">

                <label for="category">Category:</label><br>
                <!-- Assuming categories are fetched from a database table named 'category' -->
                <select id="category" name="category">
                    <?php
                    $categories_query = "SELECT * FROM category";
                    $categories_result = $mysqli->query($categories_query);

                    if ($categories_result && $categories_result->num_rows > 0) {
                        while ($category = $categories_result->fetch_assoc()) {
                            $selected = ($category['id'] == $job_details['category_id']) ? 'selected' : '';
                            echo "<option value='" . $category['id'] . "' $selected>" . $category['name'] . "</option>";
                        }
                    }
                    ?>
                </select><br>
                <label for="description">Description:</label><br>
                <textarea id="description" name="description" rows="4" cols="50"><?php echo $job_details['description']; ?></textarea><br>

                <!-- Add other fields like job_status, engineer_id, etc., in a similar manner -->

                <input type="submit" value="update">
            </form>
        </body>
        </html>
        <?php
    } else {
        echo "Job not found";
    }
} else {
    echo "Invalid request";
}

// Close the database connection
$mysqli->close();

    ?>
</body>
</html>