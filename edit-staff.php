<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["user_type"] !== 'admin') { header("location: staff.php?error=unauthorized"); exit(); }

include_once 'header.php';
require_once 'includes/dbconnection.php';

$staff_id = $_GET['id'];
$sql_select = "SELECT * FROM staff WHERE staff_id = ?;";
$stmt = mysqli_stmt_init($conn);
if(mysqli_stmt_prepare($stmt, $sql_select)){
    mysqli_stmt_bind_param($stmt, "i", $staff_id);
    mysqli_stmt_execute($stmt);
    $staff_data = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
}
?>

    <style>/* blackgraoun Photo */
        body {
        margin: 0;
        padding: 0;
        background-image: url('uploads/edit.png');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        height: 100vh;
        }
    </style>

<div class="form-container">
    <h1>Edit Staff Member: <?php echo htmlspecialchars($staff_data['staff_name']); ?></h1>
    <form action="includes/update-staff.inc.php" method="post">
        <input type="hidden" name="staff_id" value="<?php echo $staff_data['staff_id']; ?>">
        <label>Full Name:</label> <input type="text" name="name" value="<?php echo htmlspecialchars($staff_data['staff_name']); ?>" required>
        <label>Email:</label> <input type="email" name="email" value="<?php echo htmlspecialchars($staff_data['email_address']); ?>" required>
        <label>Job Role:</label>
        <select name="role" required>
            <option value="staff" <?php if($staff_data['role'] == 'staff') echo 'selected'; ?>>Event Staff (General)</option>
            <option value="catering" <?php if($staff_data['role'] == 'catering') echo 'selected'; ?>>Catering Staff</option>
            <option value="cleaning" <?php if($staff_data['role'] == 'cleaning') echo 'selected'; ?>>Cleaning Staff</option>
            <option value="security" <?php if($staff_data['role'] == 'security') echo 'selected'; ?>>Security Staff</option>
            <option value="sales" <?php if($staff_data['role'] == 'sales') echo 'selected'; ?>>Sales Coordinator</option>
            <option value="coordinator" <?php if($staff_data['role'] == 'coordinator') echo 'selected'; ?>>Event Coordinator</option>
            <option value="manager" <?php if($staff_data['role'] == 'manager') echo 'selected'; ?>>Manager</option>
            <option value="admin" <?php if($staff_data['role'] == 'admin') echo 'selected'; ?>>Admin</option>
        </select>
        <label>New Password (Optional):</label> <input type="password" name="pwd" placeholder="Leave blank to keep current password">
        <button name="update_staff" type="submit">Update Staff</button>
    </form>
    <p><a href="manage-staff.php">Back to Staff List</a></p>
</div>
<?php include_once 'footer.php'; ?>