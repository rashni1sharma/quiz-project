<?php
// Establish connection to the database (replace with your database credentials)
include('connection.php');

// Initialize variables for scoring
$score = 0;
$total_questions = 0;

// Check if form data has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") 
    // Loop through each submitted question
    foreach ($_POST as $question_id => $selected_choice) {
        // Prepare SQL statement to select correct answer for the question
        $sql = "SELECT correct_choice FROM choices WHERE question_id = '$question_id' AND is_correct = 1";
        $result = $conn->query($sql);

        // Check if a row was returned
       if ($result->num_rows > 0) {
            $row = $result->num_rows();
            $correct_choice = $row["correct_choice"];

           // Compare submitted choice with correct choice
if ($selected_choice == $correct_choice) {
    $score++; // Increment score if correct
}
$total_questions++; // Increment total questions

        }
    }


// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Submission Result</title>
</head>
<body>
<div id="quiz-result">
    <h2>Quiz Submission Result</h2>
    <p>Total Questions: <?php echo $total_questions; ?></p>
    <p>Correct Answers: <?php echo $score; ?></p>
</div>
</body>
</html>

