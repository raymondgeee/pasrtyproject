<?php
$path = $_SERVER['DOCUMENT_ROOT']."/";
set_include_path($path);
include('Modules/mysqliConnection.php');
$userId = $_SESSION['userId'];

$productId = $_GET['productId'];
$sql = "SELECT * FROM productinformation WHERE productId = ".$productId." ORDER BY productId ASC";
$queryCategory = $db->query($sql);
if($queryCategory AND $queryCategory->num_rows > 0)
{
    $resultCategory = $queryCategory->fetch_assoc();
    $categoryId = $resultCategory['categoryId'];
    $productName = $resultCategory['productName'];
    $productDetails = $resultCategory['productDetails'];
    $productPrice = $resultCategory['productPrice'];
    $productImage = $resultCategory['productImage'];
    
    if($categoryId == 5)
    {
        $folder = "Custom/Customized Cakes/";
    }
    else
    {
        $sql = "SELECT categoryName FROM productcategories WHERE categoryId = ".$categoryId;
        $queryCategories = $db->query($sql);
        if($queryCategories AND $queryCategories->num_rows > 0)
        {
            $resultCategories = $queryCategories->fetch_assoc();
            $categoryName = $resultCategories['categoryName'];
            $folder = "Custom/".$categoryName."/";
        }
    }

	$pathImage = "Uploads/index_1.jpg";
	if(file_exists($folder.$productImage))
	{
		$pathImage = $folder.$productImage;
	}
    
    echo "<img src='".$pathImage."' width='100%'>";
    echo "<div class='w3-container w3-padding'>";
		echo "<label class='w3-tiny'><b>".strtoupper($productName)."</b></label>";
		echo "<div class='w3-padding-top'></div>";
		echo "<label class='w3-tiny'><b>".$productDetails."</b></label>";
	echo "</div>";
}
?>