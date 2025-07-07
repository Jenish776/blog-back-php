<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");



include "connection.php";

$id = $_GET["delId"] ?? null;

if (!$id) {
    echo json_encode(["message" => "Missing ID"]);
    exit;
}

$exe = $obj->query("DELETE FROM posts WHERE id = '$id'");

if ($exe) {
    echo json_encode(["message" => "Deleted successfully"]);
} else {
    echo json_encode(["message" => "Error occurred"]);
}
?>