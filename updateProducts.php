<?php
$path = $_SERVER['DOCUMENT_ROOT']."/";
set_include_path($path);
include('Modules/mysqliConnection.php');

$productId = isset($_REQUEST['productId']) ? $_REQUEST['productId'] : "";

if(isset($_POST['updateBtn']))
{
    $productCategory = isset($_POST['productCategory']) ? $_POST['productCategory'] : "";
    $productImage = isset($_POST['productImage']) ? $_POST['productImage'] : "";
    $productName = isset($_POST['productName']) ? $_POST['productName'] : "";
    $productDetails = isset($_POST['productDetails']) ? $_POST['productDetails'] : "";
    $productPrice = isset($_POST['productPrice']) ? $_POST['productPrice'] : "";
    $productStatus = isset($_POST['productStatus']) ? $_POST['productStatus'] : "";
    $productStock = isset($_POST['productStock']) ? $_POST['productStock'] : "";

    $sql = "UPDATE productinformation SET   productName = '".$productName."',
                                            categoryId = '".$productCategory."',
                                            productDetails = '".$productDetails."',
                                            productPrice = '".$productPrice."',
                                            productStatus = '".$productStatus."',
                                            stock = '".$productStock."'
                                      WHERE productId = ".$productId;
    $queryUpdate = $db->query($sql);

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
            // if($productCategory == 5) $folder = "Customized Cakes/";
            // if($productCategory == 6) $folder = "Christening Cakes/";
            // if($productCategory == 7) $folder = "Graduation Cakes/";
            // if($productCategory > 7) $folder = "Others/";
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
            
            echo $sql = "UPDATE productinformation SET productImage = '".$productCategory."_".$productId.".".$ext."' WHERE productId = ".$productId;
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


$sql = "SELECT * FROM productinformation WHERE productId = ".$productId;
$queryProduct = $db->query($sql);
if($queryProduct AND $queryProduct->num_rows > 0)
{
    $resultProduct = $queryProduct->fetch_assoc();
    $productName = $resultProduct['productName'];
    $productDetails = $resultProduct['productDetails'];
    $productImage = $resultProduct['productImage'];
    $productPrice = $resultProduct['productPrice'];
    $categoryId = $resultProduct['categoryId'];
    $productStatus = $resultProduct['productStatus'];
    $stock = $resultProduct['stock'];

    $activeSelect = ($productStatus == 1) ? "selected" : "";
    $inActiveSelect = ($productStatus == 2) ? "selected" : "";
}

?>

<form id='updateProductForm' action='<?php echo $_SERVER['PHP_SELF']; ?>' enctype='multipart/form-data' method='POST'></form>
<input form='updateProductForm' type='hidden' name='productId' value='<?php echo $productId;?>'>
<div class='container-fluid'>
    <div class='row'>
        <div class='col-md-12'>
            <div class='w3-container'>
                <label class=""><b>CATEGORY</b></label>
                <select form='updateProductForm' class="w3-select w3-border" name='productCategory' type="combobox">
                    <option value="">Choose your option</option>
                    <?php
                    $sql = "SELECT * FROM productcategories";
                    $queryCategory = $db->query($sql);
                    if($queryCategory AND $queryCategory->num_rows > 0)
                    {
                        while($resultCategory = $queryCategory->fetch_assoc())
                        {
                            $categoryID= $resultCategory['categoryId'];
                            $categoryName = $resultCategory['categoryName'];

                            $selectedCategory = ($categoryId == $categoryID) ? 'selected' : '';
                            echo "<option ".$selectedCategory." value='".$categoryID."'>".$categoryName."</option>";
                        }
                    }
                    ?>
                </select>
                
                <div class='w3-padding-top'></div>
                <label class=""><b>PRODUCT PHOTO (OPTIONAL) <i class='text-xs'><?php  echo $productImage; ?></i></b></label>
                <input form='updateProductForm' class="w3-input w3-border" name='productImage' type="file">

                <div class='w3-padding-top'></div>
                <label class=""><b>PRODUCT NAME</b></label>
                <input form='updateProductForm' class="w3-input w3-border" name='productName' type="text" value='<?php echo $productName; ?>' required>
                
                <div class='w3-padding-top'></div>
                <label class=""><b>PRODUCT DETAILS</b></label>
                <input form='updateProductForm' class="w3-input w3-border" name='productDetails' type="text" value='<?php echo $productDetails; ?>'>
                
                <div class='w3-padding-top'></div>
                <label class=""><b>PRODUCT PRICE</b></label>
                <input form='updateProductForm' class="w3-input w3-border" name='productPrice' type="number" min=0 step='any' value='<?php echo $productPrice; ?>' required>

                <div class='w3-padding-top'></div>
                <label class=""><b>PRODUCT STOCK</b></label>
                <input form='updateProductForm' class="w3-input w3-border" name='productStock' type="number" min=0 step='1' value='<?php echo $stock; ?>' required>

                <div class='w3-padding-top'></div>
                <label class=""><b>STATUS</b></label>
                <select form='updateProductForm' class="w3-select w3-border" name='productStatus' type="combobox" required>
                    <option value="">Choose your option</option>
                    <option <?php echo $activeSelect; ?> value="1">ACTIVE</option>
                    <option <?php echo $inActiveSelect; ?> value="2">INACTIVE</option>
                </select>

                <div class='w3-padding-top'></div>
                <div class='w3-right'>
                    <button form='updateProductForm' name='updateBtn' class='w3-btn w3-round w3-black'><i class='fa fa-send-o'></i>&emsp;<b>UPDATE</b></button>
                </div>
            </div>
        </div>
    </div>
</div>