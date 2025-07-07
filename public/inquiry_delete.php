<?php
// ✅ Allow CORS from all origins (for development)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, PUT, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

// ✅ Handle preflight (OPTIONS) request
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

include "connection.php";

// Get the id from the query string
$id = isset($_GET['delId']) ? $_GET['delId'] : null;

if ($id) {
    $exe = $obj->query("DELETE FROM inquiry WHERE id = '$id'");
    if ($exe) {
        echo json_encode(["message" => "Deleted successfully"]);
    } else {
        echo json_encode(["message" => "Error occurred"]);
    }
} else {
    echo json_encode(["message" => "No ID provided"]);
}
?>