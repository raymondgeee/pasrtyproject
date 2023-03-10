<?php
$path = $_SERVER['DOCUMENT_ROOT']."/";
set_include_path($path);
include('Modules/mysqliConnection.php');

$type = isset($_REQUEST['type']) ? $_REQUEST['type'] : "";

if($type == 'summary')
{
	$fileName = "Sales Summary ".date("Y-m-d");
	header("Content-Type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=".$fileName.".xls");
	header("Pragma: no-cache");
	header("Expires: 0");

	$sqlData = isset($_REQUEST['sqlData']) ? $_REQUEST['sqlData'] : "";


	echo "<table border=1>";
	    echo "<thead class='w3-purple'>";
	        echo "<th class='text-center'>CUSTOMER NAME</th>";
	        echo "<th class='text-center'>PRODUCT NAME</th>";
	        echo "<th class='text-center'>ORDER QTY</th>";
	        echo "<th class='text-center'>PRICE</th>";
	        // echo "<th class='text-center'>DEL. FEE</th>";
	        echo "<th class='text-center'>ORDER DATE</th>";
	        echo "<th class='text-center'>PICK-UP DATE</th>";
	        // echo "<th class='text-center'>DELIVERY TYPE</th>";
	        echo "<th class='text-center'>BATCH NUMBER</th>";
	        echo "<th class='text-center'>ORDER STATUS</th>";
	        // echo "<th class='text-center'>ACTION</th>";
	    echo "</thead>";
	    echo "<tbody class='w3-center'>";
		$totalPriceData = $orderQty = $totalDelFee = 0;
		$sql = $sqlData." ORDER BY deliveryDate";
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
				$batchNumber = $resultReviewOrders['batchNumber'];
				$deliveryType = $resultReviewOrders['deliveryType'];
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
		            $totalPriceData += $productOrderPrice;
		        }

				$totalDelFee += $deliveryFee;
		        $orderQty += $quantity;
		        if($orderStatus == 1) $orderStatusName = "<b>Reserved</b>";
		        if($orderStatus == 2) $orderStatusName = "<b>Pending</b>";
		        if($orderStatus == 3) $orderStatusName = "<b>Approved</b>";
		        if($orderStatus == 4) $orderStatusName = "<b>Denied</b>";
		        if($orderStatus == 5) $orderStatusName = "<b>Finished</b>";

		        echo "<tr>";
		            echo "<td style='vertical-align:middle; align:center;' class='w3-center'>".$fullName."</td>";
		            echo "<td style='vertical-align:middle; align:center;' class='w3-center'>".$productOrderName."</td>";
		            echo "<td style='vertical-align:middle; align:center;' class='w3-center'>".$quantity."</td>";
		            echo "<td style='vertical-align:middle; align:center;' class='w3-center'>".$productOrderPrice." PHP</td>";
		            // echo "<td style='vertical-align:middle; align:center;' class='w3-center'>".$deliveryFee." PHP</td>";
		            echo "<td style='vertical-align:middle; align:center;' class='w3-center'>".$orderDate."</td>";
		            echo "<td style='vertical-align:middle; align:center;' class='w3-center'>".$deliveryDate."</td>";
		            // echo "<td style='vertical-align:middle; align:center;' class='w3-center'>".$deliveryTypeName."</td>";
		            echo "<td style='vertical-align:middle; align:center;' class='w3-center'>'".$batchNumber."'</td>";
		            echo "<td style='vertical-align:middle; align:center;' class='w3-center'>".$orderStatusName."</td>";
		        echo "</tr>";

		    }
		}

		$totalSummary = number_format($totalPriceData + $totalDelFee, 2);
		echo "</tbody>";
		echo "<tfoot class='w3-purple'>";
			echo "<tr>";
				echo "<th class='w3-center'></th>";
				echo "<th class='w3-center'></th>";
				echo "<th class='w3-center'>".$orderQty."</th>";
				echo "<th class='w3-center'>".number_format($totalPriceData,2)." PHP</th>";
				// echo "<th class='w3-center'>".number_format($totalDelFee,2)." PHP</th>";
				echo "<th class='w3-center'></th>";
				echo "<th class='w3-center'></th>";
				// echo "<th class='w3-center'></th>";
				echo "<th class='w3-center'></th>";
				echo "<th class='w3-center'></th>";
			echo "</tr>";
			echo "<tr>";
				echo "<th align='left' colspan=8>TOTAL SUMMARY : ".$totalSummary." PHP</th>";
			echo "</tr>";
		echo "</tfoot>";
	echo "</table>";
}
else if($type == "review")
{
	$fileName = "Review ".date("Y-m-d");
	header("Content-Type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=".$fileName.".xls");
	header("Pragma: no-cache");
	header("Expires: 0");

	$batchNumber = isset($_REQUEST['batchNumber']) ? $_REQUEST['batchNumber'] : "";
	$sql = "SELECT * FROM productorders WHERE batchNumber = '".$batchNumber."' LIMIT 1";
    $queryReviewOrders = $db->query($sql);
    if($queryReviewOrders AND $queryReviewOrders->num_rows > 0)
    {
        $resultReviewOrders = $queryReviewOrders->fetch_assoc();
        $userId = $resultReviewOrders['userId'];

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
    }

	echo "<table class='table table-condensed table-striped' border=1>";
	 	echo "<thead class='w3-purple'>";
		 	echo "<tr>";
	            echo "<th class='text-center' colspan=6>BATCH NUMBER : ".$batchNumber."</th>";
		 	echo "</tr>";
        echo "</thead>";
        echo "<thead class='w3-purple'>";
        	echo "<tr>";
            	echo "<th class='text-center' colspan=6>".$fullName."</th>";
            echo "</tr>";
        echo "</thead>";
        echo "<thead class='w3-purple'>";
        	echo "<tr>";
	            echo "<th class='text-center'>PRODUCT NAME</th>";
	            echo "<th class='text-center'>ORDER QTY</th>";
	            echo "<th class='text-center'>PRICE</th>";
	            // echo "<th class='text-center'>DEL. PRICE</th>";
	            echo "<th class='text-center'>ORDER DATE</th>";
	            echo "<th class='text-center'>PICK-UP DATE</th>";
	            // echo "<th class='text-center'>DELIVERY TYPE</th>";
	            echo "<th class='text-center'>ORDER STATUS</th>";
            echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        $x = $totalPriceData = $orderQty = $totalDelFee = 0;
        $sql = "SELECT * FROM productorders WHERE batchNumber = '".$batchNumber."'";
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

                $sql = "SELECT * FROM productinformation WHERE productId = ".$productId;
                $queryOrdered = $db->query($sql);
                if($queryOrdered AND $queryOrdered->num_rows > 0)
                {
                    $resultOrdered = $queryOrdered->fetch_assoc();
                    $productOrderName = $resultOrdered['productName'];
                    $productOrderPrice = $resultOrdered['productPrice'];
                    $totalPriceData += $productOrderPrice;
                }

                if($orderStatus == 1) $orderStatusName = "<b>Reserved</b>";
                if($orderStatus == 2) $orderStatusName = "<b>Pending</b>";
                if($orderStatus == 3) $orderStatusName = "<b>Approved</b>";
                if($orderStatus == 4) $orderStatusName = "<b>Denied</b>";
                if($orderStatus == 5) $orderStatusName = "<b>Finished</b>";

				$totalDelFee += $deliveryFee;
                $orderQty += $quantity;
                echo "<tr>";
                    echo "<td style='vertical-align:middle;' class='w3-center'>".$productOrderName."</td>";
                    echo "<td style='vertical-align:middle;' class='w3-center'>".$quantity."</td>";
                    echo "<td style='vertical-align:middle;' class='w3-center'>".$productOrderPrice." PHP</td>";
                    // echo "<td style='vertical-align:middle;' class='w3-center'>".$deliveryFee." PHP</td>";
                    echo "<td style='vertical-align:middle;' class='w3-center'>".$orderDate."</td>";
                    echo "<td style='vertical-align:middle;' class='w3-center'>".$deliveryDate."</td>";
                    // echo "<td style='vertical-align:middle;' class='w3-center'>".$deliveryTypeName."</td>";
                    echo "<td style='vertical-align:middle;' class='w3-center'>".$orderStatusName."</td>";
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
		echo "<tfoot class='w3-purple'>";
			echo "<tr>";
				echo "<th></th>";
				echo "<th>".$orderQty."</th>";
				echo "<th>".number_format($totalPriceData,2)." PHP</th>";
				// echo "<th>".number_format($totalDelFee,2)." PHP</th>";
				echo "<th></th>";
				echo "<th></th>";
				// echo "<th></th>";
				echo "<th></th>";
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