<?php
$path = $_SERVER['DOCUMENT_ROOT']."/";
set_include_path($path);
include('Modules/mysqliConnection.php');
$userId = $_SESSION['userId'];

$flavorId = $_GET['flavorId'];
$flavorPath = "Custom/Flavors/";
$sql = "SELECT * FROM cakeflavors WHERE status = 0 AND flavorId = ".$flavorId;
$queryFlavors = $db->query($sql);
if($queryFlavors AND $queryFlavors->num_rows > 0)
{
	$resultFlavors = $queryFlavors->fetch_assoc();
	$flavorId = $resultFlavors['flavorId'];
	$flavorName = $resultFlavors['flavorName'];
	$flavorPrice = $resultFlavors['flavorPrice'];
	$image = $resultFlavors['image'];

    echo "<img src='".$flavorPath.$image."' width='100%'>";
    echo "<div class='w3-container w3-padding'>";
		echo "<label class='w3-tiny'><b>".strtoupper($flavorName)."</b></label>";
		// echo "<div class='w3-padding-top'></div>";
		// echo "<input type='radio' value='".$flavorId."' data-price='".$flavorPrice."' class='w3-radio cakeFlavor' name='cakeFlavor'>";
	echo "</div>";
}
?>