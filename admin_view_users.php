<?php
// admin_view_users.php
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

    echo "<h2>View Users</h2>";

    // Display all users
    $sql = "SELECT * FROM Users";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr><th>UserID</th><th>FirstName</th><th>LastName</th><th>Email</th><th>Status</th><th>Action</th></tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["UserID"] . "</td>";
            echo "<td>" . $row["FirstName"] . "</td>";
            echo "<td>" . $row["LastName"] . "</td>";
            echo "<td>" . $row["Email"] . "</td>";
            echo "<td>" . $row["Status"] . "</td>";
            echo "<td>";
            if ($row["Status"] == "active") {
                echo "<a href='admin.php?action=deactivate&userID=" . $row["UserID"] . "'>Deactivate</a>";
            } else {
                echo "<a href='admin.php?action=activate&userID=" . $row["UserID"] . "'>Activate</a>";
            }
            echo "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No users found.";
    }

    $conn->close();
} else {
    echo "Access denied. You must be logged in as an admin.";
}
?>
