<?php
$path = $_SERVER['DOCUMENT_ROOT']."/";
set_include_path($path);
include('Modules/mysqliConnection.php');

$registeredDate = date('Y-m-d');
$createUserName =  isset($_POST['createUserName']) ? $_POST['createUserName'] : '';
$createPassword =  isset($_POST['createPassword']) ? $_POST['createPassword'] : '';
$userFirstName =  isset($_POST['userFirstName']) ? $_POST['userFirstName'] : '';
$userLastName =  isset($_POST['userLastName']) ? $_POST['userLastName'] : '';
$userGender =  isset($_POST['userGender']) ? $_POST['userGender'] : '';
$userAddress =  isset($_POST['userAddress']) ? $_POST['userAddress'] : '';
$userContactNumber =  isset($_POST['userContactNumber']) ? $_POST['userContactNumber'] : '';
$admin =  isset($_POST['admin']) ? $_POST['admin'] : '';
$tempUserId =  isset($_SESSION['userId']) ? $_SESSION['userId'] : '';

$userType = ($admin == 1) ? 0 : 1;

$sql = "INSERT INTO `userinformation`(  `firstName`, 
                                        `surName`, 
                                        `gender`, 
                                        `address`, 
                                        `contactNumber`, 
                                        `registeredDate`, 
                                        `userStatus`
                                    ) 
                                VALUES ( 
                                        '".$userFirstName."',
                                        '".$userLastName."',
                                        '".$userGender."',
                                        '".$userAddress."',
                                        '".$userContactNumber."',
                                        '".$registeredDate."',
                                        '0'
                                )";
$queryInsert = $db->query($sql);

$userId = $db->insert_id;
$sql = "INSERT INTO `useraccounts`( 
                                    `userId`, 
                                    `userName`, 
                                    `userPassword`,
                                    `userType`,
                                    `tempUserId`
                                ) 
                            VALUES (
                                    '".$userId."',
                                    '".$createUserName."',
                                    '".md5($createPassword)."',
                                    '".$userType."',
                                    '".$tempUserId."'
                            )";
$queryInsert = $db->query($sql);

$sql = "SELECT userId FROM useraccounts WHERE tempUserId = '".$tempUserId."' LIMIT 1";
$queryTemp = $db->query($sql);
if($queryTemp AND $queryTemp->num_rows > 0)
{
	$resultTemp = $queryTemp->fetch_assoc();
	$userIdData = $resultTemp['userId'];

	$sql = "SELECT orderId FROM productorders WHERE userId = '".$tempUserId."'";
	$queryTempOrders = $db->query($sql);
	if($queryTempOrders AND $queryTempOrders->num_rows > 0)
	{
		$sql = "UPDATE productorders SET userId = '".$userIdData."' WHERE userId = '".$tempUserId."'";
		$queryUpdate = $db->query($sql);
	}

	$sql = "UPDATE cakecustomizedinfo SET userId = '".$userIdData."' WHERE userId = '".$tempUserId."'";
	$queryUpdate = $db->query($sql);
}

?>