<?php
$path = $_SERVER['DOCUMENT_ROOT']."/";
set_include_path($path);
include('Modules/mysqliConnection.php');

$temp = "";
$sql = "SELECT * FROM userinformation WHERE userId = '".$_SESSION['userId']."'";
$queryUserInfo = $db->query($sql);
if($queryUserInfo AND $queryUserInfo->num_rows == 0)
{
    $temp = "temp";
}

$activeButtonMain = "true";
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
    <link rel="stylesheet" href="Include Files/Bootstrap/Hover-master/css/hover.css">
</head>
<body>
    <div class="container-fluid">
        <?php include "userHeader.php";?>
        <div class="row w3-padding">
            <div class="col-md-12">
                <!-- <?php include "userNavi.php";?> -->
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <label class="w3-large"> FEATURED PRODUCTS</label>
            </div>
        </div>
        <div class="row">
            <?php 
                for ($i=1; $i <=3 ; $i++) 
                { 
                    $imageFeatured = "Uploads/index_1.jpg";
                    if(count(glob("Uploads/featuredImage_".$i.".*")) > 0 )
                    {
                        $featuredImage = glob("Uploads/featuredImage_".$i.".*")[0];

                        if(file_exists($featuredImage))
                        {
                            $imageFeatured = $featuredImage;
                        }
                    }
                    
                    $nocahce = filemtime($imageFeatured);
                    echo "<div class='col-md-4 w3-padding-top'>";
                        echo "<div class='w3-card-8'>";
                            echo "<img src='".$imageFeatured."?".$nocahce."' width='100%' class='w3-round-large' style='height: 400px'>";
                        echo "</div>";
                    echo "</div>";
                }
            ?>
        </div>
        <div class="w3-padding"><hr></div>
        <div class="row">
            <div class="col-md-12">
                <label class="w3-large"> PRODUCT CATEGORIES</label>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 w3-padding-top">
                <div class="w3-card-2">
                    <div class="w3-container w3-black w3-center" style="height: ">
                        <label class='w3-xxlarge'>MENU</label>
                        <div class="w3-padding-top"></div>
                        <div class='w3-bottombar w3-topbar'>
                            <label class='w3-xlarge'>RICE MEAL</label>
                        </div>
                        <br>
                        <div class='row'>
                            <div class='col-md-6'>
                                <label class='w3-small w3-left'>CHICKEN FILLET</label>
                            </div>
                            <div class='col-md-6'>
                                <label class='w3-small w3-right'>130 W/ DRINKS</label>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-6'>
                                <label class='w3-small w3-left'>BEEF BROCCOLI</label>
                            </div>
                            <div class='col-md-6'>
                                <label class='w3-small w3-right'>130 W/ DRINKS</label>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-6'>
                                <label class='w3-small w3-left'>LUMPIANG SHANGHAI</label>
                            </div>
                            <div class='col-md-6'>
                                <label class='w3-small w3-right'>130 W/ DRINKS</label>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-6'>
                                <label class='w3-small w3-left'>FRIED SIOMAI</label>
                            </div>
                            <div class='col-md-6'>
                                <label class='w3-small w3-right'>130 W/ DRINKS</label>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-6'>
                                <label class='w3-small w3-left'>TEMPURA</label>
                            </div>
                            <div class='col-md-6'>
                                <label class='w3-small w3-right'>130 W/ DRINKS</label>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-6'>
                                <label class='w3-small w3-left'>FISH FILLET</label>
                            </div>
                            <div class='col-md-6'>
                                <label class='w3-small w3-right'>130 W/ DRINKS</label>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-6'>
                                <label class='w3-small w3-left'>HONEY GARLIC CHICKEN</label>
                            </div>
                            <div class='col-md-6'>
                                <label class='w3-small w3-right'>130 W/ DRINKS</label>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-6'>
                                <label class='w3-small w3-left'>A LA CARTE <span class='w3-tiny'>NO DRINK</span></label>
                            </div>
                            <div class='col-md-6'>
                                <label class='w3-small w3-right'>120</label>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-6'>
                                <label class='w3-small w3-left'>PLAIN RICE</label>
                            </div>
                            <div class='col-md-6'>
                                <label class='w3-small w3-right'>20</label>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-6'>
                                <label class='w3-medium w3-left'><span class= 'w3-text-yellow'>COMBO MEAL</span></label>
                            </div>
                            <div class='col-md-6'>
                                <label class='w3-small w3-right'>199 W/ DRINKS</label>
                            </div>
                        </div>
                        <br>
                        <div class='w3-bottombar w3-topbar'>
                            <label class='w3-xlarge'>PASTA</label>
                        </div>
                        <br>
                        <div class='row'>
                            <div class='col-md-6'>
                                <label class='w3-small w3-left'>CHICKEN PASTA</label>
                            </div>
                            <div class='col-md-6'>
                                <label class='w3-small w3-right'>110 W/ DRINKS</label>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-6'>
                                <label class='w3-small w3-left'>TUNA PASTA</label>
                            </div>
                            <div class='col-md-6'>
                                <label class='w3-small w3-right'>110 W/ DRINKS</label>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-6'>
                                <label class='w3-small w3-left'>BAKED MAC</label>
                            </div>
                            <div class='col-md-6'>
                                <label class='w3-small w3-right'>110 W/ DRINKS</label>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-6'>
                                <label class='w3-small w3-left'>A LA CARTE <span class='w3-tiny'>NO DRINK</span></label>
                            </div>
                            <div class='col-md-6'>
                                <label class='w3-small w3-right'>120</label>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-6'>
                                <label class='w3-small w3-left'>GARLIC BREAD</label>
                            </div>
                            <div class='col-md-6'>
                                <label class='w3-small w3-right'>5 <span class='w3-tiny w3-text-yellow'>(2) BREADS</span></label>
                            </div>
                        </div>
                        <br>
                        <div class='w3-bottombar w3-topbar'>
                            <label class='w3-xlarge'>OTHERS</label>
                        </div>
                        <br>
                        <div class='row'>
                            <div class='col-md-6'>
                                <label class='w3-small w3-left'>CHICKEN NUGGETS</label>
                            </div>
                            <div class='col-md-6'>
                                <label class='w3-small w3-right'>55</span></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <?php
                    $addQuery = "";
                    if($temp == "temp")
                    {
                        // $addQuery = " AND categoryId NOT IN (5)";
                    }
                    $sql = "SELECT * FROM productcategories WHERE categoryStatus = 1 ".$addQuery." ORDER BY categoryName ASC";
                    $queryCategory = $db->query($sql);
                    if($queryCategory AND $queryCategory->num_rows > 0)
                    {
                        while($resultCategory = $queryCategory->fetch_assoc())
                        {
                            $categoryId = $resultCategory['categoryId'];
                            $categoryName = $resultCategory['categoryName'];
                            $categoryStatus = $resultCategory['categoryStatus'];
                            $categoryImage = $resultCategory['categoryImage'];
                            
                            $imageData = "Uploads/index_1.jpg";
                            if($categoryImage != "")
                            {
                                $pathImage = "Uploads/".$categoryImage;
                                if(file_exists($pathImage))
                                {
                                    $imageData = $pathImage;
                                }
                            }

                            $nocahce = filemtime($imageData);

                            echo "<div class='col-md-4 w3-padding-top hvr-float'>";
                                echo "<div class='w3-card-8 w3-white'>";
                                    if($categoryId == 5)
                                    {
                                        echo "<a href='usercustomize.php'><img src='".$imageData."?".$nocahce."' style='width:100%; height:250px;'></a>";
                                    }
                                    else
                                    {
                                        echo "<a href='products.php?categoryId=".$categoryId."'><img src='".$imageData."?".$nocahce."' style='width:100%; height:250px;'></a>";
                                    }
                                    // echo "<hr>";
                                    echo "<div class='w3-container w3-padding w3-black'>";
                                        echo "<br>";
                                        echo "<label class='w3-medium'><b>".strtoupper($categoryName)."</b></label>";
                                       /* echo "<br>";
                                       echo "<br>";
                                        echo "<div class='w3-right'>";
                                            if($categoryId == 5)
                                            {
                                                echo "<a href='usercustomize.php'><button class='w3-btn w3-black w3-tiny w3-round'><i class='fa fa-sign-in'></i> <b>DETAILS</b></button></a>";
                                            }
                                            else
                                            {
                                                echo "<a href='products.php?categoryId=".$categoryId."'><button class='w3-btn w3-black w3-tiny w3-round'><i class='fa fa-sign-in'></i> <b>DETAILS</b></button></a>";
                                            }
                                        echo "</div>"; */
                                    echo "</div>";
                                echo "</div>";
                            echo "</div>";
                        }
                    }
                    ?>
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
</body>
</html>
<script src="Include Files/Javascript/jQuery 3.1.1/jquery-3.1.1.js"></script>
<script src="Include Files/Javascript/jQuery 3.1.1/jquery-ui.js"></script>
<script src="Include Files/Javascript/jQuery 3.1.1/bootstrap.min.js"></script>
<link rel="stylesheet" href="Include Files/Javascript/iziModal-master/css/iziModal.css" />
<script src="Include Files/Javascript/iziModal-master/js/iziModal.js"></script>
<link rel="stylesheet" href="Include Files/Javascript/iziToast-master/dist/css/iziToast.css" />
<script src="Include Files/Javascript/iziToast-master/dist/js/iziToast.js"></script>