<?php
// Establish database connection
$servername = "localhost"; // Change this to your servername
$username = "root"; // Change this to your database username
$password = ""; // Change this to your database password
$dbname = "customerservices"; // Change this to your database name

// Create connection
$mysqli = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $job_id = $_POST['job_id'];
    $rating = $_POST['rating'];
    $comments = $_POST['comments'];

    // Validate form data (You may add more validation as needed)

    // Update the job record with feedback data
    $updateQuery = "UPDATE job SET feedback = ?, rank = ? WHERE id = ?";

    // Use prepared statement to prevent SQL injection
    $stmt = $mysqli->prepare($updateQuery);

    // Bind parameters
    $stmt->bind_param("sii", $comments, $rating, $job_id);

    // Execute the statement
    if ($stmt->execute()) {
        // Feedback submitted successfully
        header("Location: feedback.php?job_id=$job_id"); // Redirect to a success page with job_id
        exit();
    } else {
        // Error updating feedback
        echo "Error updating feedback: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
} else {
    // If the form is not submitted, display the feedback form or an error message

    // Check if the job_id parameter is provided in the URL
    if (!isset($_GET['job_id'])) {
        echo "<p>Error: Job ID not provided.</p>";
    } else {
        $job_id = $_GET['job_id'];
        ?>

        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
            <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
            <link rel="stylesheet" href="css/style.css">
            <title>Feedback Form</title>
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
                <li><a href="logout.php" class="w3-bar-item w3-button">Logout</a></li>
            </ul>
        </div>
        <h2 style="text-align: center;">Feedback Form</h2>
        <div class="form-container">
            <form action="feedback.php" method="post">
                <input type="hidden" name="job_id" value="<?php echo $job_id; ?>">
                <div class="form-group">
                    <label for="rating">Rating:</label>
                    <select class="form-control" id="rating" name="rating">
                        <option value="5">5 - Excellent</option>
                        <option value="4">4 - Very Good</option>
                        <option value="3">3 - Good</option>
                        <option value="2">2 - Fair</option>
                        <option value="1">1 - Poor</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="comments">Comments:</label>
                    <textarea class="form-control" id="comments" name="comments" rows="8" cols="40"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit Feedback</button>
            </form>
        </div>
        <!-- Footer -->
        <footer>
        <p>&copy; 2023 Homefix. All rights reserved.</p>
        </footer>
        </body>
        </html>

        <?php
    }
}
?>