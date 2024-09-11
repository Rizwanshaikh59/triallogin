<?php
  include("connection.php");

  if(isset($_POST['signup']))
  {
    //user check already exist in the database
    $check = "SELECT * FROM `mysignup` WHERE username = '$_POST[username]' OR email = '$_POST[email]'";

    $result = mysqli_query($conn, $check);
    if($result)
    {
       if(mysqli_num_rows($result) > 0) //if any user found in the db
       {
        $fetch = mysqli_fetch_assoc($result);
        if($fetch['username'] == $_POST['username']) //if username match
        {
            echo "<script> alert('Username is already taken')</script>";
        }
        else //if email match
        {
            echo "<script> alert('Email is already registered')</script>";
        }
       }
        else // if any user not found
        {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $mobile = $_POST['mobile'];
            $password = $_POST['password'];
            $confirmpassword = $_POST['confirmpassword'];

            // Check if passwords match
            if($password != $confirmpassword) {
                echo "<script> alert('Passwords do not match')</script>";
            } else {
                // Encrypt password before storing it
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

                $sql = "INSERT INTO `mysignup`(`username`, `email`, `mobile`, `password`) VALUES ('$username','$email','$mobile','$hashedPassword')";

                if(mysqli_query($conn, $sql))
                {
                    echo "<script> alert('Account Created')</script>";
                    // Redirect to login page after signup
                    echo "<script> window.location.href='login.php';</script>";
                }
                else
                {
                    echo "<script> alert('Query Failed.....!')</script>";
                }
            }
        }
    }
    else
    {
        echo "<script> alert('Query Failed.....!')</script>";
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign-Up Form</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="sign-up-form">
         <h1>Sign-Up</h1>
         <h4>It's Free And Only Take A Minute</h4>
            <form action="signup.php" method="POST">
                <div class="username">
                    <label>Username&nbsp;&nbsp;<i class="fa-solid fa-user"></i></label>
                    <input type="text" name="username" id="username" placeholder="Enter Your Username" required>
                </div>
                <div class="email">
                    <label>Email&nbsp;&nbsp;<i class="fa-solid fa-envelope"></i></label>
                    <input type="email" name="email" id="email" placeholder="Enter Your Email" required>
                </div>
                <div class="mobile">
                    <label>Mobile.No&nbsp;&nbsp;<i class="fa-solid fa-phone"></i></label>
                    <input type="tel" name="mobile" id="mobile" placeholder="+91 1122334455" required>
                </div>
                <div>
                    <label>Password&nbsp;&nbsp;<i class="fa-solid fa-lock"></i></label>
                    <input type="password" name="password" id="password" placeholder="Enter Your Password" required>
                </div>
                <div>
                    <label>Confirm-Password&nbsp;&nbsp;<i class="fa-solid fa-lock"></i></label>
                    <input type="password" name="confirmpassword" id="confirmpassword" placeholder="Re Enter Password" required>
                </div>
                <div class="button">
                    <button type="submit" name="signup" id="signup">Sign-Up</button>
                    <button type="reset" name="reset" id="reset">Reset Data</button>
                </div>
            </form><br>
            <p>By Clicking The Sign-Up Button, You Agree To Our <br><br><a href="termsandcondition.html" target="_blank">Terms And Condition</a> And <a href="privacypolicy.html" target="_blank">Privacy Policy</a></p>
            <p>Already Have An Account? <a href="login.php">Login Here</a></p>
        </div>
</body>
</html>
