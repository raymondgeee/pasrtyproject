<?php
$path = $_SERVER['DOCUMENT_ROOT']."/";
set_include_path($path);
include('Modules/mysqliConnection.php');
$categoryId = isset($_GET['categoryId']) ? $_GET['categoryId'] : "";

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
                    <?php
                    $sql = "SELECT * FROM productorders WHERE orderStatus > 0 AND userId = ".$userId. " GROUP BY batchNumber ORDER BY orderStatus ASC";
                    $sqlData = $sql;
                    $queryBatch = $db->query($sql);
                    $disabledImportBtn = ($queryBatch->num_rows > 0) ? "" : "disabled";
                    ?>
                    <div class="w3-container w3-padding w3-white" style="height: 608px">
                        <form id="formExportXLS" method="POST" action="summaryOrderExportExcel.php?type=summary"></form>
                        <form id="formExportPDF" method="POST" action="summaryOrderExportPDF.php?type=summary" target="_blank"></form>
                        <div class='w3-right'>
                            <button <?php echo $disabledImportBtn; ?> form="formExportXLS" class='w3-btn w3-tiny w3-round w3-black'><i class="fa fa-file-excel-o"></i>&emsp;<b>IMPORT VIA XLS</b></button>
                            <button <?php echo $disabledImportBtn; ?> form="formExportPDF" class='w3-btn w3-tiny w3-round w3-black'><i class="fa fa-file-pdf-o"></i>&emsp;<b>IMPORT VIA PDF</b></button>
                        </div>
                        <div class="w3-padding-top"></div>
                        <div class="w3-padding-top"></div>
                        <i class='text-muted w3-text-pink'>NOTE : Please upload your proof of down payment to confirm your order.</i>
                        <br>
                        <i class='text-muted w3-text-indigo'><b>Please ensure 30% or more down payment.</b></i>
                        <?php 
                        echo "<table class='table table-condensed table-striped'>";
                            echo "<thead class='w3-black thead'>";
                                echo "<th class='text-center' width=30>#</th>";
                                // echo "<th class='text-center'>CATEGORY</th>";
                                echo "<th class='text-center'>BATCH ID</th>";
                                echo "<th class='text-center'>ORDER PRICE</th>";
                                echo "<th class='text-center'>DP PRICE (30%)</th>";
                                echo "<th class='text-center'>ORDER DATE</th>";
                                echo "<th class='text-center'>PICK-UP DATE</th>";
                                echo "<th class='text-center'>ORDER STATUS</th>";
                                echo "<th class='text-center'>PROOF OF PAYMENT</th>";
                            echo "</thead>";
                            echo "<tbody class='tbody'>";
                            $x = 0;
                            $pathFolder = $_SERVER['DOCUMENT_ROOT']."/Proof Photos/";
                            $priceArray = Array ();
                            $sql = "SELECT * FROM productorders WHERE orderStatus > 0 AND userId = ".$userId. " GROUP BY batchNumber ORDER BY orderStatus ASC";
                            $sqlData = $sql;
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

                                    $disabledBtn = "";
                                    if($orderStatus == 4) $disabledBtn = "disabled";
                                    $pathRootName = $pathFolder.$batchNumber."_".$_SESSION['userId'];
                                    $getFile = glob($pathRootName.".*");
                                    if(count($getFile) > 0)
                                    {
                                        $ext = pathinfo($getFile[0], PATHINFO_EXTENSION);
                                        if (file_exists($pathRootName.".".$ext)) 
                                        {
                                            $dataBtn = "<i class='fa fa-check w3-text-green w3-large'></i>";
                                        }
                                        else
                                        {
                                            // $dataBtn = "<i class='fa fa-check w3-text-green w3-large'></i>";
                                            $dataBtn = "<button ".$disabledBtn." data-id='".$batchNumber."' class='w3-btn w3-black w3-tiny w3-round uploadPay'><i class='fa fa-image'></i>&emsp;<b>UPLOAD</b></button>";
                                        }
                                    }
                                    else
                                    {
                                        // $dataBtn = "<i class='fa fa-check w3-text-green w3-large'></i>";
                                        $dataBtn = "<button ".$disabledBtn." data-id='".$batchNumber."' class='w3-btn w3-black w3-tiny w3-round uploadPay'><i class='fa fa-image'></i>&emsp;<b>UPLOAD</b></button>";
                                    }

                                    if($orderStatus == 4) $dataBtn = "<i class='fa fa-remove w3-text-pink w3-large'></i>";

                                    $tdColor = "";
                                    $sql = "SELECT * FROM usernotification WHERE notificationType = 1 AND userId = ".$userId." AND notificationKey = '".$batchNumber."' ORDER BY notificationDate DESC";
                                    $queryNotes = $db->query($sql);
                                    if($queryNotes AND $queryNotes->num_rows > 0)
                                    {
                                        $tdColor = "w3-pink";
                                    }

                                    echo "<tr>";
                                        echo "<td style='vertical-align:middle;' class='w3-center' width=30><b>".++$x."</b></td>";
                                        // echo "<td style='vertical-align:middle;' class='w3-center'>".$categoryName."</td>";
                                        echo "<td style='vertical-align:middle;' class='w3-center ".$tdColor."'><a style='cursor:pointer;' href='orderDetails.php?batchNumber=".$batchNumber."'>".$batchNumber."</a></td>";
                                        echo "<td style='vertical-align:middle;' class='w3-center'>".number_format($orderPrice, 2)." PHP</td>";
                                        echo "<td style='vertical-align:middle;' class='w3-center'>".number_format($downPaymentPrice, 2)." PHP</td>";
                                        echo "<td style='vertical-align:middle;' class='w3-center'>".$orderDate."</td>";
                                        echo "<td style='vertical-align:middle;' class='w3-center'>".$deliveryDate."</td>";
                                        echo "<td style='vertical-align:middle;' class='w3-center'>".$orderStatusName."</td>";
                                        echo "<td style='vertical-align:middle;' class='w3-center'>".$dataBtn."</td>";
                                    echo "</tr>";
                                }
                            }
                            $totalPrice = "N/A";
                            if($priceArray != NULL)
                            {
                                $totalPrice =  number_format(array_sum($priceArray),2);
                            }
                            echo "</tbody>";
                            echo "<tfoot class='w3-black tfoot'>";
                                echo "<th></th>";
                                // echo "<th></th>";
                                echo "<th></th>";
                                echo "<th></th>";
                                echo "<th></th>";
                                echo "<th></th>";
                                echo "<th></th>";
                                echo "<th></th>";
                                echo "<th></th>";
                            echo "</tfoot>";
                        echo "</table>";
                        ?>
                    </div>
                    <input form="formExportXLS" type='hidden' name='sqlData' value="<?php echo $db->real_escape_string($sqlData);?>">
                    <input form="formExportPDF" type='hidden' name='sqlData' value="<?php echo $db->real_escape_string($sqlData);?>">
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
<script>
$(document).ready(function(){
    $(".uploadPay").click(function(){
        var batchNumber = $(this).attr("data-id");
        $("#modal-izi").iziModal({
            title                   : '<i class=""></i> PROOF OF PAYMENT',
            headerColor       		: 'grey',
            subtitle                : '<b><?php echo strtoupper(date('F d, Y'));?></b>',
            width                   : 400,
            fullscreen              : false,
            transitionIn            : 'comingIn',
            transitionOut           : 'comingOut',
            padding                 : 20,
            radius                  : 0,
            restoreDefaultContent   : true,
            closeOnEscape           : true,
            closeButton             : true,
            overlayClose            : false,
            onOpening               : function(modal){
                                        modal.startLoading();
                                        // setTimeout(function(){
                                        $.post( "uploadPayment.php?batchNumber="+batchNumber, function( data ) {
                                            $( ".izimodal-content" ).html(data);
                                            modal.stopLoading();
                                        });
                                        // }, 500);
                        }
        });

        $("#modal-izi").iziModal("open");
    });
});
</script>
<style type="text/css">
    .tbody {
        display: block;
        <?php
        if($x > 12)
        {
        ?>
            height:390px;
        <?php
        }
        ?>
        overflow: auto;
    }
    .thead, .tbody tr, .tfoot {
        display: table;
        width: 100%;
        table-layout: fixed;
    }
    .thead, .tfoot {
        <?php
        if($x > 12)
        {
        ?>
            width: calc(100% - 1.5em);
        <?php
        }
        else
        {
        ?>
            width: calc(100%);
        <?php
        }
        ?>
    }
</style>