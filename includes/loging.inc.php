<?php
if (isset($_POST["submit"])) {
    $username_form = trim($_POST["uid"]);
    $password_form = trim($_POST["pwd"]);
    require_once 'dbconnection.php';

    // Staff Check
    $sql_staff = "SELECT * FROM staff WHERE email_address = ?;";
    $stmt_staff = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt_staff, $sql_staff)) {
        mysqli_stmt_bind_param($stmt_staff, "s", $username_form);
        mysqli_stmt_execute($stmt_staff);
        if ($row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt_staff))) {
            // --- 
            if ($password_form === $row["password"]) {
                session_start();
                $_SESSION["user_id"] = $row["staff_id"];
                $_SESSION["user_name"] = $row["staff_name"];
                $_SESSION["user_type"] = $row["role"];
                header("location: ../staff.php");
                exit();
            } else { header("location: ../loging.php?error=wronglogin"); exit(); }
        }
    }
    mysqli_stmt_close($stmt_staff);

    // Client Check
    $sql_client = "SELECT * FROM clients WHERE email_address = ?;";
    $stmt_client = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt_client, $sql_client)) {
        mysqli_stmt_bind_param($stmt_client, "s", $username_form);
        mysqli_stmt_execute($stmt_client);
        if ($row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt_client))) {
             // --- 
            if ($password_form === $row["password"]) {
                session_start();
                $_SESSION["user_id"] = $row["client_id"];
                $_SESSION["user_name"] = $row["client_name"];
                $_SESSION["user_type"] = "client";
                header("location: ../client.php");
                exit();
            } else { header("location: ../loging.php?error=wronglogin"); exit(); }
        }
    }
    mysqli_stmt_close($stmt_client);

    header("location: ../loging.php?error=wronglogin");
    exit();
} else {
    header("location: ../loging.php");
    exit();
}