<?php
$userId = $_SESSION['userId'];
$fullName = $_SESSION['userId']."-User";
$picture = $address = $contactNumber = $email = "N/A";
$picture = "Profile Pictures/default.png";
$sql = "SELECT * FROM userinformation WHERE userId = '".$_SESSION['userId']."'";
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
?>

<div class="col-md-3 w3-padding-top">
    <div class="w3-card-2">
        <div class="w3-container w3-padding w3-white" style="height: 608px">
            <?php
            if($fullName != "")
            {
            ?>
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
            <?php
            }
            ?>
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
                                    $categoryIdCart = $resultOrdered['categoryId'];
                                }

                                $price = $productOrderPrice * $quantity;
                                $priceArray[] = $price;
                                echo "<tr>";
                                    echo "<td class=''><b>(".$quantity.") ".$productOrderName."</b></td>";
                                    echo "<td class='w3-center'>".number_format($price,2)."</td>";
                                    echo "<td class='w3-center'><i style='cursor:pointer;' data-cat='".$categoryIdCart."' id='removeCart".$orderId."' data-id=".$orderId." class='w3-text-red fa fa-remove removeCart'></td>";
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
                    <button class="w3-btn w3-black w3-tiny w3-round reserve" <?php echo $disableBtn; ?>><i class='fa fa-star'></i>&emsp;<b>ORDER NOW</b></button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){
    $(".removeCart").click(function(){
        var orderId = $(this).attr("data-id");
        var categoryId = $(this).attr("data-cat");
        $.ajax({
            url     : "removeFromCart.php",
            type    : "POST",
            data    : {
                        orderId : orderId,
                        categoryId : categoryId
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
        var userId = "<?php echo $_SESSION['userId'];?>";
        swal({
            title: 'Order Now',
            text: 'Confirm Orders?',
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
                                location.href = "userlogin.php";
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