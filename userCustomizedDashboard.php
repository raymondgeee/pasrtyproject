<?php
$path = $_SERVER['DOCUMENT_ROOT']."/";
set_include_path($path);
include('Modules/mysqliConnection.php');

$fullName = $_SESSION['userId']."-User";
$picture = $address = $contactNumber = $email = "N/A";
$picture = "Profile Pictures/default.png";
$sql = "SELECT * FROM userinformation WHERE userId = ".$_SESSION['userId'];
$queryUserInfo = $db->query($sql);
if($queryUserInfo AND $queryUserInfo->num_rows > 0)
{
    $resultUserInfo = $queryUserInfo->fetch_assoc();
    $firstName = $resultUserInfo['firstName'];
    $surName = $resultUserInfo['surName'];
    $address = $resultUserInfo['address'];
    $email = $resultUserInfo['email'];
    $contactNumber = $resultUserInfo['contactNumber'];
    $profilePicture = $resultUserInfo['profilePicture'];

    $targetPath = "Profile Pictures/".$profilePicture;

    $picture = "Profile Pictures/default.png";
    if(file_exists($targetPath) AND $profilePicture != "")
    {
        $picture = $targetPath;
    }

    $fullName = $firstName." ".$surName;
}

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
</head>
<body>
    <div class="container-fluid">
        <?php include "userHeader.php";?>
        <!-- <div class="row w3-padding">
            <div class="col-md-12">
                <?php include "userNavi.php";?>
            </div>
        </div> -->
        <div class="row">
            <div class="col-md-3 w3-padding-top">
                <div class="w3-card-2">
                    <div class="w3-container w3-padding w3-white" style="height: 608px">
                        <div class="w3-center w3-padding-top">
                            <img src="<?php echo $picture; ?>" class="w3-tiny w3-circle w3-card-2" style="width: 100px; height: 100px;">
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
                        <hr>
                        <div class="w3-center w3-padding-top">
                            <label>CART SUMMARY INFORMATION</label>
                        </div>
                        <div class="w3-padding-top">
                            <table class='table table-striped table-condensed'>
                                <thead class="w3-black">
                                    <th class='w3-center'>NAME</th>
                                    <th class='w3-center'>PRICE</th>
                                    <th class='w3-center'><i class='fa fa-trash'></i></th>
                                </thead>
                                <tbody>
                                    <?php
                                    $priceArray = Array();
                                    $sql = "SELECT * FROM productorders WHERE userId = '".$_SESSION['userId']."' AND orderStatus = 0";
                                    $queryCart = $db->query($sql);
                                    if($queryCart AND $queryCart->num_rows > 0)
                                    {
                                        while ($resultCart = $queryCart->fetch_assoc()) 
                                        {
                                            $orderId = $resultCart['orderId'];
                                            $productId = $resultCart['productId'];
                                            $quantity = $resultCart['quantity'];

                                            $sql = "SELECT * FROM productinformation WHERE productId = ".$productId;
                                            $queryOrdered = $db->query($sql);
                                            if($queryOrdered AND $queryOrdered->num_rows > 0)
                                            {
                                                $resultOrdered = $queryOrdered->fetch_assoc();
                                                $productOrderName = $resultOrdered['productName'];
                                                $productOrderPrice = $resultOrdered['productPrice'];
                                            }

                                            $price = $productOrderPrice * $quantity;
                                            $priceArray[] = $price;
                                            echo "<tr>";
                                                echo "<td class=''><b>(".$quantity.") ".$productOrderName."</b></td>";
                                                echo "<td class='w3-center'>".number_format($price,2)."</td>";
                                                echo "<td class='w3-center'><i style='cursor:pointer;' id='removeCart".$orderId."' data-id=".$orderId." class='w3-text-red fa fa-remove removeCart'></td>";
                                            echo "</tr>";
                                        }
                                    }
                                    else
                                    {
                                        echo "<tr>";
                                            echo "<td colspan='3' class='w3-center'><b>EMPTY CART...</b></td>";
                                        echo "</tr>"; 
                                    }

                                    $totalPrice = "N/A";
                                    if($priceArray != NULL)
                                    {
                                        $totalPrice =  number_format(array_sum($priceArray),2);
                                    }

                                    $disableBtn = "";
                                    if($totalPrice == "N/A") $disableBtn = "disabled";
                                    ?>
                                </tbody>
                                <tfoot class='w3-black'>
                                    <th></th>
                                    <th>TOTAL : <span id="totalPrice"><?php echo $totalPrice; ?></span></th>
                                    <th></th>
                                </tfoot>
                            </table>
                            <div class="w3-center">
                                <button class="w3-btn w3-black w3-tiny w3-round reserve" <?php echo $disableBtn; ?>><i class='fa fa-star'></i> <b>ORDER NOW</b></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <?php
                    $folder = "Customized Cakes/";

                    $sql = "SELECT * FROM productinformation WHERE categoryId = 5 AND designedBy = '".$_SESSION['userId']."' ORDER BY productId ASC";
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

                            echo "<div id='modal-izi-".$productId."'><span class='izimodal-content-".$productId."'></span></div>";
                            echo "<div class='col-md-4 w3-padding-top'>";
                                echo "<div class='w3-card-2 w3-white'>";
                                    echo $imageData;
                                    echo "<div class='w3-container w3-padding'>";
                                        echo "<div class='w3-center'>";
                                            echo "<label class='w3-medium'><b>".strtoupper($productName)."</b></label>";
                                        echo "</div>";
                                        echo "<br>";
                                        echo "<label>DETAILS :</label>";
                                        echo "<p>".$productDetails."</p>";
                                        echo "<table class='table table-condensed table striped'>";
                                            echo "<thead class='w3-black'>";
                                                echo "<th class='w3-center'>LAYER</th>";
                                                echo "<th class='w3-center'>FLAVOR</th>";
                                            echo "</thead>";
                                            echo "<tbody>";
                                            $sql = "SELECT * FROM cakecustomizedinfo WHERE decorationId = 16 AND productId = ".$productId." ORDER BY layerNumber ASC";
                                            $queryCustomizedInfo = $db->query($sql);
                                            if($queryCustomizedInfo AND $queryCustomizedInfo->num_rows > 0)
                                            {
                                                while($resultCustomizedInfo = $queryCustomizedInfo->fetch_assoc())
                                                {
                                                    $layerNumber = $resultCustomizedInfo['layerNumber'];
                                                    $flavorId = $resultCustomizedInfo['flavorId'];

                                                    $sql = "SELECT * FROM cakeflavors WHERE status = 0 AND flavorId = ".$flavorId;
                                                    $queryFlavors = $db->query($sql);
                                                    if($queryFlavors AND $queryFlavors->num_rows > 0)
                                                    {
                                                        $resultFlavors = $queryFlavors->fetch_assoc();
                                                        $flavorName = $resultFlavors['flavorName'];
                                                        
                                                        echo "<tr>";
                                                            echo "<td class='w3-center'>LAYER ".$layerNumber."</td>";
                                                            echo "<td class='w3-center'>".$flavorName."</td>";
                                                        echo "</tr>";
                                                    }

                                                }
                                            }
                                            echo "</tbody>";
                                        echo "</table>";

                                        echo "<label class='w3-medium'>PRICE : ".number_format($productPrice, 2)." PHP</label>";
                                        echo "<br>";
                                        echo "<br>";
                                        echo "<div class='w3-right'>";
                                            echo "<button data-id=".$productId." class='w3-btn w3-tiny w3-round w3-black addToCart'><i class='fa fa-plus'></i>&emsp;<b>ADD TO CART</b></button>&nbsp;";
                                            echo "<button data-id=".$productId." class='w3-btn w3-tiny w3-round w3-black removeCustom'><i class='fa fa-remove'></i>&emsp;<b>DELETE</b></button>";
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
                        <i class="fa fa-facebook w3-padding w3-round w3-black"></i>
                        <i class="fa fa-twitter w3-padding w3-round w3-black"></i>
                        <i class="fa fa-instagram w3-padding w3-round w3-black"></i>
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
        var categoryId = 5;
        $("#modal-izi-"+productId).iziModal({
            title                   : '<i class=""></i> ADD TO CART',
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

    $(".removeCart").click(function(){
        var orderId = $(this).attr("data-id");
        $.ajax({
            url     : "removeFromCart.php",
            type    : "POST",
            data    : {
                        orderId : orderId
            },
            success : function(data){
                    $("#removeCart"+orderId).parent().parent().remove();
                    $("#totalPrice").html(data);
                    if(data == "N/A")
                    {
                        $(".reserve").attr("disabled", true);
                    }
            }
        });
    });

    $(".removeCustom").click(function(){
        var productId = $(this).attr("data-id");
        $.ajax({
            url     : "removeCustomized.php",
            type    : "POST",
            data    : {
                        productId : productId
            },
            success : function(data){
                    location.reload();
            }
        });
    });

    $(".reserve").click(function(){
        var userId = "<?php echo $_SESSION['userId'];?>";
        swal({
            title: 'Order Now',
            text: 'Are you sure want to order this cake?',
            type: 'info',
            showCancelButton: true,
            confirmButtonText: 'YES',
            cancelButtonText: 'NO'
        }).then(function(){
            $.ajax({
                url     : "reserve.php",
                type    : "POST",
                data    : {
                            userId : userId
                },
                success : function(data){
                            if(data == "temp")
                            {
                                location.href = "signup.php";
                            }
                            else
                            {
                                location.href = "orderSummary.php";
                            }
                }
            });							
        }, function (dismiss) {
                // dismiss can be 'cancel', 'overlay', 'close', 'timer'
            if (dismiss === 'cancel') 
            {
                // swal.close();
            }
        });
    });
});
</script>