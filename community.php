<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "careerforge";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['code'])) {
    $code = mysqli_real_escape_string($conn, $data['code']); // Sanitize user input
    $sql = "INSERT INTO code_review (code) VALUES (?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $code);
        if ($stmt->execute()) {
            echo json_encode(array("success" => true));
        } else {
            echo json_encode(array("success" => false, "error" => $conn->error));
        }
        $stmt->close();
    } else {
        echo json_encode(array("success" => false, "error" => "Prepared statement error"));
    }
} else {
    echo json_encode(array("success" => false, "error" => "No 'code' found in the data"));
}

$conn->close();

