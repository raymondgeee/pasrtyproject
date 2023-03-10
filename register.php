<?php
$path = $_SERVER['DOCUMENT_ROOT']."/";
set_include_path($path);
include('Modules/mysqliConnectionStart.php');
$admin = isset($_GET['admin']) ? $_GET['admin'] : "";
?>
<form id='createAccountForm' method='POST' action=''  autocomplete="off"></form>
<div class='container-fluid'>
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
                </div>
            </div>
        </div>
    </div>
</div>
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
        var admin = "<?php echo $admin; ?>";
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