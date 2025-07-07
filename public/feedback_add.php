<?php
include 'connection.php';

// Read raw JSON input
$data = json_decode(file_get_contents("php://input"), true);



// Validate required fields
if (
    empty($data["name"]) ||
    empty($data["contact"]) ||
    empty($data["email"]) ||
    empty($data["rating"]) ||
    empty($data["message"])
) {
    echo "Not Empty";
    exit;
}

$name = $data["name"];
$contact = $data["contact"];
$email = $data["email"];
$rating = $data["rating"];
$message = $data["message"];

$exe = $obj->query("INSERT INTO feedback(name, contact, email, rating, message) VALUES('$name', '$contact', '$email', '$rating', '$message')");

if ($exe) {
    echo "Inserted Successfully..";
} else {
    echo "Unknown error occurred..";
}
?>
