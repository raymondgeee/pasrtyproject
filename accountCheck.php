<?php
$path = $_SERVER['DOCUMENT_ROOT']."/";
set_include_path($path);
include('Modules/mysqliConnection.php');

$userName = isset($_POST['userName']) ? $_POST['userName'] : '';
$userPassword = isset($_POST['userPassword']) ? $_POST['userPassword'] : '';
$tempUserId =  isset($_SESSION['userId']) ? $_SESSION['userId'] : '';
$sql = "SELECT userId, userType FROM useraccounts WHERE userName = '".$userName."' AND userPassword = '".md5($userPassword)."'";
$queryCheckUser = $db->query($sql);
if($queryCheckUser AND $queryCheckUser->num_rows > 0)
{
    $resultCheckUser = $queryCheckUser->fetch_assoc();
    $userId = $resultCheckUser['userId'];
    $userType = $resultCheckUser['userType'];

    if($userType == 0)
    {
        echo "admin";
        $_SESSION['admin'] = "true";
    }
    else
    {
        echo "true";
        $_SESSION['admin'] = "false";

        $sql = "SELECT orderId FROM productorders WHERE userId = '".$tempUserId."'";
        $queryTempOrders = $db->query($sql);
        if($queryTempOrders AND $queryTempOrders->num_rows > 0)
        {
            $sql = "UPDATE productorders SET userId = '".$userId."' WHERE userId = '".$tempUserId."'";
            $queryUpdate = $db->query($sql);
        }

        $sql = "UPDATE cakecustomizedinfo SET userId = '".$userId."' WHERE userId = '".$tempUserId."'";
        $queryUpdate = $db->query($sql);
    }

    $_SESSION['userId'] = $userId;
    $_SESSION['userType'] = $userType;
    $_SESSION['userName'] = $userName;
}
else
{
    echo "false";
}
?>
