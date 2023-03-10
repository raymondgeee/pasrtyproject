<?php
$path = $_SERVER['DOCUMENT_ROOT']."/";
set_include_path($path);
include('Modules/mysqliConnection.php');

$decorationId = isset($_POST['decorationId']) ? $_POST['decorationId'] : "";

$sql = "DELETE FROM cakedecorationdetails WHERE decorationId = ".$decorationId;
$queryDelete = $db->query($sql);
?>