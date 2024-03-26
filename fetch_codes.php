<?php
$servername = "localhost"; 
$username = "root"; 
$password = "root"; 
$dbname = "careerforge";  


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM code_review ORDER BY created_at DESC"; 
$result = $conn->query($sql);

$codeEntries = array();
if ($result && $result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $codeEntries[] = array(
      'id' => $row['id'],
      'code' => $row['code'],
      'created_at' => $row['created_at']
      
    );
  }
}

echo json_encode($codeEntries);

$conn->close();
?>
