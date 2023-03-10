<?php
$path = $_SERVER['DOCUMENT_ROOT']."/";
set_include_path($path);
include('Modules/mysqliConnection.php');
$userId = $_SESSION['userId'];

$sql = "DELETE FROM cakecustomizedinfo WHERE userId = ".$userId." AND customStatus = 0";
$queryDelete = $db->query($sql);

$sql = "SELECT * FROM userinformation WHERE userId = ".$_SESSION['userId'];
$queryUserInfo = $db->query($sql);
if($queryUserInfo AND $queryUserInfo->num_rows > 0)
{
    $resultUserInfo = $queryUserInfo->fetch_assoc();
    $firstName = $resultUserInfo['firstName'];
    $surName = $resultUserInfo['surName'];
    $address = $resultUserInfo['address'];

    $fullName = $firstName." ".$surName;
}

$disabledBtn = "disabled";
$sql = "SELECT FROM cakecustomizedinfo WHERE userId = ".$userId." AND customStatus = 0";
$queryCheckCustom = $db->query($sql);
if($queryCheckCustom AND $queryCheckCustom->num_rows > 0)
{
	$disabledBtn = "";
}

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
</head>
<body>
    <div class="container-fluid">
    	<?php include "userHeader.php";?>
        <!-- <div class="row">
            <div class="col-md-12 w3-yellow w3-padding w3-card-2">
                <div class="w3-right">
                    <?php include "userNavi.php";?>
                </div>
            </div>
        </div> -->
        <div class="row">
        	<div class="col-md-3 w3-padding-top">
        		<div class="w3-card-2">
	                <div class="w3-container w3-padding w3-white" style="height:">
						<label class='w3-medium'><b>FLAVOR</b></label>
						<div id='containerFlavor'></div>
	                	<div class="w3-padding-top"></div>
	                	<?php
		                	/* $flavorPath = "Custom/Flavors/";
		                	$sql = "SELECT * FROM cakeflavors WHERE status = 0";
		                	$queryFlavors = $db->query($sql);
		                	if($queryFlavors AND $queryFlavors->num_rows > 0)
		                	{
		                		while ($resultFlavors = $queryFlavors->fetch_assoc()) 
		                		{
		                			$flavorId = $resultFlavors['flavorId'];
		                			$flavorName = $resultFlavors['flavorName'];
		                			$flavorPrice = $resultFlavors['flavorPrice'];
		                			$image = $resultFlavors['image'];

									$checkedFlavor = "";
									if($flavorId == 1) $checkedFlavor = "checked";
		                			echo "<div class='col-md-6 w3-center'>";
		                				echo "<div class='w3-padding-top'></div>";
			                			echo "<label class='w3-tiny flavors' data-value='".$flavorId."'  style='cursor:pointer;'><b>".strtoupper($flavorName)."</b></label>";
			                			echo "<div>";
			                				echo "<input type='radio' value='".$flavorId."' ".$checkedFlavor." data-price='".$flavorPrice."' class='w3-radio cakeFlavor' name='cakeFlavor'>";
	                					echo "</div>";
			                		echo "</div>";
		                		}
		                	} */
            			?>
            			<div class="w3-padding-top"></div>
        			</div>
        		</div>
    			<div class="w3-padding-top"></div>
    			<div class="w3-card-2">
	                <div class="w3-container w3-padding-top w3-black" style="height:;">
	                	<label class="w3-medium">PRICE METER</label>
    					<div class="w3-padding-top"></div>
    					<div class="priceFlavor">
							<!-- <div class="row">
								<div class="col-md-6">
									<label class='w3-medium'>FLAVOR </label>
								</div>
								<div class="col-md-6" style='font-weight:bold;'>
									<span class='w3-medium' id="totalFlavorPrice0">0.00</span> PHP
								</div>
							</div> -->
						</div>
        				<div class="row">
    						<div class="col-md-6">
    							<label class='w3-medium'>LAYERS </label>
    						</div>
    						<div class="col-md-6" style='font-weight:bold;'>
    							<span class='w3-medium' id="totalLayerPrice">0.00</span> PHP
								<input type='hidden' id="totalLayerPriceData" value=0>
    						</div>
        				</div>
        				<div class="row">
    						<div class="col-md-6">
    							<label class='w3-medium'>DESIGNS </label>
    						</div>
    						<div class="col-md-6" style='font-weight:bold;'>
    							<span class='w3-medium' id="totalDesignPrice">0.00</span> PHP
								<input type='hidden' id="totalDesignPriceData" value=0>
    						</div>
        				</div>
        				<hr>
        				<div class="row">
    						<div class="col-md-6">
    							<label class='w3-medium'>TOTAL PRICE </label>
    						</div>
    						<div class="col-md-6" style='font-weight:bold;'>
    							<span class='w3-medium' id="totalPrice">0.00</span> PHP
								<input type='hidden' id="totalPriceData" value=0>
    						</div>
						</div>
						<br>
        			</div>
        		</div>
        	</div>
            <div class="col-md-9 w3-padding-top">
            	<div class="w3-card-2">
	                <div class="w3-container w3-padding w3-white" style="height: ''">
	                	<div class="">
            				<button <?php echo $disabledBtn; ?> class="w3-btn w3-round w3-tiny w3-black" id="imageSaveBtn"><i class="fa fa-image"></i>&emsp;<b>SAVE AS IMAGE</b></button>
            				<a href="userCustomizedDashboard.php"><button class="w3-btn w3-round w3-tiny w3-black"><i class="fa fa-forward"></i>&emsp;<b>GO TO MY CUSTOM CAKES</b></button></a>
            				<a target="_blank" href="CUSTOMIZATION MANUAL.pdf"><button class="w3-btn w3-round w3-tiny w3-purple"><i class="fa fa-file-pdf-o"></i>&emsp;<b>HOW TO USE?</b></button></a>
    					</div>
	                	<div class="row">
	                		<div class='col-md-9 w3-padding'>
								<label class='w3-tiny'>Please make sure all dragged items are in the workspace.</label>
	            				<div class='w3-container w3-center w3-light-grey w3-border' id='editorSpace' style="height: 420px">
	            				
	            				</div>
	            				<?php
		                			$imgPath = "Custom/Decorations/";
		                			echo "<div class='w3-padding-top'></div>";
		                			echo "<div class='row'>";
		                				echo "<div class='col-md-4'>";
			                				echo "<label>FRUITS</label>";
			                				echo "<div class='w3-padding-top'></div>";
			                				$sql = "SELECT * FROM cakedecorationdetails WHERE availability = 0 AND decorationType = 'Fruits'";
		            						$queryFruitsDetails = $db->query($sql);
		            						if($queryFruitsDetails AND $queryFruitsDetails->num_rows > 0)
		            						{
		            							while ($resultFruitsDetails = $queryFruitsDetails->fetch_assoc()) 
		            							{
		            								$decorationId = $resultFruitsDetails['decorationId'];
		            								$decorationType = $resultFruitsDetails['decorationType'];
		            								$decorationImage = $resultFruitsDetails['decorationImage'];
		            								$decorationPrice = $resultFruitsDetails['decorationPrice'];
					                				echo "<div class='col-md-3'>";
						                				echo "<img src='".$imgPath.$decorationImage."' data-id=".$decorationId." data-price='".$decorationPrice."' id='fruits' style='width:50px; height:35px;' class='w3-border w3-padding'>";
						                			echo "</div>";	
					                			}
				                			}	                				
	                					echo "</div>";
	                					echo "<div class='col-md-4'>";
		                					echo "<label>NUMBERS</label>";
				                				echo "<div class='w3-padding-top'></div>";
				                				$sql = "SELECT * FROM cakedecorationdetails WHERE availability = 0 AND decorationType = 'Numbers'";
			            						$queryNumbersDetails = $db->query($sql);
			            						if($queryNumbersDetails AND $queryNumbersDetails->num_rows > 0)
			            						{
			            							while ($resultNumbersDetails = $queryNumbersDetails->fetch_assoc()) 
			            							{
			            								$decorationId = $resultNumbersDetails['decorationId'];
			            								$decorationType = $resultNumbersDetails['decorationType'];
			            								$decorationImage = $resultNumbersDetails['decorationImage'];
			            								$decorationPrice = $resultNumbersDetails['decorationPrice'];
						                				echo "<div class='col-md-4'>";
							                				echo "<img src='".$imgPath.$decorationImage."' data-id=".$decorationId." data-price='".$decorationPrice."' id='numbers' style='width:50px; height:50px;' class='w3-border w3-padding'>";
							                			echo "</div>";	
						                			}
					                			}	
	                					echo "</div>";
	                					echo "<div class='col-md-4'>";
		                					echo "<label>CANDLES</label>";
				                				echo "<div class='w3-padding-top'></div>";
				                				$sql = "SELECT * FROM cakedecorationdetails WHERE availability = 0 AND decorationType = 'Candles'";
			            						$queryCandlesDetails = $db->query($sql);
			            						if($queryCandlesDetails AND $queryCandlesDetails->num_rows > 0)
			            						{
			            							while ($resultCandlesDetails = $queryCandlesDetails->fetch_assoc()) 
			            							{
			            								$decorationId = $resultCandlesDetails['decorationId'];
			            								$decorationType = $resultCandlesDetails['decorationType'];
			            								$decorationImage = $resultCandlesDetails['decorationImage'];
			            								$decorationPrice = $resultCandlesDetails['decorationPrice'];
						                				echo "<div class='col-md-3'>";
							                				echo "<img src='".$imgPath.$decorationImage."' data-id=".$decorationId." data-price='".$decorationPrice."' id='candles' style='width:50px; height:50px;' class='w3-border w3-padding'>";
							                			echo "</div>";	
						                			}
					                			}	
	                					echo "</div>";
	                				echo "</div>";
	                			?>
	            			</div>
		                	<div class='col-md-3 w3-padding'>
		                		<?php
		                			$imgPath = "Custom/Decorations/";
            						echo "<div>";
			                			echo "<div class='row'>";
			                				echo "<label class='w3-medium'><b>PICK YOUR DESIGNS</b></label>";
			                					echo "<input type='text' class='w3-input w3-small w3-border' placeholder='Give it a name :)' id='cakeName'>";
			                				echo "<hr>";
			                				echo "<label>LAYERS</label>";
			                				echo "<div class='w3-padding-top'></div>";
			                				$sql = "SELECT * FROM cakedecorationdetails WHERE availability = 0 AND decorationType = 'Layers'";
		            						$queryLayerDetails = $db->query($sql);
		            						if($queryLayerDetails AND $queryLayerDetails->num_rows > 0)
		            						{
		            							while ($resultLayersDetails = $queryLayerDetails->fetch_assoc()) 
		            							{
		            								$decorationId = $resultLayersDetails['decorationId'];
		            								$decorationType = $resultLayersDetails['decorationType'];
		            								$decorationImage = $resultLayersDetails['decorationImage'];
		            								$decorationPrice = $resultLayersDetails['decorationPrice'];
		            								echo "<div class='col-md-6'>";
			                							echo "<img src='".$imgPath.$decorationImage."' data-id=".$decorationId." data-price='".$decorationPrice."' id='layers' style='width:100px; height:35px;' class='w3-border w3-padding'>";
		            								echo "</div>";
		            							}
		            						}
			                			echo "</div>";
			                			echo "<br>";
			                			echo "<div class='row'>";
			                				echo "<label>DECORATIONS</label>";
			                				echo "<div class='w3-padding-top'></div>";
			                				$sql = "SELECT * FROM cakedecorationdetails WHERE availability = 0 AND decorationType = 'Ribbons'";
		            						$queryRibbonsDetails = $db->query($sql);
		            						if($queryRibbonsDetails AND $queryRibbonsDetails->num_rows > 0)
		            						{
		            							while ($resultRibbonsDetails = $queryRibbonsDetails->fetch_assoc()) 
		            							{
		            								$decorationId = $resultRibbonsDetails['decorationId'];
		            								$decorationType = $resultRibbonsDetails['decorationType'];
		            								$decorationImage = $resultRibbonsDetails['decorationImage'];
		            								$decorationPrice = $resultRibbonsDetails['decorationPrice'];
					                				echo "<div class='col-md-6'>";
						                				echo "<img src='".$imgPath.$decorationImage."' data-id=".$decorationId." data-price='".$decorationPrice."' id='ribbons' style='width:100px; height:35px;' class='w3-border w3-padding'>";
						                			echo "</div>";	
					                			}
				                			}	                				
		                				echo "</div>";	
		                				echo "<br>";
			                			echo "<div class='row'>";
			                				echo "<label>FLOWERS</label>";
			                				echo "<div class='w3-padding-top'></div>";
			                				$sql = "SELECT * FROM cakedecorationdetails WHERE availability = 0 AND decorationType = 'Flowers'";
		            						$queryFlowersDetails = $db->query($sql);
		            						if($queryFlowersDetails AND $queryFlowersDetails->num_rows > 0)
		            						{
		            							while ($resultFlowersDetails = $queryFlowersDetails->fetch_assoc()) 
		            							{
		            								$decorationId = $resultFlowersDetails['decorationId'];
		            								$decorationType = $resultFlowersDetails['decorationType'];
		            								$decorationImage = $resultFlowersDetails['decorationImage'];
		            								$decorationPrice = $resultFlowersDetails['decorationPrice'];
					                				echo "<div class='col-md-4'>";
						                				echo "<img src='".$imgPath.$decorationImage."' data-id=".$decorationId." data-price='".$decorationPrice."' id='flowers' style='width:50px; height:50px;' class='w3-border w3-padding flowers'>";
						                			echo "</div>";	
					                			}
				                			}	                				
		                				echo "</div>";	
			                			echo "<br>";
			                			echo "<div class='row'>";
				                			echo "<label>ADD-ONS</label>";
			                				echo "<div class='w3-padding-top'></div>";
			                				$sql = "SELECT * FROM cakedecorationdetails WHERE availability = 0 AND decorationType = 'Creams'";
		            						$queryCreamsDetails = $db->query($sql);
		            						if($queryCreamsDetails AND $queryCreamsDetails->num_rows > 0)
		            						{
		            							while ($resultCreamsDetails = $queryCreamsDetails->fetch_assoc()) 
		            							{
		            								$decorationId = $resultCreamsDetails['decorationId'];
		            								$decorationType = $resultCreamsDetails['decorationType'];
		            								$decorationImage = $resultCreamsDetails['decorationImage'];
		            								$decorationPrice = $resultCreamsDetails['decorationPrice'];
					                				echo "<div class='col-md-6'>";
					                					echo "<img src='".$imgPath.$decorationImage."' data-id=".$decorationId." data-price='".$decorationPrice."' id='creams' style='width:40px; height:40px;'>";
					                				echo "</div>";
					                			}
					                		}
			                			echo "</div>";
		                			echo "</div>";
            					?>
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
    <div id='modal-izi'><span class='izimodal-content'></span></div>
