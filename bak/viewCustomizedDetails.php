<?php
$path = $_SERVER['DOCUMENT_ROOT']."/";
set_include_path($path);
include('Modules/mysqliConnection.php');

$productId = isset($_REQUEST['productId']) ? $_REQUEST['productId'] : "";

$sql = "SELECT * FROM productinformation WHERE productId = ".$productId;
$queryOrdered = $db->query($sql);
if($queryOrdered AND $queryOrdered->num_rows > 0)
{
    $resultOrdered = $queryOrdered->fetch_assoc();
    $productOrderName = $resultOrdered['productName'];
    $productOrderPrice = $resultOrdered['productPrice'];
    $productImage = $resultOrdered['productImage'];
    $categoryId = $resultOrdered['categoryId'];
    $userId = $resultOrdered['designedBy'];

    // $sql = "SELECT * FROM cakeflavors WHERE status = 0 AND flavorId = ".$flavorId;
    // $queryFlavors = $db->query($sql);
    // if($queryFlavors AND $queryFlavors->num_rows > 0)
    // {
    //     $resultFlavors = $queryFlavors->fetch_assoc();
    //     $flavorName = $resultFlavors['flavorName'];
    // }
}
$pathData = "Custom/Customized Cakes/";
echo "<img src='".$pathData.$productImage."' width='100%'>";
echo "<div class='row'>";
	echo "<div class='col-md-12'>";
		echo "<div class='w3-padding-top'></div>";
		echo "<label>PRODUCT NAME : ".$productOrderName."</label><br>";
		echo "<label>PRICE : ".$productOrderPrice." PHP</label><br>";
		echo "<table class='table table-condensed table striped'>";
			echo "<thead class='w3-black'>";
				echo "<th class='w3-center'>LAYER</th>";
				echo "<th class='w3-center'>FLAVOR</th>";
			echo "</thead>";
			echo "<tbody>";
			$sql = "SELECT * FROM cakecustomizedinfo WHERE decorationId = 16 AND productId = ".$productId." ORDER BY layerNumber ASC";
			$queryCustomizedInfo = $db->query($sql);
			if($queryCustomizedInfo AND $queryCustomizedInfo->num_rows > 0)
			{
				while($resultCustomizedInfo = $queryCustomizedInfo->fetch_assoc())
				{
					$layerNumber = $resultCustomizedInfo['layerNumber'];
					$flavorId = $resultCustomizedInfo['flavorId'];

					$sql = "SELECT * FROM cakeflavors WHERE status = 0 AND flavorId = ".$flavorId;
					$queryFlavors = $db->query($sql);
					if($queryFlavors AND $queryFlavors->num_rows > 0)
					{
						$resultFlavors = $queryFlavors->fetch_assoc();
						$flavorName = $resultFlavors['flavorName'];
						
						echo "<tr>";
							echo "<td class='w3-center'>LAYER ".$layerNumber."</td>";
							echo "<td class='w3-center'>".$flavorName."</td>";
						echo "</tr>";
					}

				}
			}
			echo "</tbody>";
		echo "</table>";
		echo "<table class='table table-bordered table-condensed table-striped'>";
			echo "<thead class='w3-black'>";
				echo "<th class='w3-center'>#</th>";
				echo "<th class='w3-center'>TYPE</th>";
				echo "<th class='w3-center'>CODE</th>";
				echo "<th class='w3-center'>COUNT</th>";
			echo "</thead>";
		$x = 0;
		$sql = "SELECT COUNT(decorationId) AS totalDeco, decorationId FROM cakecustomizedinfo WHERE productId = ".$productId." AND userId = ".$userId." AND customStatus = 1 GROUP BY decorationId";
		$queryDetails = $db->query($sql);
		if($queryDetails AND $queryDetails->num_rows > 0)
		{
			while($resultDetails = $queryDetails->fetch_assoc())
			{
				$decorationId = $resultDetails['decorationId'];	
				$totalDeco = $resultDetails['totalDeco'];	

				$sql = "SELECT * FROM cakedecorationdetails WHERE decorationId = ".$decorationId;
				$queryDeco = $db->query($sql);
				if($queryDeco AND $queryDeco->num_rows > 0)
				{
					$resultDeco = $queryDeco->fetch_assoc();
					$decorationCode = $resultDeco['decorationCode'];
					$decorationType = $resultDeco['decorationType'];
				}

				echo "<tr>";
					echo "<td class='w3-center'><b>".++$x."</b></td>";
					echo "<td class='w3-center'>".$decorationType."</td>";
					echo "<td class='w3-center'>".$decorationCode."</td>";
					echo "<td class='w3-center'>".$totalDeco."</td>";
				echo "</tr>";
			} 
		}
		echo "</table>";
	echo "</div>";
echo "</div>";
?>