<?php
$logo = glob("Custom/Logos/logo.*");
$logoData = "Custom/Logos/defaultLogo.png";

if(count($logo) > 0)
if(file_exists($logo[0]))
{
    $logoData = $logo[0];
}
$nocahce = filemtime($logoData);
?>
<div class="row">
    <div class="w3-container w3-padding w3-black w3-card-2">
		<div class="row">
			<div class="col-md-3 w3-center">
	   			<img src='<?php echo $logoData."?".$nocahce; ?>' style='width:50%; '>
	    	</div>
	    	<div class="col-md-8">
	    		<div class="w3-padding-top"></div>
	   			<label class='w3-xlarge'>PASTRY PROJECT BAKE SHOP & CAFE</label>
	   			<p class='w3-medium'>
					   <!-- Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation, sunt in culpa qui officia deserunt mollit anim id est laborum. -->
					   <!-- Pastry Project, owned by Lawrence Goguanco, started in 2016 as an online shop but has now evolved into a bakeshop and cafe. It serves a variety of pastries - cakes, cookies, bars, and more. It also offers delicious pizza, pasta & rice meals. Pastry Project ensures that there is passion and perfection in every creation.  -->

					   <label><span class='fa fa-map-marker'></span>&emsp;Poblacion 7, 4232 Tanauan City, Batangas</label><br>
					   <label><span class='fa fa-phone'></span>&emsp;+6397-718-7414</label><br>
					   <label><span class='fa fa-book'></span>&emsp;pastryproject.bc@gmailcom</label>
	   			</p>
	    	</div>
	    </div>
		<div class="w3-padding-top"></div>
	    <div class="row">
    		<div class="col-md-12 w3-grey w3-padding-12">
    			<!-- <div class=""> -->
					<?php include "userNavi.php";?>
    			<!-- </div> -->
    		</div>
    	</div>
    </div>
</div>