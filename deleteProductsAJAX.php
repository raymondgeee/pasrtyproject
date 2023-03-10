<?php
$path = $_SERVER['DOCUMENT_ROOT']."/";
set_include_path($path);
include('Modules/mysqliConnection.php');

$productId = isset($_POST['productId']) ? $_POST['productId'] : "";

$sql = "DELETE FROM productinformation WHERE productId = ".$productId." LIMIT 1";
$queryDelete = $db->query($sql);
?>