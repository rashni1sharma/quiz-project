<?php
session_start();

// Check if the user is already logged in
if(isset($_SESSION['admin_id'])) {
    header("Location: dashboard.php");
    exit;
}

// Check if the login form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate credentials (replace with your own validation logic)
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if username and password match (replace with your own authentication logic)
    if($username === 'admin' && $password === 'password') {
        // Authentication successful, set session variables
        $_SESSION['admin_id'] = 1; // Example admin ID
        header("Location: dashboard.php");
        exit;
    } else {
        // Authentication failed
        $login_error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
</head>
<body>
    <h2>Admin Login</h2>
    <form method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Login">
    </form>
    <?php if(isset($login_error)) { echo $login_error; } ?>
</body>
</html>
