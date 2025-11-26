<?php
session_start();

if (isset($_POST["submit"]) && isset($_SESSION["user_id"]) && in_array($_SESSION["user_type"], ['staff','admin','manager'])) {

    require_once 'dbconnection.php';

    // Form eken siyaluma data laba genima
    $eventName = $_POST['event_name'];
    $startDate = $_POST['start_date'];
    $endDate = !empty($_POST['end_date']) ? $_POST['end_date'] : NULL;
    $startTime = !empty($_POST['start_time']) ? $_POST['start_time'] : NULL;
    $endTime = !empty($_POST['end_time']) ? $_POST['end_time'] : NULL;
    $maxAttendees = !empty($_POST['max_attendees']) ? $_POST['max_attendees'] : NULL;
    $venueId = $_POST['venue_id'];
    $eventDescription = $_POST['event_description'];
    $staffId = $_SESSION['user_id'];
    $Phone_Number = $_SESSION['Phone_Number'];

    // Database schema only has: event_name, event_date, event_status (default), event_description, venue_id, staff_id
    $sql = "INSERT INTO events (event_name, event_date, event_description, venue_id, staff_id) VALUES (?, ?, ?, ?, ?);";

    $stmt = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        // Bind: s (name), s (date), s (desc), i (venue), i (staff)
        mysqli_stmt_bind_param($stmt, "sssii", $eventName, $startDate, $eventDescription, $venueId, $staffId, $Phone_Number);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        header("location: ../create-event.php?status=created");
        exit();
    } else {
        header("location: ../create-event.php?error=stmtfailed");
        exit();
    }

} else {
    header("location: ../loging.php");
    exit();
}