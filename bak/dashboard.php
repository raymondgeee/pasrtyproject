<?php
$path = $_SERVER['DOCUMENT_ROOT']."/";
set_include_path($path);
include('Modules/mysqliConnection.php');
$userId = $_SESSION['userId'];

$sql = "SELECT userId FROM useraccounts WHERE userId  = '".$userId."' AND userType = 0";
$queryCheckUser = $db->query($sql);
if($queryCheckUser AND $queryCheckUser->num_rows == 0)
{
   header("location:index.php");
}

$categoryId = isset($_REQUEST['categoryId']) ? $_REQUEST['categoryId'] : "";
$categoryData = $categoryId;
$start = isset($_REQUEST['start']) ? $_REQUEST['start'] : 0;
$end = isset($_REQUEST['end']) ? $_REQUEST['end'] : 6;
$prevPage = isset($_REQUEST['prevPage']) ? $_REQUEST['prevPage'] : 1;
$nextPage = isset($_REQUEST['nextPage']) ? $_REQUEST['nextPage'] : 1;
$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;

$queryAdd = "";
if($categoryId != "")
{
    $queryAdd .= " AND categoryId = ".$categoryId;
}

if(isset($_REQUEST['nextPage']))
{
    $start = $start + 6;
    $page = $page + 1;
}

if(isset($_REQUEST['prevPage']))
{
    $start = $start - 6;
    $page = $page - 1;
}

$limit = " LIMIT ".$start.", ".$end;

$activeButtonProd = "true";
$activeButtonSett = "";
$activeButtonSumm = "";
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
    <link rel="stylesheet" href="Include Files/Bootstrap/Hover-master/css/hover.css">
