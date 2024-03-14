<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
$conn = mysqli_connect('localhost', 'root', '', 'admin');
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$question_text = $_POST['question_text'];
$correct_option = $_POST['correct_option'];
$option1 = $_POST['option1'];
// Add more options as needed

$sql = "INSERT INTO questions (question_text, correct_option, option1, ...) VALUES ('$question_text', $correct_option, '$option1', ...)";
// Execute the SQL query to insert the question
// Redirect to admin panel or display a success message
?>
<DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Question Form</title>
<!-- CSS Styles -->
<style>
/* Style for form container */
form {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #f9f9f9;
}

/* Style for labels */
label {
    font-weight: bold;
}

/* Style for text inputs and select */
input[type="text"],
select {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

/* Style for Add Option button */
#add_option {
    display: block;
    margin-top: 10px;
    margin-bottom: 20px;
    padding: 10px 20px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

#add_option:hover {
    background-color: #45a049;
}

/* Style for submit button */
input[type="submit"] {
    padding: 10px 20px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #45a049;
}
</style>
</head>
<body>
<!-- Add Question Form -->
<form method="post" action="add_question.php">
    <label for="question_text">Question:</label><br>
    <input type="text" id="question_text" name="question_text" required><br>
    <!-- Options -->
    <div id="options_container">
        <label for="option1">Option 1:</label><br>
        <input type="text" id="option1" name="options[]" required><br>
    </div>
    <!-- Add more options as needed -->
    <button type="button" id="add_option">Add Option</button><br><br>
    <label for="correct_option">Correct Option:</label>
    <select id="correct_option" name="correct_option">
        <!-- Options will be populated dynamically -->
    </select><br><br>
    <input type="submit" value="Add Question">
</form>
<!-- JavaScript -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Add Option button functionality
    const addOptionButton = document.getElementById("add_option");
    addOptionButton.addEventListener("click", function() {
        const optionsContainer = document.getElementById("options_container");
        const optionInput = document.createElement("input");
        optionInput.type = "text";
        optionInput.name = "options[]";
        optionInput.required = true;
        optionsContainer.appendChild(optionInput);
        optionsContainer.appendChild(document.createElement("br"));
    });
});
</script>
</body>
</html>
