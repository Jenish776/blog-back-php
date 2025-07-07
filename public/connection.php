<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");


$obj = new mysqli("sql203.infinityfree.com","if0_39412766","PkMJhMsdvRN","if0_39412766_blogsDB");
if($obj->connect_errno != 0)
{
	echo $obj->connect_error;
	exit;
}
echo json_encode(["message" => "Hello from backend"]);

?>