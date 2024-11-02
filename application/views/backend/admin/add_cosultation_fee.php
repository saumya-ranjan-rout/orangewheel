<?php

$single_patient_info = $this->db->get_where('patient', array('patient_id' => $param2))->result_array();
foreach ($single_patient_info as $row) {
?>
    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-primary" data-collapsed="0">

                <div class="panel-heading">
                    <div class="panel-title">
                        <h3>Generate Consultation Bill</h3>
                    </div>
                </div>

                <div class="panel-body">

                    <form role="form" class="form-horizontal form-groups" action="<?php echo site_url('admin/patient/add_consultation_fee/'.$row['patient_id']); ?>" 
                        method="post" enctype="multipart/form-data"   onsubmit="disableButton()">
                     
                                <input type="hidden" name="patient_id"class="form-control" id="field-1" value="<?php echo $row['patient_id']; ?>" required readonly>
                         <input type="hidden" name="referred_by"class="form-control"  value="<?php echo $row['referred_by'];?>"  readonly>
                          <input type="hidden" name="visit_type"class="form-control"  value="<?php echo $row['visit_type'];?>"  readonly> 
                          <input type="hidden" name="remarks"class="form-control"  value="<?php echo $row['remarks'];?>"  readonly>
                          
                          
                      <input type="hidden" name="date"class="form-control"  value="<?php echo date('d-m-Y'); ?>"  readonly>
<?php
//$price=$row['consultation_fee'];
// $discount_type=$row['discount_type'];
// $discount_price=$row['discount_value'];
                    ?>
                       <input type="hidden" name="consultation_name"class="form-control"  value="Consultation Charge"  readonly>
                       <input type="hidden" name="qty"class="form-control"  value="1"  readonly>
                       <div class="form-group">
    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Consultation Fee'); ?></label>
    
    <div class="col-sm-7">
    <input type="number" name="price" class="form-control" id="consultation_fee" value="" >
    </div>
    </div>
                          <!-- <input type="hidden" name="discount_type"class="form-control"  value="<?php echo  $discount_type ?>"  readonly>
                           <input type="hidden" name="discount_price"class="form-control"  value="<?php echo $discount_price ?>"  readonly> -->
                           <div class="form-group">
    <label class="col-sm-3 control-label"><?php echo get_phrase('Discount_type');?></label>
    <div class="col-sm-7">                             
    <select class="form-control" name="discount_type"  disable>
    <option value="">None</option>
    <option value="fixed" >Fixed</option>
   
    </select>
    </div>
    </div>
                           <?php
                           
// if($discount_type =='percentage'){
// $to=($price * $discount_price) / 100;
// $total=$price-$to;
// }else if($discount_type =='fixed'){
// $total=$price-$discount_price;
// }
// else{
// $total=$price;
// }
?>
                            <!-- <input type="hidden" name="total_price"class="form-control"  value="<?php echo   $total;?>"  readonly> -->


 


                         <h4 class="modal-title" style="text-align:center;">Are you sure to generate consultation bill ?</h4>


                         <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
        

              <button type="submit" class="btn btn-primary" id="myButton"><?php echo get_phrase('Yes'); ?></button>
            <!--      <button type="submit" class="btn btn-primary" id="myButton" onclick="printAndSaveConsultationBill(event)"><?php echo get_phrase('Print and Save'); ?></button> -->


                <button type="button" class="btn btn-info" data-dismiss="modal"><?php echo get_phrase('cancel'); ?></button>
            </div>

                    </form>

                </div>

            </div>

        </div>
    </div>
<?php } ?>



<!-- <script>
function printAndSaveConsultationBill(event) {
    event.preventDefault();
    window.print();

    // Wait for the printing to complete before saving the content
    setTimeout(function() {
        var printContents = document.body.innerHTML;
        var blob = new Blob([printContents], { type: "text/html" });
        var url = URL.createObjectURL(blob);
        var a = document.createElement("a");
        a.href = url;
        //a.download = "consultation_bill.html";
        a.click();
        URL.revokeObjectURL(url);
    }, 2000); // Adjust the delay (in milliseconds) if needed
}
</script> -->