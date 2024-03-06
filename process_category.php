<?php

$jsonFile = 'http://usidas.ceid.upatras.gr/web/2023/export.php';

// Load existing JSON data
$jsonData = json_decode(file_get_contents($jsonFile), true);

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if it's a category or item submission
    if (isset($_POST['categoryAction'])) {
        // Handle category addition or editing
        $categoryId = $_POST['categoryId'];
        $categoryName = $_POST['categoryName'];

        if ($_POST['categoryAction'] === 'add') {
            // Add a new category
            $newCategory = array('id' => $categoryId, 'category_name' => $categoryName);
            $jsonData['categories'][] = $newCategory;
        } elseif ($_POST['categoryAction'] === 'edit') {
            // Edit existing category (you need to implement this part based on your requirements)
            foreach ($jsonData['categories'] as &$category) {
                if ($category['id'] === $categoryId) {
                    $category['category_name'] = $categoryName;
                    break;
                }
            }
        }
    } elseif (isset($_POST['itemAction'])) {
        // Handle item addition or editing
        $itemId = $_POST['itemId'];
        $itemName = $_POST['itemName'];
        $itemCategory = $_POST['itemCategory'];
        $detailName = $_POST['detailName'];
        $detailValue = $_POST['detailValue'];

        $newItem = array(
            'id' => $itemId,
            'name' => $itemName,
            'category' => $itemCategory,
            'details' => array(
                array('detail_name' => $detailName, 'detail_value' => $detailValue)
            )
        );

        if ($_POST['itemAction'] === 'add') {
            // Add a new item
            $jsonData['items'][] = $newItem;
        } elseif ($_POST['itemAction'] === 'edit') {
            // Edit existing item (you need to implement this part based on your requirements)
            foreach ($jsonData['items'] as &$item) {
                if ($item['id'] === $itemId) {
                    $item = $newItem;
                    break;
                }
            }
        }
    }

    // Convert the updated data to JSON
    $jsonString = json_encode($jsonData, JSON_PRETTY_PRINT);

    // Save the updated JSON data back to the file
    file_put_contents($jsonFile, $jsonString);
}

// Redirect back to your HTML page
header('Location: adminHome.php');
exit();
?>