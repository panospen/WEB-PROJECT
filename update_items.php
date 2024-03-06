<?php
include("php/config.php");
// Read the existing items
$itemsJson = file_get_contents('items.json');
$items = json_decode($itemsJson, true);

// Get the new items from the request
$newitemsJson = file_get_contents('php://input');
$newitems = json_decode($newitemsJson, true);

// Merge the new items with the existing ones
$mergeditems = array_merge($items, $newitems);

// Convert the merged items back to JSON
$mergeditemsJson = json_encode($mergeditems, JSON_PRETTY_PRINT);

// Write the updated items back to items.json
file_put_contents('items.json', $mergeditemsJson);

// Respond with a success message
echo json_encode(['message' => 'Items updated successfully']);

foreach ($newitems as $newItem){
    $itemId = mysqli_real_escape_string($con, $newItem['id']);
    $itemName = mysqli_real_escape_string($con, $newItem['name']);
    $itemCat = mysqli_real_escape_string($con, $newItem['category']);
    $query = "INSERT INTO products(id, pr_name, category) VALUES('$itemId', '$itemName', '$itemCat')";
    mysqli_query($con, $query);

    foreach($newItem['details'] as $detail){
        $detailName = mysqli_real_escape_string($con, $detail['detail_name']);
        $detailValue = mysqli_real_escape_string($con, $detail['detail_value']);
        $detailQuery = "INSERT INTO product_details(pr_id, detail_name, detail_value, quantity) VALUES('$itemId', '$detailName', '$detailValue', '')";
        mysqli_query($con, $detailQuery);
    }
}
?>