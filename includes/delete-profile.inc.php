<?php
session_start();
if (isset($_POST["delete_account"]) && isset($_SESSION["user_id"]) && $_SESSION["user_type"] === 'client') {
    require_once 'dbconnection.php';
    
    $client_id = $_SESSION['user_id'];
    
    // ON DELETE CASCADE will handle deleting related bookings automatically
    $sql = "DELETE FROM clients WHERE client_id = ?;";
    $stmt = mysqli_stmt_init($conn);
    if(mysqli_stmt_prepare($stmt, $sql)){
        mysqli_stmt_bind_param($stmt, "i", $client_id);
        mysqli_stmt_execute($stmt);
        
        // Account deleted, now log the user out
        session_unset();
        session_destroy();
        header("location: ../loging.php?status=deleted");
        exit();
    }
}
// If something goes wrong, redirect back
header("location: ../myprofile.php?error=failed");
exit();