<?php
// admin.php
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

    .admin-buttons {
        margin-top: 20px;
    }

    .admin-buttons button {
        margin-right: 10px;
        background-color: #28a745;
        color: #fff;
        border: none;
        border-radius: 5px;
        padding: 10px 15px;
        cursor: pointer;
    }

    .admin-buttons button:hover {
        background-color: #218838;
    }
</style>";

session_start();

// Check if the user is logged in
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

    echo "<h2>Admin Dashboard</h2>";

    // Display buttons for different actions
    echo "<div class='admin-buttons'>";
    echo "<button onclick='viewUsers()'>View Users</button>";
    echo "<button onclick='viewJobs()'>View Jobs</button>";
    echo "<button onclick='addJob()'>Add Job</button>";
    echo "<button onclick='editJobs()'>Edit Jobs</button>";
    echo "<button onclick='deleteJobs()'>Delete Jobs</button>";
    echo "<button onclick='viewInternships()'>View Internships</button>";
    echo "<button onclick='addInternships()'>Add Internships</button>";
    echo "<button onclick='editInternships()'>Edit Internships</button>";
    echo "<button onclick='deleteInternships()'>Delete Internships</button>";
    echo "</div>";

    // Handle activation/deactivation actions
    if (isset($_GET["action"]) && isset($_GET["userID"])) {
        $action = $_GET["action"];
        $userID = $_GET["userID"];

        if ($action == "activate") {
            $conn->query("UPDATE Users SET Status='active' WHERE UserID=$userID");
        } elseif ($action == "deactivate") {
            $conn->query("UPDATE Users SET Status='inactive' WHERE UserID=$userID");
        }

        header("Location: admin.php"); // Redirect to refresh the page after the action
        exit();
    }

    // Your existing code for displaying users...
    // ...

    $conn->close();
} else {
    // Redirect if not logged in
    header("Location: login.php");
    exit();
}
?>

<script>
    function viewUsers() {
        window.location.href = "admin_view_users.php";
    }

    function viewJobs(){
        window.location.href = "admin_view_jobs.php"
    }

    function addJob() {
        window.location.href = "admin_add_jobs.php";
    }

    function editJobs() {
        window.location.href = "admin_edit_jobs.php";
    }

    function deleteJobs() {
        window.location.href = "admin_delete_jobs.php";
    }


    function viewInternships() {
        window.location.href = "admin_view_internships.php";
    }

    function addInternships() {
        window.location.href = "admin_add_internships.php"
    }

    function editInternships() {
        window.location.href = "admin_edit_internships.php";
    }

    function deleteInternships() {
        window.location.href = "admin_delete_internships.php";
    }


</script>
