<?php
$payment_mode_info = $this->db->get('payment_mode')->result_array();
$query = $this->db->select('bill_no')->from('patient_item_issue')->order_by('id', 'DESC')->limit(1)->get();

 
 date_default_timezone_set("Asia/Calcutta");

?>




<div class="panel panel-primary" data-collapsed="0">

  <!--  <div class="panel-heading">
        <div class="panel-title">
            <h3><?php echo get_phrase('patient_item_issue_edit'); ?></h3>
        </div>
    </div>-->

    <div class="panel-body">

        <form role="form" class="form-horizontal form-groups" action="<?php echo site_url('admin/sales_return_list/return_update'); ?>" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-sm-2">
                    <label><?php echo get_phrase('issue_type'); ?> <small style="color:red;">*</small></label>
                    <select name="issue_type" class="form-control" id="issue_type" required onchange="get_invoice_no(this.value)">
                      <!--  <option value=""><?php echo get_phrase('select_issue_type'); ?></option>-->
                        <option value="invoice"  <?php if($patient_item_issue_info["issue_type"]=="invoice"){ echo"selected"; } ?>><?php echo get_phrase('invoice'); ?></option>
                       <!-- <option value="challan" <?php if($patient_item_issue_info["issue_type"]=="challan"){ echo"selected"; } ?>><?php echo get_phrase('challan'); ?></option>-->
                    </select>
                </div>
                <div class="col-sm-3">
                    <label><span id="invoice_no_span"><?php if($patient_item_issue_info["issue_type"]=="invoice"){ echo"Invoice No"; }else{ echo"Challan No"; } ?></span> <small style="color:red;">*</small></label>
                    <input type="text" name="bill_no" class="form-control" value="<?php echo $patient_item_issue_info["bill_no"]; ?>" id="field-1" required readonly > 
                    <input type="hidden" name="patient_item_issue_id" class="form-control" value="<?php echo $patient_item_issue_info["id"]; ?>" id="field-1" > 
                </div>
                <div class="col-sm-2">
                    <label><span id="date_span"><?php if($patient_item_issue_info["issue_type"]=="invoice"){ echo"Invoice Date"; }else{ echo"Challan Date"; } ?></span> <small style="color:red;">*</small></label>
                    <input type="text" name="date" class="form-control datepicker" value="<?php if($patient_item_issue_info["issue_type"]=="invoice"){ echo date('m/d/Y', strtotime($patient_item_issue_info["invoice_date"])); }else{ echo date('m/d/Y', strtotime($patient_item_issue_info["challan_date"]));}  ?>" id="date" required readonly>
</div>

 <div class="col-sm-2">
                    <label><span id="date_span">Sales return date</span> <small style="color:red;">*</small></label>
                    <input type="text" name="sales_return_date" class="form-control datepicker" value="<?php echo date('m/d/Y'); ?>" id="sales_return_date" required >
</div>
                <div class="col-sm-3">
                    <label><?php echo get_phrase('patient'); ?> <small style="color:red;">*</small></label>
                    <select name="patient_id" class="form-control select2" required>
      
        <?php
        $patients = $this->db->get('patient')->result_array();
        foreach ($patients as $row) {
            if ($row['patient_id'] == $patient_item_issue_info["patient_id"]) { ?>
                <option value="<?php echo $row['patient_id']; ?>" selected><?php echo $row['name']; ?>(<?php echo $row['phone']; ?>)</option>
            <?php }
        } ?>
    </select>
                </div>
            </div>
            <hr>
<span id="models">

