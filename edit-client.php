<?php
session_start();
if (!isset($_SESSION["user_id"]) || ($_SESSION["user_type"] !== 'admin' && $_SESSION["user_type"] !== 'manager')) { header("location: staff.php?error=unauthorized"); exit(); }

include_once 'header.php';
require_once 'includes/dbconnection.php';

$client_id = $_GET['id'];
$sql_select = "SELECT * FROM clients WHERE client_id = ?;";
$stmt = mysqli_stmt_init($conn);
if(mysqli_stmt_prepare($stmt, $sql_select)){
    mysqli_stmt_bind_param($stmt, "i", $client_id);
    mysqli_stmt_execute($stmt);
    $client_data = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
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
    <h1>Edit Client: <?php echo htmlspecialchars($client_data['client_name']); ?></h1>
    <form action="includes/update-client.inc.php" method="post">
        <input type="hidden" name="client_id" value="<?php echo $client_data['client_id']; ?>">
        <label>Full Name:</label> <input type="text" name="name" value="<?php echo htmlspecialchars($client_data['client_name']); ?>" required>
        <label>Email:</label> <input type="email" name="email" value="<?php echo htmlspecialchars($client_data['email_address']); ?>" required>
        <label>Contact No:</label> <input type="text" name="contact" value="<?php echo htmlspecialchars($client_data['contact_no']); ?>">
        <label>Address:</label> <input type="text" name="address" value="<?php echo htmlspecialchars($client_data['address']); ?>">
        <label>New Password (Optional):</label> <input type="password" name="pwd" placeholder="Leave blank to keep current password">
        <button name="update_client" type="submit">Update Client</button>
    </form>
    <p><a href="manage-clients.php">Back to Client List</a></p>
</div>
<?php include_once 'footer.php'; ?>