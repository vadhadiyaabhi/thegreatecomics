
<!-- This file is in non-public directory now -->
<!-- And here mentioned paths are according to server's location -->

<?php

    require_once __DIR__.'/../public_html/dbconnect.php';
    require_once __DIR__.'/../public_html/config.php';

    $url = 'https://c.xkcd.com/random/comic/';
    $header = get_headers($url,1);
    $comic_url = $header['Location'][0];

    $file = $comic_url . '/info.0.json';
    $data = file_get_contents($file);
    $json_data = json_decode($data);


    $img = $json_data->img;
    $content = file_get_contents($img);
    $content = chunk_split(base64_encode($content));
    $uid = md5(uniqid(time()));
    $name = basename($img);

    $from_name = from_name;
    $from_mail = from_mail;
    $replyto = replyto;
    $unsubscribe_link = unsub_link;

    $subject = "The Great Comics";

    $header = "From: ".$from_name." <".$from_mail.">\r\n";
    $header .= "Reply-To: " .$replyto. "\r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-Type: multipart/mixed; boundary=\"" .$uid. "\"\r\n\r\n";

    $message = "--" .$uid. "\r\n";
    $message .= "Content-type: text/html; charset=iso-8859-1\r\n";
    $message .= "Content-transfer-Encoding: 8bit\r\n";
    $message .= "<h3> $json_data->title </h3> <br>
            <img src=' $json_data->img ' alt='Random Comic Image' height='300px' width='300px'> <br><br> \r\n";
    $nmessage = "--" .$uid. "\r\n";
    $nmessage .= "Content-Type: Application/octet-stream; name=\"".$name."\"\r\n";
    $nmessage .= "Content-Transfer-Encoding: base64\r\n";
    $nmessage .= "Content-Diposition: attachment; filename=\"".$name."\"\r\n";
    $nmessage .= $content. "\r\n\r\n";
    $nmessage .= "--" .$uid. "--";

    $que = "SELECT email,token FROM email_info WHERE status = 'active';";
    $result = mysqli_query($con, $que);
    $num = mysqli_num_rows($result);

    if($num>0)
    {
        for($i = 0; $i < $num; $i++)
        {
            $row = mysqli_fetch_array($result);
            $to = $row['email'];
            $token = $row['token'];

            $body = $message. "\r\n";
            $body .= "<a href='$unsubscribe_link?token=$token' style='text-decoration-line: underline;'>Unsubscribe to The Great Comics </a> \r\n\r\n";
            $body .= $nmessage;

            mail($to, $subject, $body, $header);
        }

    }


?>

