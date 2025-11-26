<?php
session_start();
if (isset($_POST["update_client"]) && isset($_SESSION["user_id"]) && ($_SESSION["user_type"] === 'admin' || $_SESSION["user_type"] === 'manager')) {
    require_once 'dbconnection.php';
    $client_id = $_POST['client_id'];
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $contact = trim($_POST["contact"]);
    $address = trim($_POST["address"]);
    $pwd = trim($_POST["pwd"]);

    if(empty($pwd)){ // Password karanne neththan 
        $sql = "UPDATE clients SET client_name = ?, email_address = ?, contact_no = ?, address = ? WHERE client_id = ?;";
        $stmt = mysqli_stmt_init($conn);
        if(mysqli_stmt_prepare($stmt, $sql)){
            mysqli_stmt_bind_param($stmt, "ssssi", $name, $email, $contact, $address, $client_id);
            mysqli_stmt_execute($stmt);
        }
    } else { // new Password ekak labadenne nam pamanak
        $sql = "UPDATE clients SET client_name = ?, email_address = ?, contact_no = ?, address = ?, password = ? WHERE client_id = ?;";
        $stmt = mysqli_stmt_init($conn);
        if(mysqli_stmt_prepare($stmt, $sql)){
            $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
            mysqli_stmt_bind_param($stmt, "sssssi", $name, $email, $contact, $address, $hashedPwd, $client_id);
            mysqli_stmt_execute($stmt);
        }
    }
    header("location: ../manage-clients.php?status=updated");
    exit();
}