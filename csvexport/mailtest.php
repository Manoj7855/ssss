<?php

if(isset($_POST['submit'])){
    require 'PHPMailer/PHPMailerAutoload.php'; // Ensure you have PHPMailer installed and autoloaded
    $name = $_POST["name"];
    $email = $_POST["email"];
    $mail = new PHPMailer;

    // $mail->SMTPDebug = 4;                               // Enable verbose debug output

    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'manojkiyan56@gmail.com';             // SMTP username
    $mail->Password = 'zxyt jrno jxav vseh';                   // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    $mail->setFrom('manojkiyan56@gmail.com', 'test');
    $mail->addAddress('praisonsdp@gmail.com', 'Joe User'); // Add a recipient
    // $mail->addAddress('ellen@example.com');             // Name is optional
    // $mail->addReplyTo('info@example.com', 'Information');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    // $mail->addAttachment('/var/tmp/file.tar.gz');       // Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');  // Optional name
    $mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = 'Sample mail test';
    $mail->Body    = 'Name: '.$name.'<br>Email: '.$email;
    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    if(!$mail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'Message has been sent';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="mailtest.php" method="post">
        <div class="form-group">
            <input type="text" name="name" placeholder="Name"> <br>
            <input type="email" name="email" placeholder="Email"> <br>
            <input type="submit" name="submit" value="Submit">
        </div>
    </form>
</body>
</html>
