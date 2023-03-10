<?php
$path = $_SERVER['DOCUMENT_ROOT']."/";
set_include_path($path);
include('Modules/mysqliConnection.php');
$userId = $_SESSION['userId'];

$type = $_GET['type'];
if($type == 1)
{
	$dataPrice = $_POST['dataPrice'];
	$layerNumber = $_POST['layerNumber'];
	$dataId = $_POST['dataId'];
	$batchNumber = $userId.date("Ymd_His");
	$dateNow = date('Y-m-d');
	$sql = "SELECT batchNumber FROM cakecustomizedinfo WHERE userId = ".$userId." AND customStatus = 0 LIMIT 1";
	$queryBatch = $db->query($sql);
	if($queryBatch AND $queryBatch->num_rows > 0)
	{
		$resultBatch = $queryBatch->fetch_assoc();
		$batchNumber = $resultBatch['batchNumber'];
	}

	$sql = "INSERT INTO `cakecustomizedinfo`(
												`userId`, 
												`decorationId`, 
												`layerNumber`, 
												`price`, 
												`batchNumber`,
												`dateCreated` 
											) 
									VALUES (
												".$userId.",
												".$dataId.",
												".$layerNumber.",
												".$dataPrice.",
												'".$batchNumber."',
												'".$dateNow."'
										   )";
	$queryInsert = $db->query($sql);	
	echo $id = $db->insert_id;
}

if($type == 2)
{
	$customId = $_POST['customId'];	
	$sql = "DELETE FROM cakecustomizedinfo WHERE customId = ".$customId." LIMIT 1";
	$queryDelete = $db->query($sql);
}

if($type == 3)
{
	$customId = $_POST['customId'];	
	$flavorId = $_POST['flavorId'];

	$sql = "UPDATE cakecustomizedinfo SET flavorId = ".$flavorId." WHERE customId = ".$customId." LIMIT 1";
	$queryUpdate = $db->query($sql);
}
?>