</head>
<body class=''>
    <div class='container-fluid'>
        <div class='row'>
            <div class="w3-container w3-brown w3-black w3-card-2 w3-padding">
                <label class='w3-large'>ADMIN PANEL</label>
            </div>
        </div>
        <div class='row'>
            <div class='w3-padding-top'>
                <div class='w3-container w3-round w3-padding'>
                    <?php include "adminNavi.php";?>
                    <div class='row'>
                        <div class='col-md-12'>
                            <hr>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-md-3'>
                            <label class='w3-large'>CATEGORIES</label>
                        </div>
                        <div class='col-md-9'>
                            <span class=''>
                                <button class='w3-btn w3-black w3-round w3-tiny' id='addProducts'><i class='fa fa-plus'></i>&emsp;<b>PRODUCTS</b></button>
                            </span>
                        </div>
                    </div>
                    <div class='row w3-padding-top'>
                        <div class='col-md-3'>
                            <div class='w3-center'>
                                <div class="w3-card-2 w3-black">
                                <?php 
                                $w3AllColor = "w3-hover-dark-grey";
                                if($categoryId == "") $w3AllColor = "w3-dark-grey";
                                echo "<div class='w3-container ".$w3AllColor."' style='cursor:pointer;' onclick=\"location.href='".$_SERVER['PHP_SELF']."'\">";
                                    echo "<div class='w3-left w3-padding hvr-grow'>";
                                        echo "<i class='fa fa-list'></i>&emsp;";
                                        echo "<label style='cursor:pointer;'>".strtoupper("VIEW ALL")."</label>";
                                    echo "</div>";
                                echo "</div>";
                                $sql = "SELECT categoryName, categoryId FROM productcategories WHERE categoryStatus = 1 ORDER BY categoryName ASC";
                                $queryCategory = $db->query($sql);
                                if($queryCategory AND $queryCategory->num_rows > 0)
                                {
                                    while($resultCategory = $queryCategory->fetch_assoc())
                                    {
                                        $categoryName = $resultCategory['categoryName'];
                                        $categoryIdData = $resultCategory['categoryId'];
                                        $colorData = "w3-hover-dark-grey";
                                        if($categoryIdData == $categoryId) $colorData = "w3-dark-grey";
                                        echo "<div class='w3-container ".$colorData."' style='cursor:pointer;' onclick=\"location.href='".$_SERVER['PHP_SELF']."?categoryId=".$categoryIdData."'\">";
                                            echo "<div class='w3-left w3-padding hvr-grow'>";
                                                echo "<i class='fa fa-chevron-right'></i>&emsp;";
                                                echo "<label style='cursor:pointer;'>".strtoupper($categoryName)."</label>";
                                            echo "</div>";
                                        echo "</div>";
                                    }
                                }
                                ?>
                                </div>
                            </div>
                        </div>
                        <div class='col-md-9'>
                            <div class='row'>
                                <?php
                                $sql = "SELECT * FROM productinformation WHERE productStatus = 1 ".$queryAdd." ORDER BY categoryId, productId DESC ".$limit;
                                $queryProducts = $db->query($sql);
                                if($queryProducts AND $queryProducts->num_rows > 0)
                                {
                                    while($resultProducts = $queryProducts->fetch_assoc())
                                    {
                                        $productId = $resultProducts['productId'];
                                        $productName = $resultProducts['productName'];
                                        $productDetails = $resultProducts['productDetails'];
                                        $productImage = $resultProducts['productImage'];
                                        $stock = $resultProducts['stock'];
                                        $categoryId = $resultProducts['categoryId'];

                                        $stockColor = ($stock == 0) ? "w3-text-red" : "";

                                        /* if($categoryId == 1) $folder = "Birthday Cakes/";
                                        if($categoryId == 2) $folder = "Wedding Cakes/";
                                        if($categoryId == 3) $folder = "Cup Cakes/";
                                        if($categoryId == 5) $folder = "Customized Cakes/";
                                        if($categoryId == 6) $folder = "Christening Cakes/";
                                        if($categoryId == 7) $folder = "Graduation Cakes/";
                                        if($categoryId > 7) $folder = "Others/"; */

                                        $sql = "SELECT categoryName FROM productcategories WHERE categoryId = ".$categoryId;
                                        $queryFolders = $db->query($sql);
                                        if($queryFolders AND $queryFolders->num_rows > 0)
                                        {
                                            $resultFolders = $queryFolders->fetch_assoc();
                                            $folder = $resultFolders['categoryName']."/";
                                        }

                                        $imageData = "";
                                        if($productImage != "")
                                        {
                                            $productImageData = $productImage;
                                            if($categoryId == 5) $folder = "Customized Cakes/";
                                            $path = "Custom/".$folder."/".$productImage;
                                            if(file_exists($path))
                                            {
                                                $imageData = "<img src='".$path."' style='width:100%; height:210px;'>";
                                            }
                                            else
                                            {
                                                $imageData = "<img src='Uploads/index_1.jpg' style='width:100%; height:210px;'>";
                                                $productImageData = "N/A";
                                            }
                                        }
                                        else
                                        {
                                            $imageData = "<img src='Uploads/index_1.jpg' style='width:100%; height:210px;'>";
                                            $productImageData = "N/A";
                                        }

                                        $dataImage = (strlen($productImageData) > 9) ? substr($productImageData,0,5)."..." : $productImageData;
                                        $dataDetails = (strlen($productDetails) > 60) ? substr($productDetails,0,60)."..." : $productDetails;
                                        $productNames = (strlen($productName) > 20) ? substr($productName,0,20)."..." : $productName;

                                        ?>
                                        <div class='col-md-3 w3-padding top hvr-grow'>
                                            <div class="w3-card-2">
                                                <?php echo $imageData; ?>
                                                <div class='w3-container w3-white'>
                                                    <div class='row' >
                                                        <div class='col-md-12'>
                                                            <div class='w3-padding-top'></div>
                                                            <label title='<?php echo $productName; ?>' class='w3-small w3-hover-text-blue prodDetails' data-id='<?php echo $productId; ?>' style='cursor:pointer;'><?php echo $productNames; ?></label>
                                                        </div>
                                                       <!--  <div class='col-md-6'>
                                                            <div class='w3-right w3-padding'>
                                                                <label>ID : <?php echo $productId; ?></label><br>
                                                                <label style='cursor:pointer;' title='<?php echo $productImageData; ?>'>IMG : <?php echo $dataImage; ?></label>
                                                            </div>
                                                        </div> -->
                                                    </div>
                                                    <div class='w3-padding-top'></div>
                                                    <div class='row'>
                                                        <div class='col-md-12' style="height: 100px;">
                                                            <p>CATEGORY : <b><?php echo explode("/",$folder)[0]; ?></b></p>
                                                            <?php
                                                            if($categoryId != 5)
                                                            {
                                                            ?>
                                                                <p class='<?php echo $stockColor; ?>'>STOCK : <b><?php echo $stock; ?></b></p>
                                                            <?php
                                                            }
                                                            ?>
                                                            <p><?php echo $dataDetails; ?></p>
                                                        </div>
                                                    </div>
                                                    <div class='row'>
                                                        <div class='col-md-12'>
                                                            <div class='w3-right w3-padding-bottom'>
                                                                <?php
                                                                if($categoryId != 5)
                                                                {
                                                                ?>
                                                                    <button class='w3-btn w3-black w3-tiny w3-round updateProduct' id='updateProduct' data-id='<?php echo $productId; ?>'><i class='fa fa-edit'></i> <b>UPDATE</b></button>
                                                                <?php
                                                                }
                                                                ?>
                                                                <button class='w3-btn w3-black w3-tiny w3-round deleteProduct' id='deleteProduct' data-id='<?php echo $productId; ?>'><i class='fa fa-remove'></i> <b>DELETE</b></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                            <div class='row w3-padding-top'>
                                <div class='col-md-12'>
                                    <div class=''>
                                        <form id='formPaginationPrev' method='POST' action='<?php echo $_SERVER['PHP_SELF'];?>'></form>
                                        <input form='formPaginationPrev' type='hidden' name='categoryId' value='<?php echo $categoryData; ?>'>
                                        <input form='formPaginationPrev' type='hidden' name='start' value='<?php echo $start; ?>'>
                                        <input form='formPaginationPrev' type='hidden' name='page' value='<?php echo $page; ?>'>

                                        <form id='formPaginationNext' method='POST' action='<?php echo $_SERVER['PHP_SELF'];?>'></form>
                                        <input form='formPaginationNext' type='hidden' name='categoryId' value='<?php echo $categoryData; ?>'>
                                        <input form='formPaginationNext' type='hidden' name='start' value='<?php echo $start; ?>'>
                                        <input form='formPaginationNext' type='hidden' name='page' value='<?php echo $page; ?>'>
                                        <?php
                                        $sql = "SELECT * FROM productinformation WHERE productStatus = 1 ".$queryAdd;
                                        $queryProducts = $db->query($sql);
                                        $totalRecords = $queryProducts->num_rows;
                                        $totalPage = ceil($totalRecords / 6); 

                                        $disabledPrev = "disabled";
                                        if( $start > 0)
                                        {
                                            $disabledPrev = "";
                                        }

                                        $disabledNext = "";
                                        if($page == $totalPage)
                                        {
                                            $disabledNext = "disabled";
                                        }
                                        ?>
                                        <label>PAGE <?php echo $page." OF ".$totalPage; ?></label>&emsp;
                                        <button <?php echo $disabledPrev; ?> form='formPaginationPrev' class='w3-btn w3-black w3-tiny w3-round' value='<?php echo $prevPage; ?>' name='prevPage'><i class='fa fa-backward'></i>&emsp;<b>PREV</b></button>
                                        <button <?php echo $disabledNext; ?> form='formPaginationNext' class='w3-btn w3-black w3-tiny w3-round' value='<?php echo $nextPage; ?>' name='nextPage'><b>NEXT</b>&emsp;<i class='fa fa-forward'></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id='modal-izi'><span class='izimodal-content'></span></div>
    <div id='modal-izi-update'><span class='izimodal-content-update'></span></div>
    <div id='modal-izi-add'><span class='izimodal-content-add'></span></div>
    <div id='modal-izi-admin'><span class='izimodal-content-admin'></span></div>
    <div id='modal-izi-updateuser'><span class='izimodal-content-updateuser'></span></div>
</body>
</html>
<script src="Include Files/Javascript/jQuery 3.1.1/jquery-3.1.1.js"></script>
<script src="Include Files/Javascript/jQuery 3.1.1/jquery-ui.js"></script>
<script src="Include Files/Javascript/jQuery 3.1.1/bootstrap.min.js"></script>
<link rel="stylesheet" href="Include Files/Javascript/iziModal-master/css/iziModal.css" />
<script src="Include Files/Javascript/iziModal-master/js/iziModal.js"></script>
<link rel="stylesheet" href="Include Files/Javascript/iziToast-master/dist/css/iziToast.css" />
<script src="Include Files/Javascript/iziToast-master/dist/js/iziToast.js"></script>
<script>
$(document).ready(function(){
    $("#addProducts").click(function(){
        $("#modal-izi-add").iziModal({
            title           		: '<i class=""></i> ADD PRODUCTS',
            headerColor       		: 'grey',
            // headerColor       		: '#009688',
            subtitle        		: '<b><?php echo strtoupper(date('F d, Y'));?></b>',
            width           		: 600,
            fullscreen        		: true,
            transitionIn      		: 'comingIn',
            transitionOut       	: 'comingOut',
            padding         		: 20,
            radius          		: 0,
            restoreDefaultContent   : true,
            closeOnEscape       	: true,
            closeButton       		: true,
            overlayClose      		: false,
            onOpening         		: function(modal){
                                        modal.startLoading();
                                        // setTimeout(function(){
                                        $.post( "addProducts.php", function( data ) {
                                            $( ".izimodal-content-add" ).html(data);
                                            modal.stopLoading();
                                        });
                                        // }, 500);
                                    },
            onClosed                : function(){
                                        $("#modal-izi-add").iziModal("destroy");
                                    }
        });

        $("#modal-izi-add").iziModal("open");
    });

    $(".deleteProduct").click(function(){
        var productId = $(this).attr("data-id");
        var res = confirm("Are you sure?");
        if(res)
        {
            $.ajax({
                url     : 'deleteProductsAJAX.php',
                type    : 'POST',
                data    : {
                    productId : productId
                },
                success : function(data){
                            // $(this).parent().parent().remove();
                            location.reload();
                }
            });
        }
    });

    $(".updateProduct").click(function(){
        var productId = $(this).attr("data-id");
        $("#modal-izi-update").iziModal({
            title           		: '<i class=""></i> UPDATE PRODUCTS',
            headerColor       		: 'grey',
            // headerColor       		: '#009688',
            subtitle        		: '<b><?php echo strtoupper(date('F d, Y'));?></b>',
            width           		: 600,
            fullscreen        		: true,
            transitionIn      		: 'comingIn',
            transitionOut       	: 'comingOut',
            padding         		: 20,
            radius          		: 0,
            restoreDefaultContent   : true,
            closeOnEscape       	: true,
            closeButton       		: true,
            overlayClose      		: false,
            onOpening         		: function(modal){
                                        modal.startLoading();
                                        // setTimeout(function(){
                                        $.post( "updateProducts.php?productId="+productId, function( data ) {
                                            $( ".izimodal-content-update" ).html(data);
                                            modal.stopLoading();
                                        });
                                        // }, 500);
                                    },
            onClosed                : function(){
                                        $("#modal-izi-update").iziModal("destroy");
                                    }
        });

        $("#modal-izi-update").iziModal("open");
    });

    $(".prodDetails").click(function(){
    	var productId = $(this).attr("data-id");
    	// alert(flavorId);
    	$("#modal-izi").iziModal({
            width                   : 300,
            fullscreen              : false,
            transitionIn            : 'comingIn',
            transitionOut           : 'comingOut',
            padding                 : 0,
            radius                  : 0,
            restoreDefaultContent   : true,
            closeOnEscape           : true,
            closeButton             : true,
            overlayClose            : false,
            overlay            		: false,
            onOpening               : function(modal){
                                        modal.startLoading();
                                        // setTimeout(function(){
                                        $.post( "viewProduct.php?productId="+productId, function( data ) {
                                            $( ".izimodal-content" ).html(data);
                                            modal.stopLoading();
                                        });
                                        // }, 500);
                        			},
            onClosed               : function(){
            							$("#modal-izi").iziModal("destroy");
            						}
        });

        $("#modal-izi").iziModal("open");
    	return false;
    });
});
</script>