
<?php
$path = $_SERVER['DOCUMENT_ROOT']."/";
set_include_path($path);
include('Modules/mysqliConnection.php');

if(isset($_POST['saveBtn']))
{
    $flavorImage = isset($_POST['flavorImage']) ? $_POST['flavorImage'] : "";
    $flavorName = isset($_POST['flavorName']) ? $_POST['flavorName'] : "";
    $flavorPrice = isset($_POST['flavorPrice']) ? $_POST['flavorPrice'] : "";
    $flavorStatus = isset($_POST['flavorStatus']) ? $_POST['flavorStatus'] : "";

    // Check if file was uploaded without errors
    if(isset($_FILES["flavorImage"]) && $_FILES["flavorImage"]["error"] == 0)
    {
        $filename = $_FILES["flavorImage"]["name"];
        // Verify file extension
        $allowed = Array ("jpg", "jpeg", "png", "bmp", "gif", "JPG", "JPEG", "PNG");
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        // Verify MYME type of the file
        if(in_array($ext, $allowed))
        {
            $folder = "Flavors/";
            $pathFolder = $_SERVER['DOCUMENT_ROOT']."/Custom/".$folder;
            move_uploaded_file($_FILES["flavorImage"]["tmp_name"], $pathFolder.$_FILES["flavorImage"]["name"]);

            $flavorNameData = explode(" ", $flavorName);
            $fl = implode("_",$flavorNameData);
            $pathRoot = $pathFolder.$_FILES["flavorImage"]["name"];
            $pathRootName = $pathFolder.$fl.".".$ext;
            
            $sql = "INSERT INTO `cakeflavors`  (    `flavorName`, 
                                                    `flavorPrice`, 
                                                    `image`, 
                                                    `status`
                                                ) 
                                        VALUES (
                                                    '".$flavorName."', 
                                                    ".$flavorPrice.", 
                                                    '".$fl.".".$ext."', 
                                                    '".$flavorStatus."'
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
                <input form='addProductForm' class="w3-input w3-border" name='flavorImage' type="file" required>

                <div class='w3-padding-top'></div>
                <label class=""><b>FLAVOR NAME</b></label>
                <input form='addProductForm' class="w3-input w3-border" name='flavorName' type="text" required>
                
                <div class='w3-padding-top'></div>
                <label class=""><b>FLAVOR PRICE</b></label>
                <input form='addProductForm' class="w3-input w3-border" name='flavorPrice' type="number" min=0 step='any' required>

                <div class='w3-padding-top'></div>
                <label class=""><b>STATUS</b></label>
                <select form='addProductForm' class="w3-input w3-border" name='flavorStatus' type="combobox" required>
                    <option value='0'>ACTIVE</option>
                    <option value='1'>INACTIVE</option>
                </select>   
                <div class='w3-padding-top'></div>
                <div class='w3-right'>
                    <button form='addProductForm' name='saveBtn' class='w3-btn w3-round w3-black'><i class='fa fa-send-o'></i>&emsp;<b>SAVE</b></button>
                </div>
            </div>
        </div>
    </div>
</div>
