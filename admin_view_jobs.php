<?php
// admin_view_jobs.php
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

        a {
            text-decoration: none;
            color: #007bff;
        }

        a:hover {
            color: #6A5ACD;
        }
    </style>";

    echo "<h2>View Jobs</h2>";

    // Display all jobs
    $sql = "SELECT * FROM jobs";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Company</th><th>Link</th><th>Category</th><th>Deadline</th><th>Location</th></tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["ID"] . "</td>";
            echo "<td>" . $row["COMPANY"] . "</td>";
            echo "<td><a href='" . $row["LINK"] . "' target='_blank'>Apply Now</a></td>";
            echo "<td>" . $row["CATEGORY"] . "</td>";
            echo "<td>" . $row["DEADLINE"] . "</td>";
            echo "<td>" . $row["LOCATION"] . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No jobs found.";
    }

    $conn->close();
} else {
    echo "Access denied. You must be logged in as an admin.";
}
?>