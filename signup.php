<?php include_once 'header.php'; ?>

    <style>/* blackgraoun Photo */
        body {
        margin: 0;
        padding: 0;
        background-image: url('uploads/hero-login.png');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        height: 100vh;
        }
    </style>

<div class="form-container">
    <h1>Create a New Account</h1>
    <?php
    if (isset($_GET["error"])) {
        if ($_GET["error"] == "passwordsdontmatch") { echo '<div class="error-msg">Passwords do not match!</div>'; } 
        else if ($_GET["error"] == "emailtaken") { echo '<div class="error-msg">This email is already registered!</div>'; } 
        else { echo '<div class="error-msg">Something went wrong! Please try again.</div>'; }
    }
    ?>
    <form action="includes/signup.inc.php" method="post">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="text" name="contact" placeholder="Phone Number" required>
        <input type="text" name="address" placeholder="Address" required>
        <input type="password" name="pwd" placeholder="Password" required>
        <input type="password" name="pwdrepeat" placeholder="Repeat Password" required>
        <select name="user_type">
            <option value="client">Register as a Client</option>
            <option value="staff">Register as a Staff</option>
        </select>
        <button name="submit" type="submit">Register</button>
    </form>
    <p style="margin-top:20px;">Already have an account? <a href="loging.php">Log in.</a></p>
</div>
<?php include_once 'footer.php'; ?>