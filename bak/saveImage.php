<?php
$path = $_SERVER['DOCUMENT_ROOT']."/";
set_include_path($path);
include('Modules/mysqliConnection.php');
$userId = $_SESSION['userId'];

$dateNow = date("YmdHis").$userId;
$productCategory = 5;
$productImage = $dateNow.".jpg";
$productName = isset($_POST['productName']) ? $_POST['productName'] : "";
$productDetails = "Customized Cake";
$productPrice = isset($_POST['productPrice']) ? $_POST['productPrice'] : "";
$productStatus = 1;

$sql = "INSERT INTO `productinformation`(	`productName`, 
											`productDetails`, 
											`productPrice`, 
											`categoryId`, 
											`productImage`, 
											`productStatus`,
											`designedBy`
											) 
                                 	VALUES (
                                 			'".$productName."', 
                                 			'".$productDetails."', 
                                 			".$productPrice.", 
                                 			".$productCategory.", 
                                 			'".$productImage."', 
                                 			".$productStatus.",
                                 			".$userId."
                                 		)";
$queryInsert = $db->query($sql);
$productId = $db->insert_id;

$sql = "UPDATE cakecustomizedinfo SET productId = ".$productId.", customStatus = 1 WHERE userId = ".$userId." AND customStatus = 0";
$queryUpdate = $db->query($sql);

$data = urldecode($_POST['image']);
list($type, $data) = explode(';', $data);
list(, $data)      = explode(',', $data);
$data = base64_decode($data);
file_put_contents('Custom/Customized Cakes/'.$dateNow.'.jpg', $data);
?>