<?php
include("admin/connection.php");
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phonenumber = $_POST['phonenumber'];
    $address = $_POST['address'];
    $postcode = $_POST['postcode'];
    $gender = $_POST['gender'];

    // Validate user input
    $errors = [];

    if (empty($name)) {
        $errors[] = "Name is required";
    }

    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }

    if (empty($password)) {
        $errors[] = "Password is required";
    } elseif (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters long";
    }

    if (empty($phonenumber)) {
        $errors[] = "Phone number is required";
        
    }

    if (empty($address)) {
        $errors[] = "Address is required";
    }

    if (empty($postcode)) {
        $errors[] = "Postcode is required";
    }

    if (empty($gender)) {
        $errors[] = "Gender is required";
    }

    // Check if email is already taken
    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT * FROM user_table WHERE email = :email");
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $errors[] = "Email is already taken";
        }
    }

 // Insert new user data into the database
 if (empty($errors)) {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Set the default role_id value to 1
    $defaultRoleId = 1;

    $stmt = $conn->prepare("INSERT INTO user_table (name, email, password, ph_number, address, postcode, gender, role_id) VALUES (:name, :email, :password, :ph_number, :address, :postcode, :gender, :role_id)");
    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":password", $hashedPassword);
    $stmt->bindParam(":ph_number", $phonenumber);
    $stmt->bindParam(":address", $address);
    $stmt->bindParam(":postcode", $postcode);
    $stmt->bindParam(":gender", $gender);
    $stmt->bindParam(":role_id", $defaultRoleId); // Bind the default role_id value

    $stmt->execute();

    // Redirect to login page
    header("Location: login.php");
    exit();

        
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="homefix photo/sign-in-account.png" type="image/x-icon">
    <link rel="stylesheet" href="css/style.css">
    <title>Sign up</title>
</head>
<body class="login">
    <div class="flex-container">
            <div class="left-content">
                <div class="left-container">
                <img src="homefix photo/icons8-services.gif" alt="engineering  icon">
                <div class="info">
                    <h2>Homefix Appliance Services</h2>
                    <p>We provide you with services of your choice.</p>
                </div>
            </div>
            <div class="left-container">
                <img src="homefix photo/icons8-administrative-tools-80.png" alt="engineering  icon">
                <div class="info">
                    <h2>Pushing Boundaries</h2>
                    <p>Breaking Barriers with Innovative Repairs and Maintenance </p>
                </div>
            </div>
            <div class="left-container">
                <img src="homefix photo/maledev.png" alt="engineering  icon">
                <div class="info">
                    <h2>Homefix</h2>
                    <p>Where Creativity Meets Functionality</p>
                </div>
            </div>
            <div class="left-container">
                <img src="homefix photo/icons8-support.svg" alt="engineering  icon">
                <div class="info">
                    <h2>Engineering Support</h2>
                    <p>Building the Future: Innovative Solutions Engineered to Perfection.</p>
                </div>
            </div>
            </div>
        <div class="content-width">
            <div class="right-content">
                    <div class="same-level">
                        <h1>Sign Up Page</h1>
                        <p>Have an Account?<a href="login.php"> Sign In</a></p>
                    </div>
             
                <form action="sign_up.php" method="post">
                <?php if (!empty($errors)): ?>
                     <div class="error-messages">
                 <ul>
                    <?php foreach ($errors as $error): ?>
                    <li><?php echo $error; ?></li>
                     <?php endforeach; ?>
                 </ul>
                    </div>
                 <?php endif; ?>
                    <div class="working-name">
                            <label for="Name">Name</label><br>
                    
                        <input type="text" id="name" name="name"  required placeholder=" Enter Your Name"><br><br>
                        <label for="email">email</label><br>
                        <input type="text" id="email" name="email" placeholder=" Enter Your email" required><br><br>
                  
                        <label for="password">Password</label><br>
                        <input type="text" id="password" name="password" placeholder=" Enter your password"  required><br><br>
        
                        <label for="phonenumber">Phone Number</label><br>
                        <input type="tel" name="phonenumber" id="phonenumber" placeholder=" Phone Number"><br><br> 
                        
                        <label for="address">Address</label><br>
                        <input type="text" id="address" name="address"placeholder=" Enter your Address" required><br><br>
                        <label for="postcode">Postcodes</label><br>
                        <input type="text" id="postcode" name="postcode"placeholder=" Enter your Postcode"  required><br><br>
                       
                    <label for="gender">Gender</label><br>
                    <select id="gender" name="gender" required>
                    <option value="">Select</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    </select><br><br>
                    </div>
                    <div class="buttonup">
                    <button type="submit" name="submit">Sign Up</button>
                    </div> 



            </form>
            </div>
        </div>
    </div>
</body>
</html>