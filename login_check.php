<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Create a database connection
    $conn = new mysqli("localhost", "root", "", "PetInsure");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute a query to retrieve the hashed password for the given username
    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($storedPasswordHash);
    $stmt->fetch();
    $stmt->close();

    // Verify the provided password against the stored hash
    if (password_verify($password, $storedPasswordHash)) {
        // Set a session variable to indicate successful login
        $_SESSION["logged_in"] = true;

        // Redirect to dashboard
        header("Location: dashboard.html");
        exit;
    } else {
        // Redirect back to login with an error parameter
        header("Location: login.html?error=1");
        exit;
    }

    $conn->close();
}
?>
