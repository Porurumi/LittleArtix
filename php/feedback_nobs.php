<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Feedback</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/feedback_style.css">

</head>

<body>
    <div class="navbar">
        <a href="#" class="logo">Little Artix <img src="images/finals_bg.jpg" alt="Logo"></a>
        <ul class="nav navt">
            <li><a href="home.html">Home</a> </li>
            <li> <a href="about.html">About</a></li>
            <li><a href="products.html">Products</a> </li>
            <li> <a href="services.html">Services</a></li>
            <li><a href="contact.html">Contact</a> </li>
            <li> <a href="reviews.html">Reviews</a></li>
            <li> <a href="feedback.php">Feedback</a></li>
        </ul>
    </div>

    <div class="buffer"></div>
    <!--Tentative php code that sends data to the database the submit button is pressed -->
    <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            uploadData();
            }
            
            function uploadData(){
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $feedback = $_POST['feedback'];
            }
            //Submitting the database
            $servername = "localhost";
            $username = "root";
            $password = "";
            $database = "feedback";

            //create connection
            $conn = mysqli_connect($servername, $username, $password, $database);

            if (!$conn) {
                echo '<div class="alert alert-warning alert-dismissible fade show" role"alert"<strong>Connection Failed</strong></div>'. mysqli_connect_error();
            }
                else{
                    $sql = "INSERT INTO `storedfeedbacks` (`s.no`, `email`, `feedback`, `timestamp`) VALUES (NULL,'$email','$feedback', current_timestamp())";
                    $result = mysqli_query($conn, $sql);
                    if ($result) {
                        echo '<div class="alert alert-warning alert-dismissible fade show" role"alert" <strong>Success!</strong> feedback is submitted from '. $email.'. Thank You!!</div>';
                    }
                    else{
                        echo '<div class="alert alert-warning alert-dismissible fade show" role"alert" <strong>Erroruploading data</strong></div>'. mysqli_error($conn);
                    }
                }
            }   
    ?>
    <div class="feedbackc">
        <h1 align="center">SEND FEEDBACK</h1>
        <p align="center">WE ARE HAPPY TO KNOW YOUR CRITIQUE AND SUGGESTIONS ABOUT OUR PRODUCT AND SERVICES...</p>
        <div class="container">
            <form action="/feedback_angeles/feedback_nobs.php" method="post">
                <div class="mb-3 row">
                    <label for="email" class="col-sm-2 col-form-label"><b>EMAIL ADDRESS</b></label>
                    <div class="col-sm-10">
                        <input type="email" name="email" class="form-control" id="email" placeholder="name@example.com">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="feedback" class="col-sm-2 col-form-label feedtext"><b>FEEDBACK/ SUGGESTION</b></label>
                    <div class="col-sm-10">
                        <textarea name="feedback" class="form-control" id="feedback" rows="6"></textarea>
                    </div>
                </div>

        </div>
    </div>

    <div align="center">
        <br />
        <button type="submit" class="btn btn-primary btn-lg"><b>SUBMIT</b></button>
    </div>
    </form>

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