<?php
session_start();

// 'manager' role ekatath ethulu weeemata avasara deema
if (!isset($_SESSION["user_id"]) || !in_array($_SESSION['user_type'], ['staff', 'admin', 'manager'])) {
    header("location: loging.php");
    exit();
}
// ===============================

include_once 'header.php';
require_once 'includes/dbconnection.php';

// Check if an event ID is provided in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("location: manage-events.php");
    exit();
}

$event_id = $_GET['id'];

// Fetch the existing event data from the database
$sql_select = "SELECT * FROM events WHERE event_id = ?;";
$stmt = mysqli_stmt_init($conn);
if (mysqli_stmt_prepare($stmt, $sql_select)) {
    mysqli_stmt_bind_param($stmt, "i", $event_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (!($event_data = mysqli_fetch_assoc($result))) {
        header("location: manage-events.php?error=notfound");
        exit();
    }
    mysqli_stmt_close($stmt);
} else {
    header("location: manage-events.php?error=stmtfailed");
    exit();
}
?>

<div class="form-container">
    <h1>Edit Event</h1>
    
    <form action="includes/update-event.inc.php" method="post">
        <input type="hidden" name="event_id" value="<?php echo htmlspecialchars($event_data['event_id']); ?>">

        <label for="event_name">Event Name:</label>
        <input type="text" id="event_name" name="event_name" value="<?php echo htmlspecialchars($event_data['event_name']); ?>" required>

        <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" name="start_date" value="<?php echo htmlspecialchars($event_data['event_date']); ?>" required>

        <label for="end_date">End Date (Optional):</label>
        <input type="date" id="end_date" name="end_date" value="<?php echo htmlspecialchars($event_data['end_date']); ?>">

        <label for="start_time">Start Time (Optional):</label>
        <input type="time" id="start_time" name="start_time" value="<?php echo htmlspecialchars($event_data['start_time']); ?>">

        <label for="end_time">End Time (Optional):</label>
        <input type="time" id="end_time" name="end_time" value="<?php echo htmlspecialchars($event_data['end_time']); ?>">

        <label for="max_attendees">Capacity (Max Attendees):</label>
        <input type="number" id="max_attendees" name="max_attendees" value="<?php echo htmlspecialchars($event_data['max_attendees']); ?>" placeholder="e.g., 100">

        <label for="venue_id">Select Venue:</label>
        <select id="venue_id" name="venue_id" required>
            <?php
            $sql_venues = "SELECT * FROM venues ORDER BY venue_name";
            $result_venues = $conn->query($sql_venues);
            if ($result_venues->num_rows > 0) {
                while($row_venue = $result_venues->fetch_assoc()) {
                    $selected = ($row_venue['venue_id'] == $event_data['venue_id']) ? 'selected' : '';
                    echo "<option value='" . $row_venue['venue_id'] . "' " . $selected . ">" . htmlspecialchars($row_venue['venue_name']) . "</option>";
                }
            }
            ?>
        </select>
        
        <label for="event_description">Description:</label>
        <textarea id="event_description" name="event_description" rows="4"><?php echo htmlspecialchars($event_data['event_description']); ?></textarea>

        <button name="submit" type="submit">Update Event</button>
    </form>
    <p style="margin-top:20px;"><a href="manage-events.php">Back to Event List</a></p>
</div>

<?php
    include_once 'footer.php';
?>