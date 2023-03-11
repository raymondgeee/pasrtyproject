<?php
$notificationCount = 0;
$badge = "";
$sql = "SELECT * FROM productverification WHERE verificationStatus = 0 AND paymentImage != ''";
$queryCount = $db->query($sql);
$notificationCount = $queryCount->num_rows; 

$dateNow = date("Y-m-d");
$countDelivered = 0;
$batchNumberArray = Array ();
$sql = "SELECT orderDate, batchNumber, deliveryDate, orderStatus, batchNumber, userId FROM productorders WHERE orderStatus IN (1,3) GROUP BY batchNumber";
$queryOrders = $db->query($sql);
if($queryOrders AND $queryOrders->num_rows > 0)
{
    while($resultOrders = $queryOrders->fetch_assoc())
    {
        $deliveryDate = $resultOrders['deliveryDate'];
        $orderStatus = $resultOrders['orderStatus'];
        $batchNumberData = $resultOrders['batchNumber'];
        $userId = $resultOrders['userId'];
        
        if($orderStatus == 3)
        {
            if($deliveryDate <= $dateNow)
            {
                $countDelivered++;
            }
        }
        else if(in_array($orderStatus, Array (1)))
        {
            $orderDate = date("Y-m-d", strtotime("+7 Days ".$resultOrders['orderDate']));
            if($dateNow > $orderDate)
            {
                $batchNumberArray[] = $batchNumberData;
                $userIdArray[$batchNumberData] = $userId;
            }
        }
    }
}

if($batchNumberArray != NULL)
{   
    foreach($batchNumberArray AS $key)
    {
        $sql = "UPDATE productorders SET orderStatus = 4 WHERE batchNumber = '".$key."'";
        $queryUpdate = $db->query($sql);

       $sql = "INSERT INTO `usernotification`(
                    `userId`, 
                    `notificationDetails`, 
                    `notificationKey`,
                    `notificationRemarks`,
                    `notificationDate`
                ) 
            VALUES ( 
                    ".$userIdArray[$key].",
                    'Order/s has been denied',
                    '".$key."',
                    'Due to down payment failure.',
                    now()
                )";
        $queryInsert = $db->query($sql);
    }
}

$notificationCounter = 0;
$notificationCounter = $notificationCount + $countDelivered;

if($notificationCounter > 0)
{
    $badge = "<span style='position:absolute; top:-8px; left:100px;' class='badge w3-pink w3-tiny'>".$notificationCounter."</span>";
}

$activeColorProd = "w3-black";
$activeColorSett = "w3-black";
$activeColorSumm = "w3-black";
$activeColorCust = "w3-black";

if($activeButtonProd == "true") $activeColorProd = "w3-dark-grey";
if($activeButtonSett == "true") $activeColorSett = "w3-dark-grey";
if($activeButtonSumm == "true") $activeColorSumm = "w3-dark-grey";
if($activeButtonCust == "true") $activeColorCust = "w3-dark-grey";
?>
<div class='col-md-12'>
    <div class='w3-right'>
        <!-- <a href="#"><button class='w3-btn w3-round w3-black w3-tiny'><i class='fa fa-user'></i> <b>USERS LIST</b></button></a> -->
        <a href="dashboard.php"><button class='w3-btn w3-round <?php echo $activeColorProd; ?> w3-tiny'><i class='fa fa-globe'></i>&emsp;<b>VIEW PRODUCTS</b></button></a>
        <div class="w3-dropdown-hover">
            <button type="button" class="w3-btn w3-round w3-black w3-tiny">
                <i class='fa fa-bell'></i> &emsp;
                <b>NOTIFICATIONS</b>
                <span class="sr-only">unread messages</span>
            </button><?php echo $badge; ?>
            <div class="w3-dropdown-content w3-bar-block w3-border">
                <a href="#" class="w3-bar-item w3-button viewNotification"><b>(<?php echo $notificationCount; ?>)&emsp;Review Orders</b></a>
                <a href="#" class="w3-bar-item w3-button deliveredItems"><b>(<?php echo $countDelivered; ?>)&emsp;For Pick-Up Items</b></a>
            </div>
        </div>
        <a href="customizationSettings.php"><button class='w3-btn w3-round <?php echo $activeColorCust; ?> w3-tiny'><i class='fa fa-cogs'></i>&emsp;<b>CUSTOMIZATION SETTINGS</b></button></a>
        <a href="settings.php"><button class='w3-btn w3-round <?php echo $activeColorSett; ?> w3-tiny'><i class='fa fa-cog'></i>&emsp;<b>SETTINGS</b></button></a>
        <a href="summary.php"><button class='w3-btn w3-round <?php echo $activeColorSumm; ?> w3-tiny'><i class='fa fa-list'></i>&emsp;<b>ORDER SUMMARY</b></button></a>
        <a href="login.php"><button class="w3-btn w3-tiny w3-round w3-black"><i class="fa fa-sign-out"></i>&emsp;<b>LOGOUT</b></button></a>
    </div>
