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

$name= $email = $password ="";
$emailErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
    
    $name = test_input($_POST["name"]);
    $email = test_input($_POST["email"]);
    $checkEmailQuery = "SELECT * FROM signup WHERE email = ?";
    $checkEmailStmt = $conn->prepare($checkEmailQuery);
    $checkEmailStmt->bind_param("s", $email);
    
    $checkEmailStmt->execute();
    $checkEmailResult = $checkEmailStmt->get_result();
    if ($checkEmailResult->num_rows > 0) {
        $emailErr = "Email is already taken";
    }
    // Close the statement
    $checkEmailStmt->close();
    
    $password = test_input($_POST["password"]);

    if (empty($emailErr)) {
        // Hash the password for security
        $password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO signup (name,email,password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss",$name, $email, $password);
        $stmt->execute();
        $stmt->close();
        header("Location: login.php");
        exit();
    }
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orphanage Sign Up</title>
    <style>
    body{
        background-image: url("shadow.jpg");
            background-size: cover;
        display: flex;
        justify-content: center;
    }

    .container {
    max-width: 100%;
    padding: 100px;
    border-radius: 2px;
    }
    form{
        background-color: rgb(238, 238, 218);
    backdrop-filter: blur(100px);
    padding: 20px;
    border-radius: 8px; 
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    max-width: 22vw;
    }

    .input-group {
        margin-bottom: 15px;
        padding: 5px;
        width:100%;

    }

    h2{
        text-align: center;
    }

    .input-group label {
        display: block;
        margin-bottom: 5px;
    }

    .input-group input {
        width: 100%;
        border-radius: 2px;
        border: 1px solid #ccc;
    }

    .error {
        color: red;
        font-size: 14px;
    }

    .button{
        display:flex;
        justify-content:center;
    }
    .btn {
        background-color: #007bff;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 2px;
        cursor: pointer;
    }

    .btn:hover {
        background-color: #0056b3;
    }
    </style>

    <script>
    function validateForm() {
        var name = document.getElementById("name").value;
        var email = document.getElementById("email").value;
        var password = document.getElementById("password").value;
        var confirmPassword = document.getElementById("confirmPassword").value;

        // Reset previous error messages
        document.getElementById("nameErr").innerText = "";
        document.getElementById("emailErr").innerText = "";
        document.getElementById("passwordErr").innerText = "";
        document.getElementById("confirmPasswordErr").innerText = "";

        // Validate name
        if (name === "") {
            document.getElementById("nameErr").innerText = "Name is required";
            return false;
        }

        var nameFormat = /^[a-zA-Z]+[a-zA-Z\s]*?[^0-9]$/;
        if (!(name.match(nameFormat))) {
            document.getElementById("nameErr").innerText = "Enter a valid name";
            return false;
        }

        // Validate email
        if (email === "") {
            document.getElementById("emailErr").innerText = "Email is required";
            return false;
        }

        var mailFormat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        if(!(email.match(mailFormat)))
        {
            document.getElementById("emailErr").innerText = "Please enter a valid email";
            return false;
        }

        // Validate password
        if (password === "") {
            document.getElementById("passwordErr").innerText = "Password is required";
            return false;
        }

        if(password.length<8){
            document.getElementById("passwordErr").innerText = "Password must be at least 8 characters long";
            return false;
        }

        // Validate Confirm password
        if (confirmPassword === "") {
            document.getElementById("confirmPasswordErr").innerText = "Please confirm the password";
            return false;
        }

        // Check if Passwords match
        if (password !== confirmPassword) {
            document.getElementById("confirmPasswordErr").innerText = "Passwords do not match";
            return false;
        }

        return true;
    }
</script>

</head>
<body>

    <div class="container">
        <form action="signup.php" method="post" id="signupForm" onsubmit="return validateForm()">
            <h2>Sign Up</h2>
            <div class="input-group">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" value="<?php echo $name ?>">
                <span class="error" id="nameErr"></span>
                <br>
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" value="<?php echo $email ?>">
                <span class="error" id="emailErr"><?php echo $emailErr ?></span>
                <br>
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" value="<?php echo $password ?>">
                <span class="error" id="passwordErr"></span>
                <br>
                <label for="confirmPassword">Confirm password:</label>
                <input type="password" name="confirmPassword" id="confirmPassword">
                <span class="error" id="confirmPasswordErr"></span>
                <br>
                <div class="button">
                <button type="submit" class="btn" name="register">Sign Up</button>
                </div>
                <p>Already have an account? <a class="toggle-button" href="login.php">Click here</a> to log in.</p>    
            </div>

        </form>
    </div>

</body>
</html>