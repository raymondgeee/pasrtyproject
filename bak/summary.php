<?php
$path = $_SERVER['DOCUMENT_ROOT']."/";
set_include_path($path);
include('Modules/mysqliConnection.php');
if($_SESSION['admin'] == "false")
{
    header("location:index.php");
    exit();
}

$userIdData = isset($_REQUEST['userId']) ? $_REQUEST['userId'] : "";
$dateFrom = isset($_REQUEST['dateFrom']) ? $_REQUEST['dateFrom'] : "";
$dateTo = isset($_REQUEST['dateTo']) ? $_REQUEST['dateTo'] : "";
$pickDateFrom = isset($_REQUEST['pickDateFrom']) ? $_REQUEST['pickDateFrom'] : "";
$pickDateTo = isset($_REQUEST['pickDateTo']) ? $_REQUEST['pickDateTo'] : "";
$batchNumberData = isset($_REQUEST['batchNumber']) ? $_REQUEST['batchNumber'] : "";
$orderStats = isset($_REQUEST['orderStats']) ? $_REQUEST['orderStats'] : "";
$chkDenied = isset($_REQUEST['chkDenied']) ? $_REQUEST['chkDenied'] : "";

$checkedDenied = "";
$includeQuery = "";
if ($userIdData != "") 
{
    $includeQuery .= " AND userId = ".$userIdData;
}

if ($dateFrom != "" AND $dateTo != "") 
{
    $includeQuery .= " AND (orderDate >= '".$dateFrom."' AND orderDate <= '".$dateTo."')";
}

if ($pickDateFrom != "" AND $pickDateTo != "") 
{
    $includeQuery .= " AND (deliveryDate >= '".$pickDateFrom."' AND deliveryDate <= '".$pickDateTo."')";
}

if ($batchNumberData != "") 
{
    $includeQuery .= " AND batchNumber = '".$batchNumberData."'";
}

if ($orderStats != "") 
{
    $includeQuery .= " AND orderStatus = ".$orderStats;
}
else
{
    if($chkDenied == "")
    {
        $includeQuery .= " AND orderStatus IN (1,2,3,5)";
    }
    else
    {
        $checkedDenied = "checked";
    }
}

$userIdArray = Array ();
$sql = "SELECT * FROM productorders WHERE orderStatus > 0 ";
$queryReviewOrders = $db->query($sql);
if($queryReviewOrders AND $queryReviewOrders->num_rows > 0)
{
    while ($resultReviewOrders = $queryReviewOrders->fetch_assoc())
    {
        $orderId = $resultReviewOrders['orderId'];
        $userIdArray[] = $resultReviewOrders['userId'];
    }
}

$orderQty = $totalDelFee = 0;
$orderStatusArray = $productOrderPriceArray = Array ();
$sql = "SELECT * FROM productorders WHERE orderStatus > 0 ".$includeQuery;
$queryRecords = $db->query($sql);
$totalRecords = $queryRecords->num_rows;
$sqlData = $sql;
$queryReviewOrders = $db->query($sql);
if($queryReviewOrders AND $queryReviewOrders->num_rows > 0)
{
    while ($resultReviewOrders = $queryReviewOrders->fetch_assoc())
    {
        $orderId = $resultReviewOrders['orderId'];
        $userIdArray[] = $resultReviewOrders['userId'];
        $productId = $resultReviewOrders['productId'];
        $quantity = $resultReviewOrders['quantity'];
        $orderDate = $resultReviewOrders['orderDate'];
        $orderStatusArray[] = $resultReviewOrders['orderStatus'];
        $deliveryDate = $resultReviewOrders['deliveryDate'];
        $batchNumberArray[] = $resultReviewOrders['batchNumber'];
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
            $productOrderPriceArray[] = $resultOrdered['productPrice'];
        }
        $orderQty += $quantity;

        $totalDelFee += $deliveryFee;
    }
}

$customersName = '';
$sql = "SELECT * FROM userinformation WHERE userId = ".$userIdData;
$queryUserInfo = $db->query($sql);
if($queryUserInfo AND $queryUserInfo->num_rows > 0)
{
    $resultUserInfo = $queryUserInfo->fetch_assoc();
    $firstName = $resultUserInfo['firstName'];
    $surName = $resultUserInfo['surName'];
    $address = $resultUserInfo['address'];
    $contactNumber = $resultUserInfo['contactNumber'];

    $customersName = $firstName." ".$surName;
}

