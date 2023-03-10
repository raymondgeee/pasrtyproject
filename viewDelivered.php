<?php
$path = $_SERVER['DOCUMENT_ROOT']."/";
set_include_path($path);
include('Modules/mysqliConnection.php');

$batchNumber = isset($_GET['batchNumber']) ? $_GET['batchNumber'] : "";
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
<body>
    <div class="container-fluid">
        <div class='row'>
            <div class='col-md-12 w3-padding-top'>
                <div class='w3-container w3-padding w3-white w3-card-2'>
                <?php
                echo "<table class='table table-condensed table-striped'>";
                    echo "<thead class='w3-black'>";
                        echo "<th class='w3-center'></th>";
                        echo "<th class='w3-center'>PRODUCT NAME</th>";
                        echo "<th class='w3-center'>ORDER DATE</th>";
                        echo "<th class='w3-center'>PICK UP DATE</th>";
                    echo "</thead>";
                    echo "<tbody>";
                    $sql = "SELECT orderDate, batchNumber, deliveryDate, userId, productId FROM productorders WHERE batchNumber = '".$batchNumber."'";
                    $queryOrders = $db->query($sql);
                    if($queryOrders AND $queryOrders->num_rows > 0)
                    {
                        while($resultOrders = $queryOrders->fetch_assoc())
                        {
                            $productId = $resultOrders['productId'];
                            $batchNumber = $resultOrders['batchNumber'];
                            $deliveryDate = $resultOrders['deliveryDate'];
                            $userId = $resultOrders['userId'];

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
                            }

                            $sql = "SELECT categoryName FROM productcategories WHERE categoryId = ".$categoryId;
                            $queryFolders = $db->query($sql);
                            if($queryFolders AND $queryFolders->num_rows > 0)
                            {
                                $resultFolders = $queryFolders->fetch_assoc();
                                $folder = $resultFolders['categoryName']."/";
                            }

                            $pathFolder = $_SERVER['DOCUMENT_ROOT']."/Custom/".$folder;
                            $imageData = "";
                            if($productImage != "")
                            {
                                $path = "Custom/".$folder."/".$productImage;
                                if(file_exists($path))
                                {
                                    $imageData = "<img src='".$path."' style='width:80px; height:80px;'>";
                                }
                                else
                                {
                                    $imageData = "<img src='Uploads/index_1.jpg' style='width:80px; height:80px;'>";
                                }
                            }
                            else
                            {
                                $imageData = "<img src='Uploads/index_1.jpg' style='width:80px; height:80px;'>";
                            }

                            $orderDate = $resultOrders['orderDate'];

                            $fullName = $picture = $address = $contactNumber = $email = "";
                            $picture = "Profile Pictures/default.png";
                            $sql = "SELECT * FROM userinformation WHERE userId = '".$userId."'";
                            $queryUserInfo = $db->query($sql);
                            if($queryUserInfo AND $queryUserInfo->num_rows > 0)
                            {
                                $resultUserInfo = $queryUserInfo->fetch_assoc();
                                $firstName = $resultUserInfo['firstName'];
                                $surName = $resultUserInfo['surName'];
                                $address = $resultUserInfo['address'];
                                $contactNumber = $resultUserInfo['contactNumber'];
                                $email = $resultUserInfo['email'];
                                $profilePicture = $resultUserInfo['profilePicture'];

                                $targetPath = "Profile Pictures/".$profilePicture;

                                $picture = "Profile Pictures/default.png";
                                if(file_exists($targetPath) AND $profilePicture != "")
                                {
                                    $picture = $targetPath;
                                }
                                
                                $fullName = strtoupper($firstName." ".$surName);
                            }
                            echo "<tr>";
                                echo "<td style='vertical-align:middle;' class='w3-center'>".$imageData."</td>";
                                echo "<td style='vertical-align:middle;' class='w3-center'>".$productName."</td>";
                                echo "<td style='vertical-align:middle;' class='w3-center'>".$orderDate."</td>";
                                echo "<td style='vertical-align:middle;' class='w3-center'>".$deliveryDate."</td>";
                            echo "</tr>";
                        }
                    }
                    echo "</tbody>";
					echo "<tfoot class='w3-black'>";
                        echo "<th></th>";
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
</body>
</html>
<script src="Include Files/Javascript/jQuery 3.1.1/jquery-3.1.1.js"></script>
<script src="Include Files/Javascript/jQuery 3.1.1/jquery-ui.js"></script>
<script src="Include Files/Javascript/jQuery 3.1.1/bootstrap.min.js"></script>
<link rel="stylesheet" href="Include Files/Javascript/iziModal-master/css/iziModal.css" />
<script src="Include Files/Javascript/iziModal-master/js/iziModal.js"></script>
<link rel="stylesheet" href="Include Files/Javascript/iziToast-master/dist/css/iziToast.css" />
<script src="Include Files/Javascript/iziToast-master/dist/js/iziToast.js"></script>