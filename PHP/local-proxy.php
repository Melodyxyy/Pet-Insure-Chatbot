<?php
//Include Configuration File
require_once('config.php');

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from frontend request
    $data = json_decode(file_get_contents("php://input"), true);

    // Check if data is valid before sending
    if ($data && is_array($data)) {
        // Build API Gateway URL
        $apiUrl = "https://vreuhc8e39.execute-api.ap-southeast-2.amazonaws.com/Production"; 

        // Initiate request to API Gateway using cURL
        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Disabling SSL verification for testing

        // Execute request and retrieve response
        $response = curl_exec($ch);

        // Check for cURL errors
        if (curl_errno($ch)) {
            echo "cURL Error: " . curl_error($ch);
        }

        // Close cURL request
        curl_close($ch);

        // Return API Gateway response to frontend
        echo $response;
    } else {
        echo "Invalid data received.";
    }
} else {
    echo "Invalid request method.";
}
?>
