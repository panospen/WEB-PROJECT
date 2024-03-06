<?php
include("php/config.php");
$startDate = $_POST['startDate'];
$endDate = $_POST['endDate'];

$originalStartDate = new DateTime($startDate);
$formattedStartDate = $originalStartDate->format('Y-m-d');
$originalEndDate = new DateTime($endDate);
$formattedEndDate = $originalEndDate->format('Y-m-d');

$sql = "SELECT egine_dekto, hmerominia_aitisis FROM aithmata WHERE hmerominia_aitisis BETWEEN '$formattedStartDate' AND '$formattedEndDate' ORDER BY egine_dekto DESC";
error_log("SQL Query: " . $sql);
$result = mysqli_query($con, $sql);

// Check if there are results
if (mysqli_num_rows($result) > 0) {
    // Store data in arrays
    $dates = array();
    $newRequests = array();
    $processedRequests = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $dates[] = $row['hmerominia_aitisis'];
        if ($row['egine_dekto'] === "NAI") {
            $newRequests[] = 0; 
            $processedRequests[] = 1;
        } else {
            $newRequests[] = 1;
            $processedRequests[] = 0;
        }
    }

    // Combine data into an associative array
    $data = array(
        'dates' => $dates,
        'newRequests' => $newRequests,
        'processedRequests' => $processedRequests
    );

    // Convert data to JSON and output
    header('Content-Type: application/json');
    echo json_encode($data, JSON_NUMERIC_CHECK);
} else {
    echo json_encode(array('error' => 'No results found'));
}
?>