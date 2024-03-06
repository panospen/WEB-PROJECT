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
$data = json_decode(file_get_contents("php://input"), true);

// Sanitize user input to prevent SQL injection
$userCarId = mysqli_real_escape_string($conn, $data['car_id']);

// Retrieve inventory data from the loads table for the specified car_id
$sql = "SELECT load_id, pr_name, category, SUM(quantity) AS quantity FROM loads WHERE car_id = ? GROUP BY load_id, pr_name, category";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userCarId);

if ($stmt->execute()) {
    $result = $stmt->get_result();

    // Fetch data as an associative array
    $inventoryData = array();
    while ($row = $result->fetch_assoc()) {
        $inventoryData[] = $row;
    }

    // Encode as JSON and send to the client
    echo json_encode($inventoryData);
} else {
    echo json_encode(array("error" => "Error: " . $sql . "<br>" . $conn->error));
}

// Close the database connection
$stmt->close();
$conn->close();
?>