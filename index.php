<?php

    session_start();
    $var = false;
    $status = false;
    $fnameErr = '';
    $lnameErr = '';
    $emailErr = '';

    if(isset($_POST['submit']))
    {
        require_once __DIR__.'/dbconnect.php';
        require_once __DIR__.'/config.php';

        if (empty($_POST['fname'])) {
            $fnameErr = 'First name is required';
          } else {
            $fname = mysqli_real_escape_string($con,$_POST['fname']);
          }

        if (empty($_POST['lname'])) {
            $lnameErr = 'Last name is required';
          } else {
            $lname = mysqli_real_escape_string($con,$_POST['lname']);
          }

        if (empty($_POST['email'])) {
            $emailErr = 'Email is required';
        } else {
            $email = mysqli_real_escape_string($con,$_POST['email']);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = 'Invalid email format';
            }
        }

        if($fnameErr == '' && $lnameErr == '' && $emailErr == '')
        {
            $q = "SELECT email from email_info WHERE email = '$email' and status = 'active';";
            $result = mysqli_query($con,$q);
            $num = mysqli_num_rows($result);
            if($num > 0){
                $var = true;
            }

            else{
                
                $q = "SELECT email from email_info WHERE email = '$email' and status = 'inactive';";
                $result = mysqli_query($con,$q);
                $num = mysqli_num_rows($result);
                if($num == 0){
                    $token = bin2hex(random_bytes(15));
                    $que = "INSERT INTO email_info (fname, lname, email, status, token) VALUES ('$fname', '$lname', '$email', 'inactive','$token')";
                    $result = mysqli_query($con,$que);
                }
                
                $otp = rand(100000,999999);
                $_SESSION['otp'] = $otp;

                $from = from_mail;
                $to = $email;
                $subject = "Verification email";
                $body = "Hello $fname $lname, <br> Please enter this verification code to subscribe to The Great Comics - <strong> $otp </strong> <br> Thank You";
                $headers = "From:$from\nMIME-Version: 1.0\nContent-Type: text/html; charset=utf-8\n";

                $mail = mail($to, $subject, $body, $headers);
                if($mail){
                    $_SESSION['email'] = $email;
                    $_SESSION['email_sent'] = true;
                    header('location: verification.php');
                    exit;
                }
                else{
                    $_SESSION['email'] = 'unsent';
                    echo 'Oops! verification email could not be sent...';
                }
 
            }
        }
        
      
    }

?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <style>
            a{
                display: block;
                margin-top: 15px;
                font-size: large;
            }
            a:link{
                text-decoration: none;
            }
            .status{
                display: flex;
                align-items: center;
            }
            .fail{
                display: inline-block;
                align-items: center;
                background-color: rgb(0, 119, 255);
                color: white;
                border-radius: 10px;
                padding: 12px;
                margin: 20px auto;
            }
        </style>
        <link rel="stylesheet" href="index.css">
        <title>The Great Comics - Signin page</title>
    </head>

    <body>
        <div class="title">
        <br>
        <hr>
        <h2>The Great Comics</h2>
        <hr>
        </div>
        <div class="container">
            <p style="text-align:center;" class="para1">Subscribe with valid email to get <strong> The Great Comics </strong> after every 5 minutes</p>
            <form action="<?php if(isset($_SERVER['PHP_SELF'])){echo htmlentities($_SERVER['PHP_SELF']);} ?>" method="POST">
                <label for="fname">First name:</label><sup style="color:red;">*</sup><span class="error" style="color:red;"><?php echo $fnameErr; ?></span><br>
                <input type="text" name="fname" id="inputField" autocomplete="on" placeholder="Enter first name" required><br>
                

                <label for="lname">Last name:</label><sup style="color:red;">*</sup><span class="error" style="color:red;"><?php echo $lnameErr; ?></span><br>
                <input type="text" name="lname" class="inputField" autocomplete="on" placeholder="Enter last name" required><br>
                

                <label for="email">Email address:</label><sup style="color:red;">*</sup><span class="error" style="color:red;"><?php echo $emailErr; ?></span><br>
                <input type="text" name="email" class="inputField" autocomplete="on" placeholder="Enter valid email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required><br>
                

                <input type="submit" value="Subscribe" name="submit">
            </form>

            <a href="unsubscribe.php">Click here to Unsubscribe...</a>
            <div class="status">
                <?php if($var == true){ ?>
                    <p class="fail">
                        You have already subscribed to <strong> The Great Comics! </strong>
                    </p>
                <?php } ?>
            </div>

        </div>
    </body>
</html>