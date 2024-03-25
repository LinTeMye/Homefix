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
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
<script>
    $(document).ready(function() {
        $('#jobTable').DataTable(); // Initialize DataTable
    });
</script>
    <title>Job List</title>
</head>
<body>
<!-- Navigation Bar -->
<div class="navbar">
    <div class="logo">
        <h5>HomeFix</h5>
    </div>
    <ul class="nav-links">
        <li><a href="index.php" class="w3-bar-item w3-button">Home</a></li>
        <li><a href="Job/index.php" class="w3-bar-item w3-button">Jobs</a></li>
        <li><a href="engineer/index.php" class="w3-bar-item w3 button">Engineer</a></li>
        <li><a href="category/index.php" class="w3-bar-item w3 button">Category</a></li> 
        <li><a href="feedback/index.php" class="w3-w3-bar-item w3 button">Feedback</a></li>
        <li> <a href="../logout.php" class="w3-bar-item w3-button">Logout</a></li>         
    </ul>
</div>
<br><br>
<h2 style="text-align: center;">This week completed Job</h2>

<table id="jobTable" class="table table-bordered">
    <thead>
        <tr>
            <th>Number</th>
            <th>Date</th>
            <th>User Name</th>
            <th>Category</th>
            <th>Description</th>
            <th>Status</th>
            <th>Engineer</th>
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
  
  // Get the current week number
  $currentWeek = date('W');
  $query = "SELECT j.id, j.date, u.name, u.email, u.ph_number, u.address, c.name AS category_name, j.description, j.job_status, j.engineer_id
            FROM job j
            LEFT JOIN user_table u ON j.user_id = u.id
            LEFT JOIN category c ON j.category_id = c.id
            WHERE j.job_status = 'Complete' AND WEEK(j.date) = \"$currentWeek\"";
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
            // // Check if engineer_id is valid (non-empty)
            // if (!empty($row['engineer_id'])) {
            //     $engineer_id = $row['engineer_id'];
            //     $query = "SELECT name FROM user_table WHERE id = '$engineer_id'";
            //     $engineer_result = $mysqli->query($query);

            //     if ($engineer_result && $engineer_result->num_rows > 0) {
            //         $engineer = $engineer_result->fetch_assoc();
            //         echo $engineer['name'];
            //     } else {
            //         echo "Invalid Engineer";
            //     }
            // } else {
                // If engineer_id is empty, show the button
            //     echo "<button class='assign-engineer-btn' data-job-id='{$row['id']}' data-toggle='modal' data-target='#assignEngineerModal'>Assign Engineer</button>";
            // }

            echo "</td>";
            echo "<td>";
            echo "<a href='job/view.php?id=" . $row["id"] . "'><button>View</button></a>&nbsp;";
            echo "</td>";
            echo "</tr>";
            $counter++;
            }
    } else {
        echo " " . $mysqli->error;
    }
    $mysqli->close();
    

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['engineer_id'])) {
        $mysqli = new mysqli('localhost', 'root', '', 'customerservices');

        if ($mysqli->connect_errno) {
            echo "Failed to connect to MySQL: " . $mysqli->connect_error;
            exit();
        }

        $engineer_id = $mysqli->real_escape_string($_POST['engineer_id']);
        // Get the job ID 
        $job_id = $_POST['job_id']; 
        // Update the engineer_id in the job table
        $update_query = "UPDATE job SET engineer_id = '$engineer_id', job_status = 'Accepted' WHERE id = '$job_id'";
    
        if ($mysqli->query($update_query)) {
            // Success message or redirection
            echo "Engineer assigned successfully!";
        } else {
            echo "Error updating record: " . $mysqli->error;
        }
    
        $mysqli->close();
        exit(); 
    } 
?>
    </tbody>
</table>
<script>
    $('.assign-engineer-btn').click(function() {
        var jobId = $(this).data('job-id');
        $('#job_id').val(jobId);
    });
</script>
</body>
</html>