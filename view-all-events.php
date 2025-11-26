<?php
session_start();
// Page Protection - Admin, Manager, and specific staff roles
if (!isset($_SESSION["user_id"]) || !in_array($_SESSION['user_type'], ['admin', 'manager', 'staff', 'coordinator', 'sales'])) {
    header("location: staff.php?error=unauthorized");
    exit();
}

include_once 'header.php';
require_once 'includes/dbconnection.php';
?>

<div class="page-container" style="max-width: 1400px; margin: 30px auto; padding: 20px; background-color: #fff; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
    
    <h1>View All Events & Bookings</h1>
    <p style="margin-bottom: 20px;">Comprehensive view of all events and their bookings.</p>
    <a href="staff.php" style="display:inline-block; margin-bottom: 20px;">&larr; Back to Dashboard</a>
    
    <div class="action-links" style="margin-bottom: 30px;">
        
    </div>

    <hr style="margin-bottom: 30px;">

    <!-- Events Section -->
    <h2>All Events</h2>
    <table style="width:100%; border-collapse: collapse; margin-top: 20px;">
        <thead style="background-color: #f2f2f2;">
            <tr>
                <th style="padding: 12px; border: 1px solid #ddd; text-align: left;">Event Name</th>
                <th style="padding: 12px; border: 1px solid #ddd; text-align: left;">Date</th>
                <th style="padding: 12px; border: 1px solid #ddd; text-align: left;">Venue</th>
                <th style="padding: 12px; border: 1px solid #ddd; text-align: left;">Status</th>
                
                
            </tr>
        </thead>
        <tbody>
            <?php
            $sql_events = "SELECT 
                events.*, 
                venues.venue_name,
                COUNT(bookings.booking_id) as total_bookings
                FROM events 
                JOIN venues ON events.venue_id = venues.venue_id 
                LEFT JOIN bookings ON events.event_id = bookings.event_id
                GROUP BY events.event_id
                ORDER BY events.event_date DESC";
            
            $result_events = $conn->query($sql_events);

            if ($result_events->num_rows > 0) {
                while($row = $result_events->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td style='padding: 12px; border: 1px solid #ddd;'>" . htmlspecialchars($row['event_name']) . "</td>";
                    echo "<td style='padding: 12px; border: 1px solid #ddd;'>" . htmlspecialchars($row['event_date']) . "</td>";
                    echo "<td style='padding: 12px; border: 1px solid #ddd;'>" . htmlspecialchars($row['venue_name']) . "</td>";
                    echo "<td style='padding: 12px; border: 1px solid #ddd;'>" . htmlspecialchars($row['event_status']) . "</td>";
                    #echo "<td style='padding: 12px; border: 1px solid #ddd;'>" . htmlspecialchars($row['total_bookings']) . "</td>";
                    #echo "<td style='padding: 12px; border: 1px solid #ddd;'>";
                    #echo "<a href='edit-event.php?id=" . $row['event_id'] . "' style='color:#007bff; text-decoration:underline; margin-right:8px;'>Edit</a>";
                    #echo "<span style='color:#999; margin:0 6px;'>|</span>";
                    #echo "<a href='includes/delete-event.inc.php?id=" . $row['event_id'] . "' style='color:#d9534f; text-decoration:underline;' onclick='return confirm(\"Delete this event?\");'>Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6' style='padding: 12px; border: 1px solid #ddd; text-align: center;'>No events found.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <hr style="margin: 40px 0;">

    <!-- Bookings Section -->
    <h2>All Bookings (Clients)</h2>
    <table style="width:100%; border-collapse: collapse; margin-top: 20px;">
        <thead style="background-color: #f2f2f2;">
            <tr>
                <th style="padding: 12px; border: 1px solid #ddd; text-align: left;">Booking ID</th>
                <th style="padding: 12px; border: 1px solid #ddd; text-align: left;">Client Name</th>
                <th style="padding: 12px; border: 1px solid #ddd; text-align: left;">Event Booked</th>
                <th style="padding: 12px; border: 1px solid #ddd; text-align: left;">Event Date</th>
                <th style="padding: 12px; border: 1px solid #ddd; text-align: left;">Venue</th>
                <th style="padding: 12px; border: 1px solid #ddd; text-align: left;">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql_bookings = "SELECT 
                bookings.booking_id, bookings.booking_status,
                clients.client_name,
                events.event_name, events.event_date,
                venues.venue_name
                FROM bookings
                JOIN clients ON bookings.client_id = clients.client_id
                JOIN events ON bookings.event_id = events.event_id
                JOIN venues ON events.venue_id = venues.venue_id
                ORDER BY events.event_date DESC";
            
            $result_bookings = $conn->query($sql_bookings);

            if ($result_bookings->num_rows > 0) {
                while($row = $result_bookings->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td style='padding: 12px; border: 1px solid #ddd;'>" . htmlspecialchars($row['booking_id']) . "</td>";
                    echo "<td style='padding: 12px; border: 1px solid #ddd;'>" . htmlspecialchars($row['client_name']) . "</td>";
                    echo "<td style='padding: 12px; border: 1px solid #ddd;'>" . htmlspecialchars($row['event_name']) . "</td>";
                    echo "<td style='padding: 12px; border: 1px solid #ddd;'>" . htmlspecialchars($row['event_date']) . "</td>";
                    echo "<td style='padding: 12px; border: 1px solid #ddd;'>" . htmlspecialchars($row['venue_name']) . "</td>";
                    echo "<td style='padding: 12px; border: 1px solid #ddd;'>" . htmlspecialchars($row['booking_status']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6' style='padding: 12px; border: 1px solid #ddd; text-align: center;'>No bookings found yet.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php
    include_once 'footer.php';
?>
