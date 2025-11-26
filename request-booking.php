<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["user_type"] !== 'client') {
    header("location: loging.php");
    exit();
}
include_once 'header.php';
require_once 'includes/dbconnection.php';
?>


<div class="form-container">
    <h1>Request a New Booking</h1>
    <p>Please fill out the details for the event you would like to book.</p>
    <?php if(isset($_GET['error'])) echo '<p class="error-msg">Booking request failed. Please try again.</p>'; ?>

    <form action="includes/request-booking.inc.php" method="post">
        
        <label for="event_name">Event Type / Name:</label>
        <input type="text" id="event_name" name="event_name" placeholder="e.g., Wedding, Birthday Party" required>

        <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" name="start_date" required>

        <label for="end_date">End Date (Optional):</label>
        <input type="date" id="end_date" name="end_date">

        <label for="start_time">Start Time:</label>
        <input type="time" id="start_time" name="start_time" required>
        
        <label for="end_time">End Time (Optional):</label>
        <input type="time" id="end_time" name="end_time">

        <label for="max_attendees">Number of Guests (Approx.):</label>
        <input type="number" id="max_attendees" name="max_attendees" placeholder="e.g., 50" required>

        <label for="venue_id">Preferred Venue:</label>
            <select id="venue_id" name="venue_id" required>
                <option value="">-- Choose a Venue --</option>
                <?php
                $sql_venues = "SELECT * FROM venues ORDER BY venue_name";
                $result_venues = $conn->query($sql_venues);
                if ($result_venues->num_rows > 0) {
                    while($row_venue = $result_venues->fetch_assoc()) {
                        echo "<option value='" . $row_venue['venue_id'] . "'>" . htmlspecialchars($row_venue['venue_name']) . "</option>";
                    }
                }
                ?>
            </select>
        
        <label for="event_description">Additional Details:</label>
        <textarea id="event_description" name="event_description" rows="4" placeholder="Any special requests or details..."></textarea>

        <button name="submit_request" type="submit">Submit Booking Request</button>
    </form>
    <p style="margin-top:20px;"><a href="client.php">Back to Dashboard</a></p>
</div>

<?php
    include_once 'footer.php';
?>