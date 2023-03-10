<?php
$path = $_SERVER['DOCUMENT_ROOT']."/";
set_include_path($path);
include('Modules/mysqliConnection.php');

?>

<div class='container-fluid'>
    <div class='row'>
        <div class='col-md-12'>
            <div class='w3-container'>
                <div class='w3-padding-top'></div>
               	<?php
               	echo "<table class='table table-condensed table-striped'>";
               		echo "<thead class='w3-black'>";
               			echo "<th class='w3-center'>NOTIFICATION DETAILS</th>";
               			echo "<th class='w3-center'>BATCH NUMBER</th>";
               			echo "<th class='w3-center'>DETAILS</th>";
               		echo "</thead>";
               		echo "<tbody>";
	               	$sql = "SELECT * FROM usernotification WHERE userId = ".$_SESSION['userId']." AND notificationStatus = 0";
					$queryNotif = $db->query($sql);
					if($queryNotif AND $queryNotif->num_rows > 0)
					{
						while ($resultNotif = $queryNotif->fetch_assoc()) 
						{
							$notificationId = $resultNotif['notificationId'];
                            $notificationDetails = $resultNotif['notificationDetails'];
                            $notificationKey = $resultNotif['notificationKey'];
							$notificationStatus = $resultNotif['notificationStatus'];

							if($notificationStatus == 0) $verificationName = "READ";
                            if($notificationStatus == 1) $verificationName = "UNREAD";

							echo "<tr>";
								echo "<td style='vertical-align:middle;' class='w3-center'>".$notificationDetails."</td>";
								echo "<td style='vertical-align:middle;' class='w3-center'>".$notificationKey."</td>";
								echo "<td style='vertical-align:middle;' class='w3-center'><a href='orderDetails.php?batchNumber=".$notificationKey."&read=1'><button class='w3-black w3-btn w3-tiny w3-round'><i class=''></i> <b>VIEW</b></button></a></td>";
							echo "</tr>";
						}
					}
					echo "</tbody>";
					echo "<tfoot class='w3-black'>";
                        echo "<th></th>";
                        echo "<th></th>";
                        echo "<th></th>";
                    echo "</tfoot>";
				echo "</table>";
               	?>
            </div>
        </div>
    </div>
</div>