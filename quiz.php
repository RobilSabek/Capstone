<?php

    session_start();

    
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "careerforge";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz</title>
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

        #timer {
            position: fixed;
            top: 10px;
            right: 10px;
            background-color: #ff0000; 
            color: #fff; 
            padding: 8px 12px; 
            border-radius: 5px;
            font-size: 18px; 
            z-index: 1000; 
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .questions-container {
            width: 100%;
            max-width: 600px; 
            margin: 0 auto; 
        }

        .question {
            background-color: #ffffff;
            border: 1px solid #ced4da;
            margin: 10px 0;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: left;
        }

        .question p {
            margin-bottom: 10px;
        }

        input {
            margin: 5px 0;
            padding: 10px;
            width: 100%; 
            box-sizing: border-box;
        }

        #backToQuestionsLink {
            display: inline-block;
            background-color: #6A5ACD;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            margin-top: 20px;
            margin-right: 10px;
        }

        #backToQuestionsLink:hover {
            background-color: #0056b3;
        }

        #showAnswersButton {
            background-color: #6A5ACD;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 20px;
        }

        #showAnswersButton:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <h1>Quiz</h1>

    <!-- Timer -->
    <div id="timer">30:00</div>

    <form id="quiz-form" action="answers.php" method="post">
        <div class="questions-container">
            <?php
                if (!isset($_POST['showAnswers'])) {
                    
                    $sql = "SELECT * FROM technical_questions";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        $questions = [];
                        while ($row = $result->fetch_assoc()) {
                            $questions[] = $row;
                        }

                        // Shuffle the questions array
                        shuffle($questions);

                        // Display only the first 20 questions
                        $selected_questions = array_slice($questions, 0, 20);

                        foreach ($selected_questions as $row) {
                            echo '<div class="question">';
                            echo '<p>' . $row['question_text'] . '</p>';
                            echo '<input type="text" name="answers[' . $row['question_id'] . ']" placeholder="Type your answer">';
                            echo '</div>';
                        }

                        // Store the selected questions in a session variable
                        $_SESSION['selected_questions'] = $selected_questions;

                        echo '<a id="backToQuestionsLink" href="career.php">Back To The Question Page!</a>';
                    } else {
                        echo '<p>No questions found.</p>';
                    }
                }

                $conn->close();
            ?>
        </div>
        <button id="showAnswersButton" type="submit">Show Answers</button>
    </form>

    <script>
    var timerDuration = 30 * 60; // 30 minutes in seconds
    var timerElement = document.getElementById('timer');

    function startTimer() {
        var timer = setInterval(function () {
            var minutes = Math.floor(timerDuration / 60);
            var seconds = timerDuration % 60;

            // Add leading zero if seconds less than 10
            seconds = seconds < 10 ? '0' + seconds : seconds;

            
            timerElement.textContent = minutes + ':' + seconds;

            if (timerDuration <= 0) {
                clearInterval(timer);

                
                if (!document.getElementById('quiz-form').submitted) {
                    // Simulate form submission when time is up
                    submitForm();
                }
            }

            timerDuration--;
        }, 1000); // Update every 1 second
    }

    
    startTimer();

    
    document.getElementById('showAnswersButton').addEventListener('click', function() {
        
        document.getElementById('quiz-form').submitted = true;

        
        submitForm();
    });

    function submitForm() {
        document.getElementById('quiz-form').submit();
    }
</script>

</body>
</html>
