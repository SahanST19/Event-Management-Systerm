<?php
    include_once 'header.php';
?>

    <div class="page">
    <a class="back" href="client.php">← Back to Profile</a>
    <h2>My Events</h2>

    <!-- Demo static table — DB data loop කරන්න -->
    <table>
        <thead>
        <tr>
            <th>Title</th>
            <th>Date</th>
            <th>Time</th>
            <th>Venue</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <!-- Example row -->
        <tr>
            <td>Annual Meetup</td>
            <td>2025-11-05</td>
            <td>18:00</td>
            <td>Main Hall</td>
            <td><a class="btn" href="booking.php">New Booking</a></td>
        </tr>
        </tbody>
    </table>
<?php
    include_once 'footer.php';
?>