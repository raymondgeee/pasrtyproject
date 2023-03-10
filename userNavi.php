<?php
$notificationCount = 0;
$badge = "";
$sql = "SELECT * FROM usernotification WHERE userId = '".$_SESSION['userId']."' AND notificationStatus = 0";
$queryCount = $db->query($sql);
$notificationCount = $queryCount->num_rows; 

if($notificationCount > 0)
{
    $badge = "<span style='position:absolute; top:5px;' class='badge w3-pink w3-tiny'>".$notificationCount."</span>";
}

$temp = "";
$sql = "SELECT userId FROM userinformation WHERE userId = '".$_SESSION['userId']."'";
$queryCheck = $db->query($sql);
if($queryCheck AND $queryCheck->num_rows == 0)
{
	$temp = "temp";
}

$activeColorMain = "w3-black";
$activeColorSumm = "w3-black";
$activeColorProf = "w3-black";
$activeColorCont = "w3-black";

if($activeButtonMain == "true") $activeColorMain = "w3-dark-grey";
if($activeButtonSumm == "true") $activeColorSumm = "w3-dark-grey";
if($activeButtonProf == "true") $activeColorProf = "w3-dark-grey";
if($activeButtonCont == "true") $activeColorCont = "w3-dark-grey";
?>
<div class="" align='right'>
    <a href="maindashboard.php"><button style="width:10%;" class="w3-btn w3-tiny w3-round <?php echo $activeColorMain; ?>" title="Home"><i class="fa fa-home"></i><span class="hidden-sm hidden-xs hidden-md">&emsp;<b>HOME</b></span></button></a>
    <?php
    if($temp == "")
    {
    ?>
        <a href="orderSummary.php"><button style="width:10%;" class="w3-btn w3-tiny w3-round <?php echo $activeColorSumm; ?>" title="Orders"><i class="fa fa-file"></i><span class="hidden-sm hidden-xs hidden-md">&emsp;<b>ORDERS</b></span></button></a>
        <a href="#"><button style="width:10%;" class="w3-btn w3-tiny w3-round w3-black userNotif" title="Notification"><i class="fa fa-bell"></i><span class="hidden-sm hidden-xs hidden-md">&emsp;<b>NOTIFICATION</b></span><?php echo $badge; ?></button></a>
        <a href="profile.php"><button style="width:10%;" class="w3-btn w3-tiny w3-round <?php echo $activeColorProf; ?>" title="Profile"><i class="fa fa-user"></i><span class="hidden-sm hidden-xs hidden-md">&emsp;<b>PROFILE</b></span></button></a>
    <?php
    }
    ?>
    <a href="contact.php"><button style="width:10%;" class="w3-btn w3-tiny w3-round <?php echo $activeColorCont; ?>" title="Contact Us"><i class="fa fa-phone"></i><span class="hidden-sm hidden-xs hidden-md">&emsp;<b>CONTACT US</span></b></button></a>
    <?php
    if($temp == "")
    {
    ?>
        <a href="login.php"><button style="width:10%;" class="w3-btn w3-tiny w3-round w3-black" title="Logout"><i class="fa fa-sign-out"></i><span class="hidden-sm hidden-xs hidden-md">&emsp;<b>LOGOUT</b></span></button></a>
    <?php
    }
    else
    {
    ?>
        <a href="login.php"><button style="width:10%;" class="w3-btn w3-tiny w3-round w3-black" title="Login"><i class="fa fa-sign-in"></i><span class="hidden-sm hidden-xs hidden-md">&emsp;<b>LOGIN</b></span></button></a>
    <?php
    }
    ?>
</div>
<div id='modal-izi-usernotif'><span class='izimodal-content-usernotif'></span></div>
<script src="Include Files/Javascript/jQuery 3.1.1/jquery-3.1.1.js"></script>
<script src="Include Files/Javascript/jQuery 3.1.1/jquery-ui.js"></script>
<script src="Include Files/Javascript/jQuery 3.1.1/bootstrap.min.js"></script>
<link rel="stylesheet" href="Include Files/Javascript/iziModal-master/css/iziModal.css" />
<script src="Include Files/Javascript/iziModal-master/js/iziModal.js"></script>
<link rel="stylesheet" href="Include Files/Javascript/iziToast-master/dist/css/iziToast.css" />
<script src="Include Files/Javascript/iziToast-master/dist/js/iziToast.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $(".userNotif").click(function(){
        var notificationCount = "<?php echo $notificationCount; ?>";
        if(notificationCount > 0)
        {
            $("#modal-izi-usernotif").iziModal({
                title                   : '<i class=""></i> NOTIFICATIONS',
                // headerColor       		: '#009688',
                headerColor             : 'grey',
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
                                            $.post( "userNotification.php", function( data ) {
                                                $( ".izimodal-content-usernotif" ).html(data);
                                                modal.stopLoading();
                                            });
                                            // }, 500);
                                        },
                onClosed                : function(){
                                            $("#modal-izi-usernotif").iziModal("destroy");
                                        }
            });

            $("#modal-izi-usernotif").iziModal("open");
        }
    });
});
</script>