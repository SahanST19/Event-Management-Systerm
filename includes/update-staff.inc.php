<?php
session_start();
if (isset($_POST["update_staff"]) && isset($_SESSION["user_id"]) && $_SESSION["user_type"] === 'admin') {
    require_once 'dbconnection.php';
    $staff_id = $_POST['staff_id'];
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $role = $_POST["role"];
    $pwd = trim($_POST["pwd"]);

    if (empty($pwd)) { 
        // Password field empty - don't update password
        $sql = "UPDATE staff SET staff_name = ?, email_address = ?, role = ? WHERE staff_id = ?;";
        $stmt = mysqli_stmt_init($conn);
        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, "sssi", $name, $email, $role, $staff_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
    } else {
        // Update password as plain text (NOT recommended for production)
        $sql = "UPDATE staff SET staff_name = ?, email_address = ?, role = ?, password = ? WHERE staff_id = ?;";
        $stmt = mysqli_stmt_init($conn);
        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, "ssssi", $name, $email, $role, $pwd, $staff_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
    }

    header("location: ../manage-staff.php?status=updated");
    exit();
}
