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

// Retrieve data from the Fetch API request
$data = json_decode(file_get_contents("php://input"), true);

// Sanitize user input to prevent SQL injection
$car_id = mysqli_real_escape_string($conn, $data['car_id']);
$pr_name = mysqli_real_escape_string($conn, $data['pr_name']);
$category = mysqli_real_escape_string($conn, $data['category']);
$quantity = mysqli_real_escape_string($conn, $data['quantity']);
switch($category){
    case "5":
        $category = 'Food';
        break;    

    case "6":
        $category = 'Beverages';
   
    case "7":
        $category = 'Clothing';
        
    case "14":
        $category = 'Flood';
    
    case "16":
        $category = 'Medical Supplies';
    
    case "19":
        $category = 'Shoes';

    case "21":
        $category = 'Personal Hygiene';
}

// Start a transaction for atomicity
$conn->begin_transaction();

try {
    // Insert data into the loads table using a prepared statement
    $loadSql = "INSERT INTO loads (car_id, pr_name, category, quantity) VALUES (?, ?, ?, ?)";
    $loadStmt = $conn->prepare($loadSql);
    $loadStmt->bind_param("isss", $car_id, $pr_name, $category, $quantity);

    if (!$loadStmt->execute()) {
        throw new Exception("Error: " . $loadSql . "<br>" . $conn->error);
    }

    // Update the quantity in the products table
    $updateProductSql = "UPDATE products SET quantity = quantity - ? WHERE pr_name = ?";
    $updateProductStmt = $conn->prepare($updateProductSql);
    $updateProductStmt->bind_param("is", $quantity, $pr_name);

    if (!$updateProductStmt->execute()) {
        throw new Exception("Error: " . $updateProductSql . "<br>" . $conn->error);
    }

    // Commit the transaction
    $conn->commit();
    echo json_encode(array("message" => "Record added successfully"));
} catch (Exception $e) {
    // Rollback the transaction on error
    $conn->rollback();
    echo json_encode(array("error" => $e->getMessage()));
}

// Close the database connection
$loadStmt->close();
$updateProductStmt->close();
$conn->close();
?>