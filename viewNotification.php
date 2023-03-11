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
               			echo "<th class='w3-center'>VERIFICATION ID</th>";
               			echo "<th class='w3-center'>BATCH NUMBER</th>";
               			echo "<th class='w3-center'>READ STATUS</th>";
               			echo "<th class='w3-center'>STATUS</th>";
               			echo "<th class='w3-center'>DETAILS</th>";
               		echo "</thead>";
               		echo "<tbody>";
	               	$sql = "SELECT * FROM productverification WHERE verificationStatus = 0 AND paymentImage != ''";
					$queryVerify = $db->query($sql);
					if($queryVerify AND $queryVerify->num_rows > 0)
					{
						while ($resultVerify = $queryVerify->fetch_assoc()) 
						{
							$verificationId = $resultVerify['verificationId'];
							$batchNumber = $resultVerify['batchNumber'];
							$paymentImage = $resultVerify['paymentImage'];
							$verificationStatus = $resultVerify['verificationStatus'];
							$readStatus = $resultVerify['readStatus'];

							if($verificationStatus == 0) $verificationName = "Pending";
                            if($verificationStatus == 1) $verificationName = "Approved";
                            if($verificationStatus == 2) $verificationName = "Denied";

                            $read = "<i class='fa fa-check w3-text-green'></i>";
							if($readStatus == 0) $read = "<i class='fa fa-remove'></i>";
							echo "<tr>";
								echo "<td style='vertical-align:middle;' class='w3-center'>".$verificationId."</td>";
								echo "<td style='vertical-align:middle;' class='w3-center'>".$batchNumber."</td>";
								echo "<td style='vertical-align:middle;' class='w3-center'>".$read."</td>";
								echo "<td style='vertical-align:middle;' class='w3-center'>".$verificationName."</td>";
								echo "<td style='vertical-align:middle;' class='w3-center'><a href='review.php?batchNumber=".$batchNumber."&read=1'><button class='w3-black w3-btn w3-tiny w3-round'>REVIEW</button></a></td>";
							echo "</tr>";
						}
					}
					echo "</tbody>";
					echo "<tfoot class='w3-black'>";
                        echo "<th></th>";
                        echo "<th></th>";
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