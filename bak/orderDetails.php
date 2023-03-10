<?php
$path = $_SERVER['DOCUMENT_ROOT']."/";
set_include_path($path);
include('Modules/mysqliConnection.php');
$batchNumber = isset($_GET['batchNumber']) ? $_GET['batchNumber'] : "";
$userId = $_SESSION['userId'];

$read = isset($_GET['read']) ? $_GET['read'] : "";
if($read == 1)
{
    $sql = "UPDATE usernotification SET notificationStatus = 1 WHERE userId = ".$userId." AND notificationKey = '".$batchNumber."'";
    $queryUpdate = $db->query($sql);
}

$activeButtonMain = "";
$activeButtonSumm = "true";
$activeButtonProf = "";
$activeButtonCont = "";
?>
<!DOCTYPE html>
<html>
<head>
    <?php include "title.php";?>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include "icon.php";?>
    <link rel="stylesheet" href="Include Files/Bootstrap/Bootstrap 3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="Include Files/Bootstrap/Font Awesome/css/font-awesome.css">
    <link rel="stylesheet" href="Include Files/Bootstrap/Bootstrap 3.3.7/Roboto Font/roboto.css">
    <link rel="stylesheet" href="Include Files/Bootstrap/w3css/w3.css">
    <link rel="stylesheet" href="Include Files/Custom CSS/styles.css">
