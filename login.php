<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Career Development Platform - Sign Up / Log In</title>
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

        input[type="email"],
        input[type="password"] {
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
    <div class="form-container" id="client-form">
        <h2>Log In</h2>
        
        <form id="client-login-form" method="post" action="">
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <input type="submit" name="client-login-form" value="Log In">
        </form>

        <div class="form-switch">
            <p>Don't have an account? <a href="signup.php">Sign Up here</a></p>
        </div>
    </div>
</body>

</html>

<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "careerforge";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (isset($_POST["client-login-form"])) {
        $email = $_POST["email"];
        $password = $_POST["password"];

        
        $stmt = $conn->prepare("SELECT * FROM Users WHERE Email = ?");
        $stmt->bind_param("s", $email);

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
        
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['Password']) && $row['Status'] == 'active') {
                
                $_SESSION["user_email"] = $email;
                // admins
                if ($email == "robilsabek@gmail.com" || $email == "robeelmili@gmail.com") {
                    
                    header("Location: admin.php");
                } else {
                    // users
                    header("Location: index.html");
                }
                exit();
            } else {
                
                if ($row['Status'] != 'active') {
                    echo "Account is inactive. Please contact support.";
                } else {
                    echo "Invalid password";
                }
            }
        } else {
            
            echo "Invalid email or password";
        }

        $stmt->close();
    }
}

$conn->close();
?>
