<?php
include("php/config.php");

$delCategoryIdJson = file_get_contents('php://input');
$delCategoryId = json_decode($delCategoryIdJson, true);

// Read the current categories from the JSON file
$categoriesJson = file_get_contents('categories.json');
$categories = json_decode($categoriesJson, true);

// Search for the category ID in the categories array
$index = array_search($delCategoryId, array_column($categories, 'id'));

// If found, remove it from the array
if ($index !== false) {
    array_splice($categories, $index, 1);
}

// Encode the updated $categories array back to JSON
$updatedCategoriesJson = json_encode(array_values($categories), JSON_PRETTY_PRINT);


// Save the updated JSON back to the file
file_put_contents('categories.json', $updatedCategoriesJson);

// Set content type header for JSON
header('Content-Type: application/json');

// Respond with a success message
echo json_encode(['message' => 'Category deleted successfully']);
?>