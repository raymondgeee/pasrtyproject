<?php
$path = $_SERVER['DOCUMENT_ROOT']."/";
set_include_path($path);
include('Modules/mysqliConnectionStart.php');

$createUserName = isset($_POST['createUserName']) ? $_POST['createUserName'] : '';

$sql = "SELECT userId FROM useraccounts WHERE userName = '".$createUserName."'";
$queryCheck = $db->query($sql);
if($queryCheck AND $queryCheck->num_rows > 0)
{
    echo "true";
}

?>