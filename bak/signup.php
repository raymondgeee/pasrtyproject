<?php
$path = $_SERVER['DOCUMENT_ROOT']."/";
set_include_path($path);
include('Modules/mysqliConnection.php');

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
            <div class="col-md-9 w3-padding-top">
                <div class="w3-card-2">
                    <div class="w3-container w3-padding w3-white" style="height: 608px">
                        <div class='w3-padding-top'></div>
                        <div class='w3-padding-top'></div>
                        <div class='row'>
                            <div class='col-md-12'>
                                <div class='w3-container'>
                                    <label class='w3-xlarge'>REGISTRATION FORM</label>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-md-6'>
                                <div class='w3-container'>
                                    <label class=""><b>FIRST NAME</b></label>
                                    <input form='createAccountForm' class="w3-input w3-border" id='userFirstName' name='userFirstName' type="text" required>

                                    <div class='w3-padding-top'></div>
                                    <label class=""><b>LAST NAME</b></label>
                                    <input form='createAccountForm' class="w3-input w3-border" id='userLastName' name='userLastName' type="text" required>
                                    
                                    <div class='w3-padding-top'></div>
                                    <label class=""><b>GENDER</b></label>
                                    <select form='createAccountForm' class="w3-select w3-border" id='userGender' name='userGender' type="combobox" required>
                                        <option value="">Choose your option</option>
                                        <option value="1">MALE</option>
                                        <option value="2">FEMALE</option>
                                    </select>
                                    
                                    <div class='w3-padding-top'></div>
                                    <label class=""><b>COMPLETE ADDRESS</b></label>
                                    <input form='createAccountForm' class="w3-input w3-border" id='userAddress' name='userAddress' type="text" required>
                                    
                                    <div class='w3-padding-top'></div>
                                    <label class=""><b>CONTACT NUMBER</b></label>
                                    <input form='createAccountForm' class="w3-input w3-border" id='userContactNumber' name='userContactNumber' type="number" min=0 step=1 required>
                                </div>
                            </div>
                            <div class='col-md-6'>
                                <div class='w3-container'>
                                    <label class=""><b>CREATE USERNAME</b></label>
                                    <input form='createAccountForm' class="w3-input w3-border" id='createUserName' name='createUserName' type="text" required>

                                    <div class='w3-padding-top'></div>
                                    <label class=""><b>CREATE PASSWORD</b></label>
                                    <input form='createAccountForm' class="w3-input w3-border" id='createPassword' name='createPassword' type="password" required>
                                    
                                    <div class='w3-padding-top'></div>
                                    <label class=""><b>CONFIRM PASSWORD</b></label>
                                    <input form='createAccountForm' class="w3-input w3-border" id='confirmPassword' name='confirmPassword' type="password" required>
                                    
                                    <div class='w3-padding-top'></div>
                                    <div class='w3-right'>
                                        <button class='w3-btn w3-round w3-black' id='createAccountBtn'><i class='fa fa-send-o'></i>&emsp;<b>CREATE ACCOUNT</b></button>
                                        <!-- &emsp;<b>OR</b>&emsp;
                                        <button class='w3-btn w3-round w3-black' id='createAccountBtn'><i class='fa fa-send-o'></i>&emsp;<b>LOG IN MY ACCOUNT</b></button> -->
                                    </div>
                                </div>
                            </div>
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
<script>
function openBalloon(id)
{
    $(id).showBalloon({
        html 		: true, 
        position	: 'right',
        contents	: '<span style="font-size:12px; color:white;">This Field is requred!</span>'
    });
    
    setTimeout(function(){
        $(id).hideBalloon();
    },1500);

    $(id).focus();
}

function openBalloonMismatched(id)
{
    $(id).showBalloon({
        html 		: true, 
        position	: 'right',
        contents	: '<span style="font-size:12px; color:white;">Password not match!</span>'
    });
    
    setTimeout(function(){
        $(id).hideBalloon();
    },1500);

    $(id).focus();
}

function openBalloonUserCheck(id)
{
    $(id).showBalloon({
        html 		: true, 
        position	: 'right',
        contents	: '<span style="font-size:12px; color:white;">Username already exists try another one.</span>'
    });
    
    setTimeout(function(){
        $(id).hideBalloon();
    },1500);

    $(id).focus();
}

