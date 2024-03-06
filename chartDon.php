<?php
include("php/config.php");
$startDate = $_POST['startDate'];
$endDate = $_POST['endDate'];

$originalStartDate = new DateTime($startDate);
$formattedStartDate = $originalStartDate->format('Y-m-d');
$originalEndDate = new DateTime($endDate);
$formattedEndDate = $originalEndDate->format('Y-m-d');

$sql = "SELECT egine_dekto, hmerominia_doreas FROM dorees WHERE hmerominia_doreas BETWEEN '$formattedStartDate' AND '$formattedEndDate' ORDER BY egine_dekto DESC";
error_log("SQL Query: " . $sql);
$result = mysqli_query($con, $sql);

if (mysqli_num_rows($result) > 0) {
    // Store data in arrays
    $dates = array();
    $newRequests = array();
    $processedRequests = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $dates[] = $row['hmerominia_doreas'];
        if ($row['egine_dekto'] === " ") {
            $newDonations[] = 1; 
            $processedDonations[] = 0;
        } else {
            $newDonations[] = 0;
            $processedDonations[] = 1;
        }
    }

    // Combine data into an associative array
    $data = array(
        'dates' => $dates,
        'newDonations' => $newDonations,
        'processedDonations' => $processedDonations
    );

    // Convert data to JSON and output
    header('Content-Type: application/json');
    echo json_encode($data, JSON_NUMERIC_CHECK);
} else {
    echo json_encode(array('error' => 'No results found'));
}
?>