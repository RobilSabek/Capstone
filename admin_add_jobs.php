<?php
// admin_add_job.php
session_start();

// Check if the user is logged in as an admin
if (isset($_SESSION["user_email"])) {
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

    echo "<style>
        h2 {
            color: #6A5ACD;
        }

        form {
            max-width: 600px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 20px 0px rgba(0, 0, 0, 0.1);
        }

        input[type='text'], input[type='url'], input[type='date'] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 25px;
            outline: none;
        }

        input[type='submit'] {
            width: 100%;
            padding: 12px;
            margin: 20px 0;
            border: none;
            border-radius: 25px;
            background-color: #6A5ACD;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type='submit']:hover {
            background-color: #4B0082;
        }
    </style>";

    echo "<h2>Add Job</h2>";

    // Handle job submission
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_job"])) {
        $company = $_POST["company"];
        $link = $_POST["link"];
        $category = $_POST["category"];
        $deadline = $_POST["deadline"];
        $location = $_POST["location"];

        // Validate and insert job into the database
        // Add your validation and database insertion code here

        // Example: Insert job into the 'jobs' table
        $sql = "INSERT INTO jobs (COMPANY, LINK, CATEGORY, DEADLINE, LOCATION) VALUES ('$company', '$link', '$category', '$deadline', '$location')";
        if ($conn->query($sql) === TRUE) {
            echo "<p>Job added successfully!</p>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Display job submission form
    echo "<form method='post' action=''>
            <label for='company'>Company:</label>
            <input type='text' name='company' required>

            <label for='link'>Link:</label>
            <input type='url' name='link' required>

            <label for='category'>Category:</label>
            <input type='text' name='category' required>

            <label for='deadline'>Deadline:</label>
            <input type='date' name='deadline' required>

            <label for='location'>Location:</label>
            <input type='text' name='location' required>

            <input type='submit' name='submit_job' value='Submit Job'>
        </form>";

    $conn->close();
} else {
    echo "Access denied. You must be logged in as an admin.";
}
?>
