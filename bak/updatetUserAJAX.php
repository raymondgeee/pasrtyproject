<?php
$path = $_SERVER['DOCUMENT_ROOT']."/";
set_include_path($path);
include('Modules/mysqliConnection.php');

$userId =  isset($_POST['userId']) ? $_POST['userId'] : '';
$userFirstName =  isset($_POST['userFirstName']) ? $_POST['userFirstName'] : '';
$userLastName =  isset($_POST['userLastName']) ? $_POST['userLastName'] : '';
$userGender =  isset($_POST['userGender']) ? $_POST['userGender'] : '';
$userAddress =  isset($_POST['userAddress']) ? $_POST['userAddress'] : '';
$userContactNumber =  isset($_POST['userContactNumber']) ? $_POST['userContactNumber'] : '';

$sql = "UPDATE userinformation SET  firstName = '".$userFirstName."', 
                                    surName = '".$userLastName."', 
                                    gender = '".$userGender."', 
                                    address = '".$db->real_escape_string($userAddress)."' , 
                                    contactNumber = '".$userContactNumber."', 
                                    userStatus = 0
                              WHERE userId = ".$userId;
$queryUpdate = $db->query($sql);
?>