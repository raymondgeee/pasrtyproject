<?php
$path = $_SERVER['DOCUMENT_ROOT']."/";
set_include_path($path);
include('Modules/mysqliConnection.php');

$countF = isset($_POST['countF']) ? $_POST['countF'] : "";
echo "<div id='removeSelection".$countF."'>";
    echo "<div class='w3-padding-top'></div>";
    echo "<label>LAYER ".($countF + 1)." FLAVOR</label>";
    echo "<select id='flavorData".$countF."' class='w3-input w3-border w3-round w3-small flavorData'>";
        echo "<option value='0'>Choose your flavor</option>";
        $sql = "SELECT * FROM cakeflavors WHERE status = 0";
        $queryFlavors = $db->query($sql);
        if($queryFlavors AND $queryFlavors->num_rows > 0)
        {
            while ($resultFlavors = $queryFlavors->fetch_assoc()) 
            {
                $flavorId = $resultFlavors['flavorId'];
                $flavorName = $resultFlavors['flavorName'];
                $flavorPrice = $resultFlavors['flavorPrice'];
                
                echo "<option value='".$flavorId."~".$flavorPrice."'>".$flavorName." (".$flavorPrice." PHP)</option>";
            }
        }
    echo "</select>";
echo "</div>";
?>