$totalSummary = "0.00";
$totalPriceData = "0.00";
if($productOrderPriceArray != NULL)
{
    $totalPriceData = number_format(array_sum($productOrderPriceArray), 2);
    $totalSummary = number_format(array_sum($productOrderPriceArray) + $totalDelFee, 2);
}


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
    <link rel="stylesheet" href="Include Files/Javascript/Super Quick Table/datatables.min.css"/>
	<link rel="stylesheet" href="Include Files/Bootstrap/Bootstrap 3.3.7/css/bootstrap.css">
	<link rel="stylesheet" href="Include Files/Bootstrap/Font Awesome/css/font-awesome.css">
	<link rel="stylesheet" href="Include Files/Bootstrap/Bootstrap 3.3.7/Roboto Font/roboto.css">
    <link rel="stylesheet" href="Include Files/Bootstrap/w3css/w3.css">
    <link rel="stylesheet" href="Include Files/Custom CSS/styles.css">
	<style>
        .dataTables_wrapper .dataTables_filter {
            position:absolute;
            text-align: right;
            visibility: hidden;
        }
    </style>
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
                <div class='w3-container w3-round w3-white w3-card-2 w3-padding'>
                    <?php include "adminNavi.php";?>
                    <div class='row'>
                        <div class='col-md-12'>
                            <hr>
                        </div>
                    </div>
                    <div class='row w3-padding-top'>
                        <!-- <div class='col-md-2'>
                            <div class='w3-center'>
                                <label class='w3-medium'>CUSTOMER INFORMATION</label>
                                <div class="w3-container w3-padding w3-white w3-card-2" style="height: 208px">
                                    <div class="w3-center w3-padding-top">
                                        <img src="Profile Pictures/default.png" class="w3-tiny w3-round-xxlarge w3-card-2" style="width: 60px; height: 60px;">
                                    </div>
                                    <hr>
                                     <div class="w3-padding-top">
                                      
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <div class='col-md-12'>
                            <div class='row'>
                                <div class='col-md-12'>
                                    <div class='row'>
                                        <div class='col-md-12'>
                                            <form id="formFilter" method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>"></form>
                                            <form id="formExportXLS" method="POST" action="summaryExportExcel.php?type=summary"></form>
                                            <form id="formExportPDF" method="POST" action="summaryExportPDF.php" target="_blank"></form>
                                            <input form="formExportXLS" type='hidden' name='sqlData' value="<?php echo $db->real_escape_string($sqlData);?>">
                                            <input form="formExportPDF" type='hidden' name='sqlData' value="<?php echo $db->real_escape_string($sqlData);?>">
                                            <label class='w3-large'>SUMMARY OF ORDERS</label>
                                            <div class='w3-right'>
                                                <button form="formExportXLS" class='w3-btn w3-tiny w3-round w3-black'><i class="fa fa-file-excel-o"></i>&emsp;<b>IMPORT VIA XLS</b></button>
                                                <button form="formExportPDF" class='w3-btn w3-tiny w3-round w3-black'><i class="fa fa-file-pdf-o"></i>&emsp;<b>IMPORT VIA PDF</b></button>
                                            </div>
                                            <div class='row'>
                                                 <div class='col-md-2'>
                                                    <label class="w3-tiny">CUSTOMER NAME</label>
                                                    <select form="formFilter" class="w3-select w3-border w3-small" id='userId' name='userId' type="combobox">
                                                        <option value="">Choose your option</option>
                                                        <?php
                                                        $customers = array_unique(array_filter($userIdArray));
                                                        foreach ($customers as $key) 
                                                        {
                                                            $fullName = "";
                                                            $sql = "SELECT * FROM userinformation WHERE userId = ".$key;
                                                            $queryUserInfo = $db->query($sql);
                                                            if($queryUserInfo AND $queryUserInfo->num_rows > 0)
                                                            {
                                                                $resultUserInfo = $queryUserInfo->fetch_assoc();
                                                                $firstName = $resultUserInfo['firstName'];
                                                                $surName = $resultUserInfo['surName'];

                                                                $fullName = $firstName." ".$surName;
                                                                $selectedUser = ($userIdData == $key) ? "selected" : '';
                                                                echo "<option ".$selectedUser." value=".$key.">".$fullName."</option>";
                                                            }

                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class='col-md-2'>
                                                    <label class="w3-tiny">ORDER DATE FROM</label>
                                                    <input form="formFilter" value="<?php echo $dateFrom; ?>" class="w3-input w3-border w3-small" id='dateFrom' name='dateFrom' type="date">
                                                </div>
                                                <div class='col-md-2'>
                                                    <label class="w3-tiny">ORDER DATE TO</label>
                                                    <input form="formFilter" value="<?php echo $dateTo; ?>" class="w3-input w3-border w3-small" id='dateTo' name='dateTo' type="date">
                                                </div>
                                                <div class='col-md-2'>
                                                    <label class="w3-tiny">BATCH NUMBER</label>
                                                    <select form="formFilter" class="w3-select w3-border w3-small" id='batchNumber' name='batchNumber' type="combobox">
                                                        <option value="">Choose your option</option>
                                                        <?php
                                                        $batch = array_unique($batchNumberArray);
                                                        foreach ($batch as $key) 
                                                        {
                                                            $selectedBatch = ($batchNumberData == $key) ? "selected" : '';
                                                            echo "<option ".$selectedBatch." value=".$key.">".$key."</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class='col-md-2'>
                                                    <label class="w3-tiny">ORDER STATUS</label>
                                                    <select form="formFilter" class="w3-select w3-border w3-small" id='orderStats' name='orderStats' type="combobox">
                                                        <option value="">Choose your option</option>
                                                        <?php
                                                        $orderStat = array_unique($orderStatusArray);
                                                        foreach ($orderStat as $key) 
                                                        {
                                                            if($key == 1) $orderStatusName = "<b>Reserved</b>";
                                                            if($key == 2) $orderStatusName = "<b>Pending</b>";
                                                            if($key == 3) $orderStatusName = "<b>Approved</b>";
                                                            if($key == 4) $orderStatusName = "<b>Denied</b>";
                                                            if($key == 5) $orderStatusName = "<b>Finished</b>";

                                                            $selectedStatus = ($orderStats == $key) ? "selected" : '';
                                                            echo "<option ".$selectedStatus." value=".$key.">".$orderStatusName."</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class='col-md-2'>
                                                    <div class='row'>
                                                        <div class='col-md-3 w3-center'>
                                                            <label class="w3-tiny">DENIED</label>
                                                            <input <?php echo $checkedDenied; ?> type='checkbox' name='chkDenied' class='w3-check' form="formFilter" onchange='this.form.submit();s'>
                                                        </div>
                                                        <div class='col-md-9'>
                                                            <label class="w3-tiny">&emsp;</label><br>
                                                            <button form="formFilter" type="submit" class='w3-btn w3-round w3-black'><i class="fa fa-search"></i>&emsp;<b>SEARCH</b></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class='w3-padding-top'>
                                            <div class='row'>
                                                <div class='col-md-2'>
                                                    <label class="w3-tiny">PICK-UP DATE FROM</label>
                                                    <input form="formFilter" value="<?php echo $pickDateFrom; ?>" class="w3-input w3-border w3-small" id='pickDateFrom' name='pickDateFrom' type="date">
                                                </div>
                                                <div class='col-md-2'>
                                                    <label class="w3-tiny">PICK-UP DATE TO</label>
                                                    <input form="formFilter" value="<?php echo $pickDateTo; ?>" class="w3-input w3-border w3-small" id='pickDateTo' name='pickDateTo' type="date">
                                                </div>
                                            </div>
                                            <?php 
                                           
                                            echo "<br>";
                                            echo "<label>RECORDS : ".$totalRecords."</label><br>";
                                            echo "<label class='w3-medium'>CUSTOMER : ".strtoupper($customersName)."</label><br>";
                                            echo "<table class='table table-condensed table-striped' id='mainTable'>";
                                                echo "<thead class='w3-black'>";
                                                    echo "<th class='text-center'>#</th>";
                                                    // echo "<th class='text-center'>CUSTOMER NAME</th>";
                                                    echo "<th class='text-center'>PRODUCT NAME</th>";
                                                    echo "<th class='text-center'>ORDER QTY</th>";
                                                    echo "<th class='text-center'>PRICE</th>";
                                                    // echo "<th class='text-center'>DEL. FEE</th>";
                                                    echo "<th class='text-center'>ORDER DATE</th>";
                                                    echo "<th class='text-center'>PICK-UP DATE</th>";
                                                    echo "<th class='text-center'>TYPE</th>";
                                                    echo "<th class='text-center'>BATCH NUMBER</th>";
                                                    echo "<th class='text-center'>ORDER STATUS</th>";
                                                    // echo "<th class='text-center'>ACTION</th>";
                                                echo "</thead>";
                                                echo "<tbody class='w3-center'>";
                                                
                                                echo "</tbody>";
                                                echo "<tfoot class='w3-black'>";
                                                    echo "<th class='w3-center'></th>";
                                                    // echo "<th class='w3-center'></th>";
                                                    echo "<th class='w3-center'></th>";
                                                    echo "<th class='w3-center'></th>";
                                                    echo "<th class='w3-center'>".$totalPriceData." PHP</th>";
                                                    // echo "<th class='w3-center'>".number_format($totalDelFee,2)." PHP</th>";
                                                    echo "<th class='w3-center'></th>";
                                                    echo "<th class='w3-center'></th>";
                                                    echo "<th class='w3-center'></th>";
                                                    echo "<th class='w3-center'></th>";
                                                    echo "<th class='w3-center'></th>";
                                                echo "</tfoot>";
                                            echo "</table>";
                                            echo "<div class='w3-padding-top'></div>";
                                            echo "<label class='w3-medium'>TOTAL SUMMARY : ".$totalSummary." PHP</label>";
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
</body>
</html>
<script src="Include Files/Javascript/jQuery 3.1.1/jquery-3.1.1.js"></script>
<script src="Include Files/Javascript/jQuery 3.1.1/jquery-ui.js"></script>
<script src="Include Files/Javascript/jQuery 3.1.1/bootstrap.min.js"></script>
<script src="Include Files/Javascript/Super Quick Table/datatables.min.js"></script>
<link rel="stylesheet" href="Include Files/Javascript/iziModal-master/css/iziModal.css" />
<script src="Include Files/Javascript/iziModal-master/js/iziModal.js"></script>
<link rel="stylesheet" href="Include Files/Javascript/iziToast-master/dist/css/iziToast.css" />
<script src="Include Files/Javascript/iziToast-master/dist/js/iziToast.js"></script>
<script src="Include Files/Javascript/jQuery Balloon/jquery.balloon.js"></script>
<script>
$(document).ready(function(){
    var sqlData = "<?php echo $sqlData; ?>";
    var totalRecords = "<?php echo $totalRecords;?>";
    // alert(sqlData);
    var dataTable = $("#mainTable").DataTable({
        "processing"    : true,
        "ordering"      : false,
        "serverSide"    : true,
        "bInfo"         : false,
        "ajax"          : {
                url     : "summaryAJAX.php",
                type    : "POST",
                data    : {
                            sqlData      : sqlData,
                            totalRecords : totalRecords
                },
                error   : function(){
                    $(".mainTable-error").html("");
                    $("#mainTable").append("<tbody class='mainTable-error'>"+
                                                "<tr>"+
                                                    "<th colspan = 3>No data found in the server</th>"+
                                                "</tr>"+
                                            "</tbody>");
                    $("#mainTable-processing").css("display","none");

                }
        },
        "createdRow"    : function(row, data, index){
           $(row).addClass("w3-hover-dark-grey");
        },
        "columnDefs"    : [

        ],
        language        : {
                processing  : ""
        },
        fixedColumns    : {
                leftColumns     : 0
        },
        scrollX         : false,
        scrollY         : 260,
        scrollCollapse  : false,
        scroller        : {
            loadingIndicator    : true
        },
        stateSave       : false
    });
});
</script>