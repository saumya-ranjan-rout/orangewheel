<?php
$payment_mode_info = $this->db->get('payment_mode')->result_array();
$query = $this->db->select('bill_no')->from('patient_item_issue')->order_by('id', 'DESC')->limit(1)->get();

 
 date_default_timezone_set("Asia/Calcutta");
	$year = date("Y");
	$next_year=date("Y",strtotime("+1 year"));
$month = date("m");
 $yr = substr($year, -2); // Get the last two characters of the first part
    $nxt_yr = substr($next_year, -2);
if ($query->num_rows() > 0) {
    $parts= $query->row()->bill_no;
    $stringValue = explode("/", $parts);
    $lastPart = end($stringValue);
    $numericPart = (int) $lastPart;
    $incrementedNumericPart = $numericPart + 1;
  
	$lastinvoice = 'OWIPL/'.$yr."-".$nxt_yr .'/'.$month.'/'.$incrementedNumericPart;

} else {
    $lastinvoice = 'OWIPL/'.$yr."-".$nxt_yr .'/'.$month.'/'.(int)1000;
}
?>
<ol class="breadcrumb bc-3" style="margin-bottom: 0px;">
    <li>
        <a href="<?php echo site_url('admin'); ?>">
            <i class="entypo-folder"></i>
            <?php echo get_phrase('dashboard'); ?>
        </a>
    </li>
    <li>
        <a href="<?php echo site_url('admin/patient_item_issue'); ?>">
            <?php echo get_phrase('patient_item_issue') ?>
        </a>
    </li>
    <li><?php echo get_phrase('patient_item_issue_edit') ?></li>
</ol>
<br>



<div class="panel panel-primary" data-collapsed="0">

    <div class="panel-heading">
        <div class="panel-title">
            <h3><?php echo get_phrase('patient_item_issue_edit'); ?></h3>
        </div>
    </div>

    <div class="panel-body">

        <form role="form" class="form-horizontal form-groups" action="<?php echo site_url('admin/patient_item_issue/mainupdate'); ?>" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-sm-3">
                    <label><?php echo get_phrase('issue_type'); ?> <small style="color:red;">*</small></label>
                    <select name="issue_type" class="form-control" id="issue_type" required onchange="get_invoice_no(this.value)">
                        <option value=""><?php echo get_phrase('select_issue_type'); ?></option>
                        <option value="invoice"  <?php if($patient_item_issue_info["issue_type"]=="invoice"){ echo"selected"; } ?>><?php echo get_phrase('invoice'); ?></option>
                        <option value="challan" <?php if($patient_item_issue_info["issue_type"]=="challan"){ echo"selected"; } ?>><?php echo get_phrase('challan'); ?></option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <label><span id="invoice_no_span"><?php if($patient_item_issue_info["issue_type"]=="invoice"){ echo"Invoice No"; }else{ echo"Challan No"; } ?></span> <small style="color:red;">*</small></label>
                    <input type="text" name="bill_no" class="form-control" value="<?php echo $patient_item_issue_info["bill_no"]; ?>" id="field-1" required > 
                    <input type="hidden" name="patient_item_issue_id" class="form-control" value="<?php echo $patient_item_issue_info["id"]; ?>" id="field-1" > 
                </div>
                <div class="col-sm-3">
                    <label><span id="date_span"><?php if($patient_item_issue_info["issue_type"]=="invoice"){ echo"Invoice Date"; }else{ echo"Challan Date"; } ?></span> <small style="color:red;">*</small></label>
                    <input type="text" name="date" class="form-control datepicker" value="<?php if($patient_item_issue_info["issue_type"]=="invoice"){ echo date('m/d/Y', strtotime($patient_item_issue_info["invoice_date"])); }else{ echo date('m/d/Y', strtotime($patient_item_issue_info["challan_date"]));}  ?>" id="date" required>
