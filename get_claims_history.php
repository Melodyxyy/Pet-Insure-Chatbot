<?php
// Include Configuration File
require_once('config.php');

// Start the session (if not started already)
session_start();

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    // Redirect the user to the login page or handle as needed
    header("Location: ../html/login.html");
    exit;
}

// Get the user ID from the session
$id = $_SESSION['id'];

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch claims history for the specific user
$sql = "SELECT claim_date, pet_name, claim_details FROM claims WHERE id = ? ORDER BY claim_date DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$claims = [];

while ($row = $result->fetch_assoc()) {
    $claims[] = $row;
}

$stmt->close();

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Insurance Claim History</title>
    <!-- Include your CSS link here -->
</head>
<body>
    <header>
        <h1>Claims History</h1>
    </header>

    <!-- ... your navigation ... -->

    <main>
        <div class="container">
            <h2>Claims History</h2>
            <p>View and manage your insurance claims history:</p>
            <ul id="claimsList">
                <?php foreach ($claims as $claim) : ?>
                    <li>
                        <strong>Claim Date:</strong> <?php echo $claim['claim_date']; ?><br>
                        <strong>Pet Name:</strong> <?php echo $claim['pet_name']; ?><br>
                        <strong>Claim Details:</strong> <?php echo $claim['claim_details']; ?><br>
                        <br>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </main>

    <!-- ... your footer ... -->
</body>
</html>
