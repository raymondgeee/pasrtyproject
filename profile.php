<?php
$path = $_SERVER['DOCUMENT_ROOT']."/";
set_include_path($path);
include('Modules/mysqliConnection.php');

$userId = $_SESSION['userId'];
$userName = $_SESSION['userName'];

if(isset($_POST['updateProfile']))
{
    $firstNameData = isset($_POST['firstName']) ? $_POST['firstName'] : "";
    $surNameData = isset($_POST['surName']) ? $_POST['surName'] : "";
    $contactNumberData = isset($_POST['contactNumber']) ? $_POST['contactNumber'] : "";
    $addressData = isset($_POST['address']) ? $_POST['address'] : "";
    $emailData = isset($_POST['email']) ? $_POST['email'] : "";

    $sql = "UPDATE `userinformation` SET `firstName`    = '".$firstNameData."',
                                         `surName`      = '".$surNameData."',
                                         `address`      = '".$addressData."',
                                         `contactNumber`= '".$contactNumberData."',
                                         `email`        = '".$emailData."'
                                WHERE userId = ".$userId;
    $queryUpdate = $db->query($sql);

    header("location:".$_SERVER['PHP_SELF']);
    exit();
}

if(isset($_POST['updateAccount']))
{
    $newPassword = isset($_POST['newPassword']) ? $_POST['newPassword'] : "";
    $sql = "UPDATE `useraccounts` SET `userPassword`    = '".md5($newPassword)."'
                                    WHERE userId = ".$userId;
    $queryUpdate = $db->query($sql);

    header("location:".$_SERVER['PHP_SELF']);
    exit();
}

$sql = "SELECT * FROM userinformation WHERE userId = ".$_SESSION['userId'];
$queryUserInfo = $db->query($sql);
if($queryUserInfo AND $queryUserInfo->num_rows > 0)
{
    $resultUserInfo = $queryUserInfo->fetch_assoc();
    $firstName = $resultUserInfo['firstName'];
    $surName = $resultUserInfo['surName'];
    $address = $resultUserInfo['address'];
    $contactNumber = $resultUserInfo['contactNumber'];
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

    if($email == "")
    {
        $email = "N/A";
    }

    $nocahce = filemtime($picture);
}

$activeButtonMain = "";
$activeButtonSumm = "";
$activeButtonProf = "true";
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
    <link rel="stylesheet" href="Include Files/Custom CSS/customStyle.css">
    <link rel="stylesheet" href="Include Files/Custom CSS/styles.css">
