<?php
// admin_delete_jobs.php
session_start();

// Check if the user is logged in as an admin
if (!isset($_SESSION["user_email"])) {
    header("Location: login.php");
    exit;
}

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

// Handle job deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_job"])) {
    $jobID = $_POST["delete_job"];

    // Delete job
    $deleteSql = "DELETE FROM jobs WHERE ID=$jobID";

    if ($conn->query($deleteSql) === TRUE) {
        echo "Job deleted successfully.";
    } else {
        echo "Error deleting job: " . $conn->error;
    }
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

        main {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #6A5ACD;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .delete-button {
            background-color: #dc3545;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            cursor: pointer;
        }

        .delete-button:hover {
            background-color: #c82333;
        }
    </style>
";

echo "<header><h1>Delete Jobs</h1></header>";
echo "<main>";

// Display all jobs with delete buttons
$sql = "SELECT * FROM jobs";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>ID</th><th>Company</th><th>Link</th><th>Category</th><th>Deadline</th><th>Location</th><th>Action</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["ID"] . "</td>";
        echo "<td>" . $row["COMPANY"] . "</td>";
        echo "<td><a href='" . $row["LINK"] . "' target='_blank'>Apply Now</a></td>";
        echo "<td>" . $row["CATEGORY"] . "</td>";
        echo "<td>" . $row["DEADLINE"] . "</td>";
        echo "<td>" . $row["LOCATION"] . "</td>";
        echo "<td><form method='post' action='admin_delete_jobs.php'>";
        echo "<input type='hidden' name='delete_job' value='" . $row["ID"] . "'>";
        echo "<button type='submit' class='delete-button'>Delete</button>";
        echo "</form></td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No jobs found.";
}

echo "</main>";

$conn->close();
?>
