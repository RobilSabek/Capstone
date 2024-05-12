<?php

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "careerforge"; 

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$pass = 'spxx npxo rjyr tprm'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $username = $_POST["username"];
    $email = $_POST["email"];
    $university = $_POST["university"];
    $date = $_POST["date"];
    $time = $_POST["time"];
    $meetingType = $_POST["meetingType"];
    $onlinePlatform = isset($_POST["onlinePlatform"]) ? $_POST["onlinePlatform"] : "";

    
    $insertDataQuery = "INSERT INTO interviewdata (username, email, university, date_of_interview, time_of_interview, meeting_type, online_platform)
                        VALUES ('$username', '$email', '$university', '$date', '$time', '$meetingType', '$onlinePlatform')";

    if ($conn->query($insertDataQuery) === TRUE) {
        
        $to = $email;
        $subject = "Interview Scheduled Successfully";
        $message_body = "Dear $username,\n\nYour interview has been scheduled successfully with the following details:\n\n";
        $message_body .= "University: $university\n";
        $message_body .= "Date: $date\n";
        $message_body .= "Time: $time\n";
        $message_body .= "Meeting Type: $meetingType\n";
        if ($meetingType === 'online') {
            $message_body .= "Online Platform: $onlinePlatform\n The meeting link will be sent by the interviewer two hours before the meeting.";
        }
        $message_body .= "\nPlease make sure to attend the interview on time.\n\nBest regards,\nInterview Scheduler";

        $mail = new PHPMailer(true);
        try {
            
            $mail->isSMTP();                                           
            $mail->Host       = 'smtp.gmail.com';                
            $mail->SMTPAuth   = true;                                   
            $mail->Username   = 'robilsabek00@gmail.com';               
            $mail->Password   = $pass;                                  
            $mail->SMTPSecure = 'tls';                                  
            $mail->Port       = 587;                                   
        
            
            $mail->setFrom('robilsabek00@gmail.com', 'Interview Scheduler');
            $mail->addAddress($to, $username);    
        
            
            $mail->isHTML(false);
            $mail->Subject = $subject;
            $mail->Body    = $message_body;
        
            $mail->send();
            echo 'Message has been sent';
            header('Location: mock interview.html');
            exit();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Error inserting data into the database: " . $conn->error;
    }

    $conn->close();
}
?>
