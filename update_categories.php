<?php
include("php/config.php");
$categoriesJson = file_get_contents('categories.json');
$categories = json_decode($categoriesJson, true);

// Get the new categories from the request
$newCategoriesJson = file_get_contents('php://input');
$newCategories = json_decode($newCategoriesJson, true);

// Merge the new categories with the existing ones
$mergedCategories = array_merge($categories, $newCategories);

// Convert the merged categories back to JSON
$mergedCategoriesJson = json_encode($mergedCategories, JSON_PRETTY_PRINT);

// Write the updated categories back to categories.json
file_put_contents('categories.json', $mergedCategoriesJson);

// Respond with a success message
echo json_encode(['message' => 'Categories updated successfully']);
?>
