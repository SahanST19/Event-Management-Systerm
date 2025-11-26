<?php
session_start();
if (!isset($_SESSION["user_id"]) || ($_SESSION["user_type"] !== 'admin' && $_SESSION["user_type"] !== 'manager')) {
    header("location: staff.php?error=unauthorized");
    exit();
}
include_once 'header.php';
require_once 'includes/dbconnection.php';

// Handle add venue logic
if (isset($_POST['add_venue'])) {
    $venue_name = trim($_POST['venue_name']);
    $address = trim($_POST['address']);
    $capacity = trim($_POST['capacity']);
    $contact_info = trim($_POST['contact_info']);
    $Phone_Number = trim($_POST['Phone_Number']);

    if (!empty($venue_name) && !empty($capacity)) {
        $sql_insert = "INSERT INTO venues (venue_name, address, capacity, contact_info, Phone_Number) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);
        if (mysqli_stmt_prepare($stmt, $sql_insert)) {
            mysqli_stmt_bind_param($stmt, "ssiss", $venue_name, $address, $capacity, $contact_info, $Phone_Number);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            header("Location: manage-venues.php?status=added");
            exit();
        }
    }
}

// Handle delete venue logic
if (isset($_POST['delete_venue']) && isset($_POST['venue_id'])) {
    $venue_id = (int)$_POST['venue_id'];
    if ($venue_id > 0) {
        // Check if venue is linked to any events BEFORE deleting
        $sql_check = "SELECT COUNT(*) as event_count FROM events WHERE venue_id = ?";
        $stmt_check = mysqli_stmt_init($conn);
        if (mysqli_stmt_prepare($stmt_check, $sql_check)) {
            mysqli_stmt_bind_param($stmt_check, "i", $venue_id);
            mysqli_stmt_execute($stmt_check);
            $result_check = mysqli_stmt_get_result($stmt_check);
            $count_data = mysqli_fetch_assoc($result_check);
            mysqli_stmt_close($stmt_check);

            if ($count_data['event_count'] == 0) {
                // No events linked, safe to delete
                $sql_delete = "DELETE FROM venues WHERE venue_id = ?";
                $stmt = mysqli_stmt_init($conn);
                if (mysqli_stmt_prepare($stmt, $sql_delete)) {
                    mysqli_stmt_bind_param($stmt, "i", $venue_id);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt);
                    header("Location: manage-venues.php?status=deleted");
                    exit();
                }
            } else {
                // Venue is linked, cannot delete
                header("Location: manage-venues.php?error=venuelinked");
                exit();
            }
        }
    }
     // Redirect if delete failed or ID was invalid
     header("Location: manage-venues.php?error=deletefailed");
     exit();
}


