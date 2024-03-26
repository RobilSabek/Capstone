<?php
// Assuming you have a database connection established
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "careerforge";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $subscription_plan = $_POST["subscription_plan"];
    $card_number = $_POST["card_number"];
    $expiry_date = $_POST["expiry_date"];
    $cvv = $_POST["cvv"];
    $name = $_POST["name"];
    $email = $_POST["email"];

    // SQL query to create a table if not exists
    $createTableQuery = "CREATE TABLE IF NOT EXISTS Subscriptions (
                            id INT AUTO_INCREMENT PRIMARY KEY,
                            subscription_plan VARCHAR(50) NOT NULL,
                            card_number VARCHAR(16) NOT NULL,
                            expiry_date VARCHAR(7) NOT NULL,
                            cvv VARCHAR(3) NOT NULL,
                            name VARCHAR(100) NOT NULL,
                            email VARCHAR(100) NOT NULL,
                            timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                        )";

    if ($conn->query($createTableQuery) === TRUE) {
        // SQL query to insert data into the table
        $insertDataQuery = "INSERT INTO Subscriptions (subscription_plan, card_number, expiry_date, cvv, name, email)
                            VALUES ('$subscription_plan', '$card_number', '$expiry_date', '$cvv', '$name', '$email')";

        if ($conn->query($insertDataQuery) === TRUE) {
            echo "Subscription successful. Thank you!";
            
            // Send email to the user
            $to = $email;
            $subject = "Subscription Confirmation";
            $message = "Dear $name,\n\nThank you for subscribing to our service. Your subscription plan ($subscription_plan) has been successfully processed.";
            $headers = "From: robil.sabek@lau.edu"; // Replace with your email address

            // Send email
            mail($to, $subject, $message, $headers);
        } else {
            echo "Error: " . $insertDataQuery . "<br>" . $conn->error;
        }
    } else {
        echo "Error creating table: " . $conn->error;
    }

    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Career Development Platform - Subscription and Payment</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f0f0;
            text-align: center;
            padding-top: 50px;
            margin: 0;
        }

        .form-container {
            max-width: 400px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 20px 0px rgba(0, 0, 0, 0.1);
        }

        input[type="text"],
        input[type="password"],
        input[type="email"],
        input[type="date"] {
            width: calc(100% - 20px);
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 25px;
            outline: none;
        }

        select {
            width: calc(100% - 20px);
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 25px;
            outline: none;
        }

        button {
            width: calc(100% - 20px);
            padding: 12px;
            margin: 20px 0;
            border: none;
            border-radius: 25px;
            background-color: #6A5ACD;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #4B0082;
        }

        h2 {
            color: #6A5ACD;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h2>Subscription and Payment</h2>
        <form action="" method="post">
            <!-- Subscription Details -->
            <label for="subscription_plan">Select Subscription Plan:</label>
            <select name="subscription_plan" required>
                <option value="basic">Basic</option>
                <option value="standard">Standard</option>
                <option value="premium">Premium</option>
            </select><br>

            <!-- Payment Details -->
            <label for="card_number">Card Number:</label>
            <input type="text" name="card_number" placeholder="Enter card number" required><br>

            <label for="expiry_date">Expiry Date:</label>
            <input type="text" name="expiry_date" placeholder="MM/YYYY" required><br>

            <label for="cvv">CVV:</label>
            <input type="text" name="cvv" placeholder="Enter CVV" required><br>

            <!-- User Details (for subscription confirmation, can be expanded) -->
            <label for="name">Full Name:</label>
            <input type="text" name="name" placeholder="Enter your full name" required><br>

            <label for="email">Email:</label>
            <input type="text" name="email" placeholder="Enter your email" required><br>

            <button type="submit">Subscribe and Pay</button>
        </form>
    </div>
</body>

</html>
