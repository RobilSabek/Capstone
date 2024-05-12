<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect input from the form
    $data = array(
        'highest_level_of_education' => $_POST['highest_level_of_education'],
        'nb_jobs/internships_applied' => $_POST['nb_jobs/internships_applied'],
        'nb_interviews' => $_POST['nb_interviews'],
        'technical_skills' => $_POST['technical_skills'],
        'soft_skills' => $_POST['soft_skills'],
        'stress_level' => $_POST['stress_level']
    );

    // foreach ($data as $key => $value) {
    //     echo $key . ': ' . $value . '<br>';
    // }

        // Convert array to JSON
        $jsonData = json_encode($data);

        // Initialize cURL session
        $url = 'http://localhost:5000/predict';  // URL of the Flask API
        $ch = curl_init($url);
    
        // Set cURL options for POST request
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    
        // Execute POST request and close cURL session
        $response = curl_exec($ch);
        if ($response === false) {
            echo 'Curl error: ' . curl_error($ch);
        } else {
            // echo 'Response from Python: ' . $response;
             // Decode JSON response
            $responseArray = json_decode($response, true);
            $predictionString = $responseArray['prediction'];
            // Extract the percentage value using regex
             preg_match('/\d+\.\d+/', $predictionString, $matches);
             $percentage = $matches[0];  // This will be the percentage value
             //echo 'Percentage chance of being Accepted: ' . $percentage . '%';
             echo $percentage; 
        }
        curl_close($ch);
    
    // $command = 'python3 try.py';
    // $output = shell_exec($command);
    // echo $output;
}

?>