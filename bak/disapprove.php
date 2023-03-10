<?php
$path = $_SERVER['DOCUMENT_ROOT']."/";
set_include_path($path);
include('Modules/mysqliConnection.php');

$batchNumber = isset($_REQUEST['batchNumber']) ? $_REQUEST['batchNumber'] : "";
$userId = isset($_REQUEST['userId']) ? $_REQUEST['userId'] : "";
$type = isset($_REQUEST['type']) ? $_REQUEST['type'] : "";

?>
<div class='container-fluid'>
    <div class='row'>
        <div class='col-md-12'>
            <div class='w3-container'>
                <div class='w3-padding-top'></div>
                <label class=""><b>REMARKS</b></label>
                <textarea class="w3-input w3-border" id='remarks' rows=8></textarea>
                <div class='w3-padding-top'></div>
                <div class='w3-center'>
                    <button class='w3-btn w3-round w3-black' id='disapproveBtn'><i class='fa fa-send-o'></i>&emsp;<b>DISAPPROVE</b></button>
                </div>
                <div class='w3-padding-top'></div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){
    $("#disapproveBtn").click(function(){
        var batchNumber = "<?php echo $batchNumber; ?>";
        var userId = "<?php echo $userId; ?>";
        var remarks = $("#remarks").val();
        $.ajax({
            url     : 'approval.php',
            type    : 'POST',
            data    : {
                type : 'denied',
                batchNumber : batchNumber,
                userId      : userId,
                remarks     : remarks
            },
            success : function(data){
                        // $(this).parent().parent().remove();
                        location.reload();
            }
        });
    });
});
</script>