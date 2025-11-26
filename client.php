<?php
session_start();
// User login vee neththan ho  client kenek neweinam, login page ekata harawa yevima
if (!isset($_SESSION["user_id"]) || $_SESSION["user_type"] !== 'client') {
    header("location: loging.php");
    exit();
}
include_once 'header.php';
?>

    <style>/* background Photo */
        body {
        margin: 0;
        padding: 0;
        background-image: url('uploads/hero-register.png');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        height: 100vh;
        }
    </style>

<div class="page-container" style="text-align: center; background-color: rgba(255, 255, 255, 0.9); border-radius: 10px; margin-top: 50px;">
    
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION["user_name"]); ?>!</h1>
    <p style="margin-bottom: 40px; font-size: 18px; color: #555;">What would you like to do today?</p>
    
    <div class="action-links">
    <a href="request-booking.php" class="btn btn-green" style="padding: 20px 30px; font-size: 18px; text-decoration: none;">Make a New Booking</a>    
    <a href="my-bookings.php" class="btn btn-blue" style="padding: 20px 30px; font-size: 18px; text-decoration: none;">View My Bookings</a>
        

        <a href="available-venues.php" class="btn" style="background-color: #8e44ad; padding: 20px 30px; font-size: 18px; text-decoration: none;">Available Venues</a>
        <a href="myprofile.php" class="btn" style="background-color: #555; padding: 20px 30px; font-size: 18px; text-decoration: none;">My Profile</a>
        </div>

    <a href="includes/logout.inc.php" style="display: block; margin-top: 50px; color: red;">Logout</a>
</div>

<?php
    include_once 'footer.php';
?>