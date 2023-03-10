<?php
$path = $_SERVER['DOCUMENT_ROOT']."/";
set_include_path($path);
include('Modules/mysqliConnection.php');

$userId = isset($_POST['userId']) ? $_POST['userId'] : "";

$sql = "DELETE FROM useraccounts WHERE userId = ".$userId." LIMIT 1";
$queryDelete = $db->query($sql);

$sql = "DELETE FROM userinformation WHERE userId = ".$userId." LIMIT 1";
$queryDelete = $db->query($sql);
?>