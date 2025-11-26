<?php
session_start();

// Security check: Only admins can execute this script
if (isset($_POST["submit"]) && isset($_SESSION["user_id"]) && $_SESSION["user_type"] === 'admin') {

    require_once 'dbconnection.php';

    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $role = $_POST["role"];
    $pwd = trim($_POST["pwd"]);
    $pwdRepeat = trim($_POST["pwdrepeat"]);

    // Validations
    if ($pwd !== $pwdRepeat) { header("location: ../create-staff.php?error=passwordsdontmatch"); exit(); }
    if ($role !== 'staff' && $role !== 'admin') { header("location: ../create-staff.php?error=invalidrole"); exit(); }
    
    // Check if email already exists
    $sql_check = "SELECT email_address FROM staff WHERE email_address = ?;";
    $stmt_check = mysqli_stmt_init($conn);
    if(mysqli_stmt_prepare($stmt_check, $sql_check)){
        mysqli_stmt_bind_param($stmt_check, "s", $email);
        mysqli_stmt_execute($stmt_check);
        if(mysqli_fetch_assoc(mysqli_stmt_get_result($stmt_check))){
            mysqli_stmt_close($stmt_check);
            header("location: ../create-staff.php?error=emailtaken");
            exit();
        }
    }
    mysqli_stmt_close($stmt_check);

    // Insert new staff member
    $sql_insert = "INSERT INTO staff (staff_name, email_address, role, password) VALUES (?, ?, ?, ?);";
    $stmt_insert = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt_insert, $sql_insert)) {
        $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
        mysqli_stmt_bind_param($stmt_insert, "ssss", $name, $email, $role, $hashedPwd);
        mysqli_stmt_execute($stmt_insert);
        mysqli_stmt_close($stmt_insert);

        header("location: ../create-staff.php?status=success");
        exit();
    } else {
        header("location: ../create-staff.php?error=stmtfailed");
        exit();
    }

} else {
    // Redirect if not admin or form not submitted
    header("location: ../loging.php");
    exit();
}