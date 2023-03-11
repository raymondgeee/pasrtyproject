<?php
$path = $_SERVER['DOCUMENT_ROOT']."/";
set_include_path($path);
include('Modules/mysqliConnection.php');
include('Include Files/fpdf185/fpdf.php');


$sqlData = isset($_REQUEST['sqlData']) ? $_REQUEST['sqlData'] : "";
$userIdArray = Array ();
$sql = $sqlData;
$queryReviewOrders = $db->query($sql);
if($queryReviewOrders AND $queryReviewOrders->num_rows > 0)
{
    while ($resultReviewOrders = $queryReviewOrders->fetch_assoc())
    {
    	$userIdArray[] = $resultReviewOrders['userId'];
    }
}

$pdf = new FPDF();
$pdf->SetTopMargin(10);
$pdf->AddPage('L','','A4');
$pdf->Ln();
$pdf->SetFont('Arial','B',12);
$counter = 0;
$userArray = array_unique($userIdArray);
foreach ($userArray as $key) 
{
	$sql = "SELECT * FROM userinformation WHERE userId = ".$key;
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

    $pdf->Cell(275,7,'SALES SUMMARY REPORT',0,0,'C');
	$pdf->Ln();
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(15,5,'',0,0,'C');
	$pdf->Cell(10,5,'Customers Name : '.$fullName,0,0,'L');
	$pdf->Ln();

	// echo "<table border=1>";
 //    echo "<thead class='w3-purple'>";
 //        echo "<th class='text-center'>CUSTOMER NAME</th>";
 //        echo "<th class='text-center'>PRODUCT NAME</th>";
 //        echo "<th class='text-center'>ORDER QTY</th>";
 //        echo "<th class='text-center'>PRICE</th>";
 //        echo "<th class='text-center'>ORDER DATE</th>";
 //        echo "<th class='text-center'>DELIVERY/PICK-UP DATE</th>";
 //        echo "<th class='text-center'>BATCH NUMBER</th>";
 //        echo "<th class='text-center'>ORDER STATUS</th>";
 //    echo "</thead>";
 //    echo "<tbody class='w3-center'>";
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(15,5,'',0,0,'C');
	$pdf->Cell(8,5,'#',1,0,'C');
	$pdf->Cell(62,5,'PRODUCT NAME',1,0,'C');
	$pdf->Cell(26.5,5,'ORDER QTY',1,0,'C');
	$pdf->Cell(29.5,5,'PRICE',1,0,'C');
	// $pdf->Cell(25,5,'DEL. FEE',1,0,'C');
	$pdf->Cell(40,5,'ORDER DATE',1,0,'C');
	$pdf->Cell(50,5,'PICK-UP DATE',1,0,'C');
	// $pdf->Cell(30,5,'DEL. TYPE',1,0,'C');
	// $pdf->Cell(50,5,'BATCH NUMBER',1,0,'C');
	$pdf->Cell(26.5,5,'ORDER STATUS',1,0,'C');
	$pdf->Ln();
	$x = 0;
    $totalPriceData = $orderQty = $totalDelFee = 0;
	$sql = $sqlData." AND userId = ".$key. " ORDER BY deliveryDate ASC";
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
	        if($orderStatus == 1) $orderStatusName = "Reserved";
	        if($orderStatus == 2) $orderStatusName = "Pending";
	        if($orderStatus == 3) $orderStatusName = "Approved";
	        if($orderStatus == 4) $orderStatusName = "Denied";
	        if($orderStatus == 5) $orderStatusName = "Finished";

			$pdf->SetFont('Arial','',8);
			$pdf->Cell(15,5,'',0,0,'C');
	        $pdf->Cell(8,5,++$x,1,0,'C');
			$pdf->Cell(62,5,$productOrderName,1,0,'C');
			$pdf->Cell(26.5,5,$quantity,1,0,'C');
			$pdf->Cell(29.5,5,$productOrderPrice." PHP",1,0,'R');
			// $pdf->Cell(25,5,$deliveryFee." PHP",1,0,'C');
			$pdf->Cell(40,5,$orderDate,1,0,'C');
			$pdf->Cell(50,5,$deliveryDate,1,0,'C');
			// $pdf->Cell(30,5,$deliveryTypeName,1,0,'C');
			$pdf->Cell(26.5,5,$orderStatusName,1,0,'C');
			$pdf->Ln();
	    }
	}

	$totalSummary = number_format($totalPriceData + $totalDelFee, 2);

	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(15,5,'',0,0,'C');
	$pdf->Cell(8,5,'',1,0,'C');
	$pdf->Cell(62,5,'',1,0,'C');
	$pdf->Cell(26.5,5,$orderQty,1,0,'C');
	$pdf->Cell(29.5,5,number_format($totalPriceData,2)." PHP",1,0,'R');
	// $pdf->Cell(25,5,number_format($totalDelFee,2). " PHP",1,0,'C');
	$pdf->Cell(40,5,'',1,0,'C');
	$pdf->Cell(50,5,'',1,0,'C');
	// $pdf->Cell(30,5,'',1,0,'C');
	$pdf->Cell(26.5,5,'',1,0,'C');
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(15,5,'',0,0,'C');
	$pdf->Cell(35,5,'TOTAL SUMMARY : ',0,0,'C');
	$pdf->Cell(30,5,$totalSummary." PHP",0,0,'C');
	if(count($userArray) > 1)
	{
		if($counter < (count($userArray) - 1)) $pdf->AddPage('L');
	}
	$counter++;
}

$pdf->Output();
?>