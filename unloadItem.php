<?php
// Assuming you have a database connection established
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "xristos";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sanitize user input to prevent SQL injection
$loadId = mysqli_real_escape_string($conn, $_POST['loadId']);

// Retrieve information from the loads table based on load_id
$sqlSelectLoad = "SELECT pr_name, category, quantity FROM loads WHERE load_id = ?";
$stmtSelectLoad = $conn->prepare($sqlSelectLoad);
$stmtSelectLoad->bind_param("i", $loadId);

// Execute the select load query
$stmtSelectLoad->execute();
$stmtSelectLoad->store_result();
$stmtSelectLoad->bind_result($prName, $category, $quantity);

// Fetch the result
$stmtSelectLoad->fetch();

// Check if a record with the same name and category already exists in the products table
$sqlCheckExisting = "SELECT quantity FROM products WHERE pr_name = ? AND category = ?";
$stmtCheckExisting = $conn->prepare($sqlCheckExisting);
$stmtCheckExisting->bind_param("ss", $prName, $category);

// Execute the check existing query
$stmtCheckExisting->execute();
$stmtCheckExisting->store_result();

if ($stmtCheckExisting->num_rows > 0) {
    // Update the quantity of the existing item in the products table
    $stmtCheckExisting->bind_result($existingQuantity);
    $stmtCheckExisting->fetch();

    $newQuantity = $existingQuantity + $quantity;

    $sqlUpdateExisting = "UPDATE products SET quantity = ? WHERE pr_name = ? AND category = ?";
    $stmtUpdateExisting = $conn->prepare($sqlUpdateExisting);
    $stmtUpdateExisting->bind_param("iss", $newQuantity, $prName, $category);

    // Execute the update existing query
    $stmtUpdateExisting->execute();

    echo json_encode(array("message" => "Record added to existing item in inventory successfully"));
} else {
    // Insert a new record into the products table
    $sqlInsertNew = "INSERT INTO products (pr_name, category, quantity) VALUES (?, ?, ?)";
    $stmtInsertNew = $conn->prepare($sqlInsertNew);
    $stmtInsertNew->bind_param("ssi", $prName, $category, $quantity);

    // Execute the insert new query
    $stmtInsertNew->execute();

    echo json_encode(array("message" => "New record added to inventory successfully"));
}

// Delete the corresponding record from the loads table
$sqlDeleteLoad = "DELETE FROM loads WHERE load_id = ?";
$stmtDeleteLoad = $conn->prepare($sqlDeleteLoad);
$stmtDeleteLoad->bind_param("i", $loadId);

// Execute the delete load query
$stmtDeleteLoad->execute();

// Close the database connection
$stmtSelectLoad->close();
$stmtCheckExisting->close();
$stmtDeleteLoad->close();

if (isset($stmtUpdateExisting)) {
    $stmtUpdateExisting->close();
}

if (isset($stmtInsertNew)) {
    $stmtInsertNew->close();
}

$conn->close();
?>