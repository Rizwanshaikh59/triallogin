<?php
session_start();
include("connection.php");

// लॉगिन की स्थिति चेक करें
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // यूजर द्वारा सबमिट किए गए डेटा को प्राप्त करें
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // प्रोफाइल को अपडेट करें
    $update_query = "UPDATE `mysignup` SET username = '$username', email = '$email', password = '$password_hash' WHERE id = '$user_id'";
    if (mysqli_query($conn, $update_query)) {
        $success_message = "Profile updated successfully!";
    } else {
        $error_message = "Error updating profile. Please try again.";
    }
}

// मौजूदा यूजर डेटा प्राप्त करें
$query = "SELECT * FROM `mysignup` WHERE id = '$user_id'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="dashboard.css"> <!-- अपने CSS फाइल को लिंक करें -->
</head>
<body>
    <!--Header Section-->
    <header>
        <nav>
            <div class="logo">
                Rizwan<span>Shaikh</span>.
            </div>
            <div class="menu">
                <a href="#">Home</a>
                <a href="#">Pages</a>
                <a href="#">About Us</a>
                <a href="#">Contact Us</a>
                <a href="user_dashboard.php">User Dashboard</a>
            </div>
            <div class="icon">
                <a href="logout.php">Logout</a>
            </div>
        </nav>
    </header>

    <section class="edit-profile">
        <h1>Edit Profile</h1>
        <?php if (isset($success_message)): ?>
            <p class="success-message"><?php echo htmlspecialchars($success_message); ?></p>
        <?php endif; ?>
        <?php if (isset($error_message)): ?>
            <p class="error-message"><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>
        <form action="edit_profile.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
            <br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            <br>
            <label for="password">New Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter new password">
            <br>
            <button type="submit">Update Profile</button>
        </form>
    </section>
</body>
</html>
