<?php
include("php/config.php");
// Retrieve data from the POST request
$categoryId = $_POST['categoryId'];
$categoryName = $_POST['categoryName'];

// Update the database
$sql = "UPDATE categories SET cat_name = '$categoryName' WHERE cat_id = '$categoryId'";
$query = mysqli_query($con, $sql);
if ($query === TRUE) {
    echo "Database updated successfully";
} else {
    echo "Error updating database: " . $con->error;
}

?>
