<?php
header("Content-Type: application/json");
include 'connection.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check required POST and FILES data
if (
    !empty($_POST["firstName"]) &&
    !empty($_POST["lastName"]) &&
    !empty($_POST["userName"]) &&
    !empty($_POST["email"]) &&
    !empty($_POST["password"]) &&
    isset($_FILES["photo"]) &&
    $_FILES["photo"]["error"] === 0
) {
    $firstName = $obj->real_escape_string($_POST["firstName"]);
    $lastName  = $obj->real_escape_string($_POST["lastName"]);
    $userName  = $obj->real_escape_string($_POST["userName"]);
    $email     = $obj->real_escape_string($_POST["email"]);
    $password  = $obj->real_escape_string($_POST["password"]);

    // Check if email or username already exists
    $check = $obj->query("SELECT * FROM register WHERE email = '$email' OR userName = '$userName'");
    if ($check && $check->num_rows > 0) {
        echo json_encode([
            "status" => false,
            "message" => "Email or username already exists."
        ]);
        exit;
    }

    // Save uploaded file with unique name
    $photo_name = time() . '_' . basename($_FILES["photo"]["name"]);
    $photo_tmp  = $_FILES["photo"]["tmp_name"];
    $upload_dir = "uploads/" . $photo_name;

    if (move_uploaded_file($photo_tmp, $upload_dir)) {
        // Insert into database
        $exe = $obj->query("INSERT INTO register 
            (firstName, lastName, userName, email, Password, photo_path) 
            VALUES 
            ('$firstName', '$lastName', '$userName', '$email', '$password', '$upload_dir')");

        if ($exe) {
            echo json_encode([
                "status" => true,
                "message" => "Inserted Successfully",
                "user" => [
                    "firstName" => $firstName,
                    "lastName" => $lastName,
                    "userName" => $userName,
                    "password" => $password,
                    "email" => $email,
                    "photo_path" => $upload_dir
                ]
            ]);
        } else {
            echo json_encode([
                "status" => false,
                "message" => "Database insertion failed",
                "error" => $obj->error
            ]);
        }
    } else {
        echo json_encode([
            "status" => false,
            "message" => "File upload failed"
        ]);
    }
} else {
    echo json_encode([
        "status" => false,
        "message" => "Missing or invalid required fields",
        "debug" => [
            "firstName" => $_POST["firstName"] ?? null,
            "lastName" => $_POST["lastName"] ?? null,
            "userName" => $_POST["userName"] ?? null,
            "email" => $_POST["email"] ?? null,
            "password" => $_POST["password"] ?? null,
            "photo_error" => $_FILES["photo"]["error"] ?? "no file"
        ]
    ]);
}
