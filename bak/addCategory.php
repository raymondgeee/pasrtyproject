<?php
$path = $_SERVER['DOCUMENT_ROOT']."/";
set_include_path($path);
include('Modules/mysqliConnection.php');

if(isset($_POST['saveBtn']))
{
    $categoryName = isset($_POST['categoryName']) ? $_POST['categoryName'] : "";
    $categoryStatus = isset($_POST['categoryStatus']) ? $_POST['categoryStatus'] : "";

    $sql = "INSERT INTO productcategories (categoryName, categoryStatus) VALUES ('".$categoryName."', ".$categoryStatus.")";
    $queryInsert = $db->query($sql);

    if($queryInsert)
    {
        $pathFolder = $_SERVER['DOCUMENT_ROOT']."/Custom/".$categoryName."/";
        mkdir($pathFolder);
        chmod($pathFolder, 0777);
    }

    header("location:settings.php");
    exit(0);
}
?>
<form id='addCategoryForm' action='<?php echo $_SERVER['PHP_SELF']; ?>' method='POST'></form>
<div class='container-fluid'>
    <div class='row'>
        <div class='col-md-12'>
            <div class='w3-container'>
                <div class='w3-padding-top'></div>
                <label class=""><b>CATEGORY NAME</b></label>
                <input form='addCategoryForm' class="w3-input w3-border" name='categoryName' type="text" required>

                <div class='w3-padding-top'></div>
                <label class=""><b>STATUS</b></label>
                <select form='addCategoryForm' class="w3-select w3-border" name='categoryStatus' type="combobox" required>
                    <option value="">Choose your option</option>
                    <option value="1">ACTIVE</option>
                    <option value="2">INACTIVE</option>
                </select>

                <div class='w3-padding-top'></div>
                <div class='w3-right'>
                    <button form='addCategoryForm' name='saveBtn' class='w3-btn w3-round w3-black'><i class='fa fa-send-o'></i>&emsp;<b>SAVE</b></button>
                </div>
            </div>
        </div>
    </div>
</div>