<?php 
$models = json_decode($patient_item_issue_info["models"], true);
$i=1;
foreach($models as $model) { ?>

                 <div class="row" style="margin-top: 10px;">
                <div class="row" style="margin-top: 10px;">
                    <div class="col-sm-2">
                        <label><?php echo get_phrase('models'); ?> <small style="color:red;">*</small></label>
                        <select name="model_id[]" class="form-control select2 srr" onchange="get_model_available_quantity(this.value, <?php echo $i; ?>)" required  style="color: #999; background-color: #868686; pointer-events: none;">
                            <option value=""><?php echo get_phrase('select_a_model'); ?></option>
                            <?php
                            foreach ($item_info as $row) {
                                // $available_quantity = $row['quantity'] - $row['sold_quantity'];
                                // if ($available_quantity > 0) { 
                                    ?>
                                    <option value="<?php echo $row['id']; ?>" <?php if($model["model_id"] == $row['id']){ echo "selected"; } ?>>
                                        <?php echo $row['model']; ?>
                                    </option>
                            <?php //}
                            } ?>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <label><?php echo get_phrase('details'); ?></label><br>
                        <span id="details_span_<?php echo $i; ?>">
                       <?php    $this->db->select('item.*,item_category.item_category');
                                $this->db->from('item');
                                $this->db->join('item_category', 'item_category.id = item.item_category_id', 'left');
                                $this->db->where('item.id', $model["model_id"]);
                                $query = $this->db->get();
                                $result = $query->row_array();
                                if ($result['item_category'] == 'Accessories') {
                                    echo "<b>Category : </b>" . $result['item_category'] . ", <b>Additional Name : </b>" . $result['additional_name'];
                                } else {
                                    echo "<b>Category : </b>" . $result['item_category'] . ", <b>Type : </b>" . $result['type'] . ", <b>Channel : </b>" . $result['channel'] . ", <b>L/R : </b>" . $result['lr'];
                                }
                                ?>

                        </span><br>

                        <?php    ?>
                    </div>

                    <div class="col-sm-2">
                    <label><?php echo get_phrase('serial_no'); ?></label>
                      <select name="model_serial_no[]" class="form-control"  id="model_serial_no_<?php echo $i; ?>"  readonly>

                   
                      </select>
                    </div>

                    <div class="col-sm-1">
                        <label><?php echo get_phrase('quantity'); ?></label>
                        <input type="number" class="form-control" name="model_quantity[]" id="model_quantity_<?php echo $i; ?>" min="1" max="999" value="<?php echo $model['quantity']; ?>" readonly required />
                    </div>

                    <div class="col-sm-2">
                        <label><?php echo get_phrase('price'); ?></label>
                        <input type="text" class="form-control" id="model_price_<?php echo $i; ?>" name="model_price[]" value="<?php echo $model['price']; ?>" readonly />
                    </div>

                    <!-- <div class="col-sm-2">
                        <label><?php echo get_phrase('basic_price'); ?></label>
                        <input type="text" class="form-control" id="basic_price_1" name="basic_price[]" value="" readonly />
                    </div> -->
                    <div class="col-sm-1">
                        <label><?php echo get_phrase('discount(%)'); ?></label>
                        <input type="text" class="form-control" id="discount_percentage_<?php echo $i; ?>" name="discount_percentage[]" onkeyup="calculate_total_price_by_discount(1)" value="<?php echo $model['discount_percentage']; ?>" readonly />
                    </div>
                    <div class="col-sm-2">
                        <label><?php echo get_phrase('discount')." ".get_phrase('amount'); ?></label>
                        <input type="text" class="form-control" id="discount_1" name="discount[]" value="<?php echo $model['discount']; ?>" readonly />
         <span id="after_discount_1"> <?php $after_amount =$result['unit_price']-$model['discount']; echo "<b>(".$result['unit_price'] . "-" . $model['discount'] . "=" .$after_amount.")</b>"; ?></span>
                    </div>
                  
                        </div>
                         <div class="row" style="margin-top: 10px;">
                    <div class="col-sm-2">
                      
                        </div>
                        <div class="col-sm-2">
                        
                        </div>
                        <div class="col-sm-2">
                        <label><?php echo get_phrase('tax(%)'); ?></label>
                        <input type="text" class="form-control" id="tax_percentage_<?php echo $i; ?>" name="tax_percentage[]" value="<?php echo $model['tax_percentage']; ?>" readonly />
                    </div>
                    
                    <div class="col-sm-2">
                        <label><?php echo get_phrase('tax')." ".get_phrase('amount'); ?></label>
                        <input type="text" class="form-control" id="tax_<?php echo $i; ?>" name="tax[]" value="<?php echo $model['tax']; ?>" readonly />
                    </div>
                    <div class="col-sm-2">
                        <label><?php echo get_phrase('total_price'); ?></label>
                        <input type="text" class="form-control" id="total_price_<?php echo $i; ?>" name="total_price[]" value="<?php echo $model['total_price']; ?>" readonly />
                        <input type="hidden" class="form-control" id="available_<?php echo $i; ?>" name="available[]" value="1" readonly />
                        <input type="hidden" class="form-control" id="item_price_details_id_<?php echo $i; ?>" value="<?php echo $model['item_price_details_id']; ?>" readonly />
                    </div>
                    <!-- <div class="col-sm-1">
                        <label><?php echo get_phrase('action'); ?></label>
                    </div> -->
                </div>
                <hr>
            </div>

<?php 
 $i++;
} 
 ?>

