<?php
echo "<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f0f0f0;
        margin: 0;
        padding: 20px;
    }

    .container {
        max-width: 800px;
        margin: 0 auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0px 0px 20px 0px rgba(0, 0, 0, 0.1);
    }

    h2 {
        color: #6A5ACD;
        text-align: center;
        margin-bottom: 20px;
    }

    .admin-buttons {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        margin-bottom: 20px;
    }

    .admin-buttons button {
        margin: 10px;
        background-color: #6A5ACD;
        color: #fff;
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .admin-buttons button:hover {
        background-color: #4B0082;
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

    echo "<div class='container'>";
    echo "<h2>Admin Dashboard</h2>";

   
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
    echo "<button onclick='viewSubscribedUsers()'>View Subscribed Users</button>";
    echo "</div>";

    if (isset($_GET["action"]) && isset($_GET["userID"])) {
        $action = $_GET["action"];
        $userID = $_GET["userID"];

        if ($action == "activate") {
            $conn->query("UPDATE Users SET Status='active' WHERE UserID=$userID");
        } elseif ($action == "deactivate") {
            $conn->query("UPDATE Users SET Status='inactive' WHERE UserID=$userID");
        }

        header("Location: admin.php");
        exit();
    }

    $conn->close();
    echo "</div>";
} else {
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

    function viewSubscribedUsers() {
        window.location.href = "admin_view_subscribed_users.php";
    }

</script>
