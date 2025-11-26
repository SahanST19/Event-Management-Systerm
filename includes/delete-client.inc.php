<?php
session_start();
if (isset($_GET['id']) && isset($_SESSION["user_id"]) && ($_SESSION["user_type"] === 'admin' || $_SESSION["user_type"] === 'manager')) {
    require_once 'dbconnection.php';
    $client_id = $_GET['id'];
    
    
    // client kenekwa delete kala vita ohuta adala siyaluma bookings delete wana kotasa
    $sql = "DELETE FROM clients WHERE client_id = ?;";
    $stmt = mysqli_stmt_init($conn);
    if(mysqli_stmt_prepare($stmt, $sql)){
        mysqli_stmt_bind_param($stmt, "i", $client_id);
        mysqli_stmt_execute($stmt);
    }
    header("location: ../manage-clients.php?status=deleted");
    exit();
}