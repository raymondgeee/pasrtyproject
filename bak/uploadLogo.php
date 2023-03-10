
<?php
$path = $_SERVER['DOCUMENT_ROOT']."/";
set_include_path($path);
include('Modules/mysqliConnection.php');

if(isset($_POST['saveBtn']))
{
    if(isset($_FILES["logoData"]) && $_FILES["logoData"]["error"] == 0)
    {
        $filename = $_FILES['logoData']["name"];
        $allowed = Array ("png", "PNG");
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        // Verify MYME type of the file
        if(in_array($ext, $allowed))
        {
            $folder = "Custom/Logos/";
            $pathFolder = $_SERVER['DOCUMENT_ROOT']."/".$folder;
            move_uploaded_file($_FILES["logoData"]["tmp_name"], $pathFolder.$_FILES["logoData"]["name"]);

            $pathRoot = $pathFolder.$_FILES["logoData"]["name"];
            $pathRootName = $pathFolder."logo.".$ext;

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

?>
<form id='updateProductForm' action='<?php echo $_SERVER['PHP_SELF']; ?>' enctype='multipart/form-data' method='POST'></form>
<div class='container-fluid'>
    <div class='row'>
        <div class='col-md-12'>
            <div class='w3-container'>
                <label class=""><b>YOUR LOGO</b></label>
                <div class="w3-right w3-tiny w3-text-pink"><i>PNG FORMAT ONLY</i></div>
                <input form='updateProductForm' class="w3-input w3-border" name='logoData' type="file">
                <div class='w3-padding-top'></div>
                <div class='w3-right'>
                    <button form='updateProductForm' name='saveBtn' class='w3-btn w3-round w3-black'><i class='fa fa-send-o'></i>&emsp;<b>UPLOAD</b></button>
                </div>
            </div>
        </div>
    </div>
</div>