</body>
</html>
<script src="Include Files/Javascript/jQuery 3.1.1/jquery-3.1.1.js"></script>
<script src="Include Files/Javascript/jQuery 3.1.1/jquery-ui.js"></script>
<script src="Include Files/Javascript/jQuery 3.1.1/bootstrap.min.js"></script>
<script src="Include Files/Javascript/Interact JS/dist/interact.js"></script>
<script src="Include Files/Javascript/html2canvas/html2canvas.js"></script>
<link rel="stylesheet" href="Include Files/Javascript/iziModal-master/css/iziModal.css" />
<script src="Include Files/Javascript/iziModal-master/js/iziModal.js"></script>
<link rel="stylesheet" href="Include Files/Javascript/iziToast-master/dist/css/iziToast.css" />
<script src="Include Files/Javascript/iziToast-master/dist/js/iziToast.js"></script>
<script src="Include Files/Custom JS/customInteract.js"></script>
<script>
$(document).ready(function(){
	$(".cakeFlavor").each(function(){
		var flavorId = $(this).val();
		var flavorPrice = $(this).attr("data-price");
		var designPrice = $("#totalDesignPrice").html();
    	if($(this).is(":checked"))
    	{
    		var totalData = parseFloat(flavorPrice);
    		var totalPriceData = parseFloat(flavorPrice) + parseFloat(designPrice);
    		$("#totalFlavorPrice").html(totalData+".00");
    		$("#totalPrice").html(totalPriceData+".00");
    	}
	});

    $(".flavors").click(function(){
    	var flavorId = $(this).attr("data-value");
    	// alert(flavorId);
    	$("#modal-izi").iziModal({
            width                   : 150,
            fullscreen              : false,
            transitionIn            : 'comingIn',
            transitionOut           : 'comingOut',
            padding                 : 0,
            radius                  : 0,
            restoreDefaultContent   : true,
            closeOnEscape           : true,
            closeButton             : true,
            overlayClose            : false,
            overlay            		: false,
            onOpening               : function(modal){
                                        modal.startLoading();
                                        // setTimeout(function(){
                                        $.post( "viewFlavors.php?flavorId="+flavorId, function( data ) {
                                            $( ".izimodal-content" ).html(data);
                                            modal.stopLoading();
                                        });
                                        // }, 500);
                        			},
            onClosed               : function(){
            							$("#modal-izi").iziModal("destroy");
            						}
        });

        $("#modal-izi").iziModal("open");
    	return false;
    });
});
</script>
<script>
function post_data(imageURL) {  
    //console.log(imageURL);  
    var productName = $("#cakeName").val();
    var productPrice = $("#totalPriceData").val();

    $.ajax({  
        url: "saveImage.php",  
        type: "POST",  
        data: {  
            image : encodeURIComponent(imageURL),
            productName : productName,
            productPrice : productPrice
        },  
        dataType: "html",  
        success: function(data) {  
        	console.log(data);
            // alert(‘Success!!’);  
            location.href = "userCustomizedDashboard.php";  
        }  
    });  
}  

