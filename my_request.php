<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <title>My request</title>
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
<h2 style="text-align: center;">My Job Information</h2>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Number</th>
            <th>Date</th>
            <th>Category</th>
            <th>Description</th>
            <th>Status</th>
            <th>Assigned Engineer</th>
            <th>Feedback</th> 
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $mysqli = new mysqli('localhost', 'root', '', 'customerservices');

    // Check for connection errors
    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli->connect_error;
        exit();
    }


    session_start(); 
    $loggedInUserID = $_SESSION['user_id']; 
    

    $query = "SELECT j.id, j.date, c.name AS category_name, j.description, j.job_status, u.name AS engineer_name , j.feedback
              FROM job j
              LEFT JOIN category c ON j.category_id = c.id
              LEFT JOIN user_table u ON j.engineer_id = u.id
              WHERE j.user_id = $loggedInUserID"; // Assuming 'user_id' refers to the ID of the customer who requested the job


    $result = $mysqli->query($query);

    if ($result->num_rows > 0) {
        $counter = 1; // Initializing counter
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $counter . "</td>"; // Displaying sequential number
            echo "<td>{$row['date']}</td>";
            echo "<td>{$row['category_name']}</td>";
            echo "<td>{$row['description']}</td>";
            echo "<td>{$row['job_status']}</td>";
            echo "<td>{$row['engineer_name']}</td>";
            
            // Check if feedback is valid (non-empty)
            if (!empty($row['feedback'])) {
                $feedback = $row['feedback'];
                $query = "SELECT feedback FROM job WHERE id={$row['id']}";

                $feedback_result = $mysqli->query($query);

                if ($feedback_result && $feedback_result->num_rows > 0) {
                    $feedback = $feedback_result->fetch_assoc();
                    echo "<td>{$feedback['feedback']}</td>";
                } else {
                    echo "Invalid feedback";
                }
            } else {
            // Feedback button
            echo "<td><button class='btn btn-primary' onclick='location.href=\"feedback.php?job_id={$row['id']}\"'>Provide Feedback</button></td>";
            }
            echo "<td>";
            echo "<a href='edit.php?id=" . $row["id"] . "'><button>Edit</button></a>&nbsp;";
            echo "<a href='delete.php?id=" . $row["id"] . "'><button>Delete</button></a>";
           echo "</td>";
            echo "</tr>";
            $counter++;
        }
    } else {
        echo "Error: " . $mysqli->error;
    }

    // Close the database connection
    $mysqli->close();
    ?>
    </tbody>
</table>

<!-- Footer -->
<footer class="footer">
<p>&copy; 2023 Homefix. All rights reserved.</p>
</footer>

</body>
</html>