</div>
<div id='modal-izi-notification'><span class='izimodal-content-notification'></span></div>
<div id='modal-izi-delivered'><span class='izimodal-content-delivered'></span></div>
<script src="Include Files/Javascript/jQuery 3.1.1/jquery-3.1.1.js"></script>
<script src="Include Files/Javascript/jQuery 3.1.1/jquery-ui.js"></script>
<script src="Include Files/Javascript/jQuery 3.1.1/bootstrap.min.js"></script>
<link rel="stylesheet" href="Include Files/Javascript/iziModal-master/css/iziModal.css" />
<script src="Include Files/Javascript/iziModal-master/js/iziModal.js"></script>
<link rel="stylesheet" href="Include Files/Javascript/iziToast-master/dist/css/iziToast.css" />
<script src="Include Files/Javascript/iziToast-master/dist/js/iziToast.js"></script>
<script src="Include Files/Javascript/jQuery Balloon/jquery.balloon.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $(".viewNotification").click(function(){
        var notificationCount = "<?php echo $notificationCount; ?>";
        if(notificationCount > 0)
        {
            $("#modal-izi-notification").iziModal({
                title                   : '<i class=""></i> NOTIFICATIONS',
                headerColor              : 'grey',
                // headerColor       		: '#009688',
                subtitle                : '<b><?php echo strtoupper(date('F d, Y'));?></b>',
                width                   : 600,
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
                                            $.post( "viewNotification.php", function( data ) {
                                                $( ".izimodal-content-notification" ).html(data);
                                                modal.stopLoading();
                                            });
                                            // }, 500);
                                        },
                onClosed                : function(){
                                            $("#modal-izi-notification").iziModal("destroy");
                                        }
            });

            $("#modal-izi-notification").iziModal("open");
        }
    });

    $(".deliveredItems").click(function(){
        var countDelivered = "<?php echo $countDelivered; ?>";
        if(countDelivered > 0)
        {
            $("#modal-izi-delivered").iziModal({
                title                   : '<i class=""></i> DELIVERED PRODUCTS',
                headerColor              : 'grey',
                // headerColor       		: '#009688',
                subtitle                : '<b><?php echo strtoupper(date('F d, Y'));?></b>',
                width                   : 900,
                fullscreen              : false,
                transitionIn            : 'comingIn',
                transitionOut           : 'comingOut',
                padding                 : 10,
                radius                  : 0,
                restoreDefaultContent   : true,
                closeOnEscape           : true,
                closeButton             : true,
                overlayClose            : false,
                onOpening               : function(modal){
                                            modal.startLoading();
                                            // setTimeout(function(){
                                            $.post( "delivered.php", function( data ) {
                                                $( ".izimodal-content-delivered" ).html(data);
                                                modal.stopLoading();
                                            });
                                            // }, 500);
                                        },
                onClosed                : function(){
                                            $("#modal-izi-delivered").iziModal("destroy");
                                        }
            });

            $("#modal-izi-delivered").iziModal("open");
        }
    });
});
</script>