// Handle update venue logic
if (isset($_POST['update_venue']) && isset($_POST['venue_id'])) {
    $venue_id = (int)$_POST['venue_id'];
    $venue_name = trim($_POST['venue_name'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $capacity = trim($_POST['capacity'] ?? '');
    $contact_info = trim($_POST['contact_info'] ?? '');
    $Phone_Number = trim($_POST['Phone_Number'] ?? ''); // Corrected field name

    if ($venue_id > 0 && $venue_name !== '' && $capacity !== '') {
        $sql_update = "UPDATE venues SET venue_name = ?, address = ?, capacity = ?, contact_info = ?, Phone_Number = ? WHERE venue_id = ?";
        $stmt = mysqli_stmt_init($conn);
        if (mysqli_stmt_prepare($stmt, $sql_update)) {
            mysqli_stmt_bind_param($stmt, "ssissi", $venue_name, $address, $capacity, $contact_info, $Phone_Number, $venue_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            header("Location: manage-venues.php?status=updated");
            exit();
        } else {
             header("Location: manage-venues.php?error=updatefailed");
             exit();
        }
    } else {
        header("Location: manage-venues.php?edit=".$venue_id."&error=invaliddata");
        exit();
    }
}
?>

<div class="page-container" style="max-width: 1100px;"> <h1>Manage Venues</h1>
    <p style="margin-bottom: 20px;">Add, edit, or delete event venues.</p>
    <a href="staff.php" style="display:inline-block; margin-bottom: 20px;">&larr; Back to Dashboard</a>
    
    <hr>

    <div class="form-container" style="max-width: 100%; margin: 20px 0;">
        <form action="manage-venues.php" method="post">
            <h2>Add New Venue</h2>
            <?php
                 if (isset($_GET['status'])) {
                     if ($_GET['status'] == 'added') echo '<p style="color:green;">Venue added successfully!</p>';
                     elseif ($_GET['status'] == 'deleted') echo '<p style="color:green;">Venue deleted successfully!</p>';
                     elseif ($_GET['status'] == 'updated') echo '<p style="color:green;">Venue updated successfully!</p>';
                 }
                 if (isset($_GET['error'])) {
                      if ($_GET['error'] == 'venuelinked') echo '<p class="error-msg">Cannot delete venue: It is currently linked to one or more events.</p>';
                      else echo '<p class="error-msg">An error occurred. Please try again.</p>';
                 }
            ?>
            <div> <label>Venue Name:</label> <input type="text" name="venue_name" required> </div>
            <div> <label>Address:</label> <input type="text" name="address"> </div>
            <div> <label>Capacity:</label> <input type="number" name="capacity" required> </div>
            <div> <label>Contact Info (Email/Other):</label> <input type="text" name="contact_info"> </div>
            <div> <label>Phone Number:</label> <input type="text" name="Phone_Number"> </div>
            <button name="add_venue" type="submit">Add Venue</button>
        </form>
    </div>
    
    <hr style="margin:30px 0;">

    <?php
    $editingVenue = null;
    if (isset($_GET['edit'])) {
        $edit_id = (int)$_GET['edit'];
        if ($edit_id > 0) {
            $stmt = mysqli_stmt_init($conn);
            if (mysqli_stmt_prepare($stmt, "SELECT venue_id, venue_name, address, capacity, contact_info, Phone_Number FROM venues WHERE venue_id = ?")) {
                mysqli_stmt_bind_param($stmt, "i", $edit_id);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                if ($result && $result->num_rows === 1) {
                    $editingVenue = $result->fetch_assoc();
                }
                mysqli_stmt_close($stmt);
            }
        }
    }
    if ($editingVenue) {
    ?>
    <h2>Edit Venue: <?php echo htmlspecialchars($editingVenue['venue_name'] ?? ''); ?></h2>
    <div class="form-container" style="max-width: 100%; margin: 20px 0;">
        <form action="manage-venues.php" method="post" style="background-color: #fff7e6;">
            <input type="hidden" name="venue_id" value="<?php echo (int)$editingVenue['venue_id']; ?>">
            <div> <label>Venue Name:</label> <input type="text" name="venue_name" value="<?php echo htmlspecialchars($editingVenue['venue_name'] ?? ''); ?>" required> </div>
            <div> <label>Address:</label> <input type="text" name="address" value="<?php echo htmlspecialchars($editingVenue['address'] ?? ''); ?>"> </div>
            <div> <label>Capacity:</label> <input type="number" name="capacity" value="<?php echo htmlspecialchars($editingVenue['capacity'] ?? ''); ?>" required> </div>
            <div> <label>Contact Info:</label> <input type="text" name="contact_info" value="<?php echo htmlspecialchars($editingVenue['contact_info'] ?? ''); ?>"> </div>
            <div> <label>Phone Number:</label> <input type="text" name="Phone_Number" value="<?php echo htmlspecialchars($editingVenue['Phone_Number'] ?? ''); ?>"> </div>
            <div style="display:flex; gap:10px; margin-top: 15px;">
                <button name="update_venue" type="submit" class="btn btn-green" style="width:auto;">Save Changes</button>
                <a href="manage-venues.php" class="btn" style="background:#777; color:#fff; width:auto;">Cancel</a>
            </div>
        </form>
    </div>
    <hr style="margin-top:30px; margin-bottom: 30px;">
    <?php } ?>

    <h2>Existing Venues</h2>
    <table style="width:100%; border-collapse: collapse; margin-top: 20px; table-layout: fixed;">
        <thead style="background-color: #f2f2f2;">
            <tr>
                <th style="padding: 12px; border: 1px solid #ddd; text-align: left; width: 20%;">Venue Name</th>
                <th style="padding: 12px; border: 1px solid #ddd; text-align: left; width: 25%;">Address</th>
                <th style="padding: 12px; border: 1px solid #ddd; text-align: left; width: 10%;">Capacity</th>
                <th style="padding: 12px; border: 1px solid #ddd; text-align: left; width: 15%;">Email</th>
                <th style="padding: 12px; border: 1px solid #ddd; text-align: left; width: 15%;">Phone Number</th>
                <th style="padding: 12px; border: 1px solid #ddd; text-align: left; width: 15%;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql_select = "SELECT * FROM venues ORDER BY venue_name ASC";
            $result = $conn->query($sql_select);

            if ($result && $result->num_rows > 0) { // Check if $result is valid
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td style='padding: 12px; border: 1px solid #ddd; word-wrap: break-word;'>" . htmlspecialchars($row['venue_name'] ?? '') . "</td>";
                    echo "<td style='padding: 12px; border: 1px solid #ddd; word-wrap: break-word;'>" . htmlspecialchars($row['address'] ?? '') . "</td>";
                    echo "<td style='padding: 12px; border: 1px solid #ddd;'>" . htmlspecialchars($row['capacity'] ?? '') . "</td>";
                    echo "<td style='padding: 12px; border: 1px solid #ddd; word-wrap: break-word;'>" . htmlspecialchars($row['contact_info'] ?? '') . "</td>";
                    echo "<td style='padding: 12px; border: 1px solid #ddd; word-wrap: break-word;'>" . htmlspecialchars($row['Phone_Number'] ?? '') . "</td>";
                    echo "<td style='padding: 12px; border: 1px solid #ddd;'>";
                    echo "<a href='manage-venues.php?edit=" . (int)$row['venue_id'] . "' style='color:#007bff; text-decoration:none;'>Edit</a> | ";
                    $formId = 'del-' . (int)$row['venue_id'];
                    echo "<a href='#' onclick=\"if(confirm('Delete this venue? Any events using it must be updated first.')) document.getElementById('$formId').submit(); return false;\" style='color:#d9534f; text-decoration:none;'>Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6' style='padding: 12px; border: 1px solid #ddd; text-align: center;'>No venues found.</td></tr>"; // Colspan 6
            }
            ?>
        </tbody>
    </table>

    <?php
    if ($result && $result->num_rows > 0) {
        $result->data_seek(0);
        while($row = $result->fetch_assoc()) {
            echo "<form id='del-form-" . (int)$row['venue_id'] . "' action='manage-venues.php' method='post' style='display:none;'>";
            echo "<input type='hidden' name='venue_id' value='" . (int)$row['venue_id'] . "'>";
            echo "<input type='hidden' name='delete_venue' value='1'>";
            echo "</form>";
        }
    }
    ?>

</div>

<?php
    include_once 'footer.php';
?>