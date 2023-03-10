
<?php
$path = $_SERVER['DOCUMENT_ROOT']."/";
set_include_path($path);
include('Modules/mysqliConnection.php');

if(isset($_POST['saveBtn']))
{
    $featured = $_FILES['featured']["name"];

    foreach ($featured as $key => $filename) 
    {
        if($filename != "")
        {
            if(isset($_FILES["featured"]) && $_FILES["featured"]["error"][$key] == 0)
            {
                $allowed = Array ("jpg", "jpeg", "png", "bmp", "gif", "JPG", "JPEG", "PNG");
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                // Verify MYME type of the file
                if(in_array($ext, $allowed))
                {
                    $folder = "Uploads/";
                    $pathFolder = $_SERVER['DOCUMENT_ROOT']."/".$folder;
                    move_uploaded_file($_FILES["featured"]["tmp_name"][$key], $pathFolder.$_FILES["featured"]["name"][$key]);

                    $pathRoot = $pathFolder.$_FILES["featured"]["name"][$key];
                    $pathRootName = $pathFolder."featuredImage_".$key.".".$ext;

                    rename($pathRoot,$pathRootName);
                }
                else
                {
                    echo "Invalid File Format.";
                    exit(0);
                }
            }
        }
    }

    header("location:settings.php"); 
    exit(0);
}

?>
<form id='updateProductForm' action='<?php echo $_SERVER['PHP_SELF']; ?>' enctype='multipart/form-data' method='POST'></form>
<div class='container-fluid'>
    <div class='row'>
        <div class='col-md-12'>
            <div class='w3-container'>
                <label class=""><b>FEATURED PHOTO # 1</b></label>
                <input form='updateProductForm' class="w3-input w3-border" name='featured[1]' type="file">

                <div class='w3-padding-top'></div>
                <label class=""><b>FEATURED PHOTO # 2</b></label>
                <input form='updateProductForm' class="w3-input w3-border" name='featured[2]' type="file">

                <div class='w3-padding-top'></div>
                <label class=""><b>FEATURED PHOTO # 3</b></label>
                <input form='updateProductForm' class="w3-input w3-border" name='featured[3]' type="file">

                <div class='w3-padding-top'></div>
                <div class='w3-right'>
                    <button form='updateProductForm' name='saveBtn' class='w3-btn w3-round w3-black'><i class='fa fa-send-o'></i>&emsp;<b>UPLOAD</b></button>
                </div>
            </div>
        </div>
    </div>
</div>