function openBalloonPass(id)
{
    $(id).showBalloon({
        html 		: true, 
        position	: 'right',
        contents	: '<span style="font-size:12px; color:white;">Password atleast 8 characters!</span>'
    });
    
    setTimeout(function(){
        $(id).hideBalloon();
    },1500);

    $(id).focus();
}

function openBalloonContact(id)
{
    $(id).showBalloon({
        html 		: true, 
        position	: 'right',
        contents	: '<span style="font-size:12px; color:white;">11-Digit for Contact Number</span>'
    });
    
    setTimeout(function(){
        $(id).hideBalloon();
    },1500);

    $(id).focus();
}

$(document).ready(function(){
    $('input').on('keypress', function (event) {
        var regex = new RegExp("^[a-zA-Z0-9/.,-]+$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
        event.preventDefault();
        return false;
        }
    });

    $('input').on('paste', function (event) {
        return false;
    });
    
    $("#createAccountBtn").click(function(){
        var confirmPassword = $("#confirmPassword").val();
        var createPassword = $("#createPassword").val();
        var userFirstName = $("#userFirstName").val();
        var userLastName = $("#userLastName").val();
        var userGender = $("#userGender").val();
        var userAddress = $("#userAddress").val();
        var userContactNumber = $("#userContactNumber").val();
        var createUserName = $("#createUserName").val();
        var admin = 0;
        var counterChar = createPassword.length;
        var counterContact = userContactNumber.length;
        
        if($.trim(userFirstName) == "") openBalloon("#userFirstName");
        else if($.trim(userLastName) == "") openBalloon("#userLastName");
        else if($.trim(userGender) == "") openBalloon("#userGender");
        else if($.trim(userAddress) == "") openBalloon("#userAddress");
        else if($.trim(userContactNumber) == "") openBalloon("#userContactNumber");
        else if($.trim(createUserName) == "") openBalloon("#createUserName");
        else if($.trim(createPassword) == "") openBalloon("#createPassword");
        else 
        {
            if($.trim(createPassword) != "" && $.trim(confirmPassword) != $.trim(createPassword))
            {
                openBalloonMismatched("#confirmPassword");
                return false;
            }
            else if(counterContact < 11 || counterContact > 11)  
            {
                openBalloonContact("#userContactNumber");   
                return false;
            }
            else if(counterChar < 8)  
            {
                openBalloonPass("#createPassword");   
                return false;
            }
            else
            {
                $.ajax({
                    url     : 'checkUser.php',
                    type    : 'POST',
                    data    : {
                                createUserName : createUserName
                    },
                    success : function(data){
                            if(data == "true")
                            {
                                openBalloonUserCheck("#createUserName");
                            }
                            else
                            {
                                $.ajax({
                                    url     : 'insertUser.php',
                                    type    : 'POST',
                                    data    : {
                                                createUserName : createUserName,
                                                createPassword : createPassword,
                                                userFirstName : userFirstName,
                                                userLastName : userLastName,
                                                userGender : userGender,
                                                userAddress : userAddress,
                                                userContactNumber : userContactNumber,
                                                admin : admin
                                    },
                                    success : function(data){
                                        iziToast.success({
                                            title: 'Success!',
                                            message: 'REGISTERED',
                                            close: true,
                                            overlay: true,
                                            position: 'center',
                                            timeout: 3000,
                                            onClosed: function () {
                                                location.reload();
                                            },
                                            onClosing: function () {
                                                location.reload(); 
                                            }
                                        });
                                    }
                                });
                            }
                    }
                });
            }
        }
    });

    $("#createUserName").blur(function(){
        var createUserName = $(this).val();
        if($.trim(createUserName) != "")
        {
            $.ajax({
                url     : 'checkUser.php',
                type    : 'POST',
                data    : {
                            createUserName : createUserName
                },
                success : function(data){
                        if(data == "true")
                        {
                            $("#createUserName").addClass("w3-pale-red");
                            openBalloonUserCheck("#createUserName");
                        }
                        else
                        {
                            $("#createUserName").removeClass("w3-pale-red");
                        }
                }
            });
        }
    });

    $("#userContactNumber").keypress(function(){
        var userContactNumber = $(this).val();
        var counterContact = userContactNumber.length;

        if(counterContact > 10)
        {
            return false;
        }
    });
});
</script>