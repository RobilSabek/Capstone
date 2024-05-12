<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "careerforge";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$limit = 10;
$offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;

$sql = "SELECT * FROM technical_questions LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Technical Questions</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
            text-align: center;
            background-color: #f8f9fa;
            position: relative; 
        }

        h1 {
            color: #343a40;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            background-color: #ffffff;
            border: 1px solid #ced4da;
            margin: 10px 0;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: left;
        }

        .answer {
            font-weight: bold;
            margin-top: 10px;
            display: block;
        }

        a, button {
            text-decoration: none;
            color: #ffffff;
            background-color: #6A5ACD;
            padding: 10px 20px;
            border-radius: 5px;
            margin: 10px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        a:hover, button:hover {
            background-color: #0056b3;
        }

        .navigation-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        #quiz-button-container {
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 2;
        }

        #quiz-button {
           background-color: #6A5ACD;
        }

    </style>
</head>
<body>

    
    
    <div class="navigation-container">
        <a href="quiz.php">Take The Quiz!</a>
    </div>

    <h1>Technical Questions</h1>

    <?php if ($result->num_rows > 0): ?>
        <ul>
            <?php while ($row = $result->fetch_assoc()): ?>
                <li>
                    <p><?= $row['question_text'] ?></p>
                    <span class="answer">Answer: <?= $row['answer'] ?></span>
                </li>
            <?php endwhile; ?>
        </ul>

        <div class="navigation-container">
            <?php if ($offset > 0): ?>
                <!--Previous!-->
                <a href="?offset=<?= max(0, $offset - $limit) ?>">Previous</a>
            <?php endif; ?>

            <?php if ($result->num_rows == $limit): ?>
                <!-- Next-->
                <a href="?offset=<?= $offset + $limit ?>">Next</a>
            <?php endif; ?>

        
            <a href="index.html">Back to Home Page</a>
        </div>
    <?php else: ?>
        <p>No questions found.</p>
    <?php endif; ?>

    <?php $conn->close(); ?>
</body>
</html>