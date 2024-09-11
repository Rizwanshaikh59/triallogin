<?php
include("connection.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/vendor/autoload.php'; // अगर Composer का उपयोग किया है

if(isset($_POST['login'])) {
    // यूजर इनपुट डेटा
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // यूजर को डेटाबेस में चेक करें
    $check = "SELECT * FROM `mysignup` WHERE username = '$username' AND email = '$email'";
    $result = mysqli_query($conn, $check);

    // अगर यूजर मौजूद है
    if($result && mysqli_num_rows($result) > 0) {
        $fetch = mysqli_fetch_assoc($result);

        // पासवर्ड वेरीफाई करें
        if(password_verify($password, $fetch['password'])) {
            // अगर पासवर्ड सही है, तो वेलकम पेज पर रीडायरेक्ट करें
            echo "<script> alert('Login Successful');</script>";
            echo "<script> window.location.href='index.html';</script>";
        } else {
            // अगर पासवर्ड गलत है
            echo "<script> alert('Incorrect Password');</script>";
        }
    } else {
        // अगर यूजरनेम या ईमेल मेल नहीं खाता
        echo "<script> alert('Invalid Username or Email');</script>";
    }
}

// फॉरगॉट पासवर्ड के लिए कोड
if(isset($_POST['forgot_password'])) {
    $email = $_POST['email'];
    $check = "SELECT * FROM `mysignup` WHERE email = '$email'";
    $result = mysqli_query($conn, $check);

    if($result && mysqli_num_rows($result) > 0) {
        // ओटीपी जेनरेट करें
        $otp = rand(100000, 999999);

        // ओटीपी को डेटाबेस में सेव करें
        $update = "UPDATE `mysignup` SET otp = '$otp' WHERE email = '$email'";
        mysqli_query($conn, $update);

        // PHPMailer का उपयोग कर ईमेल भेजना
        $mail = new PHPMailer(true);

        try {
            // सर्वर सेटिंग्स
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Gmail SMTP सर्वर
            $mail->SMTPAuth = true;
            $mail->Username = 'rockstargamingr2@gmail.com'; // अपना Gmail ईमेल डालें
            $mail->Password = 'lopmvwxqzmyharso'; // अपना Gmail पासवर्ड डालें (या App Password)
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // TLS के लिए
            $mail->Port = 587;

            // रिसीवर
            $mail->setFrom('rockstargamingr2@gmail.com', 'Authorised Web');
            $mail->addAddress($email); // यूजर का ईमेल

            // ईमेल कंटेंट
            $mail->isHTML(true);
            $mail->Subject = 'Your OTP Code:';
            $mail->Body = "<h2>Your OTP Code: <strong>$otp</strong></h2>
    <p>Hello,</p>
    <p>Thank you for using our services. Please use the OTP code mentioned above to verify your identity.</p>
    <p>We hope you are enjoying your experience with <strong>Coding Practice Otp Send</strong>. Below are our business details:</p>
    <ul>
        <li>Website: <a href='https://www.officialrizwanshaikh59.site'>https://www.officialrizwanshaikh59.site</a></li>
        <li>Contact Us: rockstargamingr2@gmail.com</li>
        <li>Phone: +91 9770274616</li>
    </ul>
    <p>If you did not request this OTP, please ignore this email or contact us immediately.</p>
    <p>Best Regards,</p>
    <p><strong>Rizwan Shaikh</strong></p>";

            // ईमेल भेजें
            $mail->send();
            echo "<script>alert('OTP Sent to Your Email'); window.location.href='otp.php?email=$email';</script>";
        
        } catch (Exception $e) {
            echo "<script>alert('Failed to Send OTP: {$mail->ErrorInfo}');</script>";
        }
    } else {
        echo "<script> alert('Email Not Found');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="login-form">
        <h1>Login</h1>
        <h4>It's Free And Only Takes A Minute</h4>
        <form action="login.php" method="POST">
            <div class="username">
                <label>Username&nbsp;&nbsp;<i class="fa-solid fa-user"></i></label>
                <input type="text" name="username" id="username" placeholder="Enter Your Username" required>
            </div>
            <div class="email">
                <label>Email&nbsp;&nbsp;<i class="fa-solid fa-envelope"></i></label>
                <input type="email" name="email" id="email" placeholder="Enter Your Email" required>
            </div>
            <div>
                <label>Password&nbsp;&nbsp;<i class="fa-solid fa-lock"></i></label>
                <input type="password" name="password" id="password" placeholder="Enter Your Password" required>
            </div>
            <div class="button">
                <button type="submit" id="login" name="login">Login</button>
                <button type="submit" id="forgot_password" name="forgot_password">Forgot Password</button>
                <button type="reset">Reset</button>
            </div>
        </form><br>
        <p>By Clicking The Login Button, You Agree To Our <br><br><a href="termsandcondition.html" target="_blank">Terms And Condition</a> And <a href="privacypolicy.html" target="_blank">Privacy Policy</a></p>
        <p>New Registered Account? <a href="signup.php">Sign-Up Here</a></p>
    </div>
</body>
</html>
