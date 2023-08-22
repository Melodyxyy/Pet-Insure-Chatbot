<?php
// Include Configuration File
require_once('config.php');

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize user inputs
    $name = trim($_POST["name"]);
    $petName = trim($_POST["pet"]);
    $claimDetails = trim($_POST["claim-details"]);
    $id = trim($_POST["id"]); // Get the user ID from session or wherever it's stored

    // Validate the user ID
    if (!isValidUserID($id)) {
        echo "Please enter a valid user ID.";
    } else if (!doesUserExist($id)) {
        echo "User with ID $id does not exist.";
    } else {
        // Basic input validation
        if (empty($name) || empty($petName) || empty($claimDetails)) {
            echo "All fields are required.";
        } else {
            // Insert data into the database using prepared statement
            $sql = "INSERT INTO claims (id, name, pet_name, claim_details) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            
            // Bind parameters
            $stmt->bind_param("isss", $id, $name, $petName, $claimDetails);
            
            if ($stmt->execute()) {
                echo "Claim submitted successfully.";
                echo '<br>';
                echo '<br>';
                echo '<a href="../html/Index.html">Return to Homepage</a>'; // Add a link to return to the homepage
                echo '<br>';
                echo '<br>';
                echo '<a href="../html/Claims.html">Submit Another Claim</a>'; // Add a link to submit another claim
            } else {
                echo "Error: " . $stmt->error;
            }
            
            $stmt->close();
        }
    }
} else {
    echo "Invalid request.";
}

// Close the connection
$conn->close();

// Function to validate user ID
function isValidUserID($id) {
    // Check if the ID is a positive integer
    return (is_numeric($id) && intval($id) > 0);
}

// Function to check if user exists
function doesUserExist($id) {
    global $conn;
    $sql = "SELECT id FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->store_result();
    return $stmt->num_rows > 0;
}
?>
