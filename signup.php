<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Career Development Platform - Sign Up</title>
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

        input[type="submit"] {
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

        input[type="submit"]:hover {
            background-color: #4B0082;
        }

        .form-switch {
            margin-top: 20px;
        }

        .form-switch a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }

        .form-switch a:hover {
            color: #0056b3;
        }

        h2 {
            color: #6A5ACD;
        }
    </style>
</head>

<body>
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
        // Client Signup Form
        if (isset($_POST["client-signup-form"])) {
            // Retrieve and sanitize form data
            $first_name = mysqli_real_escape_string($conn, $_POST["first_name"]);
            $last_name = mysqli_real_escape_string($conn, $_POST["last_name"]);
            $username = mysqli_real_escape_string($conn, $_POST["username"]);
            $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
            $email = mysqli_real_escape_string($conn, $_POST["email"]);
            $date_of_birth = $_POST["date_of_birth"];

            // Perform the actual signup logic, insert into the Users table
            $sql = "INSERT INTO Users (FirstName, LastName, Username, Password, Email, DateOfBirth) 
                    VALUES ('$first_name', '$last_name', '$username', '$password', '$email', '$date_of_birth')";

            if ($conn->query($sql) === TRUE) {
                echo "Signup successful!";
                session_start();
                $_SESSION["user_email"] = $email; // Save user information in a session
                header("Location: index.html");
                exit();
            } else {
                echo "Error: Failed to Signup";
            }
        }
    }

$conn->close();
?>


    <div class="form-container" id="client-form">
        <h2>Sign Up</h2>
        <!-- Client Sign Up Form -->
        <form id="client-signup-form" method="post" action="">
            <input type="text" name="first_name" placeholder="First Name" required><br>
            <input type="text" name="last_name" placeholder="Last Name" required><br>
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="date" name="date_of_birth" required><br>
            <input type="submit" name="client-signup-form" value="Sign Up">
        </form>

        <div class="form-switch">
            <p>Already have an account? <a href="login.php">Log In here</a></p>
        </div>
    </div>
</body>

</html>

    

    