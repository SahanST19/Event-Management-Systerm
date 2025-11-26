<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["user_type"] !== 'admin') {
    header("location: staff.php?error=unauthorized");
    exit();
}
include_once 'header.php';
require_once 'includes/dbconnection.php';

// Handle form submission for adding a new staff member
if (isset($_POST['add_staff'])) {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $role = $_POST["role"];
    $pwd = trim($_POST["pwd"]);
    
    // Simple validation
    if(!empty($name) && !empty($email) && !empty($role) && !empty($pwd)){
        // You can add more specific validations here (e.g., check if email exists)
        
        $sql_insert = "INSERT INTO staff (staff_name, email_address, role, password) VALUES (?, ?, ?, ?);";
        $stmt_insert = mysqli_stmt_init($conn);
        if (mysqli_stmt_prepare($stmt_insert, $sql_insert)) {
            $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
            mysqli_stmt_bind_param($stmt_insert, "ssss", $name, $email, $role, $hashedPwd);
            mysqli_stmt_execute($stmt_insert);
            mysqli_stmt_close($stmt_insert);
            header("Location: manage-staff.php?status=added");
            exit();
        }
    }
}
?>

<div class="page-container">
    <h1>Manage Staff</h1>
    <a href="staff.php" style="display:inline-block; margin-bottom: 20px;">&larr; Back to Dashboard</a>
    <hr>

    <div class="form-container" style="max-width: 100%; margin: 20px 0;">
        <form action="manage-staff.php" method="post">
            <h2>Add New Staff Member</h2>
            <?php if(isset($_GET['status']) && $_GET['status'] == 'added') echo '<p style="color:green;">Staff member added successfully!</p>'; ?>
            
            <label for="name">Full Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email Address:</label>
            <input type="email" id="email" name="email" required>

            <label for="pwd">Password:</label>
            <input type="password" id="pwd" name="pwd" required>

            <label for="role">Job Role:</label>
            <select id="role" name="role" required>
                <option value="staff">Event Staff (General)</option>
                <option value="catering">Catering Staff</option>
                <option value="cleaning">Cleaning Staff</option>
                <option value="security">Security Staff</option>
                <option value="sales">Sales Coordinator</option>
                <option value="coordinator">Event Coordinator</option>
                <option value="manager">Manager</option>
            </select>
            
            <button name="add_staff" type="submit">Add Staff Member</button>
        </form>
    </div>
    
    <hr style="margin:30px 0;">

    <h2>Existing Staff</h2>
    <table style="width:100%; border-collapse: collapse; margin-top: 20px;">
        <thead style="background-color: #f2f2f2;">
            <tr>
                <th style="padding: 12px; border: 1px solid #ddd; text-align: left;">Name</th>
                <th style="padding: 12px; border: 1px solid #ddd; text-align: left;">Email</th>
                <th style="padding: 12px; border: 1px solid #ddd; text-align: left;">Role</th>
                <th style="padding: 12px; border: 1px solid #ddd; text-align: left;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql_select = "SELECT * FROM staff ORDER BY staff_name ASC";
            $result = $conn->query($sql_select);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    // Don't show the currently logged in admin in the list to prevent self-deletion/editing issues
                    if ($row['staff_id'] == $_SESSION['user_id']) continue;
                    
                    echo "<tr>";
                    echo "<td style='padding: 12px; border: 1px solid #ddd;'>" . htmlspecialchars($row['staff_name']) . "</td>";
                    echo "<td style='padding: 12px; border: 1px solid #ddd;'>" . htmlspecialchars($row['email_address']) . "</td>";
                    echo "<td style='padding: 12px; border: 1px solid #ddd;'>" . htmlspecialchars($row['role']) . "</td>";
                    echo "<td style='padding: 12px; border: 1px solid #ddd;'>";
                    echo "<a href='edit-staff.php?id=" . $row['staff_id'] . "'>Edit</a> | ";
                    echo "<a href='includes/delete-staff.inc.php?id=" . $row['staff_id'] . "' onclick='return confirm(\"Are you sure?\");' style='color:red;'>Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4' style='padding: 12px; border: 1px solid #ddd; text-align: center;'>No other staff members found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php include_once 'footer.php'; ?>