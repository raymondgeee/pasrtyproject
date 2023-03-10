
<?php
$path = $_SERVER['DOCUMENT_ROOT']."/";
set_include_path($path);
include('Modules/mysqliConnection.php');

if(isset($_POST['saveBtn']))
{
    $decorationId = isset($_POST['decorationId']) ? $_POST['decorationId'] : "";
    $decoImage = isset($_POST['decoImage']) ? $_POST['decoImage'] : "";
    $decoCode = isset($_POST['decoCode']) ? $_POST['decoCode'] : "";
    $decoPrice = isset($_POST['decoPrice']) ? $_POST['decoPrice'] : "";
    $decoType = isset($_POST['decoType']) ? $_POST['decoType'] : "";
    $availability = isset($_POST['availability']) ? $_POST['availability'] : "";

    $sql = "UPDATE `cakedecorationdetails` SET `decorationCode`= '".$decoCode."',
    										   `decorationPrice`= '".$decoPrice."',
    										   `decorationType`= '".$decoType."',
    										   `availability`= '".$availability."'
    							WHERE decorationId = ".$decorationId;
    $queryUpdate = $db->query($sql);
    // Check if file was uploaded without errors
    if(isset($_FILES["decoImage"]) && $_FILES["decoImage"]["error"] == 0)
    {
        $filename = $_FILES["decoImage"]["name"];
        // Verify file extension
        $allowed = Array ("jpg", "jpeg", "png", "bmp", "gif", "JPG", "JPEG", "PNG");
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        // Verify MYME type of the file
        if(in_array($ext, $allowed))
        {
            $folder = "Decorations/";
            $pathFolder = $_SERVER['DOCUMENT_ROOT']."/Custom/".$folder;
            move_uploaded_file($_FILES["decoImage"]["tmp_name"], $pathFolder.$_FILES["decoImage"]["name"]);

            $pathRoot = $pathFolder.$_FILES["decoImage"]["name"];
            $pathRootName = $pathFolder.$decoCode.".".$ext;
            
            $sql = "UPDATE `cakedecorationdetails` SET `decorationImage`= '".$decoCode.".".$ext."' WHERE decorationId = ".$decorationId;
            $queryUpdate = $db->query($sql);

            rename($pathRoot,$pathRootName);
        }
        else
        {
            echo "Invalid File Format.";
            exit(0);
        }
    }

    header("location:customizationSettings.php");

    exit(0);
}

$decorationId = isset($_REQUEST['decorationId']) ? $_REQUEST['decorationId'] : "";
$sql = "SELECT * FROM cakedecorationdetails WHERE decorationId = ".$decorationId;
$queryDecoration = $db->query($sql);
if($queryDecoration AND $queryDecoration->num_rows > 0)
{
    $resultDecoration = $queryDecoration->fetch_assoc();
	$decorationCode = $resultDecoration['decorationCode'];
    $decorationPrice = $resultDecoration['decorationPrice'];
    $decorationImage = $resultDecoration['decorationImage'];
    $decorationType = $resultDecoration['decorationType'];
    $availability = $resultDecoration['availability'];

    $activeSelect = ($availability == 0) ? "selected" : "";
    $inActiveSelect = ($availability == 1) ? "selected" : "";
}

?>
<form id='updateProductForm' action='<?php echo $_SERVER['PHP_SELF']; ?>' enctype='multipart/form-data' method='POST'></form>
<input form='updateProductForm' class="w3-input w3-border" name='decorationId' type="hidden" value="<?php echo $decorationId;?>">
<div class='container-fluid'>
    <div class='row'>
        <div class='col-md-12'>
            <div class='w3-container'>
                <label class=""><b>PHOTO : <?php echo $decorationImage; ?></b></label>
                <input form='updateProductForm' class="w3-input w3-border" name='decoImage' type="file">

                <div class='w3-padding-top'></div>
                <label class=""><b>CODE</b></label>
                <input form='updateProductForm' class="w3-input w3-border" name='decoCode' type="text" value="<?php echo $decorationCode;?>" required>
                
                <div class='w3-padding-top'></div>
                <label class=""><b>PRODUCT PRICE</b></label>
                <input form='updateProductForm' class="w3-input w3-border" name='decoPrice' type="number" min=0 step='any' value="<?php echo $decorationPrice;?>"  required>

                <div class='w3-padding-top'></div>
                <label class=""><b>TYPE</b></label>
                <input form='updateProductForm' class="w3-input w3-border" name='decoType' type="text" value="<?php echo $decorationType;?>" required>

                <div class='w3-padding-top'></div>
                <label class=""><b>STATUS</b></label>
                <select form='updateProductForm' class="w3-select w3-border" name='availability' type="combobox" required>
                    <option value="">Choose your option</option>
                    <option <?php echo $activeSelect; ?> value="0">ACTIVE</option>
                    <option <?php echo $inActiveSelect; ?> value="1">INACTIVE</option>
                </select>

                <div class='w3-padding-top'></div>
                <div class='w3-right'>
                    <button form='updateProductForm' name='saveBtn' class='w3-btn w3-round w3-black'><i class='fa fa-send-o'></i>&emsp;<b>UPDATE</b></button>
                </div>
            </div>
        </div>
    </div>
</div>
