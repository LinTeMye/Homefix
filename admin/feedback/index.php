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
    <title>Extended Job List</title>
</head>
<body>

<!-- Navigation Bar -->
<div class="navbar">
    <div class="logo">
        <h5>HomeFix</h5>
    </div>
    <ul class="nav-links">
        <li><a href="../index.php" class="w3-bar-item w3-button">Home</a></li>
        <li><a href="../Job/index.php" class="w3-bar-item w3-button">Jobs</a></li>
        <li><a href="../engineer/index.php" class="w3-bar-item w3 button">Engineer</a></li>
        <li><a href="../category/index.php" class="w3-bar-item w3 button">Category</a></li> 
        <li><a href="index.php" class="w3-w3-bar-item w3 button">Feedback</a></li>
        <li> <a href="../logout.php" class="w3-bar-item w3-button">Logout</a></li>
    </ul>
</div>
<!-- ... (same as your existing page) ... -->
<br><br>
<h2 style="text-align: center;">Feedback Table</h2>

<table id="extendedJobTable" class="table table-bordered">
    <thead>
        <tr>
            <th>Number</th>
            <th>Date</th>
            <th>User Name</th>
            <th>Category</th>
            <th>Description</th>
            <th>Status</th>
            <th>Assign Engineer</th>
            <th>Feedback</th>
            <th>Rank</th>
            <th>Detail</th>
        </tr>
    </thead>
    <tbody>
    <div class="modal fade" id="assignEngineerModal" tabindex="-1" role="dialog" aria-labelledby="assignEngineerModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignEngineerModalLabel">Assign Engineer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="index.php" method="POST">
                    <input type="hidden" name="job_id" id="job_id">
                    <div class="form-group">
                        <label for="engineerSelect">Select Engineer:</label>
                        <select class="form-control" id="engineerSelect" name="engineer_id">
                            <?php
                            $mysqli = new mysqli('localhost', 'root', '', 'customerservices');
                            if ($mysqli->connect_errno) {
                                echo "Failed to connect to MySQL: " . $mysqli->connect_error;
                                exit();
                            }
                            // Fetch engineers with role_id = 2
                            $query = "SELECT id, name FROM user_table WHERE role_id = 2";
                            $result = $mysqli->query($query);

                            if ($result && $result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='{$row['id']}'>{$row['name']}</option>";
                                }
                            } else {
                                echo "<option value=''>No Engineers Found</option>";
                            }

                            $mysqli->close();
                            ?>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
   
<?php
$mysqli = new mysqli('localhost', 'root', '', 'customerservices');
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

$query = "SELECT j.id, j.date, u.name, u.email, u.ph_number, u.address, c.name AS category_name, 
          j.description, j.job_status, j.engineer_id, j.feedback, j.rank
          FROM job j
          LEFT JOIN user_table u ON j.user_id = u.id
          LEFT JOIN category c ON j.category_id = c.id
            WHERE j.job_status = 'Complete'";
$result = $mysqli->query($query);

if ($result->num_rows > 0) {
    $counter = 1; // Initializing counter
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $counter . "</td>"; // Displaying sequential number
        echo "<td>{$row['date']}</td>";
        echo "<td>{$row['name']}</td>";
        echo "<td>{$row['category_name']}</td>";
        echo "<td>{$row['description']}</td>";
        echo "<td>{$row['job_status']}</td>";
        echo "<td>";

        if (!empty($row['engineer_id'])) {
            $engineer_id = $row['engineer_id'];
            $query = "SELECT name FROM user_table WHERE id = '$engineer_id'";
            $engineer_result = $mysqli->query($query);

            if ($engineer_result && $engineer_result->num_rows > 0) {
                $engineer = $engineer_result->fetch_assoc();
                echo $engineer['name'];
            } else {
                echo "Invalid Engineer";
            }
        } else {
            // If engineer_id is empty, show the button
            echo "<button class='assign-engineer-btn' data-job-id='{$row['id']}' data-toggle='modal' data-target='#assignEngineerModal'>Assign Engineer</button>";
        }

        echo "</td>";
        echo "<td>{$row['feedback']}</td>";
        echo "<td>{$row['rank']}</td>";
        echo "<td>";
        echo "<a href='../Job/view.php?id=" . $row["id"] . "'><button>View</button></a>&nbsp;";
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
<script>
    $(document).ready(function() {
        $('#extendedJobTable').DataTable(); 
    });
</script>

</body>
</html>
