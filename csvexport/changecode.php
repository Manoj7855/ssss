<?php
///////// no update and already name not save
include "config.php";

if (isset($_POST['submit'])) {
    // Allowed MIME types for CSV files
    $csvMimes = array('application/vnd.ms-excel', 'text/csv', 'application/csv');

    if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes)) {
        if (is_uploaded_file($_FILES["file"]["tmp_name"])) {
            $csvFile = fopen($_FILES["file"]["tmp_name"], "r");

            // Skip the first line (header)
            fgetcsv($csvFile);

            $sql = "INSERT INTO users (name, city, age, contact) VALUES ";
            $rows = [];
            while (($row = fgetcsv($csvFile)) !== FALSE) {
                // Ensure that each CSV row has the correct number of columns
                if (count($row) == 4) {
                    $name = $con->real_escape_string($row[0]);
                    $city = $con->real_escape_string($row[1]);
                    $age = intval($row[2]);
                    $contact = $con->real_escape_string($row[3]);

                    // Check if the contact already exists
                    $checkQuery = "SELECT * FROM users WHERE contact = '$contact'";
                    $result = $con->query($checkQuery);

                    if ($result->num_rows == 0) {
                        // Contact does not exist, add to the insert query
                        $rows[] = "('$name', '$city', $age, '$contact')";
                    }
                }
            }
            fclose($csvFile);

            if (!empty($rows)) {
                $sql .= implode(",", $rows);
                if ($con->query($sql)) {
                    echo "File uploaded successfully.";
                } else {
                    echo "Failed to insert data. Please try again.";
                }
            } else {
                echo "No valid data found in the file or all contacts already exist.";
            }
        } else {
            echo "File upload failed.";
        }
    } else {
        echo "Invalid file type.";
    }
}
?>
<?php
    include "config.php";

    if (isset($_POST['submit'])) {
        // Allowed MIME types for CSV files
        $csvMimes = array('application/vnd.ms-excel', 'text/csv', 'application/csv');

        if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes)) {
            if (is_uploaded_file($_FILES["file"]["tmp_name"])) {
                $csvFile = fopen($_FILES["file"]["tmp_name"], "r");

                // Skip the first line (header)
                fgetcsv($csvFile);

                while (($row = fgetcsv($csvFile)) !== FALSE) {
                
                        $name =$row[0];
                        $city =$row[1];
                        $age = $row[2];
                        $contact =$row[3];

                        // Check if the contact already exists
                        $sql = "SELECT * FROM users WHERE contact = '$contact'";
                        $result = $con->query($sql);

                        if ($result->num_rows>0) {
                            $s="update users set name='$name', city='$city', age='$age', contact='$contact'
                            where contact ='$contact'";
                            $con->query($s);
                        }
                        else{
                            $s="insert into users (name,city,age,contact) values ('$name', '$city', '$age', '$contact')";
                            $con->query($s);
                        }
                    }
                }
                fclose($csvFile);
                if (!empty($row)) {
                    $sql .= implode(",", $row);
                    if ($con->query($sql)) {
                        echo "File uploaded successfully.";
                    } else {
                        echo "Failed to insert data. Please try again.";
                    }
                } 
            } else {
                echo "File upload failed.";
                
            }
            
    } 
   



?>

<!-- email download -->
<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'vendor/phpmailer/phpmailer/src/Exception.php';
    require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
    require 'vendor/phpmailer/phpmailer/src/SMTP.php';

    $mail = new PHPMailer(true);

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
        $mail->addAttachment('C:/xampp/htdocs/import.csv');  // Add attachments
        

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

<!-- email send -->
<?php

    include "config.php";
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'vendor/phpmailer/phpmailer/src/Exception.php';
    require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
    require 'vendor/phpmailer/phpmailer/src/SMTP.php';

    $mail = new PHPMailer(true);

    // Fetch data from the database
    $sql = "SELECT name, city, age, contact FROM users";
    $result = $con->query($sql);

    // Create a CSV file
    $csvFile = 'users_data.csv';
    $csvHandle = fopen($csvFile, 'w');

    // Write CSV header
    fputcsv($csvHandle, ['Name', 'City', 'Age', 'Contact']);

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


