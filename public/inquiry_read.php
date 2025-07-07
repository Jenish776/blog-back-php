<?php
// CORS headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Access-Control-Max-Age: 86400");
header("Content-Type: application/json");

// Respond to preflight OPTIONS request
if ($_SERVER["REQUEST_METHOD"] == "OPTIONS") {
    http_response_code(200);
    exit();
}

include 'connection.php';

$result = $obj->query("SELECT * FROM inquiry");

// Ensure $r is always defined
$r = [];

while($row = $result->fetch_object()) {
    $r[] = $row;
}

echo json_encode($r);
?>
