<?php
session_start();

// Protection: Allow staff, admin, manager
if (isset($_POST["submit"]) && isset($_SESSION["user_id"]) && in_array($_SESSION['user_type'], ['staff', 'admin', 'manager'])) {

    require_once 'dbconnection.php';

    // Form එකෙන් දත්ත ලබා ගැනීම (හිස්තැන් ඉවත් කර)
    $event_id = $_POST['event_id'];
    $eventName = trim($_POST['event_name']);
    $startDate = $_POST['start_date']; // Date doesn't need trim
    $endDate = !empty($_POST['end_date']) ? trim($_POST['end_date']) : NULL;
    $startTime = !empty($_POST['start_time']) ? trim($_POST['start_time']) : NULL;
    $endTime = !empty($_POST['end_time']) ? trim($_POST['end_time']) : NULL;
    $maxAttendees = !empty($_POST['max_attendees']) ? trim($_POST['max_attendees']) : NULL;
    $venueId = $_POST['venue_id'];
    $eventDescription = trim($_POST['event_description']);

    // *** Phone_Number එක මෙතනට අදාළ නැති නිසා ඉවත් කරන ලදී ***

    // ===== නිවැරදි කරන ලද SQL UPDATE Query එක =====
    // අනවශ්‍ය Phone_Number field එක ඉවත් කරන ලදී
    // WHERE clause එකට පෙර comma එකක් නොමැති බව තහවුරු කරන ලදී
    $sql = "UPDATE events SET
                event_name = ?,
                event_date = ?,
                end_date = ?,
                start_time = ?,
                end_time = ?,
                event_description = ?,
                venue_id = ?,
                max_attendees = ?
            WHERE event_id = ?;"; // <-- Query එක මෙතනින් අවසන් වේ (Placeholders 9ක් ඇත)

    $stmt = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        // ===== Bind Param නිවැරදි කරන ලදී (types සහ variables ගණන 9ක්) =====
        // Types: s=string, i=integer. පිළිවෙළට placeholders 9ට අදාළව variables 9ක් යොදයි.
        mysqli_stmt_bind_param($stmt, "ssssssiii",
            $eventName,         // s
            $startDate,         // s (DATE is treated as string here)
            $endDate,           // s
            $startTime,         // s (TIME is treated as string here)
            $endTime,           // s
            $eventDescription,  // s
            $venueId,           // i
            $maxAttendees,      // i
            $event_id           // i (WHERE clause එකට අදාළව)
        );
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // සාර්ථකව Update වූ පසු, Success Message එකක් සමඟ Manage Events පිටුවට යොමු කිරීම
        header("location: ../manage-events.php?status=updated");
        exit();
    } else {
        // SQL සූදානම් කිරීමේ දෝෂයක් ඇත්නම්
        // error_log("SQL Prepare Error in update-event: " . mysqli_error($conn)); // ඔබට අවශ්‍ය නම් දෝෂය log කළ හැක
        header("location: ../edit-event.php?id=" . $event_id . "&error=stmtfailed");
        exit();
    }

} else {
    // If user is not authorized or form not submitted, redirect to login
    header("location: ../loging.php");
    exit();
}
?>