<?php
$path = $_SERVER['DOCUMENT_ROOT']."/";
set_include_path($path);
include('Modules/mysqliConnection.php');

$logo = glob("Custom/Logos/logo.*");
$logoData = "Custom/Logos/defaultLogo.png";

if(count($logo) > 0)
if(file_exists($logo[0]))
{
    $logoData = $logo[0];
}

$nocahce = filemtime($logoData);
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
    <div class='container'>
        <div class='w3-padding-48'></div>
        <div class='row w3-padding-top'>
            <div class='col-md-3'>
                <!-- <div class='w3-border w3-round w3-card-2 w3-white' style='height:500px;'> -->
                <!-- </div> -->
            </div>
            <div class='col-md-6'>
                <div style='height:10px;'></div>
                <div class='w3-card-8 w3-round w3-white'>
                    <div class="w3-container w3-padding w3-black">
                        <div class='w3-center'>
                            <img src='<?php echo $logoData."?".$nocahce; ?>' class='' style='width:30%; '>
                        </div>
                        <!-- <label class='w3-large'><i class='fa fa-lock'></i> Sign In</label> -->
                    </div>
                    <div class="w3-container w3-white w3-padding">
                        <div class='w3-padding'>
                            <label class='w3-large'><i class='fa fa-lock'></i> Sign In</label>
                            <input type='text' id='userName' name='userName' class='w3-card-2 w3-input w3-border w3-medium w3-sand' placeholder='Username'>
                        </div>
                        <div class='w3-padding'></div>
                        <div class='w3-padding'>
                            <input type='password' id='userPassword' name='userPassword' class='w3-card-2 w3-input w3-border w3-medium w3-sand' placeholder='Password'>
                        </div>
                        <div class='w3-padding w3-right'>
                            <button class='w3-btn w3-medium w3-round w3-black' id='signIn'><i class='fa fa-send-o'></i>&emsp;<b>LOG IN<b></button>
                            &nbsp;<b>OR</b>&nbsp;
                            <button class='w3-btn w3-medium w3-round w3-black' id='register'><i class='fa fa-copy'></i>&emsp;<b>SIGN UP<b></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id='modal-izi'><span class='izimodal-content'></span></div>
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
    $("#register").click(function(){
        $("#modal-izi").iziModal({
            title           		: '<i class=""></i> REGISTRATION',
            // headerColor       		: '#795548',
            headerColor       		: 'grey',
            subtitle        		: '<b><?php echo strtoupper(date('F d, Y'));?></b>',
            width           		: 900,
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
                                        $.post( "register.php", function( data ) {
                                            $( ".izimodal-content" ).html(data);
                                            modal.stopLoading();
                                        });
                                        // }, 500);
                                    },
            onClosed                : function(){
                                        $("#modal-izi").iziModal("destroy");
                                    }
        });
        $("#modal-izi").iziModal("open");
    });

    $("#signIn").click(function(){
        var userName = $("#userName").val();
        var userPassword = $("#userPassword").val();
        $.ajax({
            url     : 'accountCheck.php',
            type    : 'POST',
            data    : {
                        userName        : userName,
                        userPassword    : userPassword
            },
            success : function(data){
                        if(data == "true")
                        {
                            location.href = "maindashboard.php";
                            // alert("customer");
                        }
                        else if(data == "admin")
                        {
                            location.href = "dashboard.php";
                        }
                        else
                        {
                            $("#userPassword").val("");
                            
                            iziToast.error({
                                title: 'Error',
                                message: 'Invalid Username or Password. Please Try Again.',
                                close: true,
                                overlay: true,
                                position: 'center',
                                timeout: 1500
                            });
                        } 
            }
        });
    });

    $("#userPassword").keypress(function(event){
        if(event.keyCode == 13)
        {
             $("#signIn").click();
        }
    });
});
</script>