<?php


include 'connection.php';

$result = $obj->query("select * from subcategory");

while($row = $result->fetch_object())
{
	$r[] = $row;
}
echo json_encode($r);
?>