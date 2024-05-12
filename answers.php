<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Answers</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
            text-align: center;
            background-color: #f8f9fa;
        }

        h1 {
            color: #343a40;
        }

        #answers {
            margin-top: 20px;
        }

        .question {
            background-color: #e9ecef;
            border: 1px solid #ced4da;
            margin: 10px 0;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: left;
        }

        #backButton {
            background-color: #6A5ACD;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 20px;
        }

        #backButton:hover {
            background-color: #5a6268;
        }
    </style>
</head>

<body>
    <h1>Answers</h1>

    <div id="answers">
        <?php

            $servername = "localhost";
            $username = "root";
            $password = "root";
            $dbname = "careerforge";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }


            
            session_start();
            
            if (isset($_SESSION['selected_questions'])) {
                foreach ($_SESSION['selected_questions'] as $row) {
                    $question_id = $row['question_id'];
                    $user_answer = isset($_POST['answers'][$question_id]) ? $_POST['answers'][$question_id] : 'Not provided';

                    
                    $sql = "SELECT answer FROM technical_questions WHERE question_id = $question_id";
                    $result = $conn->query($sql);
                    $db_row = $result->fetch_assoc();
                    $correct_answer = $db_row['answer'];

                    echo "<div class='question'>";
                    echo "<p>Question: {$row['question_text']}</p>";
                    echo "<p>User's Answer: $user_answer</p>";
                    echo "<p>Correct Answer: $correct_answer</p>";
                    echo '</div>';
                }

                
                unset($_SESSION['selected_questions']);
            } else {
                echo '<p>No selected questions found.</p>';
            }
            $conn->close();
        ?>
    </div>

    <button id="backButton" onclick="window.location.href='quiz.php'">Take Another Quiz!</button>

    <button id="backButton" onclick="window.location.href='career.php'">Back To Solve More Exercises</button>


</body>
</html>
