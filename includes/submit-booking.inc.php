<?php
session_start();

// Check if a client is logged in and the form was submitted
if (isset($_POST["confirm_booking"]) && isset($_SESSION["user_id"]) && $_SESSION["user_type"] === 'client') {

    require_once 'dbconnection.php';

    $event_id = $_POST['event_id'];
    $client_id = $_SESSION['user_id']; // Logged-in client's ID
    $booking_date = date('Y-m-d H:i:s'); // Current date and time

    // SQL to insert the new booking
    // The booking_status defaults to 'confirmed' as per your database schema
    $sql = "INSERT INTO bookings (client_id, event_id, booking_date) VALUES (?, ?, ?);";
    
    $stmt = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, "iis", $client_id, $event_id, $booking_date);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // Redirect to the "My Bookings" page with a success message
        header("location: ../my-bookings.php?status=success");
        exit();
    } else {
        // Redirect with an error
        header("location: ../booking.php?event_id=" . $event_id . "&error=stmtfailed");
        exit();
    }

} else {
    // If not submitted or not logged in as a client, redirect to login
    header("location: ../loging.php");
    exit();
}