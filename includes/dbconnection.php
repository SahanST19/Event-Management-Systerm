<?php

// --- Database Credentials ---
$hostname = "localhost";    // Server eke nama. Localhost waladi samanayen "localhost" 
$username = "root";         // XAMPP/WAMP wala default username eka "root" 
$password = "";             // XAMPP/WAMP wala default password hiswa thabanna
$database = "event_management"; // phpMyAdmin eke hadapu database eke nama

// --- Database Connection eka ---
$conn = new mysqli($hostname, $username, $password, $database);

// --- Connection asarthakanam---
if ($conn->connect_error) {
    // connection eka aulnam, error msg ekak enwa script eka nathara karanawa .
    die("Database Connection Failed: " . $conn->connect_error);
}

?>