<?php
$path = $_SERVER['DOCUMENT_ROOT']."/";
set_include_path($path);
include('Modules/mysqliConnection.php');

$flavorId = isset($_POST['flavorId']) ? $_POST['flavorId'] : "";

$sql = "DELETE FROM cakeflavors WHERE flavorId = ".$flavorId;
$queryDelete = $db->query($sql);
?>