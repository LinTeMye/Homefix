<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <title>Engineer List</title>
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
        <li><a href="../feedback/index.php" class="w3-w3-bar-item w3 button">Feedback</a></li> 
        <li> <a href="../logout.php" class="w3-bar-item w3-button">Logout</a></li>    
    </ul>
</div>
<br><br><br><br>
<!-- Engineer Table -->
<div class="container">
    <button class="btn btn-primary" onclick="location.href='engineer.php'">New Engineer</button>
    <h2 style="text-align: center;">Engineer List</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Number</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
        
            // Establish a connection to your database
            $mysqli = new mysqli('localhost', 'root', '', 'customerservices');

            // Check connection
            if ($mysqli->connect_error) {
                die("Connection failed: " . $mysqli->connect_error);
            }

            // Fetch data where role_id is 2
            $sql = "SELECT * FROM user_table WHERE role_id = 2";
            $result = $mysqli->query($sql);

            if ($result->num_rows > 0) {
                $counter = 1; // Initializing counter
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $counter . "</td>"; // Displaying sequential number
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . $row['ph_number'] . "</td>";
                    echo "<td>";
                    echo "<a href='edit.php?id=" . $row["id"] . "'><button>Edit</button></a>&nbsp;";
                    echo "<a href='delete.php?id=" . $row["id"] . "'><button>Delete</button></a>";
                    echo "</td>";
                    echo "</tr>";
                    $counter++;
                }
            } else {
                echo "<tr><td colspan='5'>No data found</td></tr>";
            }

            // Close connection
            $mysqli->close();
            ?>
        </tbody>
    </table>
</div>
<!-- Footer -->
<footer class="footer">
    <p>&copy; 2023 Homefix. All rights reserved.</p>
</footer>
</body>

</html>
