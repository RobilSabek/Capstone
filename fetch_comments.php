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

$sql = "SELECT * FROM comments WHERE code_id = $codeId";
$result = $conn->query($sql);

$comments = array();
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $comments[] = array(
            'id' => $row['id'],
            'comment_text' => $row['comment_text'],
            'created_at' => $row['created_at']
            
        );
    }
}

echo json_encode($comments);

$conn->close();
?>