$(document).ready(function(){
	var dataURL = {};  
    $('#imageSaveBtn').click(function() {  
		var cakeName = $("#cakeName").val();

		var totalValuePrice = 0;
		var flavorArray = [];
		$(".flavorData").each(function(){
			var dataAllValue = $(this).val();
			var splitAllData = dataAllValue.split("~");
			var flavorAllPrice = splitAllData[1];
			if(dataAllValue == 0) flavorAllPrice = 0;

			totalValuePrice += parseFloat(flavorAllPrice);

			if(dataAllValue == 0)
			{
				flavorArray.push(dataAllValue);
			}
		});

		if(jQuery.inArray("0", flavorArray) !== -1)
		{
			iziToast.info({
                title: 'Warning',
                message: '<b>Please Select a flavor.</b>',
                close: true,
                overlay: true,
                position: 'topCenter',
                timeout: 2500
            });
		}
	 	else if(cakeName != "")
	 	{
	 		window.scrollTo(0,0);
	        html2canvas(document.querySelector("#editorSpace")).then(canvas => {  
	            document.body.appendChild(canvas);  
	            //console.log(canvas.toDataURL());  
	            dataURL = canvas.toDataURL();  
	    		// location.href = "userCustomizedDashboard.php"; 
	            post_data(dataURL);  
	        });  
	    }
	    else
	    {
	    	iziToast.info({
                title: 'Warning',
                message: '<b>Please Give it a name.</b>',
                close: true,
                overlay: true,
                position: 'topCenter',
                timeout: 2500
            });

            $("#cakeName").focus();
	    }
    }); 

    callInteract("layers");
    callInteract("ribbons");
    callInteract("flowers");
    callInteract("creams");
    callInteract("fruits");
    callInteract("numbers");
    callInteract("candles");
});
</script>