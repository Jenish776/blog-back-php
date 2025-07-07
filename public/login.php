<?php
header("Content-Type: application/json");
session_start();

include "connection.php";

// Read JSON body
$data = json_decode(file_get_contents("php://input"), true);
$username = $data['userName'] ?? '';
$password = $data['password'] ?? '';

if ($username && $password) {
    $stmt = $obj->prepare("SELECT id, username, Password FROM register WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();

    if ($res && $password === $res['Password']) {
        $_SESSION['user'] = [ 'id' => $res['id'], 'username' => $res['username'] ];
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