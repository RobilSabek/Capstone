<?php

require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$pass = 'spxx npxo rjyr tprm'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $studentName = $_POST["student_name"];
    $email = $_POST["email"];
    $feedback = $_POST["feedback"];
    $rating = $_POST["rating"];

    
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "careerforge";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    
    $sql = "INSERT INTO Feedback (student_name, email, feedback, rating) VALUES ('$studentName', '$email', '$feedback', $rating)";

    if ($conn->query($sql) === TRUE) {
        
        $to_email = $email; 
        $subject = "Feedback Submitted";
        $message_body = "Thank you $studentName for submitting your feedback. We will take it into consideration.\nFeedback: $feedback\nRating: $rating\n\nBest regards,\nCareerForge.";
        $headers = "From: robilsabek00@gmail.com"; 

        $mail = new PHPMailer(true);
        try {
            
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'robilsabek00@gmail.com';
            $mail->Password   = $pass;
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;
        
           
            $mail->setFrom('robilsabek00@gmail.com', 'Career Forge');
            $mail->addAddress($to_email);
        
            
            $mail->isHTML(false);
            $mail->Subject = $subject;
            $mail->Body    = $message_body;
        
            $mail->send();
            echo json_encode(array("message" => "Feedback submitted successfully"));
            header('Location: feedback.html');
            exit();
        } catch (Exception $e) {
            echo json_encode(array("error" => "Error sending email: {$mail->ErrorInfo}"));
        }
    } else {
        echo json_encode(array("error" => "Error: " . $sql . "<br>" . $conn->error));
    }

    $conn->close();
}
?>
