<?php
session_start();
// Allow only logged-in clients to view available venues
if (!isset($_SESSION["user_id"]) || $_SESSION["user_type"] !== 'client') {
    header("location: loging.php");
    exit();
}

include_once 'header.php';
require_once 'includes/dbconnection.php';
?>

<style>
    body {
    margin: 0;
    padding: 0;
    background-image: url('uploads/Available Venues1.png');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    min-height: 100vh; /* Changed height to min-height for better compatibility */
    }
</style>

<div class="page-container" style="max-width: 1100px; margin: 30px auto; padding: 20px; background-color: rgba(255, 255, 255, 0.95); border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
    <h1>Available Venues</h1>
    <p style="margin-bottom: 20px;">These venues are added by the event management team.</p>
    <a href="client.php" style="display:inline-block; margin-bottom: 20px;">&larr; Back to Dashboard</a>

    <table style="width:100%; border-collapse: collapse; margin-top: 10px;">
        <thead style="background-color: #f2f2f2;">
            <tr>
                <th style="padding: 12px; border: 1px solid #ddd; text-align: left;">Venue Name</th>
                <th style="padding: 12px; border: 1px solid #ddd; text-align: left;">Address</th>
                <th style="padding: 12px; border: 1px solid #ddd; text-align: left;">Capacity</th>
                <th style="padding: 12px; border: 1px solid #ddd; text-align: left;">Email</th>
                <th style="padding: 12px; border: 1px solid #ddd; text-align: left;">Phone Number</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // ===== SQL Query එකට Phone_Number එකතු කරන ලදී =====
            $sql = "SELECT venue_name, address, capacity, contact_info, Phone_Number FROM venues ORDER BY venue_name ASC";
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td style='padding: 12px; border: 1px solid #ddd;'>" . htmlspecialchars($row['venue_name'] ?? '') . "</td>";
                    echo "<td style='padding: 12px; border: 1px solid #ddd;'>" . htmlspecialchars($row['address'] ?? '') . "</td>";
                    echo "<td style='padding: 12px; border: 1px solid #ddd;'>" . htmlspecialchars($row['capacity'] ?? '') . "</td>";
                    echo "<td style='padding: 12px; border: 1px solid #ddd;'>" . htmlspecialchars($row['contact_info'] ?? '') . "</td>";
                    // ===== Phone Number එක පෙන්වීමට අලුත් cell එකක් =====
                    echo "<td style='padding: 12px; border: 1px solid #ddd;'>" . htmlspecialchars($row['Phone_Number'] ?? '') . "</td>";
                    echo "</tr>";
                }
            } else {
                // ===== Colspan අගය 5 ලෙස වෙනස් කරන ලදී =====
                echo "<tr><td colspan='5' style='padding: 12px; border: 1px solid #ddd; text-align: center;'>No venues available right now.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php
include_once 'footer.php';
?>