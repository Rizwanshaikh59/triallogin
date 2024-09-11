<?php
include("connection.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/vendor/autoload.php'; // Composer's autoload file

if(isset($_POST['submit_otp'])) {
    $otp = $_POST['otp'];
    $email = $_POST['email'];

    // OTP चेक करें
    $check = "SELECT * FROM `mysignup` WHERE email = '$email' AND otp = '$otp'";
    $result = mysqli_query($conn, $check);

    if($result && mysqli_num_rows($result) > 0) {
        // OTP सही है, रीडायरेक्ट करें पासवर्ड रेसिट पेज पर
        header("Location: reset_password.php?email=$email");
        exit();
    } else {
        echo "<script>alert('Invalid OTP');</script>";
    }
}

if(isset($_POST['resend_otp'])) {
    $email = $_POST['email'];

    // OTP जेनरेट करें
    $otp = rand(100000, 999999);

    // OTP को डेटाबेस में अपडेट करें
    $update = "UPDATE `mysignup` SET otp = '$otp' WHERE email = '$email'";
    mysqli_query($conn, $update);

    // PHPMailer का उपयोग कर ईमेल भेजना
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; 
        $mail->SMTPAuth = true;
        $mail->Username = 'rockstargamingr2@gmail.com'; // अपना Gmail ईमेल डालें
        $mail->Password = 'lopmvwxqzmyharso'; // अपना Gmail पासवर्ड डालें (या App Password)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('rockstargamingr2@gmail.com', 'Authorised-Web');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Your Resend OTP Code';
        $mail->Body = "<h2>Your New OTP Code: <strong>$otp</strong></h2>
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

        $mail->send();
        echo "<script>alert('New OTP has been sent to your email');</script>";

    } catch (Exception $e) {
        echo "<script>alert('Failed to send OTP: {$mail->ErrorInfo}');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="otp-form">
        <h1>OTP Verification</h1>
        <form action="otp.php" method="POST">
            <div class="email-otp">
                <label>Email</label>
                <input type="email" name="email" placeholder="Enter Your Registered Email" required>
            </div>
            <div class="otp">
                <label>OTP</label>
                <input type="text" name="otp" placeholder="Enter Your OTP" required>
            </div>
            <div class="button">
                <button type="submit" name="submit_otp">Verify OTP</button>
            </div>
        </form>
        <form action="otp.php" method="POST">
            <input type="hidden" name="email">
            <div class="button">
                <button type="submit" name="resend_otp">Resend OTP</button>
            </div>
        </form>
    </div>
</body>
</html>