</div>
                <div class="col-sm-3">
                    <label><?php echo get_phrase('patient'); ?> <small style="color:red;">*</small></label>
                    <select name="patient_id" class="form-control select2" required >
                        <option value=""><?php echo get_phrase('select_a_patient'); ?></option>
                        <?php
                        $patients = $this->db->get('patient')->result_array();
                        foreach ($patients as $row) { ?>
                            <option value="<?php echo $row['patient_id']; ?>" <?php if($row['patient_id'] == $patient_item_issue_info["patient_id"]){ echo"Selected"; } ?> ><?php echo $row['name']; ?>(<?php echo $row['phone']; ?>)</option>
                        <?php } ?>
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
                      <select name="model_serial_no[]" class="form-control"  id="model_serial_no_<?php echo $i; ?>" onchange="get_model_price(this.value,<?php echo $i; ?>)" >

                      <!-- -->
                      <option value=""><?php echo 'Select Serial No'; ?></option>
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
                        <input type="text" class="form-control" id="discount_percentage_<?php echo $i; ?>" name="discount_percentage[]" onkeyup="calculate_total_price_by_discount(1)" value="<?php echo $model['discount_percentage']; ?>"  />
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

            <span id="model_input">
                 <div class="row" style="margin-top: 10px;">
                <div class="row" style="margin-top: 10px;">
                    <div class="col-sm-2">
                         <label><?php echo get_phrase('models'); ?> <small style="color:red;">*</small></label>
                        <select name="model_id[]" class="form-control srr" onchange="get_model_available_quantity(this.value)" id="model_id">
                            <option value=""><?php echo get_phrase('select_a_model'); ?></option>
                            <?php
                            foreach ($item_info as $row) {
                                $available_quantity = $row['quantity'] - $row['sold_quantity'];
                                if ($available_quantity > 0) { ?>
                                    <option value="<?php echo $row['id']; ?>">
                                        <?php echo $row['model']; ?>
                                    </option>
                            <?php }
                            } ?>
                        </select>
                    </div>

                    <div class="col-sm-2">
                    <label><?php echo get_phrase('details'); ?></label><br>
                        <span id="details_span"></span><br>
                    </div>
                    <div class="col-sm-2">
                    <label><?php echo get_phrase('serial_no'); ?></label>
                      <select name="model_serial_no[]" class="form-control" id="model_serial_no" onchange="get_model_price(this.value)">
                      <option value=""><?php echo 'Select Serial No'; ?></option>
                      </select>
                    </div>

                    <div class="col-sm-1">
                    <label><?php echo get_phrase('quantity'); ?></label>
                        <input type="number" class="form-control" name="model_quantity[]" id="model_quantity" min="1" max="999" value="1" readonly required />
                    </div>
                    <div class="col-sm-2">
                    <label><?php echo get_phrase('price'); ?></label>
                        <input type="text" class="form-control" id="model_price" name="model_price[]" value="" readonly />
                    </div>
                    <!-- <div class="col-sm-1">
                        <input type="text" class="form-control" id="basic_price" name="basic_price[]" value="" readonly />
                    </div> -->
                    <div class="col-sm-1">
                        <label><?php echo get_phrase('discount(%)'); ?></label>
                        <input type="text" class="form-control" id="discount_percentage" name="discount_percentage[]" value="" onkeyup="calculate_total_price_by_discount(this)" />
                    </div>
                    <div class="col-sm-2">
                        <label><?php echo get_phrase('discount')." ".get_phrase('amount'); ?></label>
                        <input type="text" class="form-control" id="discount" name="discount[]" value="" readonly />
                        <span id="after_discount"></span>
                    </div>
           
                        </div>
                 <div class="row" style="margin-top: 10px;">
                    <div class="col-sm-2">
                        </div>
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-2">
                    <label><?php echo get_phrase('tax(%)'); ?></label>
                        <input type="text" class="form-control" id="tax_percentage" name="tax_percentage[]" value="" readonly />
                    </div>
                    <div class="col-sm-2">
                    <label><?php echo get_phrase('tax')." ".get_phrase('amount'); ?></label>
                        <input type="text" class="form-control" id="tax" name="tax[]" value="" readonly />
                    </div>
              
                    <div class="col-sm-2">
                    <label><?php echo get_phrase('total_price'); ?></label>
                        <input type="text" class="form-control" id="total_price" name="total_price[]" value="" readonly />
                        <input type="hidden" class="form-control" id="available" name="available[]" value="0" readonly />
                        <input type="hidden" class="form-control" id="item_price_details_id" value="" readonly />
                    </div>
                    <div class="col-sm-1">
                    <label><?php echo get_phrase('action'); ?></label><br>
                        <button type="button" class="btn btn-danger" id="model_delete" onclick="deletemodelParentElement(this)">
                            <i class="fa fa-trash-o"></i>
                        </button>
                    </div>
                    
                </div>
                <hr id="hr">
                        </div>
            </span>

            <div class="row" style="margin-top: 10px;">
                <div class="col-sm-11" align="left">
                    <button type="button" class="btn btn-primary btn-sm" onClick="add_model()">
                        <i class="fa fa-plus"></i> &nbsp;
                        <?php echo get_phrase('add_model'); ?>
                    </button>

                    <!-- <button type="button" class="btn btn-info btn-sm" onClick="calculate_sum_total_price()">
                        <?php echo get_phrase('calculate_sum_total_price'); ?>
                    </button> -->
               </div>
            </div>

            <div class="row" align="right" style="margin-top: 10px;display:none;">
                <label for="field-ta" class="col-sm-8 control-label"><?php echo get_phrase('sum_total_price'); ?></label>
                <div class="col-sm-2">
                    <input type="number" name="sum_total_price" class="form-control" id="sum_total_price" value="0" readonly />
                </div>
            </div>
            <div class="row" align="right" style="margin-top: 10px;display:none;">
                <label for="field-1" class="col-sm-8 control-label"><?php echo get_phrase('discount'); ?></label>
                <div class="col-sm-2">
                    <select name="discount_type" onchange="calculate_total_amount()" class="form-control" id="discount_type">
                        <option value=""><?php echo get_phrase('select_discount_type'); ?></option>
                        <option value="fixed"><?php echo get_phrase('fixed'); ?></option>
                        <option value="percentage"><?php echo get_phrase('percentage'); ?></option>
                    </select>
                </div>
                <div class="col-sm-2">
                    <input type="number" name="discount_value" placeholder="Value" onkeyup="calculate_total_amount()" class="form-control" id="discount_value" style="display: inline-block; width: 90%;" /><span id="percent_sign"></span>
                </div>
            </div>
            <div class="row" align="right" style="margin-top: 10px;display:none;">
                <label for="field-ta" class="col-sm-8 control-label"><?php echo get_phrase('total_amount'); ?></label>

                <div class="col-sm-2">
                    <input type="number" name="total_amount" class="form-control" id="total_amount" readonly />
                </div>
            </div>
            <div class="row" align="right" style="margin-top: 10px;display:none;">
                <label class="col-sm-8 control-label"><?php echo get_phrase('tax_type'); ?></label>
                <div class="col-sm-2">
                    <select name="tax_type" id="tax_type" class="form-control" onchange="validate_tax()">
                        <option value=""><?php echo get_phrase('select'); ?></option>
                        <option value="CGST & SGST">CGST & SGST</option>
                        <option value="IGST">IGST</option>
                    </select>
                </div>
            </div>

            <div class="row" align="right" style="margin-top: 10px;display:none;">
                <label class="col-sm-8 control-label"><?php echo get_phrase('tax(%)'); ?></label>
                <div class="col-sm-2">
                    <select name="tax_per" id="tax_per" class="form-control" onchange="validate_tax()">
                        <option value="0"><?php echo get_phrase('nil'); ?></option>
                        <option value="5">5%</option>
                        <option value="12">12%</option>
                        <option value="18">18%</option>
                        <option value="28">28%</option>
                    </select>
                </div>
                <div class="col-sm-2">
                    <input type="text" name="tax_amount" class="form-control" id="tax_amount" readonly />
                </div>
            </div>
            <div class="row" align="right" style="margin-top: 10px;">
                <label for="field-ta" class="col-sm-10 control-label"><?php echo get_phrase('grand_total'); ?></label>

                <div class="col-sm-2">
                    <input type="number" name="grand_total" class="form-control" id="grand_total" readonly value="<?php echo $patient_item_issue_info['grand_total']; ?>" />
                </div>
            </div>

            <div class="row" align="right" style="margin-top: 10px;display:none;" >
                <label for="field-ta" class="col-sm-10 control-label"><?php echo get_phrase('advance_received_amount'); ?></label>

                <div class="col-sm-2">
                    <input type="number" name="received_amount" class="form-control" value="<?php echo $patient_item_issue_info['received_amount']; ?>" id="received_amount" onkeyup="calculate_due_amount()" readonly/>
                </div>
            </div>

            <div class="row" align="right" style="margin-top: 10px;">
                <label for="field-ta" class="col-sm-10 control-label"><?php echo get_phrase('final_amount_payble'); ?></label>

                <div class="col-sm-2">
                    <input type="number" name="due_amount" class="form-control" id="due_amount" value="<?php echo $patient_item_issue_info['due_amount']; ?>"  onkeyup="change_submitbutton_attribute(<?php echo $patient_item_issue_info['due_amount']; ?>)" readonly/>
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

            <div class="row" align="right" style="margin-top: 10px;display:none;">
                <label for="field-ta" class="col-sm-8 control-label"><?php echo get_phrase('destination'); ?></label>
                <div class="col-sm-2">
                    <input type="text" name="destination" class="form-control" />
                </div>
            </div>

            <div class="row" align="right" style="margin-top: 10px;">
                <label for="field-ta" class="col-sm-10 control-label"><?php echo get_phrase('delivery_note'); ?></label>
                <div class="col-sm-2">
                    <textarea name="delivery_note" class="form-control" rows="4"><?php echo $patient_item_issue_info['delivery_note']; ?></textarea>
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
    var model_count = <?php echo $i-1; ?>;
    var sum_total_price = 0;
    var deleted_models = [];

  
    function get_model_available_quantity(model_id, append_id) {
        if (model_id != '') {
            $.ajax({
                url: '<?php echo site_url('admin/get_model_available_quantity/'); ?>' + model_id,
                success: function(response) {
                    // alert(response);
                    var data = JSON.parse(response);
                    $('#model_quantity_' + append_id).attr('max', data.quantity);
                  //  $('#model_price_' + append_id).attr('value', data.unit_price);
                   //$('#tax_percentage_' + append_id).attr('value', data.gst);

                   var optionss = '<option value="">Select Serial No</option>';
                   data.options.forEach(function(option) {
                optionss += '<option value="' + option.id + '">' + option.sl_no + '</option>';
        
            });

                   $('#model_serial_no_' + append_id).html(optionss);
                      if (data.gst === null) {
                          $('#tax_percentage_' + append_id).attr('value', 'Nil');
                } else {
                    $('#tax_percentage_' + append_id).attr('value', data.gst);
                }
                    if (data.item_category == 'Accessories') {
                        $('#details_span_' + append_id).html("<b>Category : </b>" + data.item_category + ", <b>Additional Name : </b>" + data.additional_name);
                    } else {
                        $('#details_span_' + append_id).html("<b>Category : </b>" + data.item_category + ", <b>Type : </b>" + data.type + ", <b>Channel : </b>" + data.channel + ", <b>L/R : </b>" + data.lr);
                    }
                    calculate_total_price(append_id);
                }
            });

        } else {
            $('#model_quantity_' + append_id).attr('max', 1);
          //  $('#model_price_' + append_id).attr('value', "");
          $('#model_serial_no_' + append_id).html('<option value="">Select Serial No</option>');
            $('#tax_percentage_' + append_id).attr('value', "");
             $('#discount_percentage_' + append_id).attr('value', "");
            $('#details_span_' + append_id).html("");
            calculate_total_price(append_id);
        }
    }

    function get_model_price(item_price_details_id, append_id) {

      

      if (item_price_details_id != '') {
          $.ajax({
              url: '<?php echo site_url('admin/get_model_price/'); ?>' + item_price_details_id,
              success: function(response) {
                  var data = JSON.parse(response);
              
                  $('#model_price_'+ append_id).attr('value', data.unit_price);
    
                  calculate_total_price(append_id);
              }
          });

      } else {
          $('#model_price_' + append_id).attr('value', "");
     
          calculate_total_price(append_id);
      }

  }
    function calculate_total_price_by_discount(append_id) {
        var quantity = $('#model_quantity_' + append_id).val();
        var basic_price = $('#model_price_' + append_id).val() * quantity;
       // var tax = basic_price * $('#tax_percentage_' + append_id).val() / 100;
        
       var discount_percentage = $('#discount_percentage_' + append_id).val();
        
       if (discount_percentage === '') {
       
       var discount_amount = 0;
   } else {
       var discount_amount = basic_price * parseFloat(discount_percentage) / 100;
   }
        var tax_percentage = $('#tax_percentage_' + append_id).val();
        var after_discount = basic_price - discount_amount;
    if (tax_percentage === 'Nil' || tax_percentage === '') {
        var tax = 0;
    } else {
        var tax = after_discount * parseFloat(tax_percentage) / 100;
    }
    var total_price = (basic_price + tax) - discount_amount;
    
    var calculationString = `(${basic_price} - ${discount_amount} = ${after_discount})`;

        $('#basic_price_' + append_id).attr('value', basic_price.toFixed(2));
        $('#tax_' + append_id).attr('value', tax.toFixed(2));
         $('#discount_' + append_id).attr('value', discount_amount.toFixed(2));
         $('#after_discount_' + append_id).html("<b>"+calculationString+"</b>");
        $('#total_price_' + append_id).attr('value', total_price.toFixed(2));

        calculate_sum_total_price();
    }

    function calculate_total_price(append_id) {
        var quantity = $('#model_quantity_' + append_id).val();
        var basic_price = $('#model_price_' + append_id).val() * quantity;
       // var tax = basic_price * $('#tax_percentage_' + append_id).val() / 100;

       var discount_percentage = $('#discount_percentage_' + append_id).val();
        
       if (discount_percentage === '') {
       
       var discount_amount = 0;
   } else {
       var discount_amount = basic_price * parseFloat(discount_percentage) / 100;
   }
        var tax_percentage = $('#tax_percentage_' + append_id).val();
        var after_discount = basic_price - discount_amount;
    if (tax_percentage === 'Nil' || tax_percentage === '') {
        var tax = 0;
    } else {
        var tax = after_discount * parseFloat(tax_percentage) / 100;
    }
    var total_price = (basic_price + tax) - discount_amount;
    
        
    var calculationString = `(${basic_price} - ${discount_amount} = ${after_discount})`;
    $('#basic_price_' + append_id).attr('value', basic_price.toFixed(2));
        $('#tax_' + append_id).attr('value', tax.toFixed(2));
         $('#discount_' + append_id).attr('value', discount_amount.toFixed(2));
         $('#after_discount_' + append_id).html("<b>"+calculationString+"</b>");
        $('#total_price_' + append_id).attr('value', total_price.toFixed(2));


        calculate_sum_total_price();
    }

    $('#model_input').hide();

    // CREATING BLANK model INPUT
    var blank_model = '';
    $(document).ready(function() {
        blank_model = $('#model_input').html();
    });

    function add_model() {
        model_count++;
        $("#models").append(blank_model);
        $('#model_id').attr('id', 'model_id_' + model_count);
        $('#model_id_' + model_count).attr('onchange', 'get_model_available_quantity(this.value, ' + model_count + ')');
        $('#details_span').attr('id', 'details_span_' + model_count);
        $('#after_discount').attr('id', 'after_discount_' + model_count);
        $('#model_serial_no').attr('id', 'model_serial_no_' + model_count);
        $('#model_serial_no_' + model_count).attr('onchange', 'get_model_price(this.value, ' + model_count + ')');
        $('#item_price_details_id').attr('id', 'item_price_details_id_' + model_count);
        $('#model_quantity').attr('id', 'model_quantity_' + model_count);
        $('#available').attr('id', 'available_' + model_count);
        $('#model_price').attr('id', 'model_price_' + model_count);
        $('#basic_price').attr('id', 'basic_price_' + model_count);
        $('#tax_percentage').attr('id', 'tax_percentage_' + model_count);
        $('#tax').attr('id', 'tax_' + model_count);
          $('#discount_percentage').attr('id', 'discount_percentage_' + model_count);
        $('#discount').attr('id', 'discount_' + model_count);
        $('#total_price').attr('id', 'total_price_' + model_count);
         $('#hr').attr('id', 'hr_' + model_count);
        $('#model_delete').attr('id', 'model_delete_' + model_count);
        $('#model_delete_' + model_count).attr('onclick', 'deletemodelParentElement(this, ' + model_count + ')');
          $('#discount_percentage_' + model_count).attr('onkeyup', 'calculate_total_price_by_discount(' + model_count + ')');
        $('#model_id_' + model_count).select2();
    }
    
    function calculate_sum_total_price() {
        var total;
        for (i = 1; i <= model_count; i++) {
            if (jQuery.inArray(i, deleted_models) == -1) {
                quantity = $('#model_quantity_' + i).val();
                if (quantity == '')
                    quantity = 0;
                total = $('#total_price_' + i).val();
                if (total != '') {
                    total = parseFloat(total);
                    sum_total_price = total + sum_total_price;
                }
            }
        }
        $('#sum_total_price').attr('value', sum_total_price);
        sum_total_price = 0;
        calculate_total_amount();
    }

    function calculate_total_amount() {
        var sum_total_price = $('#sum_total_price').val();
        var discount_type = $('#discount_type option:selected').val();
        var discount_value = $('#discount_value').val();
        var total_amount = sum_total_price;
        if (discount_type == 'fixed') {
            $('#percent_sign').html("");
            total_amount = sum_total_price - discount_value;
        } else if (discount_type == 'percentage') {
            $('#percent_sign').html("%");
            total_amount = sum_total_price - ((sum_total_price * discount_value) / 100);
        } else {
            $('#percent_sign').html("");
        }
        $('#total_amount').val(total_amount);
        calculate_grand_total_amount();
    }

    function validate_tax() {
        var tax_type = $('#tax_type option:selected').val();
        var tax_per = $('#tax_per option:selected').val();
        if (tax_type == '') {
            alert("Select tax type first");
            $('#tax_per').val("0").change;
        }
        calculate_grand_total_amount();
    }

    function calculate_grand_total_amount() {
        var total_amount = parseFloat($('#total_amount').val());
        var grand_total = total_amount;
        var tax_type = $('#tax_type option:selected').val();
        var tax_per = parseFloat($('#tax_per option:selected').val());
        var tax_amount = 0;
        if (tax_type == 'IGST' || tax_type == 'CGST & SGST') {
            if (tax_per > 0) {
                tax_amount = total_amount * tax_per / 100;
            }
        }
        grand_total += tax_amount;
        $('#tax_amount').val(tax_amount.toFixed(2));
        $('#grand_total').val(grand_total.toFixed(2));
        calculate_due_amount();
    }

    function calculate_due_amount() {
        var grand_total = $('#grand_total').val();
        var received_amount = $('#received_amount').val();
        $('#due_amount').val((grand_total - received_amount).toFixed(2));
        change_button_attribute();
    }

    function change_button_attribute() {
        var grand_total = $('#grand_total').val();
        var due_amount = $('#due_amount').val();
        if (grand_total > 0 && due_amount >= 0) {
            $('#submit_button').removeAttr('disabled');
        } else {
            $('#submit_button').attr('disabled', 'true');
        }
    }

    //added by tarini on 16-06-2023
    function deletemodelParentElement(n, model_count) {
        // console.log("what",n);
        // alert(model_count);
        n.parentNode.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode.parentNode);
        $('#hr_' + model_count).remove();
        deleted_models.push(model_count);
        calculate_sum_total_price(); // Recalculate the total price after removing the row
    }

    function get_invoice_no(type) {
        if (type == 'challan') {
            $('#invoice_no_span').html("Challan No");
            $('#date_span').html("Challan Date");
        } else {
            $('#invoice_no_span').html("Invoice No");
            $('#date_span').html("Invoice Date");
        }
    }
    $(document).ready(function() {
    var or_due_amount = <?php echo $patient_item_issue_info['due_amount']; ?>;
    change_submitbutton_attribute(or_due_amount);

    $('#due_amount').on('input', function() {
        change_submitbutton_attribute(or_due_amount);
    });
});

function change_submitbutton_attribute(or_due_amount) {
    var due_amount = $('#due_amount').val();
    $('#submit_button').prop('disabled', or_due_amount != due_amount);
}


</script>