<?php
session_start();

if (isset($_SESSION["user_email"])) {
    
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "careerforge";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    echo "
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f8f9fa;
                color: #333;
                margin: 0;
                padding: 0;
            }

            header {
                background-color: #6A5ACD;
                color: #fff;
                text-align: center;
                padding: 20px 0;
            }

            nav ul {
                list-style: none;
                padding: 0;
                margin: 0;
                text-align: center;
            }

            nav ul li {
                display: inline-block;
                margin-right: 20px;
            }

            nav ul li a {
                text-decoration: none;
                color: #333;
            }

            main {
                max-width: 800px;
                margin: 20px auto;
                padding: 20px;
                background-color: #fff;
                border-radius: 10px;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            }

            form fieldset {
                margin-bottom: 20px;
                border: 1px solid #ddd;
                padding: 20px;
                border-radius: 10px;
            }

            form fieldset legend {
                font-size: 20px;
                font-weight: bold;
                color: #6A5ACD;
                margin-bottom: 10px;
            }

            form fieldset input[type='text'],
            form fieldset input[type='date'],
            form fieldset textarea {
                width: calc(100% - 42px);
                padding: 10px;
                margin-bottom: 20px;
                border: 1px solid #ccc;
                border-radius: 5px;
                font-size: 16px;
            }

            form input[type='submit'] {
                background-color: #6A5ACD;
                color: #fff;
                border: none;
                border-radius: 5px;
                padding: 10px 20px;
                cursor: pointer;
                font-size: 16px;
            }

            form input[type='submit']:hover {
                background-color: #563d7c;
            }
        </style>
    ";

    echo "<header><h1>Manage Jobs</h1></header>";
    echo "<nav><ul><li><a href='admin.php'>Admin Dashboard</a></li></ul></nav>";
    echo "<main>";

    $sql = "SELECT * FROM jobs";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      
        echo '<form action="" method="post">';
        
        while ($row = $result->fetch_assoc()) {
            $jobID = $row['ID'];
            $company = $row['COMPANY'];
            $link = $row['LINK'];
            $category = $row['CATEGORY'];
            $deadline = $row['DEADLINE'];
            $location = $row['LOCATION'];

            echo '<fieldset>';
            echo '<legend>Job ID: ' . $jobID . '</legend>';
            echo 'Company: <input type="text" name="' . $jobID . '[company]" value="' . $company . '" required><br>';
            echo 'Link: <input type="text" name="' . $jobID . '[link]" value="' . $link . '" required><br>';
            echo 'Category: <input type="text" name="' . $jobID . '[category]" value="' . $category . '" required><br>';
            echo 'Deadline: <input type="text" name="' . $jobID . '[deadline]" value="' . $deadline . '" required><br>';
            echo 'Location: <input type="text" name="' . $jobID . '[location]" value="' . $location . '" required><br>';
            echo '</fieldset>';
        }

        echo '<input type="submit" value="Submit Changes">';
        echo '</form>';
    } else {
        echo '<p>No jobs found.</p>';
    }

    echo "</main>";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        foreach ($_POST as $jobID => $jobData) {
            $company = $jobData["company"];
            $link = $jobData["link"];
            $category = $jobData["category"];
            $deadline = $jobData["deadline"];
            $location = $jobData["location"];

            $updateSql = "UPDATE jobs SET 
                          COMPANY='$company', 
                          LINK='$link', 
                          CATEGORY='$category', 
                          DEADLINE='$deadline', 
                          LOCATION='$location' 
                          WHERE ID=$jobID";

            if ($conn->query($updateSql) !== TRUE) {
                echo "Error updating job: " . $conn->error;
            }
        }

        echo "<p>Changes saved successfully!</p>";
    }

    $conn->close();
} else {
    echo "<p>Access denied. You must be logged in as an admin.</p>";
}
?>
