<?php
// ✅ CORS HEADERS (must be at the top)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// ✅ Handle preflight (CORS)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// ✅ Reject non-POST methods
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(["success" => false, "message" => "Method Not Allowed"]);
    exit();
}

// ✅ Start session and include DB
session_start();
include "connection.php";

// ✅ Read JSON input
$data = json_decode(file_get_contents("php://input"), true);
$username = $data['userName'] ?? '';
$password = $data['password'] ?? '';

// ✅ Validate & respond
if ($username && $password) {
    $stmt = $obj->prepare("SELECT id, username, Password FROM register WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();

    if ($res && $password === $res['Password']) {
        $_SESSION['user'] = ['id' => $res['id'], 'username' => $res['username']];
        echo json_encode([
            "success" => true,
            "message" => "Login successful",
            "user" => $_SESSION['user']
        ]);
    } else {
        echo json_encode(["success" => false, "message" => "Invalid credentials"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Missing credentials"]);
}
?>
