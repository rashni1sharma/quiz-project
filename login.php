<?php
session_start(); // Start session

$servername = "localhost";
$username = "username";
$password = "password";
$database = "your_database";

// Create connection
$conn = mysqli_connect('localhost', 'root', '', 'user_db');
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$errors = array(); // Initialize errors array

if(isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, $_POST['password']); 
    $select = "SELECT * FROM user_form WHERE email = '$email' AND password = '$pass'";

    $result = mysqli_query($conn, $select);

    if(mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        if($row['User-Type'] == 'user') {
            $_SESSION['user_name'] = $row['name'];
            header('location:user.php');
            exit(); // Exit after redirection
        }
    } else {
        $errors[] = 'Incorrect email or password!';
    }
}

mysqli_close($conn); // Close connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <style>
        /* Your CSS styles */
        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f9f9f9;
}

.form-container {
    width: 400px;
    margin: 50px auto;
    background-color: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
}

h3 {
    text-align: center;
    color: #333;
    margin-bottom: 30px;
}

input[type="email"],
input[type="password"] {
    width: 100%;
    padding: 15px;
    margin-bottom: 20px;
    border: none;
    border-radius: 5px;
    background-color: #f5f5f5;
    box-sizing: border-box;
    font-size: 16px;
    color: #333;
}

input[type="submit"] {
    width: 100%;
    background-color: #007bff;
    border: none;
    border-radius: 5px;
    color: #fff;
    padding: 15px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s;
}

input[type="submit"]:hover {
    background-color: crimson;
}

.form-btn {
    text-align: center;
    margin-top: 20px;
    font-size: 14px;
}

.form-btn a {
    color: red;
    text-decoration: none;
}

.form-btn a:hover {
    text-decoration: underline;
}

.error-message {
    color: red;
    display: block;
    margin-bottom: 10px;
}

    </style>
</head>
<body>
    <div class="form-container">
        <form action="" method="post">
            <h3>Login</h3>
            <?php
            // Display error messages
            if(!empty($errors)) {
                foreach($errors as $error) {
                    echo '<span class="error-message">' . $error . '</span>';
                }
            }
            ?>

            <input type="email" name="email" required placeholder="Enter Your Email">
            <input type="password" name="password" required placeholder="Enter Your Password">
            <input type="submit" name="submit" value="Login">
            <div class="form-btn">
                <p>Don't have an account? <a href="registration.php">Register Now</a></p>
            </div>
        </form>
    </div>
</body>
</html>
