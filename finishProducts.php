<?php
$path = $_SERVER['DOCUMENT_ROOT']."/";
set_include_path($path);
include('Modules/mysqliConnection.php');

$type = isset($_GET['type']) ? $_GET['type'] : "";
$idArray = isset($_POST['idArray']) ? $_POST['idArray'] : "";
$userIdArray = isset($_POST['userIdArray']) ? $_POST['userIdArray'] : "";

if($type == 1)
{
    $sql = "UPDATE productorders SET orderStatus = 5 WHERE batchNumber IN ('".implode("', '",$idArray)."')";
    $queryUpdate = $db->query($sql);
}
else if($type == 2)
{
    $x = 0;
    foreach($idArray AS $key)
    {
        $sql = "INSERT INTO `usernotification`(
                                                    `userId`, 
                                                    `notificationDetails`, 
                                                    `notificationKey`,
                                                    `notificationRemarks`,
                                                    `notificationType`,
                                                    `notificationDate`
                                                ) 
                                            VALUES ( 
                                                    ".$userIdArray[$x].",
                                                    'You did not pick-up your order.',
                                                    '".$key."',
                                                    'Please pick up your order within 1-2 days or else order will be cancelled and down payment is not refundable.',
                                                    '1',
                                                    now()
                                                )";
        $queryInsert = $db->query($sql);
        $x++;                                    
    }
}
else if($type == 2)
{
    $sql = "UPDATE productorders SET orderStatus = 6 WHERE batchNumber IN ('".implode("', '",$idArray)."')";
    $queryUpdate = $db->query($sql);
}
?>