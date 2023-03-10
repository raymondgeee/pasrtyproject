<?php
$path = $_SERVER['DOCUMENT_ROOT']."/";
set_include_path($path);
include('Modules/mysqliConnectionStart.php');

$userName = isset($_POST['userName']) ? $_POST['userName'] : '';
$userPassword = isset($_POST['userPassword']) ? $_POST['userPassword'] : '';
$sql = "SELECT userId, userType FROM useraccounts WHERE userName = '".$userName."' AND userPassword = '".md5($userPassword)."'";
$queryCheckUser = $db->query($sql);
if($queryCheckUser AND $queryCheckUser->num_rows > 0)
{
    $resultCheckUser = $queryCheckUser->fetch_assoc();
    $userId = $resultCheckUser['userId'];
    $userType = $resultCheckUser['userType'];
    $_SESSION['userId'] = $userId;
    $_SESSION['userType'] = $userType;
    $_SESSION['userName'] = $userName;

    if($userType == 0)
    {
        echo "admin";
        $_SESSION['admin'] = "true";
    }
    else
    {
        echo "true";
        $_SESSION['admin'] = "false";
    }
}
else
{
    echo "false";
}
?>