</head>
<body>
    <div class="container-fluid">
        <?php include "userHeader.php";?>
        <div class="row">
            <?php include "userViewCart.php";?>
            <div class="col-md-9">
                <div class="w3-padding-top"></div>
                <div class="w3-card-2">
                    <div class="w3-container w3-padding w3-white" style="height: 608px">
                        <form id="formExportXLS" method="POST" action="summaryOrderExportExcel.php?type=ordered"></form>
                        <form id="formExportPDF" method="POST" action="summaryOrderExportPDF.php?type=ordered" target="_blank"></form>
                        <input form="formExportPDF" type='hidden' name='batchNumber' value="<?php echo $batchNumber;?>">
                        <input form="formExportXLS" type='hidden' name='batchNumber' value="<?php echo $batchNumber;?>">
                        <div class='w3-right'>
                            <button form="formExportXLS" class='w3-btn w3-tiny w3-round w3-black'><i class="fa fa-file-excel-o"></i>&emsp;<b>IMPORT VIA XLS</b></button>
                            <button form="formExportPDF" class='w3-btn w3-tiny w3-round w3-black'><i class="fa fa-file-pdf-o"></i>&emsp;<b>IMPORT VIA PDF</b></button>
                        </div>
                        <div class="w3-padding-top"></div>
                        <div class="w3-padding-top"></div>
                        <?php 
                        echo "<label>BATCH NUMBER : ".$batchNumber."</label>";
                        $sql = "SELECT * FROM usernotification WHERE userId = ".$userId." AND notificationKey = '".$batchNumber."' ORDER BY notificationDate DESC";
                        $queryNotes = $db->query($sql);
                        if($queryNotes AND $queryNotes->num_rows > 0)
                        {
                            $resultNotes = $queryNotes->fetch_assoc();
                            $notificationRemarks = $resultNotes['notificationRemarks'];
                            if($notificationRemarks != "")
                            {
                                echo "<br><label>NOTE : <span class='w3-text-pink'>".$notificationRemarks."</span></label>";
                            }
                        }
                        echo "<table class='table table-condensed table-striped'>";
                            echo "<thead class='w3-black'>";
                                echo "<th class='text-center'>#</th>";
                                echo "<th class='text-center'>PRODUCT NAME</th>";
                                echo "<th class='text-center'>ORDER QTY</th>";
                                echo "<th class='text-center'>PRICE</th>";
                                // echo "<th class='text-center'>DEL. PRICE</th>";
                                echo "<th class='text-center'>ORDER DATE</th>";
                                echo "<th class='text-center'>PICK-UP DATE</th>";
                                // echo "<th class='text-center'>TYPE</th>";
                                echo "<th class='text-center'>ORDER STATUS</th>";
                                // echo "<th class='text-center'>ACTION</th>";
                            echo "</thead>";
                            echo "<tbody>";
                            $x = $totalPriceData = $orderQty = $totalDelFee = 0;
                            $sql = "SELECT * FROM productorders WHERE batchNumber = '".$batchNumber."'";
                            $sqlData = $sql;
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
                                        echo "<td style='vertical-align:middle;' class='w3-center'><b>".++$x."</b></td>";
                                        echo "<td style='vertical-align:middle;' class='w3-center'>".$productOrderName."</td>";
                                        echo "<td style='vertical-align:middle;' class='w3-center'>".$quantity."</td>";
                                        echo "<td style='vertical-align:middle;' class='w3-center'>".number_format($productOrderPrice, 2)." PHP</td>";
                                        // echo "<td style='vertical-align:middle;' class='w3-center'>".$deliveryFee." PHP</td>";
                                        echo "<td style='vertical-align:middle;' class='w3-center'>".$orderDate."</td>";
                                        echo "<td style='vertical-align:middle;' class='w3-center'>".$deliveryDate."</td>";
                                        // echo "<td style='vertical-align:middle;' class='w3-center'>".$deliveryTypeName."</td>";
                                        echo "<td style='vertical-align:middle;' class='w3-center'>".$orderStatusName."</td>";
                                        // echo "<td style='vertical-align:middle;' class='w3-center'></td>";
                                    echo "</tr>";

                                }
                            } 
                            echo "</tbody>";
                            echo "<tfoot class='w3-black'>";
                                echo "<th class='w3-center'></th>";
                                echo "<th class='w3-center'></th>";
                                echo "<th class='w3-center'>".$orderQty."</th>";
                                echo "<th class='w3-center'>".number_format($totalPriceData,2)." PHP</th>";
                                // echo "<th class='w3-center'>".number_format($totalDelFee,2)." PHP</th>";
                                echo "<th class='w3-center'></th>";
                                // echo "<th class='w3-center'></th>";
                                echo "<th class='w3-center'></th>";
                                echo "<th class='w3-center'></th>";
                            echo "</tfoot>";
                        echo "</table>";

                        $totalSummary = number_format($totalPriceData + $totalDelFee, 2);
                        $downPaymentPrice = 0;
                        if($orderStatus == 3)
                        {
                            $downPaymentPrice = (($totalPriceData + $totalDelFee) * .30);
                        }
                        
                        $totalPayment = ($totalPriceData + $totalDelFee) - $downPaymentPrice;
                        echo "<div class='w3-padding-top'></div>";
                        echo "<div class='w3-container'>";
                            echo "<div class='row'>";
                                echo "<div class='col-md-2'>";
                                    echo "<label class='w3-medium'>TOTAL SUMMARY</label>";
                                echo "</div>";
                                echo "<div class='col-md-2'>";
                                    echo "<label class='w3-medium w3-right'>".$totalSummary." PHP</label>";
                                echo "</div>";
                            echo "</div>";
                            echo "<div class='row'>";
                                echo "<div class='col-md-2'>";
                                    echo "<label class='w3-medium'>DOWN PAYMENT</label>";
                                echo "</div>";
                                echo "<div class='col-md-2'>";
                                    echo "<label class='w3-medium w3-right'>".number_format($downPaymentPrice, 2)." PHP</label>";
                                echo "</div>";
                            echo "</div>";
                            echo "<div class='row'>";
                                echo "<div class='col-md-2 w3-topbar'>";
                                    echo "<label class='w3-medium'>TOTAL PAYMENT</label>";
                                echo "</div>";
                                echo "<div class='col-md-2 w3-topbar'>";
                                    echo "<label class='w3-medium w3-right'>".number_format($totalPayment, 2)." PHP</label>";
                                echo "</div>";
                            echo "</div>";
                        echo "</div>";
                        ?>
                    </div>
                    <input form="formExportXLS" type='hidden' name='sqlData' value="<?php echo $sqlData;?>">
                    <input form="formExportPDF" type='hidden' name='sqlData' value="<?php echo $sqlData;?>">
                </div>
            </div>
        </div>
        <div class="row w3-padding-top">
            <div class="col-md-12 w3-padding-top">
                <div class="w3-center">
                    <label><b>MADE BY <i class="fa fa-heart w3-text-black"></i> &copy; <?php echo date("Y");?></b></label>
                    <p class="w3-center">
                        <a href="https://www.facebook.com/pastryproject.bc" target="blank_"><i class="fa fa-facebook w3-padding w3-round w3-black"></i></a>
                        <!-- <i class="fa fa-twitter w3-padding w3-round w3-black"></i> -->
                        <a href="https://www.instagram.com/pastryproject.bc" target="blank_"><i class="fa fa-instagram w3-padding w3-round w3-black"></i></a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div id='modal-izi'><span class='izimodal-content'></span></div>
</body>
</html>
<script src="Include Files/Javascript/jQuery 3.1.1/jquery-3.1.1.js"></script>
<script src="Include Files/Javascript/jQuery 3.1.1/jquery-ui.js"></script>
<script src="Include Files/Javascript/jQuery 3.1.1/bootstrap.min.js"></script>
<link rel="stylesheet" href="Include Files/Javascript/iziModal-master/css/iziModal.css" />
<script src="Include Files/Javascript/iziModal-master/js/iziModal.js"></script>
<link rel="stylesheet" href="Include Files/Javascript/iziToast-master/dist/css/iziToast.css" />
<script src="Include Files/Javascript/iziToast-master/dist/js/iziToast.js"></script>
<link rel="stylesheet" href="Include Files/Javascript/sweetalert2-master/dist/sweetalert2.css" />
<script src="Include Files/Javascript/sweetalert2-master/dist/sweetalert2.js"></script>