<!DOCTYPE html>
<html>
<head>
    <title>Online Quiz  Application</title>
    <style>
        /* Style for the entire body */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url("quiz.jpg");
            background-position: center center;
                background-repeat: no-repeat;
                background-attachment: fixed;
                background-size: cover;
                backdrop-filter: blur(8px);
            
        }

        /* Style for the header */
        header {
            background-color:#ADD8E6;
            color: black;
            padding: 15px 0;
            text-align: right;
        }

        header .container {
            width: 80%;
            margin: 0 auto;
        }

        /* Style for the main content */
        main {
            padding: 20px;
        }

        /* Style for the menu */
        .menu {
            text-align: center;
        }

        .menu a {
            display: inline-block;
            margin: 10px;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }

        .menu a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
        <a href="logout.php" class="button"> Logout</a>
        </div>
    </header>
    <main>
        <div class="menu">
        <h1> hi, Welcome to the  Online Quiz Application System</h1>

            <a href="take.php" class="button">Take a quiz</a>
        </div>

    </main>
        </div>
</body>
</html>
