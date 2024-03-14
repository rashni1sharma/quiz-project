<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz</title>
    <style>
        /* Body styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        /* Header styles */
        header {
            color: black;
            padding: 20px 0;
            text-align: center;
        }

        header p {
            font-size: 24px;
        }

        /* Main styles */
        main {
            margin-top: 20px;
        }

        /* Container styles */
        .container {
            max-width: 600px;
            margin: 0 auto;
            border-radius: 8px;
            padding: 20px;
        }

        /* Form styles */
        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="number"] {
            width: calc(100% - 10px);
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            width: 100px;
            padding: 10px;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <p>Test Your Knowledge</p>
        </div>
    </header>
    <main>
        <div class="container">
            <h2>Add a Question</h2>
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <p>
                    <label>Question Number:</label>
                    <input type="number" name="question_number" value="">
                </p>
                <p>
                    <label>Question Text:</label>
                    <input type="text" name="question_text">
                </p>
                <p>
                    <label>Choice 1:</label>
                    <input type="text" name="choice_1">
                </p>
                <p>
                    <label>Choice 2:</label>
                    <input type="text" name="choice_2">
                </p>
                <p>
                    <label>Choice 3:</label>
                    <input type="text" name="choice_3">
                </p>
                <p>
                    <label>Choice 4:</label>
                    <input type="text" name="choice_4">
                </p>
                <p>
                    <label>Correct Option Number:</label>
                    <input type="number" name="correct_choice">
                </p>
                <input type="submit" name="submit" value="Submit">
            </form>
        </div>
    </main>
</body>
</html>

<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection parameters
    $servername = "localhost"; // Change this to your database server name
    $username = "username"; // Change this to your database username
    $password = "password"; // Change this to your database password
    $dbname = "quiz"; // Change this to your database name

    // Create connection
    $conn = mysqli_connect('localhost', 'root', '', 'user_db');

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Prepare and bind the INSERT statement
    $stmt = $conn->prepare("INSERT INTO Options (QuestionID, OptionText, IsCorrect) VALUES (?, ?, ?)");
    $stmt->bind_param( $questionID, $optionText, $isCorrect);

    // Set parameters and execute the statement
    $questionID = $_POST["question_number"];
    $optionTexts = array($_POST["choice_1"], $_POST["choice_2"], $_POST["choice_3"], $_POST["choice_4"]);
    $correctOption = $_POST["correct_choice"];

    foreach ($optionTexts as $key => $optionText) {
        // Determine if the option is correct based on the correct_choice value
        $isCorrect = ($key + 1 == $correctOption) ? 1 : 0;

        // Insert the option into the database
        $stmt->execute();
    }

    // Close the statement and database connection
    $stmt->close();
    $conn->close();
}
?>
