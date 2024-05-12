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
$codeId = $data['codeId'];
$commentText = $data['commentText'];

$sql = "INSERT INTO comments (code_id, comment_text) VALUES ('$codeId', '$commentText')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(array("success" => true));
} else {
    echo json_encode(array("success" => false));
}

$conn->close();
?>
