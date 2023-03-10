<?php
$path = $_SERVER['DOCUMENT_ROOT']."/";
set_include_path($path);
include('Modules/mysqliConnection.php');

$dateNow = date("Y-m-d");
?>
<div class='container-fluid'>
    <div class='row'>
        <div class='col-md-12'>
            <div class='w3-container'>
                <div class='w3-padding-top'></div>
               	<?php
                echo "<div class='w3-right'>";
                    echo "<button class='w3-btn w3-tiny w3-round w3-black' id='notifyUser'><b>DIDN'T PICK-UP? </b></button>&nbsp;";
                    echo "<button class='w3-btn w3-tiny w3-round w3-black' id='cancelOrder'><b>CANCEL ORDER</b></button>&nbsp;";
                    echo "<button class='w3-btn w3-tiny w3-round w3-black' id='finishSelected'><b>FINISH SELECTED</b></button>";
                echo "</div>";
                echo "<br>";
                echo "<br>";
               	echo "<table class='table table-condensed table-striped'>";
               		echo "<thead class='w3-black'>";
                        echo "<th class='w3-center'></th>";
                        echo "<th class='w3-center'>CUSTOMER</th>";
                        echo "<th class='w3-center'>BATCH NUMBER</th>";
               			echo "<th class='w3-center'>ORDER DATE</th>";
               			echo "<th class='w3-center'>PICK UP DATE</th>";
               		echo "</thead>";
               		echo "<tbody>";
                    $countDelivered = 0;
                    $sql = "SELECT orderId, orderDate, batchNumber, deliveryDate, userId FROM productorders WHERE orderStatus = 3 GROUP BY batchNumber";
                    $queryOrders = $db->query($sql);
                    if($queryOrders AND $queryOrders->num_rows > 0)
                    {
                        while($resultOrders = $queryOrders->fetch_assoc())
                        {
                            $orderId = $resultOrders['orderId'];
                            $batchNumber = $resultOrders['batchNumber'];
                            $deliveryDate = $resultOrders['deliveryDate'];
                            $userId = $resultOrders['userId'];

                            $orderDate = $resultOrders['orderDate'];

                            $fullName = $picture = $address = $contactNumber = $email = "";
                            $picture = "Profile Pictures/default.png";
                            $sql = "SELECT * FROM userinformation WHERE userId = '".$userId."'";
                            $queryUserInfo = $db->query($sql);
                            if($queryUserInfo AND $queryUserInfo->num_rows > 0)
                            {
                                $resultUserInfo = $queryUserInfo->fetch_assoc();
                                $firstName = $resultUserInfo['firstName'];
                                $surName = $resultUserInfo['surName'];
                                $address = $resultUserInfo['address'];
                                $contactNumber = $resultUserInfo['contactNumber'];
                                $email = $resultUserInfo['email'];
                                $profilePicture = $resultUserInfo['profilePicture'];

                                $targetPath = "Profile Pictures/".$profilePicture;

                                $picture = "Profile Pictures/default.png";
                                if(file_exists($targetPath) AND $profilePicture != "")
                                {
                                    $picture = $targetPath;
                                }
                                
                                $fullName = strtoupper($firstName." ".$surName);
                            }

                            if($deliveryDate <= $dateNow)
                            {
                                $tdColor = "";
                                $sql = "SELECT * FROM usernotification WHERE notificationType = 1 AND userId = ".$userId." AND notificationKey = '".$batchNumber."' ORDER BY notificationDate DESC";
                                $queryNotes = $db->query($sql);
                                if($queryNotes AND $queryNotes->num_rows > 0)
                                {
                                    $tdColor = "w3-pink";
                                }

                                echo "<tr>";
                                    echo "<td style='vertical-align:middle;' class='w3-center'><input type='checkbox' class='chkBox' data-id='".$userId."' id='".$batchNumber."'></td>";
                                    echo "<td style='vertical-align:middle;' class='w3-center'>".$fullName."</td>";
                                    echo "<td style='vertical-align:middle;' class='w3-center ".$tdColor."'><a href='#' onclick=\"window.open('viewDelivered.php?batchNumber=".$batchNumber."', '_blank', 'location=yes,height=570,width=520,scrollbars=yes,status=yes');\">".$batchNumber."</a></td>";
                                    echo "<td style='vertical-align:middle;' class='w3-center'>".$orderDate."</td>";
                                    echo "<td style='vertical-align:middle;' class='w3-center'>".$deliveryDate."</td>";
                                echo "</tr>";
                            }
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
<script>
$(document).ready(function(){
    $('#finishSelected').click(function(){
        var idArray = [];
        $('.chkBox').each(function(){
            if($(this).is(':checked'))
            {
                idArray.push($(this).prop('id'));
            }
        });

        $.ajax({
            url     : 'finishProducts.php?type=1',
            type    : 'POST',
            data    : {
                        idArray : idArray
            },
            success : function(data){
                        console.log(data);  
                        location.reload();             
            }
        });
    });

    $('#cancelOrder').click(function(){
        var idArray = [];
        $('.chkBox').each(function(){
            if($(this).is(':checked'))
            {
                idArray.push($(this).prop('id'));
            }
        });

        $.ajax({
            url     : 'finishProducts.php?type=3',
            type    : 'POST',
            data    : {
                        idArray : idArray
            },
            success : function(data){
                        console.log(data);  
                        location.reload();             
            }
        });
    });

    $('#notifyUser').click(function(){
        var idArray = [];
        var userIdArray = [];
        $('.chkBox').each(function(){
            if($(this).is(':checked'))
            {
                idArray.push($(this).prop('id'));
                userIdArray.push($(this).attr('data-id'));
            }
        });

        $.ajax({
            url     : 'finishProducts.php?type=2',
            type    : 'POST',
            data    : {
                        idArray : idArray,
                        userIdArray : userIdArray
            },
            success : function(data){
                        console.log(data);  
                        location.reload();             
            }
        });
    });
});
</script>