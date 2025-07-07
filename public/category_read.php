<?php

include 'connection.php';

$result = $obj->query("select * from category");


while($row = $result->fetch_object())
{
	$r[] = $row;
}

echo json_encode($r);


?>