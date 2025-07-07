<?php
header("Access-Control-Allow-Origin: *"); // Or use your frontend domain instead of *
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST");
header('Content-Type: application/json');

header("Access-Control-Allow-Origin: http://localhost:3001");
include 'connection.php';

// Read raw JSON input
$data = json_decode(file_get_contents("php://input"), true);

// Validate input
if (empty($data["categoryName"])) {
    echo json_encode(["status" => false, "message" => "Category name is required."]);
    exit;
}

$categoryName = $data["categoryName"];

// Use prepared statement correctly
$stmt = $obj->prepare("INSERT INTO category (categoryName) VALUES (?)");
$stmt->bind_param("s", $categoryName);

if ($stmt->execute()) {
    echo json_encode(["status" => true, "message" => "Inserted Successfully."]);
} else {
    echo json_encode(["status" => false, "message" => "Error in code: " . $stmt->error]);
}

$stmt->close();
$obj->close();
?>