<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>IPT_finals</title>
    <link rel="stylesheet" href="verify.css">

</head>

<body>
    <div class="navbar">
        <a href="#" class="logo">Little Artix <img src="images/finals_logo.png" alt="Logo"></a>
        <ul class="nav">
            <li><a href="home.html">Home</a></li>
            <li><a href="about.html">About</a></li>
            <li><a href="products.html">Products</a></li>
            <li><a href="services.html">Services</a></li>
            <li><a href="contact.html">Contact</a></li>
            <li><a href="reviews.html">Reviews</a></li>
            <li><a href="feedback.php">Feedbacks</a></li>
        </ul>
    </div>
    <div class="container">
        <div class="content">
            <h1>Verification Process</h1>
            <p>An email with a six-digit verification code has been sent to your email address. Enter the code below to
                proceed.</p>

            <?php if (!empty($errorMessage)) { ?>
            <p style="color: red;"><?php echo $errorMessage; ?></p>
            <?php } ?>

            <form method="post">

                <?php
      // Start the session (if not already started)
      session_start();

      // Check if the user email is stored in the session
      if (isset($_SESSION["userEmail"])) {
        $email = $_SESSION["userEmail"];
      } else {
        // Redirect to feedback page if email is not found in session (unusual case)
        header("Location: feedback_nobs.php");
        exit;
      }
      ?>
                <input type="hidden" name="email" value="<?php echo $email; ?>">


                <div class="code-input">
                    <input type="text" maxlength="6" name="code" class="digit">
                </div>
                <button type="submit">Submit</button>
            </form>
            <?php

// Database connection details (replace with your actual details)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "feedback";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $enteredCode = $_POST["code"]; // Assuming all form field names have name="code"
  $email = $_POST["email"]; // Assuming the hidden field name is "email"

  // Escape the user input to prevent SQL injection attacks
  $email = mysqli_real_escape_string($conn, $email); // Assuming a hidden field with user email

  // Order by timestamp DESC to get the most recent record
  $sql = "SELECT verification_code FROM storedfeedbacks WHERE email = '$email' AND used = 0 ORDER BY timestamp DESC LIMIT 1";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $recordedCode = $row["verification_code"];

    // Compare entered code with recorded code (using password_verify can be replaced with a simple comparison)
    if ($enteredCode === $recordedCode) { // Consider replacing with a simple comparison for verification codes
      // Codes match, verification successful!
      echo "<h3>Verification successful!</h3>"; // Handle successful verification
      header("Location: success_ver.html");
      exit();
    } else {
      // Codes don't match, display error message
      $errorMessage = "Invalid verification code.";
    }
  } else {
    // No record found for the user's email or code already used
    $errorMessage = "Invalid verification code or email.";
  }
}

$conn->close();

?>

        </div>
    </div>
</body>

<footer>
    <div class="footer-content">
        <ul class="nav">
            <li><a href="#disclaimer">Disclaimer</a></li>
            <li><a href="#termsandcondition">Terms and conditions</a></li>
            <li><a href="#privacy policy">Privacy policy</a></li>
        </ul>
    </div>
</footer>

</html>