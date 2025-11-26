<?php
session_start();
// Page Protection
if (!isset($_SESSION["user_id"]) || !in_array($_SESSION['user_type'], ['staff', 'admin', 'manager', 'coordinator', 'sales', 'catering', 'cleaning', 'security'])) {
    header("location: loging.php");
    exit();
}
include_once 'header.php';
?>

    <style>/* blackgraoun Photo */
        body {
        margin: 0;
        padding: 0;
        background-image: url('uploads/staff2.png');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        height: 100vh;
        }
    </style>

<div class="page-container" style="text-align: center;">
    
    <h1>Staff Dashboard</h1>
    <p style="margin-bottom: 40px; font-size: 18px; color: #555;">
        Welcome, <strong><?php echo htmlspecialchars($_SESSION["user_name"]); ?></strong>! 
        (Role: <?php echo ucfirst(htmlspecialchars($_SESSION["user_type"])); ?>)
    </p>
    
    <div class="hub-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; text-align: center;">

        <?php
        // Manage Events button for all staff roles
        if (in_array($_SESSION['user_type'], ['staff', 'catering', 'cleaning', 'security', 'sales', 'coordinator'])) {
        ?>
           
        <?php
        }
        ?>

        <?php
        // View All Events button for specific staff roles
        if (in_array($_SESSION['user_type'], ['staff', 'catering', 'cleaning', 'security', 'coordinator', 'sales'])) {
        ?>
            <div class="hub-card" style="border: 1px solid #ddd; border-radius: 8px; padding: 25px; background: #fff;">
                <h3>View All Events</h3>
                <p style="margin: 10px 0 20px 0;">View all events and bookings.</p>
                <a href="view-all-events.php" class="btn btn-red">View All Events</a>
            </div>
        <?php
        }
        ?>

        <?php
        // These cards are visible to 'admin' OR 'manager'
        if ($_SESSION['user_type'] === 'admin' || $_SESSION['user_type'] === 'manager') {
        ?>
            <div class="hub-card" style="border: 1px solid #ddd; border-radius: 8px; padding: 25px; background: #fff;">
                <h3>Manage Venues</h3>
                <p style="margin: 10px 0 20px 0;">Add new venues and view existing ones.</p>
                <a href="manage-venues.php" class="btn btn-blue">Go to Venues</a>
            </div>

            <div class="hub-card" style="border: 1px solid #ddd; border-radius: 8px; padding: 25px; background: #fff;">
                <h3>Manage Events</h3>
                <p style="margin: 10px 0 20px 0;">Create, view, update, and delete events.</p>
                <a href="manage-events.php" class="btn btn-green">Go to Events</a>
            </div>

            <div class="hub-card" style="border: 1px solid #ddd; border-radius: 8px; padding: 25px; background: #fff;">
                <h3>View All Events</h3>
                <p style="margin: 10px 0 20px 0;">View all events, bookings, and manage events.</p>
                <a href="view-all-events.php" class="btn btn-red">View All Events</a>
            </div>

           

            <div class="hub-card" style="border: 1px solid #ddd; border-radius: 8px; padding: 25px; background: #fff;">
                <h3>Manage Clients</h3>
                <p style="margin: 10px 0 20px 0;">View, edit, or delete client accounts.</p>
                <a href="manage-clients.php" class="btn" style="background-color: #ff9800;">Manage Clients</a>
            </div>
            <?php
        } // End of admin/manager section
        ?>

        <?php
        // This card is ONLY visible to 'admin'
        if ($_SESSION['user_type'] === 'admin') {
        ?>
            <div class="hub-card" style="border: 1px solid #ddd; border-radius: 8px; padding: 25px; background: #fff;">
                <h3>Manage Staff</h3>
                <p style="margin: 10px 0 20px 0;">Add, edit, or delete staff accounts.</p>
                <a href="manage-staff.php" class="btn" style="background-color: #555;">Manage Staff</a>
            </div>
        <?php
        } // End of admin-only section
        ?>

        

    </div>

    <a href="includes/logout.inc.php" style="display: block; margin-top: 60px; color: red; text-decoration: none;">Logout</a>
</div>

<?php
    include_once 'footer.php';
?>