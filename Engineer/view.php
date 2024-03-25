<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Add necessary meta tags and stylesheets -->
    <title>View job detail</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="../css/style.css">
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
</head>
<body>
    
<!-- Navigation Bar -->
<div class="navbar">
    <div class="logo">
        <h5>HomeFix</h5>
    </div>
    <ul class="nav-links">
        <li><a href="index.php" class="w3-bar-item w3-button">Home</a></li>   
        <li><a href="job.php" class="w3-bar-item w3-button">Job</a></li>      
    </ul>
</div>
<?php
   
// Establish a connection to your database
$mysqli = new mysqli('localhost', 'root', '', 'customerservices');

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Check if job_id is set and is a valid number
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    // Sanitize the input
    $job_id = $_GET['id'];


    $query = "SELECT j.id, j.date, u.name AS user_name, u.email, u.ph_number, u.address, c.name AS category_name, j.description, j.job_status, j.engineer_id
              FROM job j
              LEFT JOIN user_table u ON j.user_id = u.id
              LEFT JOIN category c ON j.category_id = c.id
              WHERE j.id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('i', $job_id);

    if ($stmt->execute()) {
        $jobDetails = $stmt->get_result()->fetch_assoc();

        // Display the job details as a table
        echo "<h2 style='text-align:center'>Job Details</h2>";
        echo "<table>";
        echo "<tr><th>Date</th><td>{$jobDetails['date']}</td></tr>";
        echo "<tr><th>User Name</th><td>{$jobDetails['user_name']}</td></tr>";
        echo "<tr><th>Email</th><td>{$jobDetails['email']}</td></tr>";
        echo "<tr><th>Phone Number</th><td>{$jobDetails['ph_number']}</td></tr>";
        echo "<tr><th>Address</th><td>{$jobDetails['address']}</td></tr>";
        echo "<tr><th>Category</th><td>{$jobDetails['category_name']}</td></tr>";
        echo "<tr><th>Description</th><td>{$jobDetails['description']}</td></tr>";
        echo "<tr><th>Status</th><td>{$jobDetails['job_status']}</td></tr>";

        // Check if engineer_id is valid (non-empty)
        if (!empty($jobDetails['engineer_id'])) {
            $engineer_id = $jobDetails['engineer_id'];
            $engineer_query = "SELECT name FROM user_table WHERE id = ?";
            $engineer_stmt = $mysqli->prepare($engineer_query);
            $engineer_stmt->bind_param('i', $engineer_id); 
            if ($engineer_stmt->execute()) {
                $engineer_stmt->bind_result($engineer_name);
                if ($engineer_stmt->fetch()) {
                    echo "<tr><th>Engineer</th><td>{$engineer_name}</td></tr>";
                } else {
                    echo "<tr><th>Engineer</th><td>Invalid Engineer</td></tr>";
                }
            }
        }

        echo "</table>";
    } 

    // Close the statement
    $stmt->close();
} else {
    echo "Invalid job ID.";
}

?>

</body>
</html>

  

