<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "PetInsure";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch claims history
$sql = "SELECT claim_date, pet_name, claim_details FROM claims WHERE user_id = ? ORDER BY claim_date DESC";
$user_id = 1; // Change this based on your user identification method
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$claims = [];

while ($row = $result->fetch_assoc()) {
    $claims[] = $row;
}

$stmt->close();

// Close the connection
$conn->close();

// Return claims history as JSON
header("Content-Type: application/json");
echo json_encode($claims);
?>