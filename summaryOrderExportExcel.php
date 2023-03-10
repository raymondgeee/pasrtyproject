<?php
$path = $_SERVER['DOCUMENT_ROOT']."/";
set_include_path($path);
include('Modules/mysqliConnection.php');

$type = isset($_REQUEST['type']) ? $_REQUEST['type'] : "";
$batchNumber = isset($_REQUEST['batchNumber']) ? $_REQUEST['batchNumber'] : "";
$sqlData = isset($_REQUEST['sqlData']) ? $_REQUEST['sqlData'] : "";

if($type == 'summary')
{
    $fileName = "Summary ".date("Y-m-d");
	header("Content-Type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=".$fileName.".xls");
	header("Pragma: no-cache");
	header("Expires: 0");
    
    $pathFolder = $_SERVER['DOCUMENT_ROOT']."/Proof Photos/";
    echo "<table class='table table-condensed table-striped' border=1>";
        echo "<thead class='w3-black thead'>";
            echo "<th class='text-center'>BATCH ID</th>";
            echo "<th class='text-center'>ORDER PRICE</th>";
            echo "<th class='text-center'>DP PRICE (30%)</th>";
            echo "<th class='text-center'>ORDER DATE</th>";
            echo "<th class='text-center'>PICK-UP DATE</th>";
            echo "<th class='text-center'>ORDER STATUS</th>";
            echo "<th class='text-center'>PROOF OF PAYMENT</th>";
        echo "</thead>";
        echo "<tbody class='tbody'>";
        $sql = $sqlData;
        $queryBatch = $db->query($sql);
        if($queryBatch AND $queryBatch->num_rows > 0)
        {
            while ($resultBatch = $queryBatch->fetch_assoc()) 
            {
                $batchNumber = $resultBatch['batchNumber'];
                $orderId = $resultBatch['orderId'];
                $productId = $resultBatch['productId'];
                $quantity = $resultBatch['quantity'];
                $orderDate = $resultBatch['orderDate'];
                $deliveryDate = $resultBatch['deliveryDate'];
                $orderStatus = $resultBatch['orderStatus'];

                $orderPrice = 0;
                $sql = "SELECT productId, quantity FROM productorders WHERE batchNumber = '".$batchNumber."'";
                $queryOrders = $db->query($sql);
                if($queryOrders AND $queryOrders->num_rows > 0)
                {
                    while($resultOrders = $queryOrders->fetch_assoc())
                    {
                        $productId = $resultOrders['productId'];
                        $quantity = $resultOrders['quantity'];

                        $sql = "SELECT * FROM productinformation WHERE productId = ".$productId;
                        $queryOrdered = $db->query($sql);
                        if($queryOrdered AND $queryOrdered->num_rows > 0)
                        {
                            $resultOrdered = $queryOrdered->fetch_assoc();
                            $productOrderName = $resultOrdered['productName'];
                            $productOrderPrice = $resultOrdered['productPrice'];
                            $categoryId = $resultOrdered['categoryId'];
                        }

                        $orderPrice += ($productOrderPrice * $quantity);
                    }
                }
                $downPaymentPrice = 0;
                $downPaymentPrice = ($orderPrice * .30);

                if($orderStatus == 1) $orderStatusName = "Reserved";
                if($orderStatus == 2) $orderStatusName = "Pending";
                if($orderStatus == 3) $orderStatusName = "Approved";
                if($orderStatus == 4) $orderStatusName = "Denied";

                $pathRootName = $pathFolder.$batchNumber."_".$_SESSION['userId'];
                $getFile = glob($pathRootName.".*");
                if(count($getFile) > 0)
                {
                    $ext = pathinfo($getFile[0], PATHINFO_EXTENSION);
                    if (file_exists($pathRootName.".".$ext)) 
                    {
                        $dataBtn = "<b>Uploaded</b>";
                    }
                    else
                    {
                        // $dataBtn = "<i class='fa fa-check w3-text-green w3-large'></i>";
                        $dataBtn = "<b>Upload Pending</b>";
                    }
                }
                else
                {
                    // $dataBtn = "<i class='fa fa-check w3-text-green w3-large'></i>";
                    $dataBtn = "<b>Upload Pending</b>";
                }

                echo "<tr>";
                    echo "<td style='vertical-align:middle;' class='w3-center'>'".$batchNumber."'</td>";
                    echo "<td style='vertical-align:middle;' class='w3-center'>".number_format($orderPrice, 2)." PHP</td>";
                    echo "<td style='vertical-align:middle;' class='w3-center'>".number_format($downPaymentPrice, 2)." PHP</td>";
                    echo "<td style='vertical-align:middle;' class='w3-center'>".$orderDate."</td>";
                    echo "<td style='vertical-align:middle;' class='w3-center'>".$deliveryDate."</td>";
                    echo "<td style='vertical-align:middle;' class='w3-center'>".$orderStatusName."</td>";
                    echo "<td style='vertical-align:middle;' class='w3-center'>".$dataBtn."</td>";
                echo "</tr>";
            }
        }
        echo "</tbody>";
    echo "</table>";
}
else
{
    $fileName = "Order Details ".date("Y-m-d");
	header("Content-Type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=".$fileName.".xls");
	header("Pragma: no-cache");
    header("Expires: 0");
    
    echo "<table class='table table-condensed table-striped' border = 1>";
        echo "<thead class='w3-black'>";
            echo "<th class='text-center'>PRODUCT NAME</th>";
            echo "<th class='text-center'>ORDER QTY</th>";
            echo "<th class='text-center'>PRICE</th>";
            echo "<th class='text-center'>ORDER DATE</th>";
            echo "<th class='text-center'>PICK-UP DATE</th>";
            echo "<th class='text-center'>ORDER STATUS</th>";
        echo "</thead>";
        echo "<tbody>";
        $x = $totalPriceData = $orderQty = $totalDelFee = 0;
        $sql = $sqlData;
        $queryReviewOrders = $db->query($sql);
        if($queryReviewOrders AND $queryReviewOrders->num_rows > 0)
        {
            while ($resultReviewOrders = $queryReviewOrders->fetch_assoc())
            {
                $orderId = $resultReviewOrders['orderId'];
                $productId = $resultReviewOrders['productId'];
                $quantity = $resultReviewOrders['quantity'];
                $orderDate = $resultReviewOrders['orderDate'];
                $orderStatus = $resultReviewOrders['orderStatus'];
                $deliveryDate = $resultReviewOrders['deliveryDate'];
                $deliveryType = $resultReviewOrders['deliveryType'];

                $deliveryTypeName = ($deliveryType == 0) ? "Pick-up" : "Deliver";

                $deliveryFee = "0.00";
                if($deliveryType == 1) $deliveryFee = "50.00";

                $productOrderPrice = 0;
                $sql = "SELECT * FROM productinformation WHERE productId = ".$productId;
                $queryOrdered = $db->query($sql);
                if($queryOrdered AND $queryOrdered->num_rows > 0)
                {
                    $resultOrdered = $queryOrdered->fetch_assoc();
                    $productOrderName = $resultOrdered['productName'];
                    $productOrderPrice = $resultOrdered['productPrice'] * $quantity;
                }

                if($orderStatus == 1) $orderStatusName = "<b>Reserved</b>";
                if($orderStatus == 2) $orderStatusName = "<b>Pending</b>";
                if($orderStatus == 3) $orderStatusName = "<b>Approved</b>";
                if($orderStatus == 4) $orderStatusName = "<b>Denied</b>";

                $totalDelFee += $deliveryFee;
                $totalPriceData += $productOrderPrice;
                $orderQty += $quantity;
                echo "<tr>";
                    echo "<td style='text-align:center; vertical-align:middle;' class='w3-center'>".$productOrderName."</td>";
                    echo "<td style='text-align:center; vertical-align:middle;' class='w3-center'>".$quantity."</td>";
                    echo "<td style='text-align:center; vertical-align:middle;' class='w3-center'>".number_format($productOrderPrice, 2)." PHP</td>";
                    echo "<td style='text-align:center; vertical-align:middle;' class='w3-center'>".$orderDate."</td>";
                    echo "<td style='text-align:center; vertical-align:middle;' class='w3-center'>".$deliveryDate."</td>";
                    echo "<td style='text-align:center; vertical-align:middle;' class='w3-center'>".$orderStatusName."</td>";
                echo "</tr>";

            }
        } 

        $totalSummary = number_format($totalPriceData + $totalDelFee, 2);
        $downPaymentPrice = 0;
        if($orderStatus == 3)
        {
            $downPaymentPrice = (($totalPriceData + $totalDelFee) * .30);
        }
        $totalPayment = ($totalPriceData + $totalDelFee) - $downPaymentPrice;
        echo "</tbody>";
        echo "<tfoot class='w3-black'>";
            echo "<tr>";
                echo "<th class='w3-center'></th>";
                echo "<th class='w3-center'>".$orderQty."</th>";
                echo "<th class='w3-center'>".number_format($totalPriceData,2)." PHP</th>";
                echo "<th class='w3-center'></th>";
                echo "<th class='w3-center'></th>";
                echo "<th class='w3-center'></th>";
            echo "</tr>";
            echo "<tr>";
				echo "<th align='left'>TOTAL SUMMARY</th>";
				echo "<th align='right'>".$totalSummary." PHP</th>";
			echo "</tr>";
			echo "<tr>";
				echo "<th align='left'>DOWN PAYMENT</th>";
				echo "<th align='right'>".number_format($downPaymentPrice, 2)." PHP</th>";
			echo "</tr>";
			echo "<tr>";
				echo "<th align='left'>TOTAL PAYMENT</th>";
				echo "<th align='right'>".number_format($totalPayment, 2)." PHP</th>";
			echo "</tr>";
        echo "</tfoot>";
    echo "</table>";
}
?>