<?php
// Connect to your database
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "careerforge";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve correct answers from the database
$sql = "SELECT question_id, answer FROM technical_questions";
$result = $conn->query($sql);

$correct_answers = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $correct_answers[$row['question_id']] = $row['answer'];
    }
}

$conn->close();

// Check user's answers against correct answers
$user_answers = $_POST['answers'];
$score = 0;
foreach ($user_answers as $question_id => $user_answer) {
    if (isset($correct_answers[$question_id]) && $user_answer === $correct_answers[$question_id]) {
        $score++;
    }
}

// Display results
echo "<h2>Your Quiz Results:</h2>";
echo "<p>Score: $score out of 20</p>";
echo "<h3>Correct Answers:</h3>";
foreach ($correct_answers as $question_id => $correct_answer) {
    echo "<p>Question $question_id: $correct_answer</p>";
}
?>
