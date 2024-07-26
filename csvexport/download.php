<?php
    include "config.php";

    // Fetch data from the database
    $sql = "SELECT name, city, age, contact, create_on FROM users";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        // Open a file pointer
        $output = fopen('php://output', 'w');
        
        // Set the headers to download the file
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="spot.csv"');

        // Output the column headings
        fputcsv($output, array('Name', 'City', 'Age', 'Contact', 'create_on'));

        // Output each row of the data
        while ($row = $result->fetch_assoc()) {
            fputcsv($output, $row);
        }

        // Close the file pointer
        fclose($output);
    } else {
        echo "No records found.";
    }
?>
