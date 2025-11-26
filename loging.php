<?php include_once 'header.php'; ?>

    <style>/* blackgraoun Photo */
        body {
        margin: 0;
        padding: 0;
        background-image: url('uploads/loging.png');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        height: 100vh;
        }
    </style>

<div class="form-container">
    <h1>Login to Your Account</h1>
    <?php
    if (isset($_GET["error"]) && $_GET["error"] == "wronglogin") {
        echo '<div class="error-msg">Incorrect email or password! Please try again.</div>';
    }
    ?>
    <form action="includes/loging.inc.php" method="post">
        <input type="email" name="uid" placeholder="Your Email Address" required autocomplete="off">
        <input type="password" name="pwd" placeholder="Password" required>
        <button name="submit" type="submit">Login</button>
    </form>
    <p style="margin-top:20px;">New Here? <a href="signup.php">Register.</a></p>
</div>
<?php include_once 'footer.php'; ?>