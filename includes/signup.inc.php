<?php
if (isset($_POST["submit"])) {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $contact = trim($_POST["contact"]);
    $address = trim($_POST["address"]);
    $pwd = trim($_POST["pwd"]);
    $pwdRepeat = trim($_POST["pwdrepeat"]);
    $userType = $_POST["user_type"];

    require_once 'dbconnection.php';

    if ($pwd !== $pwdRepeat) { header("location: ../signup.php?error=passwordsdontmatch"); exit(); }

    $tableName = ($userType === 'client') ? 'clients' : 'staff';
    $sql_check = "SELECT email_address FROM $tableName WHERE email_address = ?;";
    $stmt_check = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt_check, $sql_check)) { header("location: ../signup.php?error=stmtfailed"); exit(); }
    mysqli_stmt_bind_param($stmt_check, "s", $email);
    mysqli_stmt_execute($stmt_check);
    $resultData = mysqli_stmt_get_result($stmt_check);
    if (mysqli_fetch_assoc($resultData)) { mysqli_stmt_close($stmt_check); header("location: ../signup.php?error=emailtaken"); exit(); }
    mysqli_stmt_close($stmt_check);

    if ($userType === 'client') { $sql = "INSERT INTO clients (client_name, contact_no, email_address, address, password) VALUES (?, ?, ?, ?, ?);"; } 
    elseif ($userType === 'staff') { $sql = "INSERT INTO staff (staff_name, contact_no, email_address, address, password) VALUES (?, ?, ?, ?, ?);"; } 
    else { header("location: ../signup.php?error=invalidusertype"); exit(); }

    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) { header("location: ../signup.php?error=stmtfailed"); exit(); }

    // --- HASH karana eka nawatha HASh karata lasse log wenna beri una e nisa  password  ---
    $plain_password = $pwd; 
    
    mysqli_stmt_bind_param($stmt, "sssss", $name, $contact, $email, $address, $plain_password);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../loging.php?error=none");
    exit();
} else {
    header("location: ../signup.php");
    exit();
}