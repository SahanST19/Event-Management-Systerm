<?php

session_start(); // Session Start kirima

session_unset(); // All session variables ain karai
session_destroy(); // Session iwath wei


//  index.php wetha yawai home page ekata
header("location: ../index.php");
exit();

?>