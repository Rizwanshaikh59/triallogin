<?php
// Database connection
$server = "localhost";
$username = "root";
$password = "";
$dbname = "usersignup";

$conn = mysqli_connect($server, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    echo "Connected";
}

// Start
if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password'])) {
    // Secure data to prevent SQL injection
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // SQL query to insert data
    $sql = "INSERT INTO `signup1` (`username`,`email`,`password`) VALUES ('$username','$email','$password')";

    // Execute query
    $result = mysqli_query($conn, $sql);

    // Check if data is submitted
    if ($result) {
        echo "Data Submitted";
    } else {
        echo "Not Submitted: " . mysqli_error($conn); // Print error message if any
    }
} else {
    echo "Please fill all the fields";
}

// Close connection
mysqli_close($conn);
?>
