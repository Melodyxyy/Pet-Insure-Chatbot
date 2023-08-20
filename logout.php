<?php
session_start();
session_destroy();
$message = "The account has been logged out.";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Logged Out</title>
</head>
<body>
    <h1><?php echo $message; ?></h1>
    <p>You have been successfully logged out. Please <a href="../html/login.html">login</a> again if needed.</p>
</body>
</html>
