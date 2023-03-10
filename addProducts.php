
<?php
$path = $_SERVER['DOCUMENT_ROOT']."/";
set_include_path($path);
include('Modules/mysqliConnection.php');

if(isset($_POST['saveBtn']))
{
    $productCategory = isset($_POST['productCategory']) ? $_POST['productCategory'] : "";
    $productImage = isset($_POST['productImage']) ? $_POST['productImage'] : "";
    $productName = isset($_POST['productName']) ? $_POST['productName'] : "";
    $productDetails = isset($_POST['productDetails']) ? $_POST['productDetails'] : "";
    $productPrice = isset($_POST['productPrice']) ? $_POST['productPrice'] : "";
    $productStatus = isset($_POST['productStatus']) ? $_POST['productStatus'] : "";
    $productStock = isset($_POST['productStock']) ? $_POST['productStock'] : "";

    $sql = "INSERT INTO `productinformation`(`productName`, `productDetails`, `productPrice`, `categoryId`, `productImage`, `productStatus`, `stock`) 
                                     VALUES ('".$productName."', '".$productDetails."', ".$productPrice.", ".$productCategory.", '".$productImage."', ".$productStatus.", ".$productStock.")";
    $queryInsert = $db->query($sql);

    $productId = $db->insert_id;

    // Check if file was uploaded without errors
    if(isset($_FILES["productImage"]) && $_FILES["productImage"]["error"] == 0)
    {
        $filename = $_FILES["productImage"]["name"];
        // Verify file extension
        $allowed = Array ("jpg", "jpeg", "png", "bmp", "gif", "JPG", "JPEG", "PNG");
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        // Verify MYME type of the file
        if(in_array($ext, $allowed))
        {
            // if($productCategory == 1) $folder = "Birthday Cakes/";
            // if($productCategory == 2) $folder = "Wedding Cakes/";
            // if($productCategory == 3) $folder = "Cup Cakes/";
            // if($productCategory == 6) $folder = "Christening Cakes/";
            // if($productCategory == 7) $folder = "Graduation Cakes/";
            $sql = "SELECT categoryName FROM productcategories WHERE categoryId = ".$productCategory;
            $queryFolders = $db->query($sql);
            if($queryFolders AND $queryFolders->num_rows > 0)
            {
                $resultFolders = $queryFolders->fetch_assoc();
                $folder = $resultFolders['categoryName']."/";
            }

            $pathFolder = $_SERVER['DOCUMENT_ROOT']."/Custom/".$folder;
            move_uploaded_file($_FILES["productImage"]["tmp_name"], $pathFolder.$_FILES["productImage"]["name"]);

            $pathRoot = $pathFolder.$_FILES["productImage"]["name"];
            $pathRootName = $pathFolder.$productCategory."_".$productId.".".$ext;
            
            $sql = "UPDATE productinformation SET productImage = '".$productCategory."_".$productId.".".$ext."' WHERE productId = ".$productId;
            $queryUpdate = $db->query($sql);

            rename($pathRoot,$pathRootName);
        }
        else
        {
            echo "Invalid File Format.";
            exit(0);
        }
    }

    header("location:dashboard.php");

    exit(0);
}
?>
<form id='addProductForm' action='<?php echo $_SERVER['PHP_SELF']; ?>' enctype='multipart/form-data' method='POST'></form>
<div class='container-fluid'>
    <div class='row'>
        <div class='col-md-12'>
            <div class='w3-container'>
                <label class=""><b>CATEGORY</b></label>
                <select form='addProductForm' class="w3-select w3-border" name='productCategory' type="combobox" required>
                    <option value="">Choose your option</option>
                    <?php
                    $sql = "SELECT categoryName, categoryId FROM productcategories WHERE categoryId != 5";
                    $queryCategory = $db->query($sql);
                    if($queryCategory AND $queryCategory->num_rows > 0)
                    {
                        while($resultCategory = $queryCategory->fetch_assoc())
                        {
                            $categoryId = $resultCategory['categoryId'];
                            $categoryName = $resultCategory['categoryName'];
                            echo "<option value=".$categoryId.">".$categoryName."</option>";
                        }
                    }
                    ?>
                </select>
                
                <div class='w3-padding-top'></div>
                <label class=""><b>PRODUCT PHOTO (OPTIONAL)</b></label>
                <input form='addProductForm' class="w3-input w3-border" name='productImage' type="file">

                <div class='w3-padding-top'></div>
                <label class=""><b>PRODUCT NAME</b></label>
                <input form='addProductForm' class="w3-input w3-border" name='productName' type="text" required>
                
                <div class='w3-padding-top'></div>
                <label class=""><b>PRODUCT DETAILS</b></label>
                <input form='addProductForm' class="w3-input w3-border" name='productDetails' type="text">
                
                <div class='w3-padding-top'></div>
                <label class=""><b>PRODUCT PRICE</b></label>
                <input form='addProductForm' class="w3-input w3-border" name='productPrice' type="number" min=0 step='any' required>

                <div class='w3-padding-top'></div>
                <label class=""><b>PRODUCT STOCK</b></label>
                <input form='addProductForm' class="w3-input w3-border" name='productStock' type="number" min=0 step='any' required>

                <div class='w3-padding-top'></div>
                <label class=""><b>STATUS</b></label>
                <select form='addProductForm' class="w3-select w3-border" name='productStatus' type="combobox" required>
                    <option value="">Choose your option</option>
                    <option value="1">ACTIVE</option>
                    <option value="2">INACTIVE</option>
                </select>

                <div class='w3-padding-top'></div>
                <div class='w3-right'>
                    <button form='addProductForm' name='saveBtn' class='w3-btn w3-round w3-black'><i class='fa fa-send-o'></i>&emsp;<b>SAVE</b></button>
                </div>
            </div>
        </div>
    </div>
</div>
