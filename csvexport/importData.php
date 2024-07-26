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

            $sql = "INSERT INTO users (name, city, age, contact, create_on) VALUES ";
            $rows = [];
            while (($row = fgetcsv($csvFile)) !== FALSE) {
                // Ensure that each CSV row has the correct number of columns
                if (count($row) == 5) {
                    $name = $con->real_escape_string($row[0]);
                    $city = $con->real_escape_string($row[1]);
                    $age = intval($row[2]);
                    $contact = $con->real_escape_string($row[3]);
                    $create_on = $con->real_escape_string($row[4]);

                    // Check if the contact already exists
                    $checkQuery = "SELECT * FROM users WHERE contact = '$contact'";
                    $result = $con->query($checkQuery);

                    if ($result->num_rows == 0) {
                        // Contact does not exist, add to the insert query
                        $rows[] = "('$name', '$city', $age, '$contact', '$create_on')";
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