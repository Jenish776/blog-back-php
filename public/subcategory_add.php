<?php 


// Include database connection
include 'connection.php';

// Read the raw POST JSON data
$data = json_decode(file_get_contents("php://input"), true);

// Validate the input
if (empty($data["subCategoryName"]) || empty($data["category_id"])) {
    echo json_encode(["message" => "SubCategory name and Category ID cannot be empty."]);
    exit;
}

// Sanitize inputs (to avoid SQL injection)
$subCategoryName = $data["subCategoryName"];
$category_id = $data['category_id']; 

// Prepare and execute the SQL query (using prepared statements for safety)
$stmt = $obj->prepare("INSERT INTO subcategory (subCategoryName, category_id) VALUES (?, ?)");
$stmt->bind_param("si", $subCategoryName, $category_id); // "si" stands for string, integer

// Execute the query and check the result
if ($stmt->execute()) {
    echo json_encode(["message" => "Inserted successfully."]);
} else {
    echo json_encode(["message" => "Unknown error occurred."]);
}

// Close the statement
$stmt->close();
?>
