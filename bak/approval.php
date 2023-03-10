<?php
$path = $_SERVER['DOCUMENT_ROOT']."/";
set_include_path($path);
include('Modules/mysqliConnection.php');

$batchNumber = isset($_REQUEST['batchNumber']) ? $_REQUEST['batchNumber'] : "";
$type = isset($_REQUEST['type']) ? $_REQUEST['type'] : "";
$userId = isset($_REQUEST['userId']) ? $_REQUEST['userId'] : "";
$remarks = isset($_REQUEST['remarks']) ? $_REQUEST['remarks'] : "";

if($type == "approve")
{
	$verificationStatus = 1;
	$orderStatus = 3;
	$notificationDetails = "Order/s has been approved";
}

if($type == "denied")
{
	$verificationStatus = 2;
	$orderStatus = 4;
	$notificationDetails = "Order/s has been denied";
}

$sql = "UPDATE productverification SET verificationStatus = ".$verificationStatus." WHERE batchNumber = '".$batchNumber."'";
$queryUpdate = $db->query($sql);

$sql = "UPDATE productorders SET orderStatus = ".$orderStatus." WHERE batchNumber = '".$batchNumber."'";
$queryUpdate = $db->query($sql);

$sql = "INSERT INTO `usernotification`(
										`userId`, 
										`notificationDetails`, 
										`notificationKey`,
										`notificationRemarks`,
										`notificationDate`
									   ) 
								VALUES ( 
										".$userId.",
										'".$db->real_escape_string($notificationDetails)."',
										'".$batchNumber."',
										'".$db->real_escape_string($remarks)."',
										now()
									   )";
$queryInsert = $db->query($sql);

if($type == "denied")
{
	$sql = "SELECT productId, quantity FROM productorders WHERE batchNumber = '".$batchNumber."'";
	$queryProducts = $db->query($sql);
	if($queryProducts AND $queryProducts->num_rows > 0)
	{
		while ($resultProducts = $queryProducts->fetch_assoc()) 
		{
			$productId = $resultProducts['productId'];
			$quantity = $resultProducts['quantity'];

			$sql = "SELECT * FROM productinformation WHERE productId = ".$productId;
			$queryOrdered = $db->query($sql);
			if($queryOrdered AND $queryOrdered->num_rows > 0)
			{
				$resultOrdered = $queryOrdered->fetch_assoc();
				$stock = $resultOrdered['stock'];
				$categoryId = $resultOrdered['categoryId'];
			}

			if($stock > $quantity AND $categoryId != 5)
			{
				$sql = "UPDATE productinformation SET stock = (stock + ".$quantity.") WHERE productId = ".$productId;
        		$queryUpdate = $db->query($sql);
			}
		}
	}
}
?>