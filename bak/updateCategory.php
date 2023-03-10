<?php
$path = $_SERVER['DOCUMENT_ROOT']."/";
set_include_path($path);
include('Modules/mysqliConnection.php');

$categoryId = isset($_REQUEST['categoryId']) ? $_REQUEST['categoryId'] : "";

if(isset($_POST['updateBtn']))
{
    $categoryName = isset($_POST['categoryName']) ? $_POST['categoryName'] : "";
    $categoryStatus = isset($_POST['categoryStatus']) ? $_POST['categoryStatus'] : "";
    $categoryImage = isset($_POST['categoryImage']) ? $_POST['categoryImage'] : "";

    $sql = "UPDATE productcategories SET categoryName = '".$categoryName."',
                                         categoryStatus = ".$categoryStatus."
                                    WHERE categoryId = ".$categoryId;
    $queryUpdate = $db->query($sql);

    // Check if file was uploaded without errors
    if(isset($_FILES["categoryImage"]) && $_FILES["categoryImage"]["error"] == 0)
    {
        $filename = $_FILES["categoryImage"]["name"];
        // Verify file extension
        $allowed = Array ("jpg", "jpeg", "png", "bmp", "gif", "JPG", "JPEG", "PNG");
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        // Verify MYME type of the file
        if(in_array($ext, $allowed))
        {
            $pathFolder = $_SERVER['DOCUMENT_ROOT']."/Uploads/";
            move_uploaded_file($_FILES["categoryImage"]["tmp_name"], $pathFolder.$_FILES["categoryImage"]["name"]);

            $pathRoot = $pathFolder.$_FILES["categoryImage"]["name"];
            $pathRootName = $pathFolder.$categoryId.".".$ext;
            
            $sql = "UPDATE `productcategories` SET `categoryImage`= '".$categoryId.".".$ext."' WHERE categoryId = ".$categoryId;
            $queryUpdate = $db->query($sql);

            rename($pathRoot,$pathRootName);
        }
        else
        {
            echo "Invalid File Format.";
            exit(0);
        }
    }

    header("location:settings.php");
    exit(0);
}

$sql = "SELECT * FROM productcategories WHERE categoryId = ".$categoryId;
$queryCategory = $db->query($sql);
if($queryCategory AND $queryCategory->num_rows > 0)
{
    $resultCategory = $queryCategory->fetch_assoc();
    $categoryName = $resultCategory['categoryName'];
    $categoryStatus = $resultCategory['categoryStatus'];
    $categoryImage = ($resultCategory['categoryImage'] != '') ? $resultCategory['categoryImage'] : "N/A";

    $categoryActive = ($categoryStatus == 1) ? "selected" : "";
    $categoryInActive = ($categoryStatus == 2) ? "selected" : "";
}
?>
<form id='updateCategoryForm' action='<?php echo $_SERVER['PHP_SELF']; ?>' enctype='multipart/form-data' method='POST'></form>
<input form='updateCategoryForm' type='hidden' name='categoryId' value='<?php echo $categoryId; ?>'>
<div class='container-fluid'>
    <div class='row'>
        <div class='col-md-12'>
            <div class='w3-container'>
                <label class=""><b>PHOTO : <?php echo $categoryImage; ?></b> </label>
                <span class='w3-right'>
                    <i class='w3-tiny w3-text-pink'><b>Recommended : Atleast 200x200px image</b></i>
                </span>
                <input form='updateCategoryForm' class="w3-input w3-border" name='categoryImage' type="file">

                <div class='w3-padding-top'></div>
                <label class=""><b>CATEGORY NAME</b></label>
                <input form='updateCategoryForm' class="w3-input w3-border" name='categoryName' value='<?php echo $categoryName; ?>' type="text" required>

                <div class='w3-padding-top'></div>
                <label class=""><b>STATUS</b></label>
                <select form='updateCategoryForm' class="w3-select w3-border" name='categoryStatus' type="combobox" required>
                    <option value="">Choose your option</option>
                    <option <?php echo $categoryActive; ?> value="1">ACTIVE</option>
                    <option <?php echo $categoryInActive; ?> value="2">INACTIVE</option>
                </select>

                <div class='w3-padding-top'></div>
                <div class='w3-right'>
                    <button form='updateCategoryForm' name='updateBtn' class='w3-btn w3-round w3-black'><i class='fa fa-send-o'></i>&emsp;<b>UPDATE</b></button>
                </div>
            </div>
        </div>
    </div>
</div>