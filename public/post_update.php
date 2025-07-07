<?php
header("Content-Type: application/json");
session_start();

include "connection.php";

$user = $_SESSION['user'] ?? null;
$data = $_POST;

$id = $data['id'] ?? null;
$category = $data['category'] ?? '';
$subcategory = $data['subcategory'] ?? '';
$title = $data['title'] ?? '';
$description = $data['description'] ?? '';

if (!$id || !$user) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized or missing data']);
    exit;
}

$photo_path = null;
if (!empty($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
    $name = basename($_FILES['photo']['name']);
    $target = 'uploads/' . time() . '_' . preg_replace('/\s+/', '_', $name);
    if (move_uploaded_file($_FILES['photo']['tmp_name'], $target)) {
        $photo_path = $target;
    }
}

$set = [
    "category = ?",
    "subcategory = ?",
    "title = ?",
    "description = ?"
];
if ($photo_path) $set[] = "photo_path = ?";

$sql = "UPDATE posts SET " . implode(',', $set) . " WHERE id = ? AND user_id = ?";
$stmt = $obj->prepare($sql);

if ($photo_path) {
    $stmt->bind_param("sssssi", $category, $subcategory, $title, $description, $photo_path, $id, $user['id']);
} else {
    $stmt->bind_param("ssssii", $category, $subcategory, $title, $description, $id, $user['id']);
}

if ($stmt->execute() && $stmt->affected_rows) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Not authorized or no changes made']);
}