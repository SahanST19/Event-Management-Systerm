<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["user_type"] !== 'client') {
    header("location: loging.php");
    exit();
}
include_once 'header.php';
require_once 'includes/dbconnection.php';
?>

    <style>/* blackgraoun Photo */
        body {
        margin: 0;
        padding: 0;
        background-image: url('uploads/Create Event.png');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        height: 100vh;
        }
    </style>

<div class="page-container" style="max-width: 1200px; margin: 30px auto; padding: 20px; background-color: #fff; border-radius: 8px;">

    <h1>My Bookings</h1>
    <p>Here is a list of all the events you have booked.</p>
    <?php if (isset($_GET['status'])) echo '<p style="color:green; padding:10px; background-color:#e9f7ef; border-radius:5px;">Your booking action was successful!</p>'; ?>
    <a href="client.php" style="display:inline-block; margin: 20px 0;">&larr; Back to Dashboard</a>

    <table style="width:100%; border-collapse: collapse;">
        <thead style="background-color: #f2f2f2;">
            <tr>
                <th style="padding: 12px; border: 1px solid #ddd; text-align: left;">Event Name</th>
                <th style="padding: 12px; border: 1px solid #ddd; text-align: left;">Event Start Date</th>
                <th style="padding: 12px; border: 1px solid #ddd; text-align: left;">Event End Date</th>
                <th style="padding: 12px; border: 1px solid #ddd; text-align: left;">Event Start Time</th>
                <th style="padding: 12px; border: 1px solid #ddd; text-align: left;">Event End Time</th>
                <th style="padding: 12px; border: 1px solid #ddd; text-align: left;">Capacity</th>
                <th style="padding: 12px; border: 1px solid #ddd; text-align: left;">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $client_id = $_SESSION['user_id'];
            $sql = "SELECT 
                        events.event_name, events.event_date, events.end_date, events.start_time, events.end_time, events.max_attendees,
                        venues.venue_name, 
                        bookings.booking_date, bookings.booking_status
                    FROM bookings
                    JOIN events ON bookings.event_id = events.event_id
                    JOIN venues ON events.venue_id = venues.venue_id
                    WHERE bookings.client_id = ?
                    ORDER BY events.event_date DESC";
            
            $stmt = mysqli_stmt_init($conn);
            if (mysqli_stmt_prepare($stmt, $sql)) {
                mysqli_stmt_bind_param($stmt, "i", $client_id);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td style='padding: 12px; border: 1px solid #ddd;'>" . htmlspecialchars($row['event_name']) . "</td>";
                        echo "<td style='padding: 12px; border: 1px solid #ddd;'>" . htmlspecialchars($row['event_date']) . "</td>";
                        $end_date = !empty($row['end_date']) ? htmlspecialchars($row['end_date']) : 'N/A';
                        echo "<td style='padding: 12px; border: 1px solid #ddd;'>" . $end_date . "</td>";
                        $start_time = !empty($row['start_time']) ? date('h:i A', strtotime($row['start_time'])) : 'N/A';
                        $end_time = !empty($row['end_time']) ? date('h:i A', strtotime($row['end_time'])) : 'N/A';
                        echo "<td style='padding: 12px; border: 1px solid #ddd;'>" . $start_time . "</td>";
                        echo "<td style='padding: 12px; border: 1px solid #ddd;'>" . $end_time . "</td>";
                        echo "<td style='padding: 12px; border: 1px solid #ddd;'>" . htmlspecialchars($row['max_attendees']) . "</td>";
                        echo "<td style='padding: 12px; border: 1px solid #ddd;'>" . htmlspecialchars($row['booking_status']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7' style='padding: 12px; border: 1px solid #ddd; text-align: center;'>You have not made any bookings yet.</td></tr>";
                }
            }
            ?>
        </tbody>
    </table>
</div>

<?php
    include_once 'footer.php';
?>