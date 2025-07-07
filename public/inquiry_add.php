<?php


include 'connection.php';

// Read raw JSON input
$data = json_decode(file_get_contents("php://input"), true);


if($data["name"] =='' || $data["contact"]=='' || $data["email"]=='' || $data["subject"]=='' || $data["message"] == '')
{
    echo "Not Empty";
    exit;
}
$name = $data["name"];
$contact = $data["contact"];
$email = $data["email"];
$subject = $data["subject"];
$message = $data["message"];


$exe = $obj->query("insert into inquiry(name,contact,email,subject,message) values('$name','$contact','$email','$subject','$message')");

if($exe)
{
	echo "Inserted Successfully..";
}
else
{
	echo "Unknown error occured..";
}



?>