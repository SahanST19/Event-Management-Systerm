<?php
session_start();

// 'admin' සහ 'manager' roles walata pamanak ethulu veema sadaha 
if (!isset($_SESSION["user_id"]) || ($_SESSION['user_type'] !== 'admin' && $_SESSION['user_type'] !== 'manager')) {
    header("location: staff.php?error=unauthorized");
    exit();
}
// ===============================

include_once 'header.php';
require_once 'includes/dbconnection.php';
?>

<div class="page-container" style="max-width: 1200px; margin: 30px auto; padding: 20px; background-color: #fff; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
    
    <h1>All Client Bookings</h1>
    <p style="margin-bottom: 20px;">View all the event bookings made by clients.</p>
    <a href="staff.php" style="display:inline-block; margin-bottom: 20px;">&larr; Back to Dashboard</a>
    
    <hr style="margin-bottom: 20px;">

    <table style="width:100%; border-collapse: collapse; margin-top: 20px;">
        <thead style="background-color: #f2f2f2;">
            <tr>
                <th style="padding: 12px; border: 1px solid #ddd; text-align: left;">Booking ID</th>
                <th style="padding: 12px; border: 1px solid #ddd; text-align: left;">Client Name</th>
                <th style="padding: 12px; border: 1px solid #ddd; text-align: left;">Event Booked</th>
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
            $sql = "SELECT 
                        bookings.booking_id, bookings.booking_status,
                        clients.client_name,
                        events.event_name, events.event_date, events.end_date, events.start_time, events.end_time, events.max_attendees
                    FROM bookings
                    JOIN clients ON bookings.client_id = clients.client_id
                    JOIN events ON bookings.event_id = events.event_id
                    ORDER BY events.event_date DESC";
            
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td style='padding: 12px; border: 1px solid #ddd;'>" . htmlspecialchars($row['booking_id']) . "</td>";
                    echo "<td style='padding: 12px; border: 1px solid #ddd;'>" . htmlspecialchars($row['client_name']) . "</td>";
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
                echo "<tr><td colspan='9' style='padding: 12px; border: 1px solid #ddd; text-align: center;'>No bookings found yet.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php
    include_once 'footer.php';
?>