</span>

          

           

          

      
            <div class="row" align="right" style="margin-top: 10px;">
                <label for="field-ta" class="col-sm-10 control-label"><?php echo get_phrase('grand_total'); ?></label>

                <div class="col-sm-2">
                    <input type="number" name="grand_total" class="form-control" id="grand_total" readonly value="<?php echo $patient_item_issue_info['grand_total']; ?>" />
                </div>
            </div>

         
            <div class="row" align="right" style="margin-top: 10px;">
                <label for="field-ta" class="col-sm-10 control-label"><?php echo get_phrase('final_amount_payble'); ?></label>

                <div class="col-sm-2">
                    <input type="number" name="due_amount" class="form-control" id="due_amount" value="<?php echo $patient_item_issue_info['due_amount']; ?>" readonly/>
                </div>
            </div>

            <div class="row" align="right" style="margin-top: 10px;">
                <label for="field-1" class="col-sm-10 control-label"><?php echo get_phrase('payment_status'); ?> <small style="color:red;">*</small></label>
                <div class="col-sm-2">
                    <select name="payment_status" class="form-control" id="payment_status" required>
                        <option value=""><?php echo get_phrase('select_a_status'); ?></option>
                      
                        <option value="paid" <?php if($patient_item_issue_info['payment_status'] == "paid"){ echo "selected"; } ?>><?php echo get_phrase('paid'); ?></option>
                        <option value="unpaid" <?php if($patient_item_issue_info['payment_status'] == "unpaid"){ echo "selected"; } ?>><?php echo get_phrase('unpaid'); ?></option>
                        <option value="partial" <?php if($patient_item_issue_info['payment_status'] == "partial"){ echo "selected"; } ?>><?php echo get_phrase('partial'); ?></option>
                    </select>
                </div>
            </div>

            <div class="row" align="right" style="margin-top: 10px;">
                <label for="field-ta" class="col-sm-10 control-label"><?php echo get_phrase('payment_mode'); ?></label>
                <div class="col-sm-2">
                    <select name="payment_mode_id" class="form-control">
                        <option value=""><?php echo get_phrase('select_payment_mode'); ?></option>
                        <?php foreach ($payment_mode_info as $row) { ?>
                            <option value="<?php echo $row['id']; ?>" <?php if($patient_item_issue_info['payment_mode_id'] == $row['id']){ echo "selected"; } ?>><?php echo $row['payment_mode']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="row" align="right" style="margin-top: 10px;">
                <label for="field-1" class="col-sm-10 control-label"><?php echo get_phrase('dispatched_through'); ?></label>
                <div class="col-sm-2">
                    <select name="dispatched_through" class="form-control">
                        <option value=""><?php echo get_phrase('select'); ?></option>
                        <option value="By Hand" <?php if($patient_item_issue_info['dispatched_through'] == "By Hand"){ echo "selected"; } ?>><?php echo get_phrase('by_hand'); ?></option>
                        <option value="Courier" <?php if($patient_item_issue_info['dispatched_through'] == "Courier"){ echo "selected"; } ?>><?php echo get_phrase('courier'); ?></option>
                        <option value="Self" <?php if($patient_item_issue_info['dispatched_through'] == "Self" ){ echo "selected"; } ?>><?php echo get_phrase('self'); ?></option>
                    </select>
                </div>
            </div>

         

            <div class="row" align="right" style="margin-top: 10px;">
                <label for="field-ta" class="col-sm-10 control-label"><?php echo get_phrase('delivery_note'); ?></label>
                <div class="col-sm-2">
                    <textarea name="delivery_note" class="form-control" rows="4"><?php echo $patient_item_issue_info['delivery_note']; ?></textarea>
                </div>
            </div>
            <hr>
              <div class="row" align="right" style="margin-top: 10px;">
                <label for="field-ta" class="col-sm-10 control-label"><?php echo get_phrase('Amount Return'); ?></label>

                <div class="col-sm-2">
                    <input type="number" name="sales_return_amount" class="form-control" id="sales_return_amount" value=""   oninput="calculateReturnAmount()" required/>
                </div>
            </div>
             <div class="row" align="right" style="margin-top: 10px;">
                <label for="field-ta" class="col-sm-10 control-label"><?php echo get_phrase('Due'); ?></label>

                <div class="col-sm-2">
                    <input type="number" name="sales_return_due" class="form-control" id="sales_return_due" value=""  readonly/>
                </div>
            </div>

 <div class="row" align="right" style="margin-top: 10px;">
                <label for="field-ta" class="col-sm-10 control-label"><?php echo get_phrase('Total Amount Return'); ?></label>

                <div class="col-sm-2">
                    <input type="number" name="total_sales_return_amount" class="form-control" id="total_sales_return_amount" value=""  onkeyup="change_submitbutton_attribute()"  readonly/>
                </div>
            </div>
  <div class="row" align="right" style="margin-top: 10px;">
                <label for="field-ta" class="col-sm-10 control-label"><?php echo get_phrase('reason'); ?></label>
                <div class="col-sm-2">
                    <textarea name="sales_return_reason" class="form-control" rows="4"></textarea>
                </div>
            </div>
            <div class="row" align="right" style="margin-top: 10px;">
                <div class="col-sm-12">
                    <button id='submit_button' type="submit" class="btn btn-success">
                        <i class="fa fa-check"></i> &nbsp; <?php echo get_phrase('update_issue'); ?>
                    </button>
                </div>
            </div>
        </form>

    </div>

</div>
<script>
    function calculateReturnAmount() {
        var dueAmount = parseFloat(document.getElementById('due_amount').value);
        var returnAmount = parseFloat(document.getElementById('sales_return_amount').value);
        var remainingDue = dueAmount - returnAmount;
        
        document.getElementById('sales_return_due').value = remainingDue.toFixed(2);
        document.getElementById('total_sales_return_amount').value = returnAmount.toFixed(2);
    }
</script>
<script>
    $(document).ready(function() {
    $('.srr').each(function(index) {
        var currentIndex = index + 1;
        var selectedModelId = $(this).val();
   var selected_item_price_details_id =   $('#item_price_details_id_' + currentIndex).val();
   $.ajax({
                url: '<?php echo site_url('admin/get_model_available_quantity/'); ?>' + selectedModelId,
                success: function(response) {
                  //   alert(response);
                    var data = JSON.parse(response);

                 
            var optionss = '<option value="">Select</option>';
            data.options.forEach(function(option) {
                optionss += '<option value="' + option.id + '"';
                if (option.id == selected_item_price_details_id) {
                    optionss += ' selected';
                }
                optionss += '>' + option.sl_no + '</option>';
            });



                   $('#model_serial_no_' + currentIndex).html(optionss);
        }
               
    });   
 });
});
</script>

<script type="text/javascript">
  

   


function change_submitbutton_attribute() {
    var total_sales_return_amount = $('#total_sales_return_amount').val();
    $('#submit_button').prop('disabled', total_sales_return_amount != '');
}


</script>
