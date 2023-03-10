<?php
$path = $_SERVER['DOCUMENT_ROOT']."/";
set_include_path($path);
include('Modules/mysqliConnection.php');

function delete_directory($dirname) {
    if (is_dir($dirname))
      $dir_handle = opendir($dirname);
        if (!$dir_handle)
            return false;
        while($file = readdir($dir_handle)) {
            if ($file != "." && $file != "..") {
                if (!is_dir($dirname."/".$file))
                        unlink($dirname."/".$file);
                else
                        delete_directory($dirname.'/'.$file);
            }
        }
        closedir($dir_handle);
        rmdir($dirname);
        return true;
}

$categoryId = isset($_POST['categoryId']) ? $_POST['categoryId'] : "";

$sql = "SELECT categoryName FROM productcategories WHERE categoryId = ".$categoryId;
$queryFolders = $db->query($sql);
if($queryFolders AND $queryFolders->num_rows > 0)
{
    $resultFolders = $queryFolders->fetch_assoc();
    $folder = $resultFolders['categoryName'];

    $pathFolder = $_SERVER['DOCUMENT_ROOT']."/Custom/".$folder."/";
    delete_directory($pathFolder);
}

$sql = "DELETE FROM productcategories WHERE categoryId = ".$categoryId." LIMIT 1";
$queryDelete = $db->query($sql);
?>