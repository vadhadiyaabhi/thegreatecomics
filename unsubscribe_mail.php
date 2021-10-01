<?php

    if(isset($_GET['token']))
    {
        $var = false;
        $var2 = false;
        require_once __DIR__.'/dbconnect.php';
        $token = mysqli_real_escape_string($con,$_GET['token']);
        $result = mysqli_query($con, "SELECT token FROM email_info WHERE token = '$token';");
        $num = mysqli_num_rows($result);
        if($num>0)
        {
            mysqli_query($con, "DELETE FROM email_info WHERE token = '$token';");
            $var = true;
        }
        else
        {
            $var2 = true;
        }
  
    }

?>


    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>The Great Comics - Unsubscribe Done</title>
    </head>
    <body>
        <?php if($var){ ?>
            <p style="background-color: rgb(255, 45, 45); color: white; text-align: center; padding: 7px; border-radius:7px;">You've successfully unsubscribed from <strong> The Great Comics </strong> </p>
        <?php } ?>
        <?php if($var2){ ?>
            <p style="background-color: rgb(0, 184, 0); color: white; text-align: center; padding: 7px; border-radius: 7px;">You've already unsubscribed from <strong> The Great Comics </strong> </p>
        <?php } ?>
    </body>
    </html>

