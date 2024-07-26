

<!-- email download -->
<?php

    include "config.php";
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'vendor/phpmailer/phpmailer/src/Exception.php';
    require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
    require 'vendor/phpmailer/phpmailer/src/SMTP.php';

    $mail = new PHPMailer(true);

    // Fetch data from the database
    $sql = "SELECT name, city, age, contact, create_on FROM users";
    $result = $con->query($sql);

    // Create a CSV file
    $csvFile = 'users_data.csv';
    $csvHandle = fopen($csvFile, 'w');

    // Write CSV header
    fputcsv($csvHandle, ['Name', 'City', 'Age', 'Contact', 'Create_on']);

    // Write data rows
    while ($row = $result->fetch_assoc()) {
        fputcsv($csvHandle, $row);
    }

    // Close CSV file
    fclose($csvHandle);
   

    try {
        // Server settings
        // $mail->SMTPDebug = 2;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                 // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                             // Enable SMTP authentication
        $mail->Username   = 'manojkiyan56@gmail.com';            // SMTP username
        $mail->Password   = 'zxyt jrno jxav vseh';                   // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;   // Enable TLS encryption
        $mail->Port       = 587;                              // TCP port to connect to

        // Recipients
        $mail->setFrom('manojkiyan56@gmail.com', 'Manoj');
        $mail->addAddress('praisonsdp@gmail.com', 'Joe User');     // Add a recipient


        // Attachments
        $mail->addAttachment($csvFile); // Add CSV file as attachment
        

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Here is the subject';
        $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
?>

