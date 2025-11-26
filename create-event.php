<?php
session_start();

// 'manager' role ekatath ethul veemata avasara deema 
if (!isset($_SESSION["user_id"]) || !in_array($_SESSION['user_type'], ['staff', 'admin', 'manager'])) {
    header("location: loging.php");
    exit();
}
// ===============================

include_once 'header.php';
require_once 'includes/dbconnection.php';
?>

<div class="form-container">
    <h1>Create a New Event</h1>
    <?php 
    if(isset($_GET['status']) && $_GET['status'] == 'created'){
        echo '<p style="color:green; text-align:center;">Event created successfully!</p>';
    }
    ?>
    <form action="includes/create-event.inc.php" method="post">
        
        <label for="event_name">Event Name:</label>
        <input type="text" id="event_name" name="event_name" required>

        <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" name="start_date" required>

        <label for="end_date">End Date (Optional):</label>
        <input type="date" id="end_date" name="end_date">

        <label for="start_time">Start Time (Optional):</label>
        <input type="time" id="start_time" name="start_time">

        <label for="end_time">End Time (Optional):</label>
        <input type="time" id="end_time" name="end_time">

        <label for="max_attendees">Capacity (Max Attendees):</label>
        <input type="number" id="max_attendees" name="max_attendees" placeholder="e.g., 100">

        <label for="venue_id">Select Venue:</label>
            <select id="venue_id" name="venue_id" required>
                <option value="">-- Choose a Venue --</option>
                <?php
                $sql_venues = "SELECT * FROM venues ORDER BY venue_name";
                $result_venues = $conn->query($sql_venues);
                if ($result_venues->num_rows > 0) {
                    while($row_venue = $result_venues->fetch_assoc()) {
                        echo "<option value='" . $row_venue['venue_id'] . "'>" . htmlspecialchars($row_venue['venue_name']) . "</option>";
                    }
                } else {
                    echo "<option value=''>No venues found. Please add one first.</option>";
                }
                ?>
            </select>
        
        <label for="event_description">Description:</label>
        <textarea id="event_description" name="event_description" rows="4"></textarea>

        <button name="submit" type="submit">Create Event</button>
    </form>
    <p style="margin-top:20px;"><a href="staff.php">Back to Dashboard</a></p>
</div>

<?php
    include_once 'footer.php';
?>