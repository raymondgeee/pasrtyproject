<?php

$imageFile = isset($_GET['imageFile']) ? $_GET['imageFile'] : "";
$pathFolder = $_SERVER['DOCUMENT_ROOT']."/Proof Photos/";
$pathRootName = $pathFolder.$imageFile;

$ext = pathinfo($pathRootName, PATHINFO_EXTENSION);

$fsize = filesize($pathRootName);
header("Pragma: public");
header("Expires: 0");
header("Content-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Control: private", false);
header("Content-Type: image/".$ext);
header("Content-Disposition: attachment; filename=\"".basename($pathRootName)."\";");
header("Content-Transfer-Encoding: binary");
header("Content-Length: ".$fsize);

ob_clean();
flush();
readfile($pathRootName);
?>