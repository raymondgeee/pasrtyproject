<?php
$path = $_SERVER['DOCUMENT_ROOT']."/";
set_include_path($path);
include('Modules/mysqliConnection.php');

$productId = isset($_REQUEST['productId']) ? $_REQUEST['productId'] : "";
$categoryId = isset($_REQUEST['categoryId']) ? $_REQUEST['categoryId'] : "";


if(isset($_POST['addCartBtn']))
{
	$dateNow = date("Y-m-d");
    $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : "";
    
    $sql = "SELECT orderId FROM productorders WHERE productId = ".$productId." AND userId = '".$_SESSION['userId']."' AND orderStatus = 0";
    $queryOrders = $db->query($sql);
    if($queryOrders AND $queryOrders->num_rows > 0)
    {
        $resultOrders = $queryOrders->fetch_assoc();
        $orderId = $resultOrders['orderId'];

        $sql = "UPDATE productorders SET quantity = quantity + ".$quantity." WHERE orderId = ".$orderId;
        $queryUpdate = $db->query($sql);
    }
    else
    {
        $sql = "INSERT INTO `productorders`(
                                                `productId`, 
                                                `quantity`, 
                                                `userId`, 
                                                `orderDate`
                                            ) 
                                VALUES   (	
                                                '".$productId."',
                                                '".$quantity."',
                                                '".$_SESSION['userId']."',
                                                '".$dateNow."'
                                            )";
        $queryInsert = $db->query($sql);
    }
    
    if($categoryId != 5)
    {
        $sql = "UPDATE productinformation SET stock = (stock - ".$quantity.") WHERE productId = ".$productId;
        $queryUpdate = $db->query($sql);
    }

    if($categoryId == 5)
    {
        header("location:userCustomizedDashboard.php");
    }
    else
    {
	   header("location:products.php?categoryId=".$categoryId);
    }
	exit(0);
}

$sql = "SELECT * FROM productinformation WHERE productId = ".$productId;
$queryOrdered = $db->query($sql);
if($queryOrdered AND $queryOrdered->num_rows > 0)
{
    $resultOrdered = $queryOrdered->fetch_assoc();
    $productOrderName = $resultOrdered['productName'];
    $productOrderPrice = $resultOrdered['productPrice'];
    $stock = $resultOrdered['stock'];
}
?>

<form id='addCartForm' method='POST' action='<?php echo $_SERVER['PHP_SELF'];?>'></form>
<input form='addCartForm' type="hidden" name="categoryId" value="<?php echo $categoryId; ?>">
<input form='addCartForm' type="hidden" name="productId" value="<?php echo $productId; ?>">
<div class='container-fluid'>
    <div class='row'>
        <div class='col-md-12'>
            <div class='w3-container'>
            	<div class='w3-center'>
                	<label class="w3-large"><b><?php echo strtoupper($productOrderName); ?></b></label>
                </div>
                <div class='w3-padding-top'></div>
                <label class=""><b>ORDER QUANTITY :</b></label>
                <?php
                if($categoryId == 5)
                {
                ?>
                    <input form='addCartForm' class="w3-input w3-border" id='quantity' name='quantity' type="number" value=1 min=1 step=1 required>
                <?php
                }
                else if($categoryId == 3)
                {
                ?>
                    <input form='addCartForm' class="w3-input w3-border" id='quantity' name='quantity' type="number" value=30 min=30 max="<?php echo $stock; ?>" step=1 required>
                <?php
                }
                else
                {
                ?>
                    <input form='addCartForm' class="w3-input w3-border" id='quantity' name='quantity' type="number" value=1 min=1 max="<?php echo $stock; ?>" step=1 required>
                <?php
                }
                ?>
                
                <div class='w3-padding-top'></div>
                <div class='w3-center'>
                    <button form='addCartForm' class='w3-btn w3-round w3-tiny w3-black' name='addCartBtn' id='addCartBtn'><i class='fa fa-send-o'></i>&emsp;<b>SUBMIT</b></button>
                </div>
            </div>
        </div>
    </div>
</div>