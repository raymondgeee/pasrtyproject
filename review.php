<?php
$path = $_SERVER['DOCUMENT_ROOT']."/";
set_include_path($path);
include('Modules/mysqliConnection.php');

$userId = $_SESSION['userId'];
$sql = "SELECT userId FROM useraccounts WHERE userId  = '".$userId."' AND userType = 0";
$queryCheckUser = $db->query($sql);
if($queryCheckUser AND $queryCheckUser->num_rows == 0)
{
   header("location:login.php");
   exit();
}

$batchNumber = isset($_REQUEST['batchNumber']) ? $_REQUEST['batchNumber'] : "";
$read = isset($_REQUEST['read']) ? $_REQUEST['read'] : "";

if($read == 1)
{
    $sql = "UPDATE productverification SET readStatus = 1 WHERE batchNumber = '".$batchNumber."' AND readStatus = 0";
    $queryUpdate = $db->query($sql);
}

$sql = "SELECT userId FROM productorders WHERE batchNumber = '".$batchNumber."' LIMIT 1";
$queryUser = $db->query($sql);
if($queryUser AND $queryUser->num_rows > 0)
{
    $resultUser = $queryUser->fetch_assoc();
    $userId = $resultUser['userId'];
}

$sql = "SELECT * FROM userinformation WHERE userId = ".$userId;
$queryUserInfo = $db->query($sql);
if($queryUserInfo AND $queryUserInfo->num_rows > 0)
{
    $resultUserInfo = $queryUserInfo->fetch_assoc();
    $firstName = $resultUserInfo['firstName'];
    $surName = $resultUserInfo['surName'];
    $address = $resultUserInfo['address'];
    $contactNumber = $resultUserInfo['contactNumber'];
    $email = $resultUserInfo['email'];
    $profilePicture = $resultUserInfo['profilePicture'];

    $targetPath = "Profile Pictures/".$profilePicture;

    $picture = "Profile Pictures/default.png";
    if(file_exists($targetPath) AND $profilePicture != "")
    {
        $picture = $targetPath;
    }

    $fullName = $firstName." ".$surName;
}

$pathFolder = $_SERVER['DOCUMENT_ROOT']."/Proof Photos/";
$pathRootName = $pathFolder.$batchNumber."_".$userId;

$getFile = glob($pathRootName.".*");
if(count($getFile) > 0)
{
    $ext = pathinfo($getFile[0], PATHINFO_EXTENSION);
    if (file_exists($pathRootName.".".$ext)) 
    {
        $dataBtn = "<a href='imageDownload.php?imageFile=".$batchNumber."_".$userId.".".$ext."'><button class='w3-btn w3-tiny w3-round w3-black'><i class='fa fa-photo'></i>&emsp;<b>VIEW ATTACHED IMAGE</b></button></a>";
    }
    else
    {
        $dataBtn = "";
    }
}
else
{
    $dataBtn = "";
}

$disabledBtn = "";
$sql = "SELECT * FROM productorders WHERE batchNumber = '".$batchNumber."' AND orderStatus >= 3 LIMIT 1";
$queryReviewStatus = $db->query($sql);
if($queryReviewStatus AND $queryReviewStatus->num_rows > 0)
{
    $disabledBtn = "disabled";
}

$dateNow = date('Y-m-d');
$disabledDisAppBtn = "";
$sql = "SELECT * FROM productorders WHERE batchNumber = '".$batchNumber."' LIMIT 1";
$queryCheckDate = $db->query($sql);
if($queryCheckDate AND $queryCheckDate->num_rows > 0)
{
    $resultCheckDate = $queryCheckDate->fetch_assoc();
    $deliveryDateData = $resultCheckDate['deliveryDate'];
    $orderStatusData = $resultCheckDate['orderStatus'];

    if($deliveryDateData < $dateNow)
    {
        $disabledBtn = "disabled";
    }
    
    if(in_array($orderStatusData, Array(3,4,5))) $disabledDisAppBtn = "disabled";
}

if($dataBtn == "") $disabledBtn = "disabled";

