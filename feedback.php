<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "careerforge";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$data = json_decode(file_get_contents('php://input'), true);

$studentName = $conn->real_escape_string($data['studentName']);
$feedback = $conn->real_escape_string($data['feedback']);
$rating = intval($data['rating']);

$sql = "INSERT INTO Feedback (student_name, feedback, rating) VALUES ('$studentName', '$feedback', $rating)";


if ($conn->query($sql) === TRUE) {
    echo json_encode(array("message" => "Feedback submitted successfully"));
} else {
    echo json_encode(array("error" => "Error: " . $sql . "<br>" . $conn->error));
}

$conn->close();
?>
