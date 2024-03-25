<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>Engineer's Assigned Jobs</title>
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
        <li><a href="logout.php" class="w3-bar-item w3-button">Log out</a></li>   
       
    </ul>
</div>
<br><br>
<h2 style="text-align: center;">Engineer's Assigned Jobs</h2>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Number</th>
            <th>Date</th>
            <th>User Name</th>
            <th>Category</th>
            <th>Description</th>
            <th>Status</th>
            <th>Detail</th>
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
    // Fetch data for the engineer's assigned jobs
    $engineer_id = $_SESSION['user_id']; 
    $query = "SELECT j.id, j.date, u.name, c.name AS category_name, j.description, j.job_status
              FROM job j
              LEFT JOIN user_table u ON j.user_id = u.id
              LEFT JOIN category c ON j.category_id = c.id
              WHERE j.engineer_id = $engineer_id";

    $result = $mysqli->query($query);
    if ($result->num_rows > 0) {
        $counter = 1; 
        
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $counter . "</td>"; 
            echo "<td>{$row['date']}</td>";
            echo "<td>{$row['name']}</td>";
            echo "<td>{$row['category_name']}</td>";
            echo "<td>{$row['description']}</td>";
            echo "<td>{$row['job_status']}</td>";
            echo "<td>";
            echo "<a href='view.php?id=" . $row["id"] . "'><button>View</button></a>&nbsp;";
            echo "<a href='job_complete.php?id=" . $row["id"] . "'><button>Complete</button></a>&nbsp;";
            echo "</td>";
            echo "</tr>";
            $counter++;
        }
    } else {
        echo "Error: " . $mysqli->error;
    }
    $mysqli->close();
    ?>
    </tbody>
</table>


</body>
</html>
