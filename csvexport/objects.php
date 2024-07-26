<?php
include "config.php";

// Retrieve startDate, endDate, and currentDate from the request
$startDate = isset($_GET['startDate']) ? $_GET['startDate'] : '';
$endDate = isset($_GET['endDate']) ? $_GET['endDate'] : '';
$currentDate = isset($_GET['currentDate']) ? $_GET['currentDate'] : date('Y-m-d');

// Debugging statements
error_log("Start Date: " . $startDate);
error_log("End Date: " . $endDate);
error_log("Current Date: " . $currentDate);

// Build the SQL query based on the date range and include records from the current date
if (!empty($startDate) && !empty($endDate)) {
    $sql = "SELECT * FROM users WHERE DATE(create_on) BETWEEN '$startDate' AND '$endDate'";
} else {
    $sql = "SELECT * FROM users WHERE DATE(create_on) = '$currentDate'";
}

// Debugging statement for SQL query
error_log("SQL Query: " . $sql);

$result = mysqli_query($con, $sql);

$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

$response = array(
    "data" => $data
);

echo json_encode($response);

mysqli_close($con);
?>
