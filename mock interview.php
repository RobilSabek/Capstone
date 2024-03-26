<?php

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "careerforge";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$successMessage = $errorMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $university = $_POST['university'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $meetingType = $_POST['meetingType'];

    $onlinePlatform = ($meetingType === 'inPerson') ? '' : $_POST['onlinePlatform'];

   

    // Insert data into the database
    $sql = "INSERT INTO interviewData (username, email, university, date_of_interview, time_of_interview, meeting_type, online_platform)
            VALUES ('$username', '$email', '$university', '$date', '$time', '$meetingType', '$onlinePlatform')";

    if ($conn->query($sql) === TRUE) {
        // Send confirmation email using Gmail's SMTP server
    $to      = 'robilsabek00@gmail.com';
    $subject = 'the subject';
    $message = 'hello';
    $headers = array(
    'From' => 'robeelmili147@gmail.com',
    'Reply-To' => 'webmaster@example.com',
    'X-Mailer' => 'PHP/' . phpversion()
);

mail($to, $subject, $message, $headers);
/*if ($mailResult) {
    $successMessage = "Interview scheduled successfully! Confirmation email sent to $email.";
} else {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}
*/
    }

}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Interview Scheduler</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 50px;
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        h1 {
            margin-bottom: 20px;
            color: #007bff;
        }

        .interviewer-container {
            display: flex;
            justify-content: center;
            align-items: flex-end;
            gap: 20px;
            margin-bottom: 20px;
        }

        .interviewer-card {
            text-align: center;
            transition: transform 0.3s ease;
            position: relative;
        }

        .interviewer-img {
            width: 250px;
            height: 250px;
            border-radius: 50%;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .interviewer-name {
            font-size: 20px;
            position: absolute;
            bottom: -30px;
            left: 50%;
            transform: translateX(-50%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .interviewer-card:hover .interviewer-name {
            opacity: 1;
        }

        .interviewer-card:hover .interviewer-img {
            transform: scale(1.1);
        }

        #scheduleForm {
            display: none;
            width: 400px;
            margin: 20px auto;
            padding: 20px;
            border-radius: 10px;
            background-color: #e0e9f3;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        select,
        button,
        input[type="date"],
        input[type="time"] {
            width: calc(100% - 18px);
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        button {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url('data:image/svg+xml;utf8,<svg fill="#000000" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24px" height="24px"><path d="M7 10l5 5 5-5z" /></svg>');
            background-position: right 10px top 50%;
            background-repeat: no-repeat;
        }

        .success-message,
        .error-message {
            text-align: center;
            margin-top: 20px;
            padding: 15px;
            border-radius: 5px;
        }

        .success-message {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }

        .error-message {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }

        .details p {
            margin: 5px 0;
        }

        .details p span {
            font-weight: bold;
        }

        .go-back-button {
            margin-top: 20px;
        }

        .go-back-button button {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            padding: 10px 20px;
        }

        .go-back-button button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <h1>Interview Scheduler</h1>
    <div class="interviewer-container">
        <div class="interviewer-card">
            <img src="https://img.freepik.com/free-photo/close-up-portrait-cheerful-glamour-girl-with-cute-make-up-smiling-white-teeth-looking-happy-camera-standing-blue-background_1258-70300.jpg?w=996&t=st=1702060997~exp=1702061597~hmac=1f5d522317a1d74449e0e88b14991648ddfedfb7a20601eb5e7cdefe466a04ab" alt="Emily Thompson" class="interviewer-img" onclick="openScheduler('Emily Thompson')">
            <button class="interviewer-name" onclick="openDescription('Emily Thompson')">Emily Thompson</button>
        </div>
        <div class="interviewer-card">
            <img src="https://img.freepik.com/free-photo/waist-up-portrait-handsome-serious-unshaven-male-keeps-hands-together-dressed-dark-blue-shirt-has-talk-with-interlocutor-stands-against-white-wall-self-confident-man-freelancer_273609-16320.jpg?w=996&t=st=1702060944~exp=1702061544~hmac=8037f86be80a9c5b497553e36397df28f58e3584c2ffc03dc32c29c6ac47b8ef" alt="Simon Drake" class="interviewer-img" onclick="openScheduler('Simon Drake')">
            <button class="interviewer-name" onclick="openDescription('Simon Drake')">Simon Drake</button>
        </div>
        <div class="interviewer-card">
            <img src="https://st2.depositphotos.com/1715570/5435/i/450/depositphotos_54357355-stock-photo-handsome-young-black-man-smiling.jpg" alt="Alexander Johnson" class="interviewer-img" onclick="openScheduler('Alexander Johnson')">
            <button class="interviewer-name" onclick="openDescription('Alexander Johnson')">Alexander Johnson</button>
        </div>
    </div>
    <div id="messageUnderPics"></div>
    <form id="scheduleForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        <label for="university">University:</label>
        <input type="text" id="university" name="university" required><br><br>
        <label for="date">Date of Interview:</label>
        <input type="date" id="date" name="date" required><br><br>
        <label for="time">Time of Interview:</label>
        <input type="time" id="time" name="time" required><br><br>
        <label for="meetingType">Meeting Type:</label>
        <select id="meetingType" name="meetingType" onchange="showHideOnlineOptions()">
            <option value="inPerson">In Person</option>
            <option value="online">Online</option>
        </select><br><br>
        <div id="onlineOptions" style="display: none;">
            <label for="onlinePlatform">Select Online Platform:</label>
            <select id="onlinePlatform" name="onlinePlatform">
                <option value="webex">Webex</option>
                <option value="zoom">Zoom</option>
                <option value="googleMeet">Google Meet</option>
            </select><br><br>
            <input type="hidden" id="selectedInterviewer" name="selectedInterviewer">
        </div>
        <button type="submit" name="submit">Done</button>
    </form>

    <?php
    // Display success or error messages
    if (!empty($successMessage)) {
        echo '<div class="success-message">' . $successMessage . '</div>';
    } elseif (!empty($errorMessage)) {
        echo '<div class="error-message">' . $errorMessage . '</div>';
    }
    ?>

    <script>
        // Your JavaScript code goes here
        function showHideOnlineOptions() {
            const meetingType = document.getElementById('meetingType').value;
            const onlineOptions = document.getElementById('onlineOptions');

            if (meetingType === 'online') {
                onlineOptions.style.display = 'block';
            } else {
                onlineOptions.style.display = 'none';
            }
        }

        function openScheduler(interviewer) {
            const form = document.getElementById('scheduleForm');
            form.style.display = 'block';
            form.style.animation = 'fadeIn 0.5s';

            const message = `You have scheduled a meeting with ${interviewer}.`;
            document.getElementById('messageUnderPics').style.display = 'block';
            document.getElementById('messageUnderPics').innerHTML = message;

            // Set the value of the hidden field
            document.getElementById('selectedInterviewer').value = interviewer;
        }

        function openDescription(interviewer) {
            let descriptionPage = '';
            if (interviewer === 'Emily Thompson') {
                descriptionPage = 'emily_thompson.html';
            } else if (interviewer === 'Simon Drake') {
                descriptionPage = 'simon_drake.html';
            } else if (interviewer === 'Alexander Johnson') {
                descriptionPage = 'alexander_johnson.html';
            }
            window.open(descriptionPage, '_blank');
        }

        function submitForm() {
            const interviewer = document.getElementById('selectedInterviewer').value;
            const date = document.getElementById('date').value;
            const time = document.getElementById('time').value;
            const meetingType = document.getElementById('meetingType').value;
            const onlinePlatform = document.getElementById('onlinePlatform').value;

            let meetingDetails = `Interview with ${interviewer} scheduled for ${date} at ${time}.`;

            if (meetingType === 'inPerson') {
                meetingDetails += ` Location: Office`;
            } else if (meetingType === 'online') {
                meetingDetails += ` Meeting Platform: ${onlinePlatform}`;
            }

            const popup = document.createElement('div');
            popup.className = 'popup';
            popup.innerHTML = `Interview scheduled successfully!<br>${meetingDetails}`;
            document.body.appendChild(popup);

            setTimeout(() => {
                document.body.removeChild(popup);
                document.getElementById('scheduleForm').submit();
            }, 5000);
        }
    </script>

</body>

</html>
