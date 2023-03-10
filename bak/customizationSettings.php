<?php
$path = $_SERVER['DOCUMENT_ROOT']."/";
set_include_path($path);
include('Modules/mysqliConnection.php');
if($_SESSION['admin'] == "false")
{
    header("location:index.php");
    exit();
}

$activeButtonProd = "";
$activeButtonSett = "";
$activeButtonSumm = "";
$activeButtonCust = "true";
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
                        <div class='col-md-6'>
                            <label class='w3-medium'>DECORATION LIST</label>
                            <?php
                            echo "<div class='w3-right'>";
                                echo "<button class='w3-btn w3-round w3-black w3-tiny' id='addDeco'><i class='fa fa-plus'></i>&emsp;<b>DECORATION</b></button>";
                            echo "</div>";
                            echo "<div class='w3-padding-top'></div>";
                            echo "<table class='table table-bordered table-condensed table-striped'>";
                                echo "<thead class='w3-black thead'>";
                                    echo "<th class='text-center' width='30'>#</th>";
                                    echo "<th class='text-center' width='100'>PHOTO</th>";
                                    echo "<th class='text-center'>CODE</th>";
                                    echo "<th class='text-center'>PRICE</th>";
                                    echo "<th class='text-center'>TYPE</th>";
                                    echo "<th class='text-center'>STATUS</th>";
                                    echo "<th class='text-center'>ACTION</th>";
                                echo "</thead>";
                                echo "<tbody class='tbody'>";
                                $x = 0;
                                $sql = "SELECT * FROM cakedecorationdetails ORDER BY decorationId ASC";
                                $queryDecoration = $db->query($sql);
                                if($queryDecoration AND $queryDecoration->num_rows > 0)
                                {
                                    while($resultDecoration = $queryDecoration->fetch_assoc())
                                    {
                                        $decorationId = $resultDecoration['decorationId'];
                                        $decorationCode = $resultDecoration['decorationCode'];
                                        $decorationPrice = $resultDecoration['decorationPrice'];
                                        $decorationImage = $resultDecoration['decorationImage'];
                                        $decorationType = $resultDecoration['decorationType'];
                                        $availability = $resultDecoration['availability'];

                                        $availabilityName = ($availability == 0) ? "Available" : "Not Available"; 
                                        
                                        $pathData = "Custom/Decorations/";
                                        echo "<tr class='w3-hover-grey'>";
                                            echo "<td style='vertical-align:middle;' class='text-center' width='30'><b>".++$x."</b></td>";
                                            echo "<td style='vertical-align:middle;' class='text-center' width='100'><img src='".$pathData.$decorationImage."' class='w3-white w3-card-2 w3-border w3-padding' style='width:50px; height:50px;'></td>";
                                            echo "<td style='vertical-align:middle;' class='text-center'>".$decorationCode."</td>";
                                            echo "<td style='vertical-align:middle;' class='text-center'>".$decorationPrice."</td>";
                                            echo "<td style='vertical-align:middle;' class='text-center'>".$decorationType."</td>";
                                            echo "<td style='vertical-align:middle;' class='text-center'>".$availabilityName."</td>";
                                            echo "<td style='vertical-align:middle;' class='text-center'>";
                                                echo "<i style='cursor:pointer;' data-id='".$decorationId."' class='removeDeco fa fa-remove w3-medium'></i>&emsp;";
                                                echo "<i style='cursor:pointer;' data-id='".$decorationId."' class='updateDeco fa fa-edit w3-medium'></i>";
                                            echo"</td>";
                                        echo "</tr>";
                                    }
                                }
                                echo "</tbody>";
                                echo "<tfoot class='w3-black tfoot'>";
                                    echo "<th width=30></th>";
                                    echo "<th width=100></th>";
                                    echo "<th></th>";
                                    echo "<th></th>";
                                    echo "<th></th>";
                                    echo "<th></th>";
                                echo "</tfoot>";
                            echo "</table>";
                            ?>
                        </div>
                        <div class='col-md-6'>
                            <label class='w3-medium'>FLAVOR LIST</label>
                            <?php
                            echo "<div class='w3-right'>";
                                echo "<button class='w3-btn w3-round w3-black w3-tiny' id='addFlavor'><i class='fa fa-plus'></i>&emsp;<b>FLAVORS</b></button>";
                            echo "</div>";
                            echo "<div class='w3-padding-top'></div>";
                            echo "<table class='table table-bordered table-condensed table-striped'>";
                                echo "<thead class='w3-black theadFL'>";
                                    echo "<th class='text-center' width='30'>#</th>";
                                    echo "<th class='text-center' width='100'>PHOTO</th>";
                                    echo "<th class='text-center'>FLAVOR NAME</th>";
                                    echo "<th class='text-center'>FLAVOR PRICE</th>";
                                    echo "<th class='text-center'>ACTION</th>";
                                echo "</thead>";
                                echo "<tbody class='tbodyFL'>";
                                $xFL = 0;
                                $sql = "SELECT * FROM cakeflavors ORDER BY flavorId ASC";
                                $queryFlavors = $db->query($sql);
                                if($queryFlavors AND $queryFlavors->num_rows > 0)
                                {
                                    while($resultFlavors = $queryFlavors->fetch_assoc())
                                    {
                                        $flavorId = $resultFlavors['flavorId'];
                                        $flavorName = $resultFlavors['flavorName'];
                                        $flavorPrice = $resultFlavors['flavorPrice'];
                                        $image = $resultFlavors['image'];
                                        
                                        $pathData = "Custom/Flavors/";
                                        echo "<tr class='w3-hover-grey'>";
                                            echo "<td style='vertical-align:middle;' class='text-center' width='30'><b>".++$xFL."</b></td>";
                                            echo "<td style='vertical-align:middle;' class='text-center' width='100'><img src='".$pathData.$image."' class='w3-white w3-card-2 w3-border w3-padding' style='width:50px; height:50px;'></td>";
                                            echo "<td style='vertical-align:middle;' class='text-center'>".$flavorName."</td>";
                                            echo "<td style='vertical-align:middle;' class='text-center'>".$flavorPrice."</td>";
                                            echo "<td style='vertical-align:middle;' class='text-center'>";
                                                echo "<i style='cursor:pointer;' data-id='".$flavorId."' class='removeFlavor fa fa-remove w3-medium'></i>&emsp;";
                                                echo "<i style='cursor:pointer;' data-id='".$flavorId."' class='updateFlavor fa fa-edit w3-medium'></i>";
                                            echo"</td>";
                                        echo "</tr>";
                                    }
                                }
                                echo "</tbody>";
                                echo "<tfoot class='w3-black tfootFL'>";
                                    echo "<th width=30></th>";
                                    echo "<th width=100></th>";
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
    <div id='modal-izi-add'><span class='izimodal-content-add'></span></div>
    <div id='modal-izi-update'><span class='izimodal-content-update'></span></div>
    <div id='modal-izi-addFlvr'><span class='izimodal-content-addFlvr'></span></div>
    <div id='modal-izi-upFlvr'><span class='izimodal-content-upFlvr'></span></div>
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
    $("#addDeco").click(function(){
        $("#modal-izi-add").iziModal({
            title           		: '<i class=""></i> DECORATION FORM',
            headerColor       		: 'grey',
            // headerColor       		: '#009688',
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
                                        $.post( "addDecoration.php", function( data ) {
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

    $(".removeDeco").click(function(){
        var decorationId = $(this).attr("data-id");
        var res = confirm("Are you sure?");
        if(res)
        {
            $.ajax({
                url     : 'deleteDecoAJAX.php',
                type    : 'POST',
                data    : {
                    decorationId : decorationId
                },
                success : function(data){
                            // $(this).parent().parent().remove();
                            location.reload();
                }
            });
        }
    });

    $(".updateDeco").click(function(){
        var decorationId = $(this).attr("data-id");
        $("#modal-izi-update").iziModal({
            title           		: '<i class=""></i> UPDATE DECORATION',
            headerColor       		: 'grey',
            // headerColor       		: '#009688',
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
                                        $.post( "updateDeco.php?decorationId="+decorationId, function( data ) {
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

    $("#addFlavor").click(function(){
        $("#modal-izi-addFlvr").iziModal({
            title           		: '<i class=""></i> FLAVORS FORM',
            headerColor       		: 'grey',
            // headerColor       		: '#009688',
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
                                        $.post( "addFlavor.php", function( data ) {
                                            $( ".izimodal-content-addFlvr" ).html(data);
                                            modal.stopLoading();
                                        });
                                        // }, 500);
                                    },
            onClosed                : function(){
                                        $("#modal-izi-addFlvr").iziModal("destroy");
                                    }
        });

        $("#modal-izi-addFlvr").iziModal("open");
    });

    $(".removeFlavor").click(function(){
        var flavorId = $(this).attr("data-id");
        var res = confirm("Are you sure?");
        if(res)
        {
            $.ajax({
                url     : 'deleteFlavorAJAX.php',
                type    : 'POST',
                data    : {
                    flavorId : flavorId
                },
                success : function(data){
                            // $(this).parent().parent().remove();
                            location.reload();
                }
            });
        }
    });

    $(".updateFlavor").click(function(){
        var flavorId = $(this).attr("data-id");
        $("#modal-izi-upFlvr").iziModal({
            title           		: '<i class=""></i> UPDATE FLAVOR',
            headerColor       		: 'grey',
            // headerColor       		: '#009688',
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
                                        $.post( "updateFlavor.php?flavorId="+flavorId, function( data ) {
                                            $( ".izimodal-content-upFlvr" ).html(data);
                                            modal.stopLoading();
                                        });
                                        // }, 500);
                                    },
            onClosed                : function(){
                                        $("#modal-izi-upFlvr").iziModal("destroy");
                                    }
        });

        $("#modal-izi-upFlvr").iziModal("open");
    });
});
</script>
<style type="text/css">
    .tbody {
        display: block;
        height:390px;
        overflow: auto;
    }
    .thead, .tbody tr, .tfoot {
        display: table;
        width: 100%;
        table-layout: fixed;
    }
    .thead, tfoot {
        width: calc(100% - 1.5em);
    }
</style>
<style type="text/css">
    .tbodyFL {
        display: block;
        height:390px;
        overflow: auto;
    }
    .theadFL, .tbodyFL tr, .tfootFL {
        display: table;
        width: 100%;
        table-layout: fixed;
    }
    .theadFL, .tfootFL {
        width: calc(100% - 1.5em);
    }
</style>