<?php
$path = $_SERVER['DOCUMENT_ROOT']."/";
set_include_path($path);
include('Modules/mysqliConnection.php');

$orderId = isset($_REQUEST['orderId']) ? $_REQUEST['orderId'] : "";
$categoryId = isset($_REQUEST['categoryId']) ? $_REQUEST['categoryId'] : "";

$sql = "SELECT productId, quantity FROM productorders WHERE orderId = ".$orderId;
$queryProducts = $db->query($sql);
if($queryProducts AND $queryProducts->num_rows > 0)
{
    $resultProducts = $queryProducts->fetch_assoc();
    $productId = $resultProducts['productId'];
    $quantity = $resultProducts['quantity'];

    if($categoryId != 5)
    {
        $sql = "UPDATE productinformation SET stock = (stock + ".$quantity.") WHERE productId = ".$productId;
        $queryUpdate = $db->query($sql);
    }
}

$sql = "DELETE FROM productorders WHERE orderId = ".$orderId;
$queryDelete = $db->query($sql);

$priceArray = Array();
$sql = "SELECT productId, quantity FROM productorders WHERE userId = '".$_SESSION['userId']."' AND orderStatus = 0";
$queryProducts = $db->query($sql);
if($queryProducts AND $queryProducts->num_rows > 0)
{
	while ($resultProducts = $queryProducts->fetch_assoc()) 
	{
		$productId = $resultProducts['productId'];
		$quantity = $resultProducts['quantity'];

		$sql = "SELECT * FROM productinformation WHERE productId = ".$productId;
        $queryOrdered = $db->query($sql);
        if($queryOrdered AND $queryOrdered->num_rows > 0)
        {
            $resultOrdered = $queryOrdered->fetch_assoc();
            $productOrderPrice = $resultOrdered['productPrice'];
        }

        $price = $productOrderPrice * $quantity;
        $priceArray[] = $price;
	}
}

$totalPrice = "N/A";
if($priceArray != NULL)
{
	echo $totalPrice = number_format(array_sum($priceArray),2);
}
?>