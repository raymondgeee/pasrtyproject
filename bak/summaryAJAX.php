<?php
$path = $_SERVER['DOCUMENT_ROOT']."/";
set_include_path($path);
include('Modules/mysqliConnection.php');

$totalRecords = isset($_REQUEST['totalRecords']) ? $_REQUEST['totalRecords'] : 0;
$sqlData = isset($_REQUEST['sqlData']) ? $_REQUEST['sqlData'] : "";
$totalData = $totalRecords;
$totalFiltered = $totalRecords;

$data = Array ();
$sql = $sqlData;
$sql .= " LIMIT ".$_REQUEST['start'].", ".$_REQUEST['length'];
// $sql = "SELECT * FROM productorders";
$x = $_REQUEST['start'];
// $x = 0;
$queryReviewOrders = $db->query($sql);
if($queryReviewOrders AND $queryReviewOrders->num_rows > 0)
{
    while ($resultReviewOrders = $queryReviewOrders->fetch_assoc())
    {
        $orderId = $resultReviewOrders['orderId'];
        $userId = $resultReviewOrders['userId'];
        $productId = $resultReviewOrders['productId'];
        $quantity = $resultReviewOrders['quantity'];
        $orderDate = $resultReviewOrders['orderDate'];
        $orderStatus = $resultReviewOrders['orderStatus'];
        $deliveryDate = $resultReviewOrders['deliveryDate'];
        $deliveryType = $resultReviewOrders['deliveryType'];
        $batchNumber = $resultReviewOrders['batchNumber'];

        $deliveryTypeName = ($deliveryType == 0) ? "Pick-up" : "Deliver";

        $deliveryFee = "0.00";
        if($deliveryType == 1) $deliveryFee = "50.00";

        $sql = "SELECT * FROM userinformation WHERE userId = ".$userId;
        $queryUserInfo = $db->query($sql);
        if($queryUserInfo AND $queryUserInfo->num_rows > 0)
        {
            $resultUserInfo = $queryUserInfo->fetch_assoc();
            $firstName = $resultUserInfo['firstName'];
            $surName = $resultUserInfo['surName'];
            $address = $resultUserInfo['address'];
            $contactNumber = $resultUserInfo['contactNumber'];

            $fullName = $firstName." ".$surName;
        }

        $sql = "SELECT * FROM productinformation WHERE productId = ".$productId;
        $queryOrdered = $db->query($sql);
        if($queryOrdered AND $queryOrdered->num_rows > 0)
        {
            $resultOrdered = $queryOrdered->fetch_assoc();
            $productOrderName = $resultOrdered['productName'];
            $productOrderPrice = $resultOrdered['productPrice'];
        }

        if($orderStatus == 1) $orderStatusName = "<b>Reserved</b>";
        if($orderStatus == 2) $orderStatusName = "<b>Pending</b>";
        if($orderStatus == 3) $orderStatusName = "<b>Approved</b>";
        if($orderStatus == 4) $orderStatusName = "<b>Denied</b>";
        if($orderStatus == 5) $orderStatusName = "<b>Finished</b>";

        $nestedData = Array ();
        $nestedData[] = ++$x;
        // $nestedData[] = $fullName;
        $nestedData[] = $productOrderName;
        $nestedData[] = $quantity;
        $nestedData[] = number_format($productOrderPrice, 2)." PHP";
        // $nestedData[] = $deliveryFee." PHP";
        $nestedData[] = $orderDate;
        $nestedData[] = $deliveryDate;
        $nestedData[] = $deliveryTypeName;
        $nestedData[] = "<a href = 'review.php?batchNumber=".$batchNumber."'>".$batchNumber."</a>";
        $nestedData[] = $orderStatusName;
        $data[] = $nestedData;
    }
} 

$json_data = Array (
						"draw" 				=> intval($_REQUEST['draw']),
						"recordsTotal" 		=> intval($totalData),
						"recordsFiltered" 	=> intval($totalFiltered),
						"data" 				=> $data
				   );

echo json_encode($json_data);
?>