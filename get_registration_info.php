<?php
//Include Configuration File
require_once('config.php');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get registration info from session
$registrationInfo = $_SESSION["registrationInfo"] ?? [];

// Fetch additional info from the database using prepared statement
$username = $registrationInfo["username"] ?? "";
$query =
    "SELECT email, membership_level, pet_names FROM users WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $registrationInfo["email"] = $row["email"];
    $registrationInfo["membership"] = $row["membership_level"];
    $registrationInfo["petNames"] = $row["pet_names"];
}

$stmt->close();
$conn->close();

// Return the registration info as JSON
header("Content-Type: application/json");
echo json_encode($registrationInfo);
?>