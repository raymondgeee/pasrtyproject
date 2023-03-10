
<?php
$path = $_SERVER['DOCUMENT_ROOT']."/";
set_include_path($path);
include('Modules/mysqliConnection.php');

$batchNumber = isset($_REQUEST['batchNumber']) ? $_REQUEST['batchNumber'] : "";
$dateNow = date("Y-m-d");
$nextDays = date("Y-m-d",strtotime("+7 Days"));
if(isset($_POST['saveBtn']))
{
    $deliverDate = isset($_REQUEST['deliverDate']) ? $_REQUEST['deliverDate'] : "";
    $deliverType = isset($_REQUEST['deliverType']) ? $_REQUEST['deliverType'] : 0;
    // Check if file was uploaded without errors
    if(isset($_FILES["proofPhoto"]) && $_FILES["proofPhoto"]["error"] == 0)
    {
        $filename = $_FILES["proofPhoto"]["name"];
        // Verify file extension
        $allowed = Array ("jpg", "jpeg", "png", "PNG", "JPG", "JPEG");
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        // Verify MYME type of the file
        if(in_array($ext, $allowed))
        {
            $pathFolder = $_SERVER['DOCUMENT_ROOT']."/Proof Photos/";
            move_uploaded_file($_FILES["proofPhoto"]["tmp_name"], $pathFolder.$_FILES["proofPhoto"]["name"]);

            $pathRoot = $pathFolder.$_FILES["proofPhoto"]["name"];
            $pathRootName = $pathFolder.$batchNumber."_".$_SESSION['userId'].".".$ext;
            
            $sql = "UPDATE productorders SET deliveryDate = '".$deliverDate."', deliveryType = ".$deliverType.", orderStatus = 2 WHERE batchNumber = ".$batchNumber;
            $queryUpdate = $db->query($sql);

            $sql = "UPDATE productverification SET paymentImage = '".$batchNumber."_".$_SESSION['userId'].".".$ext."' WHERE batchNumber = ".$batchNumber;
            $queryUpdate = $db->query($sql);

            rename($pathRoot,$pathRootName);
        }
        else
        {
            echo "Invalid File Format.";
            exit(0);
        }

        header("location:orderSummary.php");
    }
    else
    {
        echo "Please upload photo.";
        exit(0);
    }

    exit(0);
}
?>
<form id='orderForm' action='<?php echo $_SERVER['PHP_SELF']; ?>' enctype='multipart/form-data' method='POST'></form>
<input form='orderForm' type="hidden" name="batchNumber" value="<?php echo $batchNumber; ?>">
<div class='container-fluid'>
    <div class='row'>
        <div class='col-md-12'>
            <div class='w3-container'>
                <div class='w3-padding-top'></div>
                <label class=""><b>PROOF PHOTO</b></label>
                <label class="w3-tiny w3-right w3-text-indigo"><i>Image should be jpg, png format only.</i></label>
                <input form='orderForm' class="w3-input w3-border" name='proofPhoto' type="file" required>

                <!-- <div class='w3-padding-top'></div> -->
                <!-- <input form='orderForm' class="w3-radio" name='deliverType' value="0" checked type="radio" required>&emsp; -->
                <!-- <label class=""><b>PICK UP</b></label>&emsp; -->
                <!-- <input form='orderForm' class="w3-radio" name='deliverType' value="1" type="radio" required>&emsp; -->
                <!-- <label class=""><b>DELIVER</b></label>&emsp; -->

                <div class='w3-padding-top'></div>
                <div class='w3-padding-top'></div>
                <label class=""><b>PICK UP-DATE</b></label>
                <label class="w3-tiny w3-text-indigo"><i>Date if pick-up should be 7 days after the confirmatio of orders.</i></label>
                <input form='orderForm' class="w3-input w3-border" id='deliveryDate' name='deliverDate' type="date" required>
                
                <div class='w3-padding-top'></div>
                <div class='w3-right'>
                    <button disabled form='orderForm' id='saveBtn' name='saveBtn' class='w3-btn w3-round w3-black'><i class='fa fa-send-o'></i>&emsp;<b>CONFIRM</b></button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){
    $("#deliveryDate").change(function(){
        var deliveryDate = $(this).val();
        var nextDays = "<?php echo $nextDays; ?>";

        if(deliveryDate > nextDays)
        {
            $("#saveBtn").attr("disabled",false);
        }
        else
        {
            alert("Please select date 7 days above");
            $("#saveBtn").attr("disabled",true);
        }
    });
});
</script>