<?php
$path = $_SERVER['DOCUMENT_ROOT']."/";
set_include_path($path);
include('Modules/mysqliConnection.php');
$userId = $_SESSION['userId'];
$sql = "SELECT userId FROM useraccounts WHERE userId  = '".$userId."' AND userType = 0";
$queryCheckUser = $db->query($sql);
if($queryCheckUser AND $queryCheckUser->num_rows == 0)
{
   header("location:login.php");
   exit();
}

$activeButtonProd = "";
$activeButtonSett = "true";
$activeButtonSumm = "";
$activeButtonCust = "";
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
<body class=''>
    <div class='container-fluid'>
        <div class='row'>
            <div class="w3-container w3-black w3-card-2 w3-padding">
                <label class='w3-large'>ADMIN PANEL</label>
            </div>
        </div>
        <div class='row'>
            <div class='col-md-12 w3-padding-top'>
                <div class='w3-container w3-round w3-white w3-card-2 w3-padding'>
                    <?php include "adminNavi.php";?>
                    <div class='row'>
                        <div class='col-md-12'>
                            <hr>
                        </div>
                    </div>
                    <div class='row w3-padding-top'>
                        <div class='col-md-3'>
                            <div class='w3-center'>
                                <label class='w3-large'>FUNCTIONS</label>
                                <div class="w3-black w3-card-2">
                                    <div id='addCategory' class="w3-container w3-hover-dark-grey" style='cursor:pointer;'>
                                        <div class='w3-left w3-padding hvr-grow'>
                                            <i class='fa fa-book'></i>&emsp;
                                            <label style='cursor:pointer;'>ADD CATEGORIES</label>
                                        </div>
                                    </div>
                                    <div id='featuredProd' class="w3-container w3-hover-dark-grey" style='cursor:pointer;'>
                                        <div class='w3-left w3-padding hvr-grow'>
                                            <i class='fa fa-photo'></i>&emsp;
                                            <label style='cursor:pointer;'>UPLOAD FEATURED PRODUCTS</label>
                                        </div>
                                    </div>
                                    <div id='uploadLogo' class="w3-container w3-hover-dark-grey" style='cursor:pointer;'>
                                        <div class='w3-left w3-padding hvr-grow'>
                                            <i class='fa fa-photo'></i>&emsp;
                                            <label style='cursor:pointer;'>UPLOAD LOGO</label>
                                        </div>
                                    </div>
                                    <div id='addUsers' class="w3-container w3-hover-dark-grey" style='cursor:pointer;'>
                                        <div class='w3-left w3-padding hvr-grow'>
                                            <i class='fa fa-bookmark'></i>&emsp;
                                            <label style='cursor:pointer;'>REGISTER ADMIN</label>
                                        </div>
                                    </div>
                                    <div onclick="location.href='adminProfile.php'" class="w3-container w3-hover-dark-grey" style='cursor:pointer;'>
                                        <div class='w3-left w3-padding hvr-grow'>
                                            <i class='fa fa-user'></i>&emsp;
                                            <label style='cursor:pointer;'>MY PROFILE</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class='col-md-9'>
                            <div class='row'>
                                <div class='col-md-12'>
                                    <div class='row'>
                                        <div class='col-md-6'>
                                        <label class='w3-large'>CATEGORY LIST</label>
                                        <?php
                                        echo "<table class='table table-condensed table-striped'>";
                                            echo "<thead class='w3-black theadCat'>";
                                                echo "<th class='text-center' width='30'>#</th>";
                                                echo "<th class='text-center'>CATEGORY NAME</th>";
                                                echo "<th class='text-center'>CATEGORY IMAGE</th>";
                                                echo "<th class='text-center'>CATEGORY STATUS</th>";
                                                echo "<th class='text-center'>ACTION</th>";
                                            echo "</thead>";
                                            echo "<tbody class='tbodyCat'>";
                                            $xCat = 0;
                                            $sql = "SELECT * FROM productcategories ORDER BY categoryId ASC";
                                            $queryCategory = $db->query($sql);
                                            if($queryCategory AND $queryCategory->num_rows > 0)
                                            {
                                                while($resultCategory = $queryCategory->fetch_assoc())
                                                {
                                                    $categoryId = $resultCategory['categoryId'];
                                                    $categoryName = $resultCategory['categoryName'];
                                                    $categoryStatus = $resultCategory['categoryStatus'];
                                                    $categoryImage = ($resultCategory['categoryImage'] != '') ? $resultCategory['categoryImage'] : "N/A";
                                                    
                                                    $categoryStatusName = ($categoryStatus == 1) ? "ACTIVE" : "INACTIVE";

                                                    echo "<tr class='w3-hover-grey'>";
                                                        echo "<td class='text-center' width='30'>".++$xCat."</td>";
                                                        echo "<td>".strtoupper($categoryName)."</td>";
                                                        echo "<td class='text-center'>".$categoryImage."</td>";
                                                        echo "<td class='text-center'>".$categoryStatusName."</td>";
                                                        echo "<td class='text-center'>";
                                                            echo "<i style='cursor:pointer;' data-id='".$categoryId."' class='removeCat fa fa-remove'></i>&emsp;&emsp;";
                                                            echo "<i style='cursor:pointer;' data-id='".$categoryId."' class='updateCat fa fa-edit'></i>";
                                                        echo"</td>";
                                                    echo "</tr>";
                                                }
                                            }
                                            echo "</tbody>";
                                            echo "<tfoot class='w3-black tfootCat'>";
                                                echo "<th width='30'></th>";
                                                echo "<th></th>";
                                                echo "<th></th>";
                                                echo "<th></th>";
                                                echo "<th></th>";
                                            echo "</tfoot>";
                                        echo "</table>";
                                        ?>
                                        </div>
                                        <div class='col-md-6'>
                                        <label class='w3-large'>ADMIN LIST</label>
                                        <?php
                                        echo "<table class='table table-condensed table-striped'>";
                                            echo "<thead class='w3-black theadAdmin'>";
                                                echo "<th class='text-center' width='30'>#</th>";
                                                echo "<th class='text-center'>NAME</th>";
                                                echo "<th class='text-center'>USERNAME</th>";
                                                echo "<th class='text-center'>ACTION</th>";
                                            echo "</thead>";
                                            echo "<tbody class='tbodyAdmin'>";
                                            $xAdmin = 0;
                                            $sql = "SELECT * FROM useraccounts WHERE userType = 0";
                                            $queryAdmin = $db->query($sql);
                                            if($queryAdmin AND $queryAdmin->num_rows > 0)
                                            {
                                                while($resultAdmin = $queryAdmin->fetch_assoc())
                                                {
                                                    $userId = $resultAdmin['userId'];
                                                    $userName = $resultAdmin['userName'];
                                                    
                                                    $sql = "SELECT * FROM userinformation WHERE userId = ".$userId;
                                                    $queryUserInfo = $db->query($sql);
                                                    if($queryUserInfo AND $queryUserInfo->num_rows > 0)
                                                    {
                                                        $resultUserInfo = $queryUserInfo->fetch_assoc();
                                                        $firstName = $resultUserInfo['firstName'];
                                                        $surName = $resultUserInfo['surName'];

                                                        $fullName = $firstName." ".$surName;
                                                    }

                                                    echo "<tr class='w3-hover-grey'>";
                                                        echo "<td class='text-center' width='30'>".++$xAdmin."</td>";
                                                        echo "<td>".strtoupper($fullName)."</td>";
                                                        echo "<td class='text-center'>".$userName."</td>";
                                                        echo "<td class='text-center'>";
                                                            echo "<i style='cursor:pointer;' data-id='".$userId."' class='removeUser fa fa-remove'></i>&emsp;";
                                                            echo "<i style='cursor:pointer;' data-id='".$userId."' class='updateUser fa fa-edit'></i>";
                                                        echo"</td>";
                                                    echo "</tr>";
                                                }
                                            }
                                            echo "</tbody>";
                                            echo "<tfoot class='w3-black tfootAdmin'>";
                                                echo "<th width='30'></th>";
                                                echo "<th></th>";
                                                echo "<th></th>";
                                                echo "<th></th>";
                                            echo "</tfoot>";
                                        echo "</table>";
                                        ?>
                                        </div>
                                    </div>
                                    <div class='row'>
                                        <div class='col-md-6'>
                                            <label class='w3-large'>CUSTOMER LIST</label>
                                            <?php
                                            echo "<table class='table table-condensed table-striped'>";
                                                echo "<thead class='w3-black theadUser'>";
                                                    echo "<th class='text-center' width='30'>#</th>";
                                                    echo "<th class='text-center'>NAME</th>";
                                                    echo "<th class='text-center'>USERNAME</th>";
                                                    echo "<th class='text-center'>ACTION</th>";
                                                echo "</thead>";
                                                echo "<tbody class='tbodyUser'>";
                                                $xUser = 0;
                                                $sql = "SELECT * FROM useraccounts WHERE userType = 1";
                                                $queryAdmin = $db->query($sql);
                                                if($queryAdmin AND $queryAdmin->num_rows > 0)
                                                {
                                                    while($resultAdmin = $queryAdmin->fetch_assoc())
                                                    {
                                                        $userId = $resultAdmin['userId'];
                                                        $userName = $resultAdmin['userName'];
                                                        
                                                        $sql = "SELECT * FROM userinformation WHERE userId = ".$userId;
                                                        $queryUserInfo = $db->query($sql);
                                                        if($queryUserInfo AND $queryUserInfo->num_rows > 0)
                                                        {
                                                            $resultUserInfo = $queryUserInfo->fetch_assoc();
                                                            $firstName = $resultUserInfo['firstName'];
                                                            $surName = $resultUserInfo['surName'];

                                                            $fullName = $firstName." ".$surName;
                                                        }

                                                        echo "<tr class='w3-hover-grey'>";
                                                            echo "<td class='text-center' width='30'>".++$xUser."</td>";
                                                            echo "<td>".strtoupper($fullName)."</td>";
                                                            echo "<td class='text-center'>".$userName."</td>";
                                                            echo "<td class='text-center'>";
                                                                echo "<i style='cursor:pointer;' data-id='".$userId."' class='removeUser fa fa-remove'></i>&emsp;";
                                                                echo "<i style='cursor:pointer;' data-id='".$userId."' class='updateUser fa fa-edit'></i>";
                                                            echo"</td>";
                                                        echo "</tr>";
                                                    }
                                                }
                                                echo "</tbody>";
                                                echo "<tfoot class='w3-black tfootUser'>";
                                                    echo "<th width='30'></th>";
                                                    echo "<th></th>";
                                                    echo "<th></th>";
                                                    echo "<th></th>";
                                                echo "</tfoot>";
                                            echo "</table>";
                                            ?>
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
    <div id='modal-izi-update'><span class='izimodal-content-update'></span></div>
    <div id='modal-izi-add'><span class='izimodal-content-add'></span></div>
    <div id='modal-izi-admin'><span class='izimodal-content-admin'></span></div>
    <div id='modal-izi-updateuser'><span class='izimodal-content-updateuser'></span></div>
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
    $("#addCategory").click(function(){
        $("#modal-izi-add").iziModal({
            title           		: '<i class=""></i> ADD CATEGORY',
            // headerColor       		: '#009688',
            headerColor       		: 'grey',
            subtitle        		: '<b><?php echo strtoupper(date('F d, Y'));?></b>',
            width           		: 600,
            fullscreen        		: false,
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
                                        $.post( "addCategory.php", function( data ) {
                                            $( ".izimodal-content-add" ).html(data);
                                            modal.stopLoading();
                                        });
                                        // }, 500);
                                    },
            onClosed                : function(){
                                        $("#modal-izi-add").iziModal("destroy");
                                    }
                        
        });

        $("#modal-izi-add").iziModal("open");
    });

    $(".removeCat").click(function(){
        var categoryId = $(this).attr("data-id");
        var res = confirm("Are you sure?");
        if(res)
        {
            $.ajax({
                url     : 'deleteCategoryAJAX.php',
                type    : 'POST',
                data    : {
                    categoryId : categoryId
                },
                success : function(data){
                            // $(this).parent().parent().remove();
                            location.reload();
                }
            });
        }
    });

    $(".updateCat").click(function(){
        var categoryId = $(this).attr("data-id");
        $("#modal-izi-update").iziModal({
            title           		: '<i class=""></i> UPDATE CATEGORY',
            // headerColor       		: '#009688',
            headerColor       		: 'grey',
            subtitle        		: '<b><?php echo strtoupper(date('F d, Y'));?></b>',
            width           		: 600,
            fullscreen        		: false,
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
                                        $.post( "updateCategory.php?categoryId="+categoryId, function( data ) {
                                            $( ".izimodal-content-update" ).html(data);
                                            modal.stopLoading();
                                        });
                                        // }, 500);
                                    },
            onClosed                : function(){
                                        $("#modal-izi-update").iziModal("destroy");
                                    }
        });

        $("#modal-izi-update").iziModal("open");
    });


    $("#addUsers").click(function(){
        $("#modal-izi-admin").iziModal({
            title           		: '<i class=""></i> REGISTER ADMIN',
            // headerColor       		: '#009688',
            headerColor       		: 'grey',
            subtitle        		: '<b><?php echo strtoupper(date('F d, Y'));?></b>',
            width           		: 900,
            fullscreen        		: false,
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
                                        $.post( "register.php?admin=1", function( data ) {
                                            $( ".izimodal-content-admin" ).html(data);
                                            modal.stopLoading();
                                        });
                                        // }, 500);
                                    },
            onClosed                : function(){
                                        $("#modal-izi-admin").iziModal("destroy");
                                    }
        });

        $("#modal-izi-admin").iziModal("open");
    });

    $(".removeUser").click(function(){
        var userId = $(this).attr("data-id");
        var res = confirm("Are you sure?");
        if(res)
        {
            $.ajax({
                url     : 'deleteAdminAJAX.php',
                type    : 'POST',
                data    : {
                    userId : userId
                },
                success : function(data){
                            // $(this).parent().parent().remove();
                            location.reload();
                }
            });
        }
    });

    $(".updateUser").click(function(){
        var userId = $(this).attr("data-id");

        $("#modal-izi-updateuser").iziModal({
            title           		: '<i class=""></i> UPDATE INFORMATION',
            // headerColor       		: '#009688',
            headerColor       		: 'grey',
            subtitle        		: '<b><?php echo strtoupper(date('F d, Y'));?></b>',
            width           		: 500,
            fullscreen        		: false,
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
                                        $.post( "updateUserAccounts.php?admin=1&userId="+userId, function( data ) {
                                            $( ".izimodal-content-updateuser" ).html(data);
                                            modal.stopLoading();
                                        });
                                        // }, 500);
                                    },
            onClosed                : function(){
                                        $("#modal-izi-updateuser").iziModal("destroy");
                                    }
        });

        $("#modal-izi-updateuser").iziModal("open");
    });
    
    $("#featuredProd").click(function(){

        $("#modal-izi-update").iziModal({
            title           		: '<i class=""></i> UPLOAD FEATURED PRODUCTS',
            // headerColor       		: '#009688',
            headerColor       		: 'grey',
            subtitle        		: '<b><?php echo strtoupper(date('F d, Y'));?></b>',
            width           		: 500,
            fullscreen        		: false,
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
                                        $.post( "uploadFeatured.php", function( data ) {
                                            $( ".izimodal-content-update" ).html(data);
                                            modal.stopLoading();
                                        });
                                        // }, 500);
                                    },
            onClosed                : function(){
                                        $("#modal-izi-update").iziModal("destroy");
                                    }
        });

        $("#modal-izi-update").iziModal("open");
    });

    $("#uploadLogo").click(function(){

        $("#modal-izi-update").iziModal({
            title           		: '<i class=""></i> UPLOAD LOGO',
            // headerColor       		: '#009688',
            headerColor       		: 'grey',
            subtitle        		: '<b><?php echo strtoupper(date('F d, Y'));?></b>',
            width           		: 500,
            fullscreen        		: false,
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
                                        $.post( "uploadLogo.php", function( data ) {
                                            $( ".izimodal-content-update" ).html(data);
                                            modal.stopLoading();
                                        });
                                        // }, 500);
                                    },
            onClosed                : function(){
                                        $("#modal-izi-update").iziModal("destroy");
                                    }
        });

        $("#modal-izi-update").iziModal("open");
    });
});
</script>
<style type="text/css">
    .tbodyCat {
        display: block;
        <?php
        if($xCat > 6)
        {
        ?>
            height:167px;
        <?php
        }
        ?>
        overflow: auto;
    }
    .theadCat, .tbodyCat tr, .tfootCat {
        display: table;
        width: 100%;
        table-layout: fixed;
    }
    .theadCat, .tfootCat {
        <?php
        if($xCat > 6)
        {
        ?>
            width: calc(100% - 1.5em);
        <?php 
        }
        else
        {
        ?>
            width: calc(100%);
        <?php
        }
        ?>
    }
</style>
<style type="text/css">
    .tbodyAdmin {
        display: block;
        <?php
        if($xCat > 6)
        {
        ?>
            height:167px;
        <?php
        }
        ?>
        overflow: auto;
    }
    .theadAdmin, .tbodyAdmin tr, .tfootAdmin {
        display: table;
        width: 100%;
        table-layout: fixed;
    }
    .theadAdmin, .tfootAdmin {
        <?php
        if($xCat > 6)
        {
        ?>
            width: calc(100% - 1.5em);
        <?php
        }
        else
        {
        ?>
            width: calc(100%);
        <?php
        }
        ?>
    }
</style>
<style type="text/css">
    .tbodyUser {
        display: block;
        <?php
        if($xCat > 6)
        {
        ?>
            height:167px;
        <?php
        }
        ?>
        overflow: auto;
    }
    .theadUser, .tbodyUser tr, .tfootUser {
        display: table;
        width: 100%;
        table-layout: fixed;
    }
    .theadUser, .tfootUser {
        <?php
        if($xCat > 6)
        {
        ?>
            width: calc(100% - 1.5em);
        <?php
        }
        else
        {
        ?>
            width: calc(100%);
        <?php
        }
        ?>
    }
</style>