<?php
$path = $_SERVER['DOCUMENT_ROOT']."/";
set_include_path($path);
include('Modules/mysqliConnection.php');

$userId = isset($_POST['userId']) ? $_POST['userId'] : "";

$sql = "SELECT userId FROM userinformation WHERE userId = '".$userId."'";
$queryCheck = $db->query($sql);
if($queryCheck AND $queryCheck->num_rows == 0)
{
	echo "temp";
}
else
{
	$batchNumber = date("YmdHis").$userId;

	$sql = "UPDATE productorders SET batchNumber = '".$batchNumber."', orderStatus = 1 WHERE userId = '".$userId."' AND orderStatus = 0";
	$queryUpdate = $db->query($sql);

	$sql = "INSERT INTO `productverification`(`verificationStatus`, `batchNumber`) 
									VALUES (0, '".$batchNumber."')";
	$queryInsert = $db->query($sql);
}
?>