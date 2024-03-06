<?php
// Retrieve data from the POST request
$data = json_decode(file_get_contents('php://input'), true);

// Assuming categories.json is in the same directory as this script
$file = 'categories.json';

// Convert the associative array to JSON format
$jsonData = json_encode($data, JSON_PRETTY_PRINT);

// Write the JSON data to the file
if (file_put_contents($file, $jsonData)) {
    echo "Categories updated successfully";
} else {
    echo "Error updating categories";
}
?>
