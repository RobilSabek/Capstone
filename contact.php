<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $fullName = $_POST["full_name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $message = $_POST["message"];

    // Validate data (you might want to add more validation)
    if (empty($fullName) || empty($email) || empty($phone) || empty($message)) {
        echo "All fields are required.";
        exit;
    }

    ini_set("SMTP", "smtp.gmail.com");
    ini_set("smtp_port", 465);


    // Set up email
    $to = $email;
    $subject = "New Call Back Request";
    $headers = "From: robilsabek00@gmail.com";

    // Compose email message
    $emailMessage = "Full Name: $fullName\n";
    $emailMessage .= "Email: $email\n";
    $emailMessage .= "Phone: $phone\n";
    $emailMessage .= "Message: $message\n";

    // Send email

    if(mail($to, $subject, $emailMessage, $headers)){
        echo "Thank you! Your request has been submitted.";
    }

 else {
    // If not a POST request, redirect or handle accordingly
    echo "Invalid request.";
}
}

?>
