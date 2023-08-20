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
?>
