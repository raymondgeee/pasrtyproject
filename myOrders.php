<?php
$path = $_SERVER['DOCUMENT_ROOT']."/";
set_include_path($path);
include('Modules/mysqliConnection.php');
$categoryId = isset($_GET['categoryId']) ? $_GET['categoryId'] : "";
$userId = $_SESSION['userId'];

$sql = "SELECT * FROM userinformation WHERE userId = ".$_SESSION['userId'];
$queryUserInfo = $db->query($sql);
if($queryUserInfo AND $queryUserInfo->num_rows > 0)
{
    $resultUserInfo = $queryUserInfo->fetch_assoc();
    $firstName = $resultUserInfo['firstName'];
    $surName = $resultUserInfo['surName'];
    $address = $resultUserInfo['address'];

    $fullName = $firstName." ".$surName;
}
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
        <div class="row">
            <div class="col-md-12 w3-padding-top">
                <div class="w3-container w3-padding w3-white w3-card-2">
                    <b><h3>TEST ONLY</h3></b>
                    <p>asdasdasd asdasdasd asd asda da asd ad ada da sda dasd </p>
                    <div class="w3-padding-24"></div>
                     <div class="w3-center">
                        <button class="w3-btn w3-brown w3-large w3-round"><i class=""></i> <b>RESERVE NOW</b></button>
                     </div>
                    <div class="w3-padding"></div>
                </div>
            </div>
        </div>
        <div class="row w3-padding">
            <div class="col-md-12">
                <?php include "userNavi.php";?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 w3-padding-top">
                <div class="w3-card-2">
                    <div class="w3-container w3-padding w3-white" style="height: 608px">
                        <div class="w3-center w3-padding-top">
                            <label>USER INFORMATION</label>
                            <br>
                            <img src="Profile Pictures/default.png" class="w3-tiny w3-round-xxlarge w3-card-2" style="width: 50px; height: 50px;">
                        </div>
                        <hr>
                        <div class="w3-padding-top">
                            <label><?php echo strtoupper($fullName); ?></label> 
                            <br>
                            <label><?php echo strtoupper($address); ?></label> 
                        </div>
                        <hr>
                        <div class="w3-center w3-padding-top">
                            <label>CART SUMMARY INFORMATION</label>
                        </div>
                        <div class="w3-padding-top">
                            <table class='table table-striped table-condensed'>
                                <thead class="w3-purple">
                                    <th class='w3-center'>NAME</th>
                                    <th class='w3-center'>PRICE</th>
                                    <th class='w3-center'><i class='fa fa-trash'></i></th>
                                </thead>
                                <tbody>
                                    <?php
                                    $priceArray = Array();
                                    $sql = "SELECT * FROM productorders WHERE orderStatus = 0";
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
                                <tfoot class='w3-purple'>
                                    <th></th>
                                    <th>TOTAL : <span id="totalPrice"><?php echo $totalPrice; ?></span></th>
                                    <th></th>
                                </tfoot>
                            </table>
                            <div class="w3-center">
                                <button class="w3-btn w3-tiny w3-round reserve" <?php echo $disableBtn; ?>><i class='fa fa-star'></i> <b>RESERVE</b></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="w3-padding-top"></div>
                <div class="w3-card-2">
                    <div class="w3-container w3-padding w3-white" style="height: 608px">
                        <?php 
                        $batchNumberArray = Array ();
                        $sql = "SELECT DISTINCT batchNumber FROM productorders WHERE userId = ".$userId;
                        $queryBatch = $db->query($sql);
                        if($queryBatch AND $queryBatch->num_rows > 0)
                        {
                            while ($resultBatch = $queryBatch->fetch_assoc()) 
                            {
                                $batchNumberArray[] = $resultBatch['batchNumber'];
                            }
                        }
                        echo "<table class='table table-bordered table-condensed table-striped'>";
                        foreach ($batchNumberArray as $batchId) 
                        {
                            echo "<thead class='w3-purple'>";
                                echo "<th class='text-center'>#</th>";
                                echo "<th class='text-center'>PRODUCT NAME</th>";
                                echo "<th class='text-center'>ORDER QTY</th>";
                                echo "<th class='text-center'>ORDER DATE</th>";
                                echo "<th class='text-center'>DELIVERY/PICK-UP DATE</th>";
                                echo "<th class='text-center'>ORDER STATUS</th>";
                            echo "</thead>";
                        }
                        echo "</table>";
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row w3-padding-top">
            <div class="col-md-12 w3-padding-top">
                <div class="w3-center">
                    <label><b>MADE BY <i class="fa fa-heart w3-text-red"></i> &copy; <?php echo date("Y");?></b></label>
                    <p class="w3-center">
                        <i class="fa fa-facebook w3-padding w3-round w3-indigo"></i>
                        <i class="fa fa-twitter w3-padding w3-round w3-blue"></i>
                        <i class="fa fa-instagram w3-padding w3-round w3-pink"></i>
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
<script>
$(document).ready(function(){
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

    $(".reserve").click(function(){
        var res = confirm("Are you sure?");
        var userId = "<?php echo $_SESSION['userId'];?>";
        if(res)
        {
            $.ajax({
                url     : "reserve.php",
                type    : "POST",
                data    : {
                            userId : userId
                },
                success : function(data){
                            location.href = "orderSummay.php";
                }
            });
        }
    });
});
</script>