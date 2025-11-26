<?php
session_start();

// 'manager' role ekatath meme pituwata ethulath viya heki vana paridi
if (!isset($_SESSION["user_id"]) || !in_array($_SESSION['user_type'], ['staff', 'admin', 'manager'])) {
    header("location: loging.php");
    exit();
}
// ===============================

include_once 'header.php';
require_once 'includes/dbconnection.php';
?>

<style> /* blackground photo */
	body {
    margin: 0;
    padding: 0;
    background-image: url('uploads/hero-dashboard.png');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    height: 100vh;
  }
</style>

<div class="page-container">
    
    <h1>Manage Events</h1>
    <p style="margin-bottom: 20px;">Here you can create new events or edit/delete existing ones.</p>
    <a href="staff.php" style="display:inline-block; margin-bottom: 20px;">&larr; Back to Dashboard</a>

    <div class="action-links" style="margin-bottom: 30px;">
        <a href="create-event.php" class="btn btn-green">+ Create New Event</a>
    </div>

    <?php if(isset($_GET['status'])) echo '<p style="color:green;">Action was successful!</p>'; ?>

    <table style="width:100%; border-collapse: collapse; margin-top: 20px;">
        <thead style="background-color: #f2f2f2;">
            <tr>
                <th style="padding: 12px; border: 1px solid #ddd; text-align: left;">Event Name</th>
                <th style="padding: 12px; border: 1px solid #ddd; text-align: left;">Date</th>
                <th style="padding: 12px; border: 1px solid #ddd; text-align: left;">Venue</th>
                <th style="padding: 12px; border: 1px solid #ddd; text-align: left;">Status</th>
                <th style="padding: 12px; border: 1px solid #ddd; text-align: left;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT events.*, venues.venue_name FROM events JOIN venues ON events.venue_id = venues.venue_id ORDER BY events.event_date DESC";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td style='padding: 12px; border: 1px solid #ddd;'>" . htmlspecialchars($row['event_name']) . "</td>";
                    echo "<td style='padding: 12px; border: 1px solid #ddd;'>" . htmlspecialchars($row['event_date']) . "</td>";
                    echo "<td style='padding: 12px; border: 1px solid #ddd;'>" . htmlspecialchars($row['venue_name']) . "</td>";
                    echo "<td style='padding: 12px; border: 1px solid #ddd;'>" . htmlspecialchars($row['event_status']) . "</td>";
                    echo "<td style='padding: 12px; border: 1px solid #ddd;'>";
                    echo "<a href='edit-event.php?id=" . $row['event_id'] . "' style='text-decoration:none;'>Edit</a> | ";
                    echo "<a href='includes/delete-event.inc.php?id=" . $row['event_id'] . "' style='text-decoration:none; color:red;' onclick='return confirm(\"Are you sure?\");'>Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5' style='padding: 12px; border: 1px solid #ddd; text-align: center;'>No events found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php
    include_once 'footer.php';
?>