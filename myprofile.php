<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["user_type"] !== 'client') {
    header("location: loging.php");
    exit();
}
include_once 'header.php';
require_once 'includes/dbconnection.php';

// Fetch current client's data using session ID
$client_id = $_SESSION['user_id'];
$sql_select = "SELECT * FROM clients WHERE client_id = ?;";
$stmt = mysqli_stmt_init($conn);
if(mysqli_stmt_prepare($stmt, $sql_select)){
    mysqli_stmt_bind_param($stmt, "i", $client_id);
    mysqli_stmt_execute($stmt);
    $client_data = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
}
?>
<div class="form-container">
    <h1>My Profile</h1>
    <p>You can update your personal details here.</p>
    <?php if(isset($_GET['status']) && $_GET['status'] == 'updated') echo '<p style="color:green;">Profile updated successfully!</p>'; ?>
    
    <form action="includes/update-profile.inc.php" method="post">
        <label>Full Name:</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($client_data['client_name']); ?>" required>
        
        <label>Email Address:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($client_data['email_address']); ?>" required>
        
        <label>Contact Number:</label>
        <input type="text" name="contact" value="<?php echo htmlspecialchars($client_data['contact_no']); ?>">
        
        <label>Address:</label>
        <input type="text" name="address" value="<?php echo htmlspecialchars($client_data['address']); ?>">
        
        <label>New Password (Optional):</label>
        <input type="password" name="pwd" placeholder="Leave blank to keep your current password">
        
        <button name="update_profile" type="submit">Update Profile</button>
    </form>

    
    <hr style="margin: 30px 0;">

    <div style="text-align:left; border: 1px solid red; padding: 20px; border-radius: 5px;">
        <h3 style="color:red;">Delete Account</h3>
        <p>Warning: Deleting your account is permanent and will also remove all your existing bookings. This action cannot be undone.</p>
        <form action="includes/delete-profile.inc.php" method="post" onsubmit="return confirm('Are you absolutely sure you want to delete your account? This is permanent!');">
            <button name="delete_account" type="submit" style="background-color:#c0392b; width: auto; padding: 10px 20px;">Delete My Account</button>
        </form>
    </div>
    
    <p style="margin-top:20px;"><a href="client.php">Back to Dashboard</a></p>
</div>
<?php include_once 'footer.php'; ?>