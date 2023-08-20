<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $petType = $_POST["pet-type"];
    $petName = $_POST["pet-name"];
    $age = $_POST["age"];
    $email = $_POST["email"];

    //Include Configuration File
    require_once('config.php');
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL query with a parameterized query
    $sql = "INSERT INTO Quotes (pet_type, pet_name, age, email) VALUES (?, ?, ?, ?)";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    // Bind parameters to the statement
    $stmt->bind_param("ssis", $petType, $petName, $age, $email);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Quote request submitted successfully!";
        echo '<br>';
        echo '<br>';
        echo '<a href="../html/Index.html">Return to Homepage</a>'; // Add a link to return to the homepage
        echo '<br>';
        echo '<br>';
        echo '<a href="../html/Get_Quote.html">Submit Another Inquiry</a>'; // Add a link to submit another inquiry.
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and database connection
    $stmt->close();
    $conn->close();
} else {
    echo "Form submission error.";
}
?>