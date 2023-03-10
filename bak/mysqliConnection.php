<?php
session_start();
$DBServer = 'localhost';
// $DBUser   = 'id10792122_root';
$DBUser   = 'root';
$DBPass   = '';
// $DBName   = 'id10792122_orderingdatabase';
$DBName   = 'orderingdatabase';
$db = new mysqli($DBServer, $DBUser, $DBPass, $DBName);
$db->set_charset("utf8");
// check connection
if ($db->connect_error)
{
  trigger_error('Database connection failed: '  . $db->connect_error, E_USER_ERROR);
}

if(!isset($_SESSION['userId']))
{
	$listId = 1;
	$sql = "SELECT listId FROM tempaccount ORDER BY listId DESC LIMIT 1";
	$query = $db->query($sql);
	if($query AND $query->num_rows > 0)
	{
		$result = $query->fetch_assoc();
		$listId = $result['listId'];
	}

	$tempUserId = date("ymdhis").$listId;
	$_SESSION['userId'] = $tempUserId;
	// header("location:index.php");
	// exit();
}
?>