<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $membership = $_POST["membership"];
    $petNames = $_POST["pet_names"];
    $password = $_POST["password"];

    // Validate password complexity
    if (!preg_match('/^(?=.*[A-Z])(?=.*[^a-zA-Z]).{8,}$/', $password)) {
        die("Password must contain at least one uppercase letter, one non-letter character, and be at least 8 characters long.");
    }

    // Hash the password using bcrypt
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Database connection
    $conn = new mysqli("localhost", "root", "", "PetInsure");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the email is already registered
    $emailQuery = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($emailQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $emailResult = $stmt->get_result();

    if ($emailResult->num_rows > 0) {
        die("Email address is already registered.");
    }

    // Prepare and execute insert query
    $insertQuery = "INSERT INTO users (username, email, membership_level, pet_names, password) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("sssss", $username, $email, $membership, $petNames, $hashedPassword);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    // Store registration info in session
    session_start();
    $_SESSION["registrationInfo"] = array(
        "username" => $username,
        "email" => $email,
        "membership" => $membership,
        "petNames" => $petNames
    );

    // Redirect to dashboard page
    header("Location: ../html/dashboard.html");
    exit;
}
?>
