<?php
$path = $_SERVER['DOCUMENT_ROOT']."/";
set_include_path($path);
include('Modules/mysqliConnectionStart.php');

$userId = $_POST['userId'];
$oldPassword = $_POST['oldPassword'];

$sql = "SELECT userPassword FROM useraccounts WHERE userId = ".$userId;
$query = $db->query($sql);
if($query AND $query->num_rows > 0)
{
	$result = $query->fetch_assoc();
	$userPassword = $result['userPassword'];

	if(md5($oldPassword) == $userPassword)
	{
		echo "true";
	}
	else
	{
		echo "false";
	}
}
else
{
	echo "false";
}
?>