<body>
    <div class='container-fluid'>
        <?php include "userHeader.php";?>
        <div class="row w3-padding">
            <!-- <div class="col-md-12">
                <div class="w3-right">
                    <?php include "userNavi.php";?>
                </div>
            </div> -->
        </div>
    </div>
    <div class='container'>
        <div class='row'>
            <div class='w3-container w3-card-2 w3-white' >
                <div class='w3-padding-top'></div>
                <div class='row'>
                    <div class='col-md-4 w3-center'>
                        <div class='w3-padding w3-center'>
                            <div class='w3-padding-top'></div>
                            <form id="imageUploadForm" enctype="multipart/form-data" method="POST" action="uploadImage.php?type=1"></form>
                            <input form='imageUploadForm' type="file" style="display:none;" name='profilePicture' id='profilePicture' class="btn btn-warning btn-xs">
                            <span class="w3-small pull-right" style='position:absolute; top:20px; left:257px; cursor:pointer;' id='clickUpload'><i class='w3-transparent fa fa-edit w3-large'></i></span>
                            <div id='showPicture' class=''>
                                <img src="<?php echo $picture."?".$nocahce; ?>" class='w3-border img-responsive w3-card-2' style='height:250px; width:250px;'/>
                            </div>
                        </div>
                    </div>
                    <div class='col-md-8'>
                        <div class='row'>
                            <div class='col-md-10'>
                                <div class='w3-padding-top'></div>
                                <div><b class='w3-xlarge'><?php echo strtoupper($fullName); ?></b></div>
                                <div class='w3-padding-top'></div>
                                <div>
                                    <label style='width:5%;'>
                                        <i class='fa fa-map-marker w3-large'></i>
                                    </label>
                                    <b><?php echo $address; ?></b>
                                </div>
                                <div>
                                    <label style='width:5%;'>
                                        <i class='fa fa-phone w3-large'></i>
                                    </label>
                                    <b><?php echo $contactNumber; ?></b>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='w3-padding-top'></div>
                            <div class='col-md-12'>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="tab" role="tabpanel">
                                            <ul class="nav nav-tabs" role="tablist">
                                                <li role="presentation" class="active"><a href="#Section1" aria-controls="home" role="tab" data-toggle="tab">Personal</a></li>
                                                <li role="presentation"><a href="#Section2" aria-controls="profile" role="tab" data-toggle="tab">Account</a></li>
                                                <!-- <li role="presentation"><a href="#Section3" aria-controls="messages" role="tab" data-toggle="tab">Account</a></li> -->
                                            </ul>
                                            <div class="tab-content tabs">
                                                <div role="tabpanel" class="tab-pane fade in active" id="Section1">
                                                    <!-- <h3>Section 1</h3> -->
                                                    <div class="row">
                                                        <div class='col-md-10'>
                                                            <div class='w3-right'>
                                                               <b><i class='fa fa-edit w3-large w3-text-teal' style='cursor:pointer;' id='editProfile'></i></b>&nbsp;
                                                               <b><i class='fa fa-remove w3-large w3-text-pink' style='cursor:pointer; display: none;' id='cancelProfile'></i></b>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-10">
                                                            <form id='formProfile' action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST"></form>
                                                            <table class="table table-condensed">
                                                                <tr>
                                                                    <td style="vertical-align: middle;"><label>First Name</label></td>
                                                                    <td style="vertical-align: middle;">
                                                                        <label class='labelText'><?php echo $firstName; ?></label> 
                                                                        <input form='formProfile' type='text' name='firstName' class="w3-input w3-border editInput" value="<?php echo $firstName; ?>" style="width:90%; display:none;" required>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="vertical-align: middle;"><label>Last Name</label></td>
                                                                    <td style="vertical-align: middle;">
                                                                        <label class='labelText'><?php echo $surName; ?></label>
                                                                        <input form='formProfile' type='text' name='surName' class="w3-input w3-border editInput" value="<?php echo $surName; ?>" style="width:90%; display:none;" required>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="vertical-align: middle;"><label>Phone</label></td>
                                                                    <td style="vertical-align: middle;">
                                                                        <label class='labelText'><?php echo $contactNumber; ?></label>
                                                                        <input form='formProfile' type='text' name='contactNumber' class="w3-input w3-border editInput" value="<?php echo $contactNumber; ?>" style="width:90%; display:none;" required>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="vertical-align: middle;"><label>Address</label></td>
                                                                    <td style="vertical-align: middle;">
                                                                        <label class='labelText'><?php echo $address; ?></label>
                                                                        <input form='formProfile' type='text' name='address' class="w3-input w3-border editInput" value="<?php echo $address; ?>" style="width:90%; display:none;" required>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="vertical-align: middle;"><label>Email</label></td>
                                                                    <td style="vertical-align: middle;">
                                                                        <label class='labelText'><?php echo $email; ?></label>
                                                                        <input form='formProfile' type='email' name='email' class="w3-input w3-border editInput" value="<?php echo $email; ?>" style="width:90%; display:none;" required>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-10">
                                                            <div class="w3-right">
                                                                <button form='formProfile' id='updateProfile' name='updateProfile' class='w3-btn w3-small input-sm w3-round w3-black editInput' style="display:none;"><i class="fa fa-send"></i>&emsp;<b>UPDATE</b></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div role="tabpanel" class="tab-pane fade" id="Section2">
                                                    <!-- <h3>Section 2</h3> -->
                                                    <div class="row">
                                                        <div class='col-md-10'>
                                                            <div class='w3-right'>
                                                               <b><i class='fa fa-edit w3-large w3-text-teal' style='cursor:pointer;' id='editAccount'></i></b>
                                                               <b><i class='fa fa-remove w3-large w3-text-pink' style='cursor:pointer; display: none;' id='cancelAccount'></i></b>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-10">
                                                            <form id='formAccount' action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST"></form>
                                                            <table class="table table-condensed">
                                                                <tr>
                                                                    <td style="vertical-align: middle;"><label>User ID</label></td>
                                                                    <td style="vertical-align: middle;">
                                                                        <label><?php echo $userId; ?></label> 
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="vertical-align: middle;"><label>User Name</label></td>
                                                                    <td style="vertical-align: middle;">
                                                                        <label><?php echo $userName; ?></label> 
                                                                    </td>
                                                                </tr>
                                                                <tr class='hiddenRow' style="display:none;">
                                                                    <td style="vertical-align: middle;"><label>Old Password</label></td>
                                                                    <td style="vertical-align: middle;">
                                                                        <input form='formAccount' type='password' name='oldPassword' id='oldPassword' class="w3-input w3-border" style="width:90%;" required>
                                                                    </td>
                                                                </tr>
                                                                <tr class='hiddenRow' style="display:none;">
                                                                    <td style="vertical-align: middle;"><label>New Password</label></td>
                                                                    <td style="vertical-align: middle;">
                                                                        <input form='formAccount' type='password' name='newPassword' class="w3-input w3-border" style="width:90%;" required>
                                                                    </td>
                                                                </tr>
                                                                <tr class='showRow'>
                                                                    <td style="vertical-align: middle;"><label>User Password</label></td>
                                                                    <td style="vertical-align: middle;">
                                                                        <label>*******</label> 
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div> 
                                                    <div class="row">
                                                        <div class="col-md-10">
                                                            <div class="w3-right">
                                                                <button form='formAccount' id='updateAccount' name='updateAccount' class='w3-btn w3-small input-sm w3-round w3-black hiddenRow' style="display:none;"><i class="fa fa-send"></i>&emsp;<b>UPDATE</b></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
