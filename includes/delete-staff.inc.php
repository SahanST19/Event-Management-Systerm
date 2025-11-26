<?php
session_start();
if (isset($_GET['id']) && isset($_SESSION["user_id"]) && $_SESSION["user_type"] === 'admin') {
    require_once 'dbconnection.php';
    $staff_id = $_GET['id'];
    // Note: This will fail if the staff member is linked to events due to foreign key constraints.
    // For a real project, you would first re-assign their events or delete them.
    $sql = "DELETE FROM staff WHERE staff_id = ?;";
    $stmt = mysqli_stmt_init($conn);
    if(mysqli_stmt_prepare($stmt, $sql)){
        mysqli_stmt_bind_param($stmt, "i", $staff_id);
        mysqli_stmt_execute($stmt);
    }
    header("location: ../manage-staff.php?status=deleted");
    exit();
}