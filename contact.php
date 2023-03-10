<?php
$path = $_SERVER['DOCUMENT_ROOT']."/";
set_include_path($path);
include('Modules/mysqliConnection.php');
$categoryId = isset($_GET['categoryId']) ? $_GET['categoryId'] : "";
$userId = $_SESSION['userId'];

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

$activeButtonMain = "";
$activeButtonSumm = "";
$activeButtonProf = "";
$activeButtonCont = "true";
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
        <div class="row w3-padding">
            <!-- <div class="col-md-12">
                <div class="w3-right">
                    <?php include "userNavi.php";?>
                </div>
            </div> -->
        </div>
        <div class='w3-padding-top'></div>
        <div class='row'>
            <div class='col-md-12'>
                <div class='w3-center'>
                    <h1><b class='w3-text-black'>GET IN TOUCH WITH US</b></h1>
                </div>
            </div>  
        </div>
        <div class='row'>
            <div class='col-md-3'></div>
            <div class='col-md-6'>
                <div class='w3-center'>
                <!-- Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation, sunt in culpa qui officia deserunt mollit anim id est laborum. -->
                <label class='w3-large'>
                    Pastry Project, owned by Lawrence Goguanco, started in 2016 as an online shop but has now evolved into a bakeshop and cafe. It serves a variety of pastries - cakes, cookies, bars, and more. It also offers delicious pizza, pasta & rice meals. Pastry Project ensures that there is passion and perfection in every creation.
                </label>
                </div>
            </div>  
        </div>
        <hr>
        <div class='row'>
            <div class='w3-container'>
                
                <div class='col-md-4 '>
                    <div class='row'>
                        <div class='col-md-4 col-sm-4 col-xs-4'></div>
                        <div class='col-md-8 col-sm-8 col-xs-8'>
                            <span class='circle w3-black w3-card-2'>
                                <i class=' w3-text white fa fa-map-marker fa-4x'></i>
                            </span>  
                        </div>  
                        <div class='col-md-4'></div>
                    </div>  
                    <div class='row w3-padding-top'>
                        <div class='col-md-2'></div>
                        <div class='col-md-8 w3-center'>
                            <label class='w3-large'>ADDRESS</label>
                            <p>
                                <div><b>Poblacion7, 4232</b></div>
                                <div>Tanauan City, Batangas</div>
                            </p>
                        </div>  
                        <div class='col-md-2'></div>
                    </div>
                </div> 
                <div class='col-md-4 '>
                    <div class='row'>
                        <div class='col-md-4 col-sm-4 col-xs-4'></div>
                        <div class='col-md-8 col-sm-8 col-xs-8'>
                            <span class='circle w3-black w3-card-2'>
                                <i class=' w3-text white fa fa-phone fa-4x'></i>
                            </span>  
                        </div>  
                        <div class='col-md-4'></div>
                    </div>  
                    <div class='row w3-padding-top'>
                        <div class='col-md-2'></div>
                        <div class='col-md-8 w3-center'>
                            <label class='w3-large'>PHONE</label>
                            <p>
                                <div><b>For Orders and Inquiries</b></div>
                                <div>09771874141</div>
                            </p>
                        </div>  
                        <div class='col-md-2'></div>
                    </div>
                </div>  
                <div class='col-md-4 w3-center'>
                    <div class='row'>
                        <div class='col-md-4 col-sm-4 col-xs-4'></div>
                        <div class='col-md-8 col-sm-8 col-xs-8'>
                            <span class='circle w3-black w3-card-2'>
                                <i class=' w3-text white fa fa-commenting-o fa-4x'></i>
                            </span>  
                        </div>  
                        <div class='col-md-4'></div>
                    </div>  
                    <div class='row w3-padding-top'>
                        <div class='col-md-2'></div>
                        <div class='col-md-8 w3-center'>
                            <label class='w3-large'>EMAIL</label>
                            <p>
                                <div><b>GMAIL</b></div>
                                <div>pastryproject.bc@gmailcom</div>
                            </p>
                        </div>  
                        <div class='col-md-2'></div>
                    </div>
                </div>  
            </div>
        </div>
        <hr>
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