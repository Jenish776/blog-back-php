<?php 
include "connection.php";

$data = json_decode(file_get_contents("php://input"),true);


$categoryName = $data["categoryName"];


$exe = $obj->query("update category set categoryName = '$categoryName'");

if($exe){
    echo "Updated successfully";
}
else{
    echo "error occured";
}

?>