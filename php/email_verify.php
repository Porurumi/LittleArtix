<?php
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
  use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require 'PHPMailer-master/src/Exception.php';

    // Replace with your actual database credentials (use environment variables for security)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "feedback";

    function connectToDatabase() {
      global $servername, $username, $password, $database;
      $conn = mysqli_connect($servername, $username, $password, $database);
      if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
      }
      return $conn;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $email = $_POST["email"];
      $mob_no = $_POST['mob_no'];
      $name = $_POST['name'];
     $order = $_POST["ordered"];
     
      
      $conn = connectToDatabase();

      // Sanitize email before inserting
      $sanitizedEmail = mysqli_real_escape_string($conn, $email);
      $verificationCode = rand(100000, 999999);

      $sql = "INSERT INTO `storedfeedbacks` (`id`,`s.no`,`email`, `mob_no`, `name`, `ordered`,`verification_code`, `used`, `timestamp`) VALUES ('',NULL,'$sanitizedEmail','$mob_no','$name','$order','$verificationCode','', current_timestamp())";
      $result = mysqli_query($conn, $sql);

      if ($result) {
      
         $mail = new PHPMailer(true); // Enable exceptions

        try {
       

          // Replace with your SMTP details (use environment variables for security)
          $mail->SMTPDebug = SMTP::DEBUG_SERVER; 
          $mail->isSMTP();
          $mail->Host = 'smtp.gmail.com';
          $mail->Port = 587; // Typically 587 for TLS, 465 for SSL
          $mail->SMTPSecure = 'tsl'; // or 'ssl'
          $mail->SMTPAuth = true;
          $mail->Username = 'roanremetre00@gmail.com';
          $mail->Password = 'qzuc xkuq yhbs pymp';

          $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` for SSL
          $mail->SMTPOptions = array(
          'ssl' => array(
          'verify_peer' => false,
          'verify_host' => false,
          'allow_self_signed' => true
            )
          );

          $mail->setFrom('roanremetre00@gmail.com', 'Little Artix Order');
          $mail->addAddress('$sanitizedEmail');
          $mail->Subject = 'Little Artix Order Verification';

          // Set email content to plain text
          $mail->Body = "Your verification code for Little Artix order is: $verificationCode";
          $mail->isHTML(false);
          $mail->send();
          echo '<div class="alert alert-success">Verification code sent to your email!</div>';
          session_start(); // Start the session
            $_SESSION["userEmail"] = $sanitizedEmail;
          header("refresh: 1; url=verify.php"); //PALITAN MO TO NG NAME KUNG PAPALITAN MO ANG MGA FILE NAME 


        } catch (Exception $e) {
          // Handle specific exceptions for better error messages
          if (strpos($e->getMessage(), 'Failed to connect to mail server')) {
            $errorMessage = 'Failed to connect to email server. Please check your network connection or SMTP settings.';
          } else if (strpos($e->getMessage(), 'Invalid credentials')) {
            $errorMessage = 'Invalid email credentials. Please verify your username and password.';
          } else {
            $errorMessage = 'Error sending verification code: ' . $e->getMessage();
          }
          echo "<div class='alert alert-danger'>$errorMessage</div>";
        }
      } else {
        echo '<div class="alert alert-warning alert-dismissible fade show" role"alert" <strong>Erroruploading data</strong></div>' . mysqli_error($conn);
      }

      mysqli_close($conn);
    }
?>