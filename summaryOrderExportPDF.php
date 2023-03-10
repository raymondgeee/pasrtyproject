<?php
$path = $_SERVER['DOCUMENT_ROOT']."/";
set_include_path($path);
include('Modules/mysqliConnection.php');
include('Include Files/FPDF/fpdf.php');

$userId = $_SESSION['userId'];
$sqlData = isset($_REQUEST['sqlData']) ? $_REQUEST['sqlData'] : "";
$type = isset($_REQUEST['type']) ? $_REQUEST['type'] : "";
$batchNumber = isset($_REQUEST['batchNumber']) ? $_REQUEST['batchNumber'] : "";

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

$pdf = new FPDF();
$pdf->SetTopMargin(10);
$pdf->AddPage('P','','A4');
$pdf->Ln();
$pdf->SetFont('Arial','B',12);

if($type == "summary")
{
    $pdf->Cell(198,7,"CUSTOMER'S SUMMARY OF ORDERS",0,0,'C');
    $pdf->Ln();
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(10,5,"Customer's Name : ".$fullName,0,0,'L');
    $pdf->Ln();

    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(8,5,'#',1,0,'C');
    $pdf->Cell(35.83,5,'BATCH ID',1,0,'C');
    $pdf->Cell(29.83,5,'ORDER PRICE',1,0,'C');
    $pdf->Cell(29.83,5,'DP PRICE (30%)',1,0,'C');
    $pdf->Cell(29.83,5,'ORDER DATE',1,0,'C');
    $pdf->Cell(29.83,5,'PICK-UP DATE',1,0,'C');
    $pdf->Cell(25.83,5,'STATUS',1,0,'C');
    $pdf->Ln();

    $x = 0;
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

            $pdf->SetFont('Arial','',8);
            $pdf->Cell(8,5,++$x,1,0,'C');
            $pdf->Cell(35.83,5,$batchNumber,1,0,'C');
            $pdf->Cell(29.83,5,number_format($orderPrice, 2)." PHP",1,0,'C');
            $pdf->Cell(29.83,5,number_format($downPaymentPrice, 2)." PHP",1,0,'C');
            $pdf->Cell(29.83,5,$orderDate,1,0,'C');
            $pdf->Cell(29.83,5,$deliveryDate,1,0,'C');
            $pdf->Cell(25.83,5,$orderStatusName,1,0,'C');
            $pdf->Ln();
        }
    }
}
else
{
    $pdf->Cell(198,7,"ORDER DETAILS",0,0,'C');
    $pdf->Ln();
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(10,5,"BATCH NUMBER : ".$batchNumber,0,0,'L');
    $pdf->Ln();

    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(8,5,'#',1,0,'C');
    $pdf->Cell(35.83,5,'PRODUCT NAME',1,0,'C');
    $pdf->Cell(29.83,5,'ORDER QTY',1,0,'C');
    $pdf->Cell(29.83,5,'PRICE',1,0,'C');
    $pdf->Cell(29.83,5,'ORDER DATE',1,0,'C');
    $pdf->Cell(29.83,5,'PICK-UP DATE',1,0,'C');
    $pdf->Cell(25.83,5,'STATUS',1,0,'C');
    $pdf->Ln();

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


            $sql = "SELECT * FROM productinformation WHERE productId = ".$productId;
            $queryOrdered = $db->query($sql);
            if($queryOrdered AND $queryOrdered->num_rows > 0)
            {
                $resultOrdered = $queryOrdered->fetch_assoc();
                $productOrderName = $resultOrdered['productName'];
                $productOrderPrice = $resultOrdered['productPrice'] * $quantity;
            }

            if($orderStatus == 1) $orderStatusName = "Reserved";
            if($orderStatus == 2) $orderStatusName = "Pending";
            if($orderStatus == 3) $orderStatusName = "Approved";
            if($orderStatus == 4) $orderStatusName = "Denied";

            $totalDelFee += $deliveryFee;
            $totalPriceData += $productOrderPrice;
            $orderQty += $quantity;
 
            $pdf->SetFont('Arial','',8);
            $pdf->Cell(8,5,++$x,1,0,'C');
            $pdf->Cell(35.83,5,$productOrderName,1,0,'C');
            $pdf->Cell(29.83,5,$quantity,1,0,'C');
            $pdf->Cell(29.83,5,number_format($productOrderPrice, 2)." PHP",1,0,'C');
            $pdf->Cell(29.83,5,$orderDate,1,0,'C');
            $pdf->Cell(29.83,5,$deliveryDate,1,0,'C');
            $pdf->Cell(25.83,5,$orderStatusName,1,0,'C');
            $pdf->Ln();
        }
    }
    
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(8,5,'',0,0,'C');
    $pdf->Cell(35.83,5,'',0,0,'C');
    $pdf->Cell(29.83,5,'',0,0,'C');
    $pdf->Cell(29.83,5,'',0,0,'C');
    $pdf->Cell(29.83,5,'',0,0,'C');
    $pdf->Cell(29.83,5,'',0,0,'C');
    $pdf->Cell(25.83,5,'',0,0,'C');
    $pdf->Ln();

    $downPaymentPrice = 0;
    if($orderStatus == 3)
    {
        $downPaymentPrice = (($totalPriceData + $totalDelFee) * .30);
    }

    $totalPayment = ($totalPriceData + $totalDelFee) - $downPaymentPrice;
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(43.83,5,'TOTAL SUMMARY','TLB',0,'L');
    $pdf->Cell(29.83,5,number_format($totalPriceData, 2)." PHP",1,0,'R');
    $pdf->Ln();
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(43.83,5,'DOWN PAYMENT','TLB',0,'L');
    $pdf->Cell(29.83,5,number_format($downPaymentPrice, 2)." PHP",1,0,'R');
    $pdf->Ln();
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(43.83,5,'TOTAL PAYMENT','TLB',0,'L');
    $pdf->Cell(29.83,5,number_format($totalPayment, 2)." PHP",1,0,'R');

    $pdf->Ln();
}
$pdf->Output();
?>