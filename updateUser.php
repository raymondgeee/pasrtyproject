<?php
$path = $_SERVER['DOCUMENT_ROOT']."/";
set_include_path($path);
include('Modules/mysqliConnection.php');

$admin = isset($_GET['admin']) ? $_GET['admin'] : "";
$userId = isset($_GET['userId']) ? $_GET['userId'] : "";

$sql = "SELECT * FROM userinformation WHERE userId = ".$userId;
$queryUser = $db->query($sql);
if($queryUser AND $queryUser->num_rows > 0)
{
    $resultUser = $queryUser->fetch_assoc();
    $userFirstName =  $resultUser['firstName'];
    $userLastName =  $resultUser['surName'];
    $userGender =  $resultUser['gender'];
    $userAddress =  $resultUser['address'];
    $userContactNumber =  $resultUser['contactNumber'];

    $genderMale = ($userGender == 1) ? "selected" : "";
    $genderFemale = ($userGender == 2) ? "selected" : "";
}

$sql = "SELECT * FROM useraccounts WHERE userId = ".$userId;
$queryAccounts = $db->query($sql);
if($queryAccounts AND $queryAccounts->num_rows > 0)
{
    $resultAccounts = $queryAccounts->fetch_assoc();
    $userName = $resultAccounts['userName'];
    $userPassword = $resultAccounts['userPassword'];
}
?>
<form id='createAccountForm' method='POST' action=''></form>
<div class='container-fluid'>
    <div class='row'>
        <div class='col-md-12'>
            <div class='w3-container'>
                <label class=""><b>FIRST NAME</b></label>
                <input form='createAccountForm' class="w3-input w3-border" value='<?php echo $userFirstName; ?>' id='userFirstName' name='userFirstName' type="text" required>

                <div class='w3-padding-top'></div>
                <label class=""><b>LAST NAME</b></label>
                <input form='createAccountForm' class="w3-input w3-border" value='<?php echo $userLastName; ?>' id='userLastName' name='userLastName' type="text" required>
                
                <div class='w3-padding-top'></div>
                <label class=""><b>GENDER</b></label>
                <select form='createAccountForm' class="w3-select w3-border" id='userGender' name='userGender' type="combobox" required>
                    <option value="">Choose your option</option>
                    <option <?php echo $genderMale; ?> value="1">MALE</option>
                    <option <?php echo $genderFemale; ?> value="2">FEMALE</option>
                </select>
                
                <div class='w3-padding-top'></div>
                <label class=""><b>COMPLETE ADDRESS</b></label>
                <input form='createAccountForm' class="w3-input w3-border" value='<?php echo $userAddress; ?>' id='userAddress' name='userAddress' type="text" required>
                
                <div class='w3-padding-top'></div>
                <label class=""><b>CONTACT NUMBER</b></label>
                <input form='createAccountForm' class="w3-input w3-border" value='<?php echo $userContactNumber; ?>' id='userContactNumber' name='userContactNumber' type="number" min=0 step=1 required>

                <div class='w3-padding-top'></div>
                <div class='w3-right'>
                    <button class='w3-btn w3-round w3-black' id='updateAccountBtn'><i class='fa fa-send-o'></i>&emsp;<b>UPDATE INFO</b></button>
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

$(document).ready(function(){
    $("#updateAccountBtn").click(function(){
        var userFirstName = $("#userFirstName").val();
        var userLastName = $("#userLastName").val();
        var userGender = $("#userGender").val();
        var userAddress = $("#userAddress").val();
        var userContactNumber = $("#userContactNumber").val();
        var userId = "<?php echo $userId; ?>";
        
        if($.trim(userFirstName) == "") openBalloon("#userFirstName");
        else if($.trim(userLastName) == "") openBalloon("#userLastName");
        else if($.trim(userGender) == "") openBalloon("#userGender");
        else if($.trim(userAddress) == "") openBalloon("#userAddress");
        else if($.trim(userContactNumber) == "") openBalloon("#userContactNumber");
        else 
        {
            $.ajax({
                url     : 'updatetUserAJAX.php',
                type    : 'POST',
                data    : {
                            userId : userId,
                            userFirstName : userFirstName,
                            userLastName : userLastName,
                            userGender : userGender,
                            userAddress : userAddress,
                            userContactNumber : userContactNumber
                },
                success : function(data){
                    location.reload();
                }
            });
        }
    });
});
</script>