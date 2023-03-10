
<?php
$path = $_SERVER['DOCUMENT_ROOT']."/";
set_include_path($path);
include('Modules/mysqliConnection.php');

if(isset($_POST['saveBtn']))
{
    $decoImage = isset($_POST['decoImage']) ? $_POST['decoImage'] : "";
    $decoCode = isset($_POST['decoCode']) ? $_POST['decoCode'] : "";
    $decoPrice = isset($_POST['decoPrice']) ? $_POST['decoPrice'] : "";
    $decoType = isset($_POST['decoType']) ? $_POST['decoType'] : "";

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
            
            $sql = "INSERT INTO `cakedecorationdetails`(    `decorationCode`, 
                                                            `decorationPrice`, 
                                                            `decorationImage`, 
                                                            `decorationType`
                                                       ) 
                                                VALUES (
                                                            '".$decoCode."', 
                                                            ".$decoPrice.", 
                                                            '".$decoCode.".".$ext."', 
                                                            '".$decoType."'
                                                       )";
            $queryInsert = $db->query($sql);

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
?>
<form id='addProductForm' action='<?php echo $_SERVER['PHP_SELF']; ?>' enctype='multipart/form-data' method='POST'></form>
<div class='container-fluid'>
    <div class='row'>
        <div class='col-md-12'>
            <div class='w3-container'>
                <label class=""><b>PHOTO</b></label>
                <input form='addProductForm' class="w3-input w3-border" name='decoImage' type="file" required>

                <div class='w3-padding-top'></div>
                <label class=""><b>CODE</b></label>
                <input form='addProductForm' class="w3-input w3-border" name='decoCode' type="text" required>
                
                <div class='w3-padding-top'></div>
                <label class=""><b>PRODUCT PRICE</b></label>
                <input form='addProductForm' class="w3-input w3-border" name='decoPrice' type="number" min=0 step='any' required>

                <div class='w3-padding-top'></div>
                <label class=""><b>TYPE</b></label>
                <input form='addProductForm' class="w3-input w3-border" name='decoType' type="text" required>

                <div class='w3-padding-top'></div>
                <div class='w3-right'>
                    <button form='addProductForm' name='saveBtn' class='w3-btn w3-round w3-black'><i class='fa fa-send-o'></i>&emsp;<b>SAVE</b></button>
                </div>
            </div>
        </div>
    </div>
</div>
