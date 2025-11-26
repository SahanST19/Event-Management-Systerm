<?php
session_start();
// Page Protection
if (!isset($_SESSION["user_id"]) || $_SESSION["user_type"] !== 'client') {
    header("location: loging.php");
    exit();
}

include_once 'header.php';
require_once 'includes/dbconnection.php';

// Check if an event_id is provided
if (!isset($_GET['event_id']) || empty($_GET['event_id'])) {
    header("location: client.php");
    exit();
}

$event_id = $_GET['event_id'];

// Fetch event details for confirmation
$sql = "SELECT events.*, venues.venue_name 
        FROM events 
        JOIN venues ON events.venue_id = venues.venue_id 
        WHERE events.event_id = ? AND events.event_status = 'scheduled';";

$stmt = mysqli_stmt_init($conn);
if (mysqli_stmt_prepare($stmt, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $event_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (!($event = mysqli_fetch_assoc($result))) {
        header("location: client.php?error=eventnotfound");
        exit();
    }
} else {
    header("location: client.php?error=stmtfailed");
    exit();
}
?>

<div class="page-container" style="max-width: 700px; margin: 30px auto; padding: 20px; background-color: #fff; border-radius: 8px;">
    
    <h1>Confirm Your Booking</h1>
    <p>Please review the details and confirm your booking.</p>

    <div style="background-color: #f9f9f9; padding: 20px; border-radius: 5px; text-align: left; margin-top: 20px;">
        <h3><?php echo htmlspecialchars($event['event_name']); ?></h3>
        <p><strong>Date:</strong> <?php echo htmlspecialchars($event['event_date']); ?></p>
        <?php if(!empty($event['start_time'])) echo "<p><strong>Time:</strong> " . htmlspecialchars(date('h:i A', strtotime($event['start_time']))) . "</p>"; ?>
        <p><strong>Venue:</strong> <?php echo htmlspecialchars($event['venue_name']); ?></p>
        <p><strong>Description:</strong> <?php echo htmlspecialchars($event['event_description']); ?></p>
    </div>

    <form action="includes/submit-booking.inc.php" method="post" style="margin-top: 20px;">
        <input type="hidden" name="event_id" value="<?php echo $event['event_id']; ?>">
        <button type="submit" name="confirm_booking">Confirm Booking</button>
    </form>
    
    <a href="client.php" style="display:inline-block; margin-top: 20px;">&larr; Cancel and Go Back</a>
</div>

<?php
    include_once 'footer.php';
?>