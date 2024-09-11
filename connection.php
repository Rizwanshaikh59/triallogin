<?php
// Database connection
$servername = "localhost"; // आपके डेटाबेस का सर्वर नेम
$username = "root"; // डेटाबेस यूजरनेम (ज्यादातर 'root' होता है)
$password = ""; // डेटाबेस पासवर्ड (यदि कोई हो तो डालें, अन्यथा खाली छोड़ दें)
$database = "loginpage"; // डेटाबेस का नाम, जहाँ आप डेटा सेव करना चाहते हैं

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
