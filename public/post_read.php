<?php


include 'connection.php';

$result = $obj->query("SELECT * FROM posts");

$r = [];
while ($row = $result->fetch_object()) {
    $r[] = $row;
}

echo json_encode($r);
?>