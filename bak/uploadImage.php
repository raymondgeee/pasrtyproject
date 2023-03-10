<?php
$path = $_SERVER['DOCUMENT_ROOT']."/";
set_include_path($path);
include('Modules/mysqliConnection.php');

$userId = $_SESSION['userId'];
$userName = $_SESSION['userName'];

$type = isset($_GET['type']) ? $_GET['type'] : '';

$validFormatsArray = array("jpg", "png", "gif", "bmp", "JPEG", "JPG", "PNG", "BMP", "GIF");

if(is_array($_FILES)) 
{	
	if($type == 1)
	{	
		if ($_FILES['profilePicture']['size'] >= 1048576 * 10) 
		{
		    echo "exceed";
		}
		else if ($_FILES['profilePicture']['error'] == 4) 
		{
	        echo "error";    
	  	} 
		else
		{
			if(is_uploaded_file($_FILES['profilePicture']['tmp_name'])) 
			{
				$filename =  $_FILES['profilePicture']['name'];
				$imageFormat = pathinfo($filename, PATHINFO_EXTENSION);
		        $newFileName = $_SESSION['userId'].".".$imageFormat;

				$sourcePath = $_FILES['profilePicture']['tmp_name'];
				$targetPath = "Profile Pictures/".$newFileName;
				

				if(in_array($imageFormat, $validFormatsArray))
				{
					if(!file_exists($newFileName))
					{
						if(move_uploaded_file($sourcePath,$targetPath)) 
						{
							$sql = "UPDATE userinformation SET profilePicture = '".$newFileName."' WHERE userId = ".$_SESSION['userId']." LIMIT 1";
							$queryUpdate = $db->query($sql);

							echo "<img src='".$targetPath."' class='w3-border img-responsive w3-card-2' style='height:250px; width:250px;'/>";
						}
					}
				}
			}
		}
	}
	else if($type == 2)
	{
		if ($_FILES['headerImage']['size'] >= 1048576 * 10) 
		{
		    echo "exceed";
		}
		else if ($_FILES['headerImage']['error'] == 4) 
		{
	        echo "error";    
	  	} 
		else
		{
			if(is_uploaded_file($_FILES['headerImage']['tmp_name'])) 
			{
				$filename =  $_FILES['headerImage']['name'];
		        $newFileName = $_SESSION['userId']."_".$filename;

				$sourcePath = $_FILES['headerImage']['tmp_name'];
				$targetPath = "../Images/".$newFileName;
				$imageFormat = pathinfo($newFileName, PATHINFO_EXTENSION);

				if(in_array($imageFormat, $validFormatsArray))
				{
					if(!file_exists($newFileName))
					{
						if(move_uploaded_file($sourcePath,$targetPath)) 
						{
							$sql = "INSERT INTO `library_image`(`imageFileName`, `imageType`) VALUES ('".$newFileName."', 1)";
							$queryInsert = $db->query($sql);
							$nocahce = filemtime($targetPath);
							echo "<img style='height:160px; width:100%;' class='w3-card-2 w3-round' src='".$targetPath."?".$nocahce."'/>";
						}
					}
				}
			}
			else
			{
				echo "error";
			}
		}
	}	
}
else
{
	echo "error";
}
?>