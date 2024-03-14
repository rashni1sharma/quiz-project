<?php
// Establish connection to the database (replace with your database credentials)
include('connection.php');

// Prepare SQL statement to select data
$sql = "SELECT * FROM questions";
$sql2 = "SELECT * FROM ";
// Execute SQL statement
$result = $conn->query($sql);
// Check if any rows were returned
if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        $qno = $row["question_id"];
        $question = $row["question_text"];
        echo '<form method="post" action="submission.php"> ';
        echo '<div id="question">' . $qno . $question . '</div>';
        echo '<div id="choices">';

        $sql2 = "SELECT * FROM  choices where question_id ='$qno'";
        $result2 = $conn->query($sql2);
        if ($result2->num_rows > 0) {
            while ($row = $result2->fetch_assoc()) {
                $choice = $row["choice_text"];

                echo '<label><input type="radio" name="' . $qno . '" value="' . $choice . '">' . $choice . '</label>';
                echo '</div>';
            }
        }
        // Else block was commented out, so I'm not including it here
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
    <title></title>
    <style>
        /* CSS for Quiz Application */
        #quiz-container {
            width: 80%;
            margin: auto;
            text-align: center;
            margin-top: 50px;
        }

        #question {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        #choices {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 10px;
        }

        label {
            display: block;
        }

        input[type="radio"] {
            margin-right: 5px;
        }

        #submit-btn {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #submit-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div id="quiz-container">
    <form method="post" action="gain.php">
        <!-- <div id="question">Which company developed the Java programming language?</div>
        <div id="choices">
            <label><input type="radio" name="choices[]" value="Microsoft">Microsoft  </label>
            <label><input type="radio" name="choices[]" value="IBM">  IBM</label>
            <label><input type="radio" name="choices[]" value=" Sun Microsystems"> Sun Microsystems </label>
            <label><input type="radio" name="choices[]" value="Oracle ">Oracle  </label>
        </div> -->
        <button type="submit" id="submit-btn">Submit Answer</button>
    </form>
</div>
</body>
</html>
