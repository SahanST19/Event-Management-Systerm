<?php
session_start();

if (isset($_POST["submit_request"]) && isset($_SESSION["user_id"]) && $_SESSION["user_type"] === 'client') {

    require_once 'dbconnection.php';

    $client_id = $_SESSION['user_id'];
    $event_name = $_POST['event_name'];
    $start_date = $_POST['start_date'];
    $end_date = !empty($_POST['end_date']) ? $_POST['end_date'] : NULL;
    $start_time = $_POST['start_time'];
    $end_time = !empty($_POST['end_time']) ? $_POST['end_time'] : NULL;
    $max_attendees = $_POST['max_attendees'];
    $venue_id = $_POST['venue_id'];
    $event_description = $_POST['event_description'];
    
    // Step 1: Insert the client's request as a 'pending' event
    // The staff_id is set to a default (e.g., 1) or can be NULL if the schema allows. Assuming admin staff_id is 1.
    $sql_event = "INSERT INTO events (event_name, event_date, end_date, start_time, end_time, event_description, venue_id, staff_id, max_attendees, event_status) VALUES (?, ?, ?, ?, ?, ?, ?, 1, ?, 'pending');";
    $stmt_event = mysqli_stmt_init($conn);

    if (mysqli_stmt_prepare($stmt_event, $sql_event)) {
        mysqli_stmt_bind_param($stmt_event, "ssssssii", $event_name, $start_date, $end_date, $start_time, $end_time, $event_description, $venue_id, $max_attendees);
        mysqli_stmt_execute($stmt_event);
        
        // Get the ID of the event we just created
        $new_event_id = mysqli_insert_id($conn);
        mysqli_stmt_close($stmt_event);

        // Step 2: Create a booking record linking this client to the new event
        if ($new_event_id > 0) {
            $sql_booking = "INSERT INTO bookings (client_id, event_id, booking_date, booking_status) VALUES (?, ?, NOW(), 'waitlist');";
            $stmt_booking = mysqli_stmt_init($conn);
            if (mysqli_stmt_prepare($stmt_booking, $sql_booking)) {
                mysqli_stmt_bind_param($stmt_booking, "ii", $client_id, $new_event_id);
                mysqli_stmt_execute($stmt_booking);
                mysqli_stmt_close($stmt_booking);

                header("location: ../my-bookings.php?status=requested");
                exit();
            }
        }
    }

    header("location: ../request-booking.php?error=failed");
    exit();

} else {
    header("location: ../loging.php");
    exit();
}