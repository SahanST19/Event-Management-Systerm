<?php
session_start();


// 'manager' role ekatath meya sidhu kirimata avasara laba dena kotasa 
if (!isset($_SESSION["user_id"]) || !in_array($_SESSION['user_type'], ['staff', 'admin', 'manager'])) {
    header("location: ../loging.php");
    exit();
}
// ===============================

// Check if an ID is provided in the URL
if (isset($_GET['id'])) {
    
    require_once 'dbconnection.php';
    
    $event_id = $_GET['id'];
    
    $sql = "DELETE FROM events WHERE event_id = ?;";
    
    $stmt = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $event_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        mysqli_stmt_close($stmt);
        
        header("location: ../manage-events.php?status=deleted");
        exit();
        
    } else {
        header("location: ../manage-events.php?error=stmtfailed");
        exit();
    }
    
} else {
    header("location: ../manage-events.php");
    exit();
}
?>