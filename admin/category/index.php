
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <title>Category List</title>
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
<br><br><br><br><br><br><br>
<!-- Category Table -->
<div class="container">
<button class="btn btn-primary" onclick="location.href='create.php'">New Category</button>
    <h2 style="text-align: center;">Category List</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Number</th>
                <th>Name</th>
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
        $sql = "SELECT * FROM category";
        $result = $mysqli->query($sql);

        if ($result->num_rows > 0) {
            $counter = 1; // Initializing counter
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $counter . "</td>"; // Displaying sequential number
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>";
                echo "<a href='edit.php?id="  . $row["id"] . "'><button>Edit</button></a>&nbsp;";
                echo "<a href='delete.php?id=" . $row["id"] . "'><button>Delete</button></a>";
                echo "</td>";
                echo "</tr>";
                $counter++;
            }
        } else {
            echo "<tr><td colspan='5'>No data found</td></tr>";
        }
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