$activeButtonProd = "";
$activeButtonSett = "";
$activeButtonSumm = "true";
$activeButtonCust = "";
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
<body class=''>
    <div class='container-fluid'>
        <div class='row'>
            <div class="w3-container w3-black w3-card-2 w3-padding">
                <label class='w3-large'>ADMIN PANEL</label>
            </div>
        </div>
        <div class='row'>
            <div class='col-md-12 w3-padding-top'>
                <div class='w3-container w3-round w3-white w3-card-2 w3-padding' style=''>
                    <?php include "adminNavi.php";?>
                    <div class='row'>
                        <div class='col-md-12'>
                            <hr>
                        </div>
                    </div>
                    <div class='row w3-padding-top'>
                        <div class='col-md-3'>
                            <div class='w3-center'>
                                <label class='w3-medium'>CUSTOMER INFORMATION</label>
                                <div class="w3-container w3-padding w3-black w3-card-2" style="height: 280px">
                                    <div class="w3-center w3-padding-top">
                                        <img src="<?php echo $picture; ?>" class="w3-tiny w3-round-xxlarge w3-card-2" style="width: 60px; height: 60px;">
                                    </div>
                                    <hr>
                                    <div class="w3-padding-top">
                                        <label class='w3-large'><i class='fa fa-user'></i>&emsp;<?php echo strtoupper($fullName); ?></label> 
                                        <div class="w3-padding-top"></div>
                                        <label><i class='fa fa-map-marker'></i>&emsp;<?php echo strtoupper($address); ?></label>
                                        <br>
                                        <label><i class='fa fa-phone'></i>&emsp;<?php echo strtoupper($contactNumber); ?></label> 
                                        <br>
                                        <label><i class='fa fa-book'></i>&emsp;<?php echo $email; ?></label> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class='col-md-9'>
                            <div class='row'>
                                <div class='col-md-12'>
                                    <div class='row'>
                                        <div class='col-md-12'>
                                        <label class='w3-large'>REVIEW ORDERS</label>
                                        <div class='w3-right'>
                                            <form id="formExportXLS" method="POST" action="summaryExportExcel.php?type=review"></form>
                                            <input form="formExportXLS" type='hidden' name='batchNumber' value="<?php echo $db->real_escape_string($batchNumber);?>">
                                            <button form="formExportXLS" class='w3-btn w3-tiny w3-round w3-black'><i class="fa fa-file-excel-o"></i>&emsp;<b>IMPORT VIA XLS</b></button>
                                            <?php echo $dataBtn; ?>
                                            <button <?php echo $disabledBtn; ?> class='w3-btn w3-tiny w3-round w3-blue approve'><i class="fa fa-check"></i>&emsp;<b>APPROVE</b></button>
                                            <!-- <button <?php echo $disabledBtn; ?> class='w3-btn w3-tiny w3-round w3-red denied'><i class="fa fa-remove"></i>&emsp;<b>DISAPPROVE</b></button> -->
                                            <button <?php echo $disabledDisAppBtn; ?> class='w3-btn w3-tiny w3-round w3-red denied'><i class="fa fa-remove"></i>&emsp;<b>DISAPPROVE</b></button>
                                        </div>
                                        <?php 
                                        
                                        echo "<br>";
                                        echo "<label>BATCH NUMBER : ".$batchNumber."</label>";
                                        echo "<table class='table table-condensed table-striped'>";
                                            echo "<thead class='w3-black'>";
                                                echo "<th class='text-center'>#</th>";
                                                echo "<th class='text-center'>IMAGE</th>";
                                                echo "<th class='text-center'>PRODUCT NAME</th>";
                                                echo "<th class='text-center'>ORDER QTY</th>";
                                                echo "<th class='text-center'>PRICE</th>";
                                                // echo "<th class='text-center'>DEL. PRICE</th>";
                                                echo "<th class='text-center'>ORDER DATE</th>";
                                                echo "<th class='text-center'>PICK-UP DATE</th>";
                                                // echo "<th class='text-center'>DELIVERY TYPE</th>";
                                                echo "<th class='text-center'>ORDER STATUS</th>";
                                                // echo "<th class='text-center'>ACTION</th>";
                                            echo "</thead>";
                                            echo "<tbody>";
                                            $x = $totalDelFee = $totalPriceData = 0;
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
                                                        $categoryId = $resultOrdered['categoryId'];
                                                        $productImage = $resultOrdered['productImage'];
                                                        $totalPriceData += $productOrderPrice;
                                                    }

                                                    $sql = "SELECT categoryName FROM productcategories WHERE categoryId = ".$categoryId;
                                                    $queryFolders = $db->query($sql);
                                                    if($queryFolders AND $queryFolders->num_rows > 0)
                                                    {
                                                        $resultFolders = $queryFolders->fetch_assoc();
                                                        $folder = $resultFolders['categoryName']."/";
                                                    }

                                                    if($categoryId == 5) $folder = "Customized Cakes";

                                                    $pathFolder = $_SERVER['DOCUMENT_ROOT']."/Custom/".$folder;
                                                    $imageData = "";
                                                    if($productImage != "")
                                                    {
                                                        $path = "Custom/".$folder."/".$productImage;
                                                        if(file_exists($path))
                                                        {
                                                            $imageData = "<img src='".$path."' style='width:80px; height:80px;'>";
                                                        }
                                                        else
                                                        {
                                                            $imageData = "<img src='Uploads/index_1.jpg' style='width:80px; height:80px;'>";
                                                        }
                                                    }
                                                    else
                                                    {
                                                        $imageData = "<img src='Uploads/index_1.jpg' style='width:80px; height:80px;'>";
                                                    }

                                                    $totalDelFee += $deliveryFee;
                                                    if($orderStatus == 1) $orderStatusName = "<b>Reserved</b>";
                                                    if($orderStatus == 2) $orderStatusName = "<b>Pending</b>";
                                                    if($orderStatus == 3) $orderStatusName = "<b>Approved</b>";
                                                    if($orderStatus == 4) $orderStatusName = "<b>Denied</b>";
                                                    if($orderStatus == 5) $orderStatusName = "<b>Finished</b>";

                                                    if($categoryId == 5)
                                                    {
                                                        $productOrderName = "<span style='cursor:pointer;' class='customizedDetails' data-id='".$productId."'>".$productOrderName."</span>";
                                                    }
                                                    
                                                    $tdColor = "";
                                                    if($deliveryDate < $dateNow) $tdColor = "w3-pink";
                                                    echo "<tr>";
                                                        echo "<td style='vertical-align:middle;' class='w3-center'><b>".++$x."</b></td>";
                                                        echo "<td style='vertical-align:middle;' class='w3-center'>".$imageData."</td>";
                                                        echo "<td style='vertical-align:middle;' class='w3-center'>".$productOrderName."</td>";
                                                        echo "<td style='vertical-align:middle;' class='w3-center'>".$quantity."</td>";
                                                        echo "<td style='vertical-align:middle;' class='w3-center'>".$productOrderPrice." PHP</td>";
                                                        // echo "<td style='vertical-align:middle;' class='w3-center'>".$deliveryFee." PHP</td>";
                                                        echo "<td style='vertical-align:middle;' class='w3-center'>".$orderDate."</td>";
                                                        echo "<td style='vertical-align:middle;' class='w3-center ".$tdColor."'>".$deliveryDate."</td>";
                                                        // echo "<td style='vertical-align:middle;' class='w3-center'>".$deliveryTypeName."</td>";
                                                        echo "<td style='vertical-align:middle;' class='w3-center'>".$orderStatusName."</td>";
                                                        // echo "<td style='vertical-align:middle;' class='w3-center'></td>";
                                                    echo "</tr>";

                                                }
                                            } 

                                            $totalSummary = number_format($totalPriceData + $totalDelFee, 2);
                                            echo "</tbody>";
                                            echo "<tfoot class='w3-black'>";
                                                echo "<th></th>";
                                                echo "<th></th>";
                                                echo "<th></th>";
                                                echo "<th></th>";
                                                echo "<th style='vertical-align:middle;' class='w3-center'>".number_format($totalPriceData,2)." PHP</th>";
                                                // echo "<th style='vertical-align:middle;' class='w3-center'>".number_format($totalDelFee,2)." PHP</th>";
                                                echo "<th></th>";
                                                echo "<th></th>";
                                                // echo "<th></th>";
                                                echo "<th></th>";
                                            echo "</tfoot>";
                                        echo "</table>";

                                        $downPaymentPrice = 0;
                                        if($orderStatus == 3)
                                        {
                                            $downPaymentPrice = (($totalPriceData + $totalDelFee) * .30);
                                        }
                                        $totalPayment = ($totalPriceData + $totalDelFee) - $downPaymentPrice;
                                        echo "<div class='w3-padding-top'></div>";
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
                                        ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id='modal-izi-update'><span class='izimodal-content-update'></span></div>
    <div id='modal-izi-add'><span class='izimodal-content-add'></span></div>
    <div id='modal-izi-admin'><span class='izimodal-content-admin'></span></div>
    <div id='modal-izi-updateuser'><span class='izimodal-content-updateuser'></span></div>
    <div id='modal-izi-notification'><span class='izimodal-content-notification'></span></div>
    <div id='modal-izi-custom'><span class='izimodal-content-custom'></span></div>
    <div id='modal-izi-denied'><span class='izimodal-content-denied'></span></div>
