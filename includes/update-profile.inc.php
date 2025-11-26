<?php
session_start();
if (isset($_POST["update_profile"]) && isset($_SESSION["user_id"]) && $_SESSION["user_type"] === 'client') {
    require_once 'dbconnection.php';
    
    // Get client ID from the SESSION for security
    $client_id = $_SESSION['user_id'];
    
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $contact = trim($_POST["contact"]);
    $address = trim($_POST["address"]);
    $pwd = trim($_POST["pwd"]);

    if(empty($pwd)){ // If password field is empty, don't update it
        $sql = "UPDATE clients SET client_name = ?, email_address = ?, contact_no = ?, address = ? WHERE client_id = ?;";
        $stmt = mysqli_stmt_init($conn);
        if(mysqli_stmt_prepare($stmt, $sql)){
            mysqli_stmt_bind_param($stmt, "ssssi", $name, $email, $contact, $address, $client_id);
            mysqli_stmt_execute($stmt);
        }
    } else { // If new password is provided, update it as well
        $sql = "UPDATE clients SET client_name = ?, email_address = ?, contact_no = ?, address = ?, password = ? WHERE client_id = ?;";
        $stmt = mysqli_stmt_init($conn);
        if(mysqli_stmt_prepare($stmt, $sql)){
            // For a real project, use the secure password hash method we discussed
            $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
            mysqli_stmt_bind_param($stmt, "sssssi", $name, $email, $contact, $address, $hashedPwd, $client_id);
            mysqli_stmt_execute($stmt);
        }
    }
    header("location: ../myprofile.php?status=updated");
    exit();
}