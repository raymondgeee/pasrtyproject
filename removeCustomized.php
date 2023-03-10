<?php
$path = $_SERVER['DOCUMENT_ROOT']."/";
set_include_path($path);
include('Modules/mysqliConnection.php');
$userId = $_SESSION['userId'];

$productId = isset($_REQUEST['productId']) ? $_REQUEST['productId'] : "";

$sql = "DELETE FROM productinformation WHERE productId = ".$productId." LIMIT 1";
$queryDelete = $db->query($sql);

$sql = "DELETE FROM cakecustomizedinfo WHERE productId = ".$productId." AND userId = ".$userId;
$queryDelete = $db->query($sql);
?>