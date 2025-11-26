<?php
session_start();
// Admin/Manager level protection
if (!isset($_SESSION["user_id"]) || ($_SESSION["user_type"] !== 'admin' && $_SESSION["user_type"] !== 'manager')) {
    header("location: staff.php?error=unauthorized");
    exit(); 
}
include_once 'header.php';
require_once 'includes/dbconnection.php';
?>

    <style> /* blackground photo */
        body {
        margin: 0;
        padding: 0;
        background-image: url('uploads/Available Venues1.png');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        height: 100vh;
    }
    </style>

<div class="page-container">
    <h1>Manage Clients</h1>
    <p>View, edit, or delete existing client accounts.</p>
    <a href="staff.php" style="display:inline-block; margin-bottom: 20px;">&larr; Back to Dashboard</a>
    <hr style="margin-bottom: 20px;">

    <?php if(isset($_GET['status'])) echo '<p style="color:green;">Action was successful!</p>'; ?>

    <table style="width:100%; border-collapse: collapse; margin-top: 20px;">
        <thead style="background-color: #f2f2f2;">
            <tr>
                <th style="padding: 12px; border: 1px solid #ddd; text-align: left;">Client Name</th>
                <th style="padding: 12px; border: 1px solid #ddd; text-align: left;">Email</th>
                <th style="padding: 12px; border: 1px solid #ddd; text-align: left;">Contact No</th>
                <th style="padding: 12px; border: 1px solid #ddd; text-align: left;">Address</th>
                <th style="padding: 12px; border: 1px solid #ddd; text-align: left;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql_select = "SELECT * FROM clients ORDER BY client_name ASC";
            $result = $conn->query($sql_select);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td style='padding: 12px; border: 1px solid #ddd;'>" . htmlspecialchars($row['client_name']) . "</td>";
                    echo "<td style='padding: 12px; border: 1px solid #ddd;'>" . htmlspecialchars($row['email_address']) . "</td>";
                    echo "<td style='padding: 12px; border: 1px solid #ddd;'>" . htmlspecialchars($row['contact_no']) . "</td>";
                    echo "<td style='padding: 12px; border: 1px solid #ddd;'>" . htmlspecialchars($row['address']) . "</td>";
                    echo "<td style='padding: 12px; border: 1px solid #ddd;'>";
                    echo "<a href='edit-client.php?id=" . $row['client_id'] . "'>Edit</a> | ";
                    echo "<a href='includes/delete-client.inc.php?id=" . $row['client_id'] . "' onclick='return confirm(\"Are you sure? This will also delete all bookings made by this client!\");' style='color:red;'>Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5' style='padding: 12px; border: 1px solid #ddd; text-align: center;'>No clients found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php include_once 'footer.php'; ?>