</body>
</html>
<script src="Include Files/Javascript/jQuery 3.1.1/jquery-3.1.1.js"></script>
<script src="Include Files/Javascript/jQuery 3.1.1/jquery-ui.js"></script>
<script src="Include Files/Javascript/jQuery 3.1.1/bootstrap.min.js"></script>
<link rel="stylesheet" href="Include Files/Javascript/iziModal-master/css/iziModal.css" />
<script src="Include Files/Javascript/iziModal-master/js/iziModal.js"></script>
<link rel="stylesheet" href="Include Files/Javascript/iziToast-master/dist/css/iziToast.css" />
<script src="Include Files/Javascript/iziToast-master/dist/js/iziToast.js"></script>
<script src="Include Files/Javascript/jQuery Balloon/jquery.balloon.js"></script>
<script>
$(document).ready(function(){
    $(".customizedDetails").click(function(){
        var productId = $(this).attr("data-id");
        $("#modal-izi-custom").iziModal({
            title                   : '<i class=""></i> CUSTOM DETAILS',
            // headerColor       		: '#009688',
            headerColor       		: 'grey',
            subtitle                : '<b><?php echo strtoupper(date('F d, Y'));?></b>',
            width                   : 350,
            fullscreen              : false,
            transitionIn            : 'comingIn',
            transitionOut           : 'comingOut',
            padding                 : 0,
            radius                  : 0,
            restoreDefaultContent   : true,
            closeOnEscape           : true,
            closeButton             : true,
            overlayClose            : false,
            overlay                 : false,
            onOpening               : function(modal){
                                        modal.startLoading();
                                        // setTimeout(function(){
                                        $.post( "viewCustomizedDetails.php?productId="+productId, function( data ) {
                                            $( ".izimodal-content-custom" ).html(data);
                                            modal.stopLoading();
                                        });
                                        // }, 500);
                                    },
            onClosed               : function(){
                                        $("#modal-izi-custom").iziModal("destroy");
                                    }
        });

        $("#modal-izi-custom").iziModal("open");
    });

    $(".approve").click(function(){
        var batchNumber = "<?php echo $batchNumber; ?>";
        var userId = "<?php echo $userId; ?>";
        var res = confirm("Are you sure?");
        if(res)
        {
            $.ajax({
                url     : 'approval.php',
                type    : 'POST',
                data    : {
                    type : 'approve',
                    batchNumber : batchNumber,
                    userId      : userId
                },
                success : function(data){
                            // $(this).parent().parent().remove();
                            location.reload();
                }
            });
        }
    });

    $(".denied").click(function(){
        var batchNumber = "<?php echo $batchNumber; ?>";
        var userId = "<?php echo $userId; ?>";

        $("#modal-izi-denied").iziModal({
            title                   : '<i class=""></i> NOTIFCATION REMARKS',
            // headerColor       		: '#009688',
            headerColor       		: 'grey',
            subtitle                : '<b><?php echo strtoupper(date('F d, Y'));?></b>',
            width                   : 350,
            fullscreen              : false,
            transitionIn            : 'comingIn',
            transitionOut           : 'comingOut',
            padding                 : 0,
            radius                  : 0,
            restoreDefaultContent   : true,
            closeOnEscape           : true,
            closeButton             : true,
            overlayClose            : false,
            overlay                 : false,
            onOpening               : function(modal){
                                        modal.startLoading();
                                        // setTimeout(function(){
                                        $.post( "disapprove.php?batchNumber="+batchNumber+"&userId="+userId, function( data ) {
                                            $( ".izimodal-content-denied" ).html(data);
                                            modal.stopLoading();
                                        });
                                        // }, 500);
                                    },
            onClosed               : function(){
                                        $("#modal-izi-denied").iziModal("destroy");
                                    }
        });

        $("#modal-izi-denied").iziModal("open");
        // var res = confirm("Are you sure?");
        // if(res)
        // {
        //     $.ajax({
        //         url     : 'approval.php',
        //         type    : 'POST',
        //         data    : {
        //             type : 'denied',
        //             batchNumber : batchNumber,
        //             userId      : userId
        //         },
        //         success : function(data){
        //                     // $(this).parent().parent().remove();
        //                     location.reload();
        //         }
        //     });
        // }
    });

});
</script>