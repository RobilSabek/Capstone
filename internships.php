<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "careerforge";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>CareerForge Opportunities</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
    <link href="css/font-awesome.min.css" rel="stylesheet" />
    <link href="css/style.css" rel="stylesheet" />
    <link href="css/responsive.css" rel="stylesheet" />

    <style>
        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            text-align: left;
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .filter-form-container {
            text-align: center;
            margin: 20px 0;
        }
        .filter-form-container form {
            display: inline-block;
            margin-right: 20px;
        }
        .filter-form-container input[type=submit] {
            background-color: #00bbf0;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
        }
        .filter-form-container input[type=submit]:hover {
            background-color: #009fda;
        }
        .filter-form-container select, .filter-form-container input[type=text] {
            padding: 10px;
            margin-right: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
    </style>
    
</head>

<body class="sub_page">
    <div class="hero_area">
        <header class="header_section">
            <div class="container-fluid">
                <nav class="navbar navbar-expand-lg custom_nav-container ">
                    <a class="navbar-brand" href="index.html">
                        <span>CareerForge</span>
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class=""> </span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav  ">
                            <li class="nav-item ">
                                <a class="nav-link" href="index.html">Home <span class="sr-only">(current)</span></a>
                            </li>
                            <li class="nav-item active">
                                <a class="nav-link" href="service.html">Services</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="about.html"> About</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="contact.html">Contact Us</a>
                            </li>
                        </ul>
                        <div class="quote_btn-container">
                            <a href="" class="quote_btn">Give a feedback</a>
                        </div>
                    </div>
                </nav>
            </div>
        </header>
    </div>

    <div>
        <div class="heading_container heading_center">
            <h2 class="" style="margin-bottom: 80px; margin-top:50px;">Internships <span >Opportunities</span></h2>
        </div>

        <!-- Filter Form -->
        <div class="filter-form-container">
            <form method="post" action="">
                <label for="location">Location:</label>
                <select name="location">
                    <option value="">All</option>
                    <option value="on-site">On-site</option>
                    <option value="remotely">Remotely</option>
                </select>

                <label for="position">Position:</label>
                <input type="text" name="position" placeholder="Enter position">

                <input type="submit" value="Apply Filter">
            </form>
        </div>

        <table>
            <tr style="padding-bottom: 50px;">
                <th class="col-md-2" style="padding-bottom: 50px;"></th>
                <th class="col-md-2" style="padding-bottom: 50px;">COMPANY</th>
                <th class="col-md-2" style="padding-bottom: 50px;">LINK</th>
                <th class="col-md-2" style="padding-bottom: 50px;">CATEGORY</th>
                <th class="col-md-2" style="padding-bottom: 50px;">DEADLINE</th>
                <th class="col-md-2" style="padding-bottom: 50px;">LOCATION</th>
            </tr>

            <?php
            // Select data from database with filters
            $filter_location = isset($_POST['location']) ? $_POST['location'] : '';
            $filter_position = isset($_POST['position']) ? $_POST['position'] : '';

            $sql = "SELECT ID, COMPANY, LINK, CATEGORY, DEADLINE, LOCATION FROM internships WHERE 1";

            if ($filter_location !== '') {
                $sql .= " AND LOCATION = '$filter_location'";
            }

            if ($filter_position !== '') {
                $sql .= " AND CATEGORY LIKE '%$filter_position%'";
            }

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr style='padding-bottom: 50px;'>";
                    echo "<td class='col-md-2' style='padding-bottom: 50px;'>" . $row["ID"] . "</td>";
                    echo "<td class='col-md-3' style='padding-bottom: 50px;'>" . $row["COMPANY"] . "</td>";
                    echo '<td class="col-md-2" style="padding-bottom: 50px;"><a href="' . $row["LINK"] . '" target="_blank"><button style="background-color:#00bbf0; border-radius:5px;">Apply Now</button></a></td>';
                    echo "<td class='col-md-2' style='padding-bottom: 50px;'>" . $row["CATEGORY"] . "</td>";
                    echo "<td class='col-md-2' style='padding-bottom: 50px;'>" . $row["DEADLINE"] . "</td>";
                    echo "<td class='col-md-2' style='padding-bottom: 50px;'>" . $row["LOCATION"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>0 results</td></tr>";
            }
            ?>
        </table>
    </div>

    <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script type="text/javascript" src="js/custom.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCh39n5U-4IoWpsVGUHWdqB6puEkhRLdmI&callback=myMap"></script>
</body>

</html>

<?php
// Close connection
$conn->close();
?>