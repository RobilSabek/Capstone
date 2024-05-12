<?php

require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$pass = 'spxx npxo rjyr tprm'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $full_name = $_POST["full_name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $message = $_POST["message"];

    $to = $email;
    $subject = "Thank you for contacting us";
    $message_body = "Dear $full_name,\n\nThank you for contacting us about $message. We will get back to you as soon as possible.\n\nBest regards,\nCareer Forge";
    $headers = "From: robilsabek00@gmail.com"; 
    $sendFrom = 'robilsabek00@gmail.com';

    $mail = new PHPMailer(true);
    try {
       
        $mail->isSMTP();                                            
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = $sendFrom;
        $mail->Password   = $pass;
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;
    
        
        $mail->setFrom($sendFrom, 'Career Forge');
        $mail->addAddress($to, $full_name);     
    
       
        $mail->isHTML(false);
        $mail->Subject = $subject;
        $mail->Body    = $message_body;
    
        $mail->send();
        echo 'Message has been sent';
        header('Location: contact.html');
        exit();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
