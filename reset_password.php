<?php
include("connection.php");

if(isset($_POST['reset_password'])) {
    $email = $_POST['email'];
    $new_password = $_POST['new_password'];
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // पासवर्ड अपडेट करें
    $update = "UPDATE `mysignup` SET password = '$hashed_password', otp = NULL WHERE email = '$email'";
    mysqli_query($conn, $update);

    echo "<script>alert('Password Updated Successfully'); window.location.href='login.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="reset-form">
        <h1>Reset Your Password</h1>
        <form action="reset_password.php" method="POST">
            <div class="email">
                <label>Email</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($_GET['email']); ?>" readonly required>
            </div>
            <div class="new_password">
                <label>New Password</label>
                <input type="password" name="new_password" placeholder="Enter Your New Password" required>
            </div>
            <div class="button">
                <button type="submit" name="reset_password">Update New Password</button>
            </div>
        </form>
    </div>
</body>
</html>
