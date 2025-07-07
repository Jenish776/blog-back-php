<?php
header("Content-Type: application/json");

include 'connection.php'; 

if (
    !empty($_POST['category']) &&
    !empty($_POST['subcategory']) &&
    !empty($_POST['title']) &&
    !empty($_POST['description']) &&
    !empty($_POST['username']) &&
    !empty($_POST['datetime']) &&
    isset($_FILES['photo']) &&
    $_FILES['photo']['error'] === 0
) {
    // Retrieve form values
    $category    = $_POST['category'];
    $subcategory = $_POST['subcategory'];
    $title       = $_POST['title'];
    $description = $_POST['description'];
    $username    = $_POST['username'];
    $datetime    = $_POST['datetime'];

    // Handle file upload
    $photo_name = basename($_FILES["photo"]["name"]);
    $photo_tmp  = $_FILES["photo"]["tmp_name"];
    $upload_dir = "uploads/" . $photo_name;
    
    if (move_uploaded_file($photo_tmp, $upload_dir)) {
        $photo_path = $upload_dir;
        echo $upload_dir;

        // Prepared statement to insert into DB
        $stmt = $obj->prepare("INSERT INTO posts (category, subcategory, title, description, username, datetime, photo_path) 
                               VALUES (?, ?, ?, ?, ?, ?, ?)");

        if ($stmt === false) {
            echo json_encode(["status" => false, "message" => "Prepare failed: " . $obj->error]);
            exit;
        }

        $stmt->bind_param("sssssss", $category, $subcategory, $title, $description, $username, $datetime, $photo_path);

        if ($stmt->execute()) {
            echo json_encode(["status" => true, "message" => "Post uploaded successfully"]);
        } else {
            echo json_encode(["status" => false, "message" => "Database insertion failed: " . $stmt->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(["status" => false, "message" => "File upload failed"]);
    }
} else {
    echo json_encode(["status" => false, "message" => "Missing or invalid fields"]);
}
?>