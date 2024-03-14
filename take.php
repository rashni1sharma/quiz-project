<?php
// Database connection
$servername = "localhost"; // Change this to your database server hostname
$username = "username"; // Change this to your database username
$password = "password"; // Change this to your database password
$database = "quiz_database"; // Change this to your database name


// Create connection
$conn = mysqli_connect('localhost', 'root', '', 'user_db');
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
// Function to get quiz questions from the database
function getQuizQuestions($conn) {
    $sql = "SELECT * FROM questions";
    $result = $conn->query($sql);

    $questions = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $questions[] = $row;
        }
    }

    return $questions;
}

// Function to insert a new quiz response into the database
function insertQuizResponse($conn, $questionId, $userId, $selectedOption, $isCorrect) {
    $sql = "INSERT INTO responses (question_id, user_id, selected_option, is_correct) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiss", $questionId, $userId, $selectedOption, $isCorrect);
    $stmt->execute();
    $stmt->close();
}

// Function to update the score for a user
function updateScore($conn, $userId, $score) {
    $sql = "UPDATE users SET score = ? WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $score, $userId);
    $stmt->execute();
    $stmt->close();
}

// Close connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Quiz Website</title>
  <style>
    /* CSS Styles */
    body {
      font-family: Arial, sans-serif;
      background-color: #f5f5f5;
      margin: 0;
      padding: 0;
    }

    #quiz-container {
      max-width: 600px;
      margin: 50px auto;
      padding: 20px;
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      text-align: center;
    }

    h1 {
      color: #333;
    }

    #question {
      margin-bottom: 20px;
    }

    #options button {
      margin: 5px;
      padding: 10px 20px;
      font-size: 16px;
      background-color: #007bff;
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    #options button:hover {
      background-color: #0056b3;
    }

    #submit {
      margin-top: 20px;
      padding: 10px 20px;
      font-size: 16px;
      background-color: #28a745;
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    #submit:hover {
      background-color: #218838;
    }

    #result {
      margin-top: 20px;
      font-size: 18px;
      font-weight: bold;
    }

    #timer {
      margin-top: 20px;
    }

    #correct-answer {
      margin-top: 20px;
      color: #dc3545;
    }

    #history {
      margin-top: 20px;
      text-align: left;
    }

    #history h2 {
      font-size: 20px;
      margin-bottom: 10px;
    }

    #history div {
      margin-bottom: 10px;
    }
  </style>
</head>
<body>
  <div id="quiz-container">
    <h1>Quiz Time!</h1>
    <div id="question"></div>
    <div id="options"></div>
    <button id="submit">Submit</button>
    <div id="result"></div>
    <div id="timer">Time Left: <span id="time-left"></span></div>
    <div id="correct-answer"></div>
    <div id="history"></div>
  </div>
  <script>
    // JavaScript Code
    const quizData = [
      {
        question: 'What is the full form of sql?',
        options: ['structure query language', 'simple  query language', 'simple  question language', 'structure question level'],
        answer: 'structure query language'
      },
      {
        question: 'What is the capital of France?',
        options: ['Paris', 'London', 'Berlin', 'Rome'],
        answer: 'Paris'
      },
      
      {
        question: 'What is the largest mammal?',
        options: ['Elephant', 'Blue Whale', 'Giraffe', 'Hippopotamus'],
        answer: 'Blue Whale'
      },
      {
        question: 'What is the chemical symbol for water?',
        options: ['O', 'W', 'H2O', 'H'],
        answer: 'H2O'
      },
      {
        question: '   who is the founder of linux?',
        options: [' linus Torvalds', 'steve jobs', 'roshani sharma', 'linus jobs'],
        answer: 'linus Torvalds'
      },
    ];

    const quizContainer = document.getElementById('quiz-container');
    const questionElement = document.getElementById('question');
    const optionsElement = document.getElementById('options');
    const submitButton = document.getElementById('submit');
    const resultElement = document.getElementById('result');
    const timerElement = document.getElementById('time-left');
    const correctAnswerElement = document.getElementById('correct-answer');
    const historyElement = document.getElementById('history');

    let currentQuestion = 0;
    let score = 0;
    let timeLeft = 30; // Set the initial time limit
    let userAnswers = []; // Array to store user answers

    let timerInterval; // Declare timerInterval here

    function showQuestion() {
      const currentQuiz = quizData[currentQuestion];
      questionElement.textContent = currentQuiz.question;

      optionsElement.innerHTML = '';
      currentQuiz.options.forEach(option => {
        const button = document.createElement('button');
        button.textContent = option;
        button.onclick = () => checkAnswer(option);
        optionsElement.appendChild(button);
      });
    }

    function checkAnswer(option) {
      const currentQuiz = quizData[currentQuestion];
      userAnswers.push({ question: currentQuiz.question, answer: option }); // Store user's answer
      if (option === currentQuiz.answer) {
        score++;
      } else {
        correctAnswerElement.textContent = `Correct Answer: ${currentQuiz.answer}`;
      }
      currentQuestion++;
      if (currentQuestion < quizData.length) {
        showQuestion();
      } else {
        showResult();
      }
    }

    function showResult() {
      quizContainer.style.display = 'none';
      clearInterval(timerInterval); // Stop the timer
      resultElement.textContent = `You scored ${score}/${quizData.length}`;
      showHistory();
    }

    function showHistory() {
      historyElement.innerHTML = '<h2>Quiz History</h2>';
      userAnswers.forEach((answer, index) => {
        const historyItem = document.createElement('div');
        historyItem.innerHTML = `<strong>Question ${index + 1}:</strong> ${answer.question}<br>
                                 <strong>Your Answer:</strong> ${answer.answer}<br><br>`;
        historyElement.appendChild(historyItem);
      });
    }

    showQuestion();

    // Timer functionality
    timerInterval = setInterval(() => { // Assign timerInterval here
      timeLeft--;
      timerElement.textContent = timeLeft;

      if (timeLeft <= 0) {
        clearInterval(timerInterval);
        showResult();
      }
    }, 1000);

    submitButton.addEventListener('click', () => {
      if (currentQuestion < quizData.length) {
        alert('Please select an option!');
      } else {
        showResult();
      }
    });
  </script>
</body>
</html>
