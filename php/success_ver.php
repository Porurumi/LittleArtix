<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Little Artix</title>
    <meta http-equiv="refresh" content="15;url=../index.html">
    <link rel="icon" type="image/x-icon" href="../images/finals_logo.ico">
    <link rel="stylesheet" href="../css/success.css">
</head>

<body>
    <div class="navbar">
        <a href="#" class="logo">Little Artix <img src="../images/finals_logo.png" alt="Logo"></a>
        <ul class="nav">
            <li><a href="../index.html">Home</a> </li>
            <li> <a href="about.html">About</a></li>
            <li><a href="products.html">Products</a> </li>
            <li> <a href="services.html">Services</a></li>
            <li><a href="contact.html">Contact</a> </li>
            <li> <a href="reviews.html">Reviews</a></li>
            <li> <a href="order.html">Pre-order</a></li>
        </ul>
    </div>
    <div class="content">
        <h1>Email Verified Successfully!</h1>
        <h3>We will be in contact with you within 24 hours.<br>
            <center>Have a nice day.</center> <br>
        </h3>

    </div>
    <?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// Include PHPMailer library
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require 'PHPMailer-master/src/Exception.php';

// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$database = "feedback";

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the latest entry from the storedfeedbacks table
$sql = "SELECT mob_no, name, email, ordered FROM storedfeedbacks ORDER BY timestamp DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $name = $row["name"];
    $mob_no = $row["mob_no"];
    $email = $row["email"];
    $order = $row["ordered"];

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
       

         // Gmail connection settings
         $mail->SMTPDebug = SMTP::DEBUG_SERVER;
         $mail->isSMTP();
         $mail->Host = 'smtp.gmail.com';
         $mail->Port = 587; // Typically 587 for TLS, 465 for SSL
         $mail->SMTPSecure = 'tls'; // or 'ssl'
         $mail->SMTPAuth = true;
         $mail->Username = 'roanremetre00@gmail.com';
         $mail->Password = 'qzuc xkuq yhbs pymp';
 
         $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` for SSL
         $mail->SMTPOptions = array(
             'ssl' => array(
                 'verify_peer' => false,
                 'verify_host' => false,
                 'allow_self_signed' => true
             )
         );
          // Set up the email
        $mail->setFrom('roanremetre00@gmail.com', 'Rohan Remetre');
        $mail->addAddress('demigodmaui62@gmail.com', 'Maricon Bascon');
        $mail->Subject = 'New Order Registered';

        // Set the email body
        $body = "New Order Made:<br>";
        $body .= "Name: $name<br>";
        $body .= "Mobile Number: $mob_no<br>";
        $body .= "Email: $email<br>";
        $body .= "Order: $order<br>";

        $mail->Body = $body;
        $mail->isHTML(true);

        // Send the email
        if (!$mail->send()) {
            echo 'Error sending email: ' . $mail->ErrorInfo;
        } else {
            echo 'Email sent successfully!';
        }
    } catch (Exception $e) {
        error_log("Error sending email: " . $e->getMessage());
        echo 'Error sending email. Please try again later.';
    }
} else {
    echo 'No entries found in the database.';
}


// Close the database connection
$conn->close();
?>




</body>
<footer>
    <div class="footer-content">
        <ul class="foot">
            <li><a href="disclaimer.html">Disclaimer</a></li>
            <li><a href="termscondition.html">Terms and conditions</a></li>
            <li><a href="privacypolicy.html">Privacy policy</a></li>
        </ul>
    </div>
</footer>

</html>