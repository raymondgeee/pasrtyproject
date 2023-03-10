<?php
$path = $_SERVER['DOCUMENT_ROOT']."/";
set_include_path($path);
include('Modules/mysqliConnection.php');
$categoryId = isset($_GET['categoryId']) ? $_GET['categoryId'] : "";

$activeButtonMain = "";
$activeButtonSumm = "";
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
    <link rel="stylesheet" href="Include Files/Bootstrap/Hover-master/css/hover.css">
</head>
<body>
    <div class="container-fluid">
        <?php include "userHeader.php";?>
        <div class="row">
            <?php include "userViewCart.php";?>
            <div class="col-md-9">
                <div class="row">
                    <?php
                    /* if($categoryId == 1) $folder = "Birthday Cakes/";
                    if($categoryId == 2) $folder = "Wedding Cakes/";
                    if($categoryId == 3) $folder = "Cup Cakes/";
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

                    $sql = "SELECT * FROM productinformation WHERE categoryId = ".$categoryId." ORDER BY productId ASC";
                    $queryCategory = $db->query($sql);
                    if($queryCategory AND $queryCategory->num_rows > 0)
                    {
                        while($resultCategory = $queryCategory->fetch_assoc())
                        {
                            $productId = $resultCategory['productId'];
                            $productName = $resultCategory['productName'];
                            $productDetails = $resultCategory['productDetails'];
                            $productPrice = $resultCategory['productPrice'];
                            $productImage = $resultCategory['productImage'];
                            $stock = $resultCategory['stock'];

                            $addCartbtn = ($stock == 0) ? "disabled" : "";

                            $outOfstock = ($stock == 0) ? "&emsp; <span class='w3-text-red'>OUT OF STOCK</span>" : "&emsp; <span class='w3-text-green'>".$stock." AVAILABLE</span>";

                            $imageData = "";
                            if($productImage != "")
                            {
                                $path = "Custom/".$folder."/".$productImage;
                                if(file_exists($path))
                                {
                                    $imageData = "<img src='".$path."' style='width:100%; height:180px;'>";
                                }
                                else
                                {
                                    $imageData = "<img src='Uploads/index_1.jpg' style='width:100%; height:180px;'>";
                                }
                            }
                            else
                            {
                                $imageData = "<img src='Uploads/index_1.jpg' style='width:100%; height:180px;'>";
                            }

                            $productNames = (strlen($productName) > 25) ? substr($productName,0,25)."..." : $productName;
                            echo "<div id='modal-izi-".$productId."'><span class='izimodal-content-".$productId."'></span></div>";
                            echo "<div class='col-md-4 w3-padding-top hvr-bob'>";
                                echo "<div class='w3-card-2'>";
                                    echo $imageData;
                                    echo "<div class='w3-container w3-padding w3-white'>";
                                        echo "<div class='w3-center'>";
                                            echo "<label title='".strtoupper($productName)."' class='w3-medium'><b>".strtoupper($productNames)."</b></label>";
                                        echo "</div>";
                                        echo "<br>";
                                        echo "<label>DETAILS : ".$outOfstock."</label>";
                                        echo "<p>".$productDetails."</p>";
                                        echo "<label class='w3-medium'>PRICE : ".number_format($productPrice,2)." PHP</label>";
                                        echo "<br>";
                                        echo "<br>";
                                        echo "<div class='w3-right'>";
                                            echo "<button ".$addCartbtn." data-id=".$productId." class='w3-btn w3-tiny w3-round w3-black addToCart'><i class='fa fa-plus'></i>&emsp;<b>ADD TO CART</b></button>";
                                        echo "</div>";
                                    echo "</div>";
                                echo "</div>";
                            echo "</div>";
                        }
                    }
                    ?>
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
    $(".addToCart").click(function(){
        var productId = $(this).attr("data-id");
        var categoryId = "<?php echo $categoryId?>";
        $("#modal-izi-"+productId).iziModal({
            title                   : '<i class=""></i> ADD TO CART',
            // headerColor       		: '#009688',
            headerColor       		: 'grey',
            subtitle                : '<b><?php echo strtoupper(date('F d, Y'));?></b>',
            width                   : 300,
            fullscreen              : true,
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
                                        $.post( "addCart.php?productId="+productId+"&categoryId="+categoryId, function( data ) {
                                            $( ".izimodal-content-"+productId ).html(data);
                                            modal.stopLoading();
                                        });
                                        // }, 500);
                        }
        });

        $("#modal-izi-"+productId).iziModal("open");
    });
});
</script>