<script type="text/javascript">
function openBalloon(id)
{
    $(id).showBalloon({
        html        : true, 
        position    : 'right',
        contents    : '<span style="font-size:12px; color:white;">This Field is requred!</span>'
    });
    
    setTimeout(function(){
        $(id).hideBalloon();
    },1500);

    $(id).focus();
}

$(document).ready(function(){
    $("#editProfile").click(function(){
        $(".labelText").hide();
        $(".editInput").show();
        $("#cancelProfile").show();
    });

    $("#cancelProfile").click(function(){
        $(".labelText").show();
        $(".editInput").hide();
        $("#cancelProfile").hide();
    });

    $("#editAccount").click(function(){
        $(".hiddenRow").show();
        $(".showRow").hide();
        $("#cancelAccount").show();
    });

    $("#cancelAccount").click(function(){
        $(".hiddenRow").hide();
        $(".showRow").show();
        $("#cancelAccount").hide();
    });

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

    $("#oldPassword").blur(function(){
        var userId = '<?php echo $userId; ?>';
        var oldPassword = $(this).val();
        if($.trim(oldPassword) != "")
        {
            $.ajax({
                url     : 'checkUserPassword.php',
                type    : 'POST',
                data    : {
                            userId : userId,
                            oldPassword : oldPassword
                },
                success : function(data){
                            if(data == "false")
                            {
                                $("#oldPassword").addClass("w3-pale-red");
                                $("#oldPassword").attr("placeholder","Password did not match");
                                $("#oldPassword").val("");
                                $("#oldPassword").focus();
                            }
                            else
                            {
                                $("#oldPassword").removeClass("w3-pale-red");
                                $("#oldPassword").attr("placeholder","");
                                $("#newPassword").focus();
                            }
                }
            });
        }
    });

    $("#imageUploadForm").on('submit',function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        console.log(formData);
        $.ajax({
            url             : $("#imageUploadForm").attr("action"),
            data            : formData,
            cache           : false,
            contentType     : false,
            processData     : false,
            type            : "POST",
            success         : function(data){
                                console.log(data);
                                if(data == 'exceed')
                                {
                                    iziToast.error({
                                        title: 'Error',
                                        message: 'Cant upload image. Max file size is 10mb',
                                        close: true,
                                        overlay: true,
                                        position: 'center',
                                        timeout: 1500
                                    });
                                }
                                else if(data == 'error')
                                {
                                    iziToast.error({
                                        title: 'Error',
                                        message: 'Something went wrong while uploading image. <br> Please try again if error exists try another image.',
                                        close: true,
                                        overlay: true,
                                        position: 'center',
                                        timeout: 1500
                                    });
                                }
                                else
                                {
                                    iziToast.success({
                                        title: 'Success!!',
                                        message: 'Successfully updated your Profile Picture',
                                        close: true,
                                        overlay: true,
                                        position: 'center',
                                        timeout: 1500
                                    });


                                    $("#showPicture").html(data);
                                }
                            }
        });
    });

    $("#profilePicture").on('change',function(e) {
        $("#imageUploadForm").submit();
    });
    
    $("#clickUpload").click(function(){
        $("#profilePicture").click();
    });
});
</script>