

<?php
$payment_mode_info = $this->db->get('payment_mode')->result_array();
$query = $this->db->select('invoice_no')->from('purchase')->order_by('id', 'DESC')->limit(1)->get();
if ($query->num_rows() > 0) {
    $stringValue = $query->row()->invoice_no;
    $numericPart = (int) $stringValue;
    $incrementedNumericPart = $numericPart + 1;
    $lastinvoice = $incrementedNumericPart;
} else {
    $lastinvoice = 1001;
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
<a href="<?php echo site_url('admin/purchase_entry'); ?>">
<?php echo get_phrase('manage_purchase_entry'); ?>
</a>
</li>
<li><?php echo get_phrase('add_purchase_entry') ?></li>
</ol>
<br>

<div class="row">
<div class="col-md-12">

<div class="panel panel-primary" data-collapsed="0" style=" background-color: #E7E7E7">

<div class="panel-heading" style=" background-color: #E7E7E7">
<div class="panel-title" style="text-align:center;">
<h3><?php echo get_phrase('add_purchase_entry'); ?></h3>
</div>
</div>

<div class="panel-body">

<form role="form" class="form-horizontal form-groups" action="<?php echo site_url('admin/purchase_entry/create'); ?>" method="post" enctype="multipart/form-data">

<div class="form-group">

<div class="row">
<div class="col-sm-5">
<div class="col-sm-4"><label for="field-ta" class="control-label"><?php echo get_phrase('supplier'); ?> <small style="color:red;">*</small></label>
</div>
<div class="col-sm-8">

<select name="supplier_id" class="form-control select2" onchange="get_supplier_details(this.value)"  required>
<option value=""><?php echo get_phrase('select_a_supplier'); ?></option>
<?php
$patients = $this->db->get('item_supplier')->result_array();
foreach ($patients as $row) { ?>
    <option value="<?php echo $row['id']; ?>"><?php echo $row['item_supplier']; ?>(<?php echo $row['supplier_code']; ?>)</option>
    <?php } ?>
    </select>
    <br>
    <span id="supplier_details"></span><br>
    </div>
    </div>
    <div class="col-sm-7">
    
    <div class="form-group">
    <div class="col-sm-12">
    <div class="col-sm-4">
    <label for="field-ta" class="control-label"><?php echo get_phrase('invoice_no'); ?> <small style="color:red;">*</small></label>
    </div>
    <div class="col-sm-8">
    <input type="text" name="invoice_no" class="form-control"  id="invoice_no" value="<?php echo $lastinvoice; ?>" readonly required>
    </div>
    </div></div>
    
    <div class="form-group">
    <div class="col-sm-12">
    <div class="col-sm-4">
    <label for="field-ta" class="control-label"><?php echo get_phrase('supplier_invoice_no'); ?> <small style="color:red;">*</small></label>
    </div>
    <div class="col-sm-8">
    <input type="text" name="supplier_invoice_no" class="form-control"  id="supplier_invoice_no" required>
    
    </div>
    </div>
    </div>
    <div class="form-group">
    <div class="col-sm-12">
    <div class="col-sm-4">
    <label for="field-ta" class="control-label"><?php echo get_phrase('invoice_date'); ?> <small style="color:red;">*</small></label>
    </div>
    <div class="col-sm-8">
    <input type="text" name="invoice_date" class="form-control datepicker" id="invoice_date"  required>
    
    </div>
    </div>
    </div>
    
    </div>
    </div>
    
    
    
    
    
    </div>
    
    
    <hr>
    
    
    <span id="models">
    <div class="form-group">
    
    
    <div class="col-sm-3">
    <label><?php echo get_phrase('item'); ?> <small style="color:red;">*</small></label>
    <select name="item_id[]" class="form-control select2" id="item_id_1" required >
    <option value=""><?php echo get_phrase('select_a_item'); ?></option>
    <?php
    foreach ($item_info as $row) {
        ?>
        
        <option value="<?php echo $row['id']; ?>">
        <?php echo $row['model']; ?>
        </option>
        <?php }
        ?>
        </select>
        
        
        
        
        </div>
        <div class="col-sm-2">
        <label><?php echo get_phrase('quantity'); ?></label>
        <input type="number" class="form-control" name="item_quantity[]" id="item_quantity_1" min="1" max="999" value="1" onkeyup="calculate_amount(1)"  required />
        </div>
        <div class="col-sm-2">
        <label><?php echo get_phrase('batch'); ?></label>
        <input type="text" class="form-control" name="item_batch[]" id="item_batch_1" required />
        </div>
        
        
        <!-- <div class="col-sm-2">
        <label><?php echo get_phrase('details'); ?></label><br>
        <span id="details_span_1"></span><br>
        </div> -->
        
        <div class="col-sm-2">
        <label><?php echo get_phrase('price'); ?></label>
        <input type="text" class="form-control" id="item_price_1" name="item_price[]" value=""  onkeyup="calculate_amount(1)"/>
        </div>
        <div class="col-sm-2">
        <label><?php echo get_phrase('Amount'); ?></label>
        <input type="text" class="form-control" id="item_amount_1" name="item_amount[]" value=""  />
        </div>
        </div>
        </span>
        
        <span id="model_input">
        <div class="form-group">
        
        <div class=" col-sm-3">
        <select name="item_id[]" class="form-control" id="item_id">
        <option value=""><?php echo get_phrase('select_a_item'); ?></option>
        <?php
        foreach ($item_info as $row) {
            ?>
            <option value="<?php echo $row['id']; ?>">
            <?php echo $row['model']; ?>
            </option>
            <?php }
            ?>
            </select>
            </div>
            <div class="col-sm-2">
            <input type="number" class="form-control" name="item_quantity[]" id="item_quantity" min="1" max="999" value="1" onkeyup="calculate_amount()"  />
            </div>
            <div class="col-sm-2">
            <input type="text" class="form-control" name="item_batch[]" id="item_batch"   />
            </div>
            
            <!-- <div class="col-sm-2">
            <span id="details_span"></span><br>
            </div> -->
            
            <div class="col-sm-2">
            <input type="text" class="form-control" id="item_price" name="item_price[]" value=""   onkeyup="calculate_amount()" />
            </div>
            <div class="col-sm-2">
            <input type="text" class="form-control" id="item_amount" name="item_amount[]" value=""  />
            </div>
            
            <div class="col-sm-1">
            <button type="button" class="btn btn-danger" id="item_delete" onclick="deletemodelParentElement(this)">
            <i class="fa fa-trash-o"></i>
            </button>
            </div>
            </div>
            </span>
            <hr>
            <div class="form-group">
            <div class="col-sm-offset-1 col-sm-1">
            <button type="button" class="btn btn-primary btn-sm" onClick="add_model()">
            <i class="fa fa-plus"></i> &nbsp;
            <?php echo get_phrase('add_item'); ?>
            </button>
            
            </div>
            </div>
            <hr>
            <div class="row">
            <div class="col-sm-6">
            </div>
            <div class="col-sm-6">
            <div class="form-group">
            <label for="field-ta" class="col-sm-4 control-label"><?php echo get_phrase('total_price'); ?></label>
            
            <div class="col-sm-8">
            <input type="number" name="total_amount" class="form-control" id="total_amount" value="0" readonly />
            </div>
            </div>
            
            <div class="form-group">
            <label for="field-1" class="col-sm-4 control-label"><?php echo get_phrase('discount'); ?></label>
            <div class="col-sm-4">
            <select name="discount_type" onchange="calculate_grand_total_price()" class="form-control" id="discount_type">
            <option value=""><?php echo get_phrase('select_discount_type'); ?></option>
            <option value="fixed"><?php echo get_phrase('fixed'); ?></option>
            <option value="percentage"><?php echo get_phrase('percentage'); ?></option>
            </select>
            </div>
            <div class="col-sm-4">
            <input type="number" name="discount_value" placeholder="Value" onkeyup="calculate_grand_total_price()" class="form-control" id="discount_value" style="display: inline-block; width: 90%;" /><span id="percent_sign"></span>
            </div>
            </div>
            <div class="form-group">
            <label for="field-ta" class="col-sm-4 control-label"><?php echo get_phrase('tax_type'); ?></label>
            
            <div class="col-sm-3">
            <select name="tax_type" class="form-control" id="tax_type">
            <option value=""><?php echo get_phrase('select_tax_type'); ?></option>
            <option value="cgst & sgst"><?php echo get_phrase('CGST & SGST'); ?></option>
            <option value="igst"><?php echo get_phrase('IGST'); ?></option>
            </select>
            </div>
            <label for="field-ta" class="col-sm-1 control-label"><?php echo get_phrase('value'); ?></label>
            
            <div class="col-sm-4">
            <select name="tax_value" class="form-control" id="gst" onchange="calculate_grand_total_price()">
            <option value="0"><?php echo get_phrase('nil'); ?></option>
            <option value="5"><?php echo get_phrase('5%'); ?></option>
            <option value="12"><?php echo get_phrase('12%'); ?></option>
            <option value="18"><?php echo get_phrase('18%'); ?></option>
            <option value="28"><?php echo get_phrase('28%'); ?></option>
            </select>
            </div>
            </div>
            <div class="form-group">
            <label for="field-ta" class="col-sm-4 control-label"><?php echo get_phrase('grand_total'); ?></label>
            
            <div class="col-sm-8">
            <input type="number" name="grand_total" class="form-control" id="grand_total" readonly />
            </div>
            </div>
            <div class="form-group">
            <label for="field-1" class="col-sm-4 control-label"><?php echo get_phrase('payment_status'); ?> <small style="color:red;">*</small></label>
            <div class="col-sm-8">
            <select name="payment_status" class="form-control" id="payment_status" required>
            <option value=""><?php echo get_phrase('select_a_status'); ?></option>
            <option value="paid"><?php echo get_phrase('paid'); ?></option>
            <option value="unpaid"><?php echo get_phrase('unpaid'); ?></option>
            <option value="partial"><?php echo get_phrase('partial'); ?></option>
            </select>
            </div>
            </div>
            
            <div class="form-group">
            <label for="field-ta" class="col-sm-4 control-label"><?php echo get_phrase('payment_mode'); ?></label>
            <div class="col-sm-8">
            <select name="payment_mode_id" class="form-control">
            <option value=""><?php echo get_phrase('select_payment_mode'); ?></option>
            <?php foreach ($payment_mode_info as $row) { ?>
                <option value="<?php echo $row['id']; ?>"><?php echo $row['payment_mode']; ?></option>
                <?php } ?>
                </select>
                </div>
                </div>
            
            <div class="form-group">
            <label for="field-ta" class="col-sm-4 control-label"><?php echo get_phrase('received_amount'); ?></label>
            
            <div class="col-sm-8">
            <input type="number" name="received_amount" class="form-control" id="paid_amount" onkeyup="calculate_unpaid_amount()" />
            </div>
            </div>
            
            <div class="form-group">
            <label for="field-ta" class="col-sm-4 control-label"><?php echo get_phrase('due_amount'); ?></label>
            
            <div class="col-sm-8">
            <input type="number" name="due_amount" class="form-control" id="unpaid_amount" readonly />
            </div>
            </div>
            
         
                
                <div class="form-group">
                <div class="col-sm-offset-8 col-sm-2">
                <button id='' type="submit" class="btn btn-success">
                <i class="fa fa-check"></i> &nbsp; <?php echo get_phrase('save'); ?>
                </button>
                </div>
                </div>
                </div>
                </div>
                </form>
                
                </div>
                
                </div>
                
                </div>
                </div>
                
                <script type="text/javascript">
                var model_count = 1;
                var total_amount = 0;
                var deleted_models = [];
                
                $(document).ready(function() {
                    $('#submit_button').attr('disabled', 'true');
                });
                
                function get_model_available_quantity(model_id, append_id) {
                    if (model_id != '') {
                        $.ajax({
                            url: '<?php echo site_url('admin/get_model_available_quantity/'); ?>' + model_id,
                            success: function(response) {
                                // alert(response);
                                var data = JSON.parse(response);
                                $('#model_quantity_' + append_id).attr('max', data.quantity);
                                $('#model_price_' + append_id).attr('value', data.unit_price);
                                if (data.item_category == 'Accessories') {
                                    $('#details_span_' + append_id).html("<b>Category : </b>" + data.item_category + "<br><b>Additional Name : </b>" + data.additional_name);
                                } else {
                                    $('#details_span_' + append_id).html("<b>Category : </b>" + data.item_category + "<br><b>Type : </b>" + data.type + "<br><b>Channel : </b>" + data.channel + "<br><b>L/R : </b>" + data.lr);
                                }
                                calculate_total_price();
                            }
                        });
                        
                    } else {
                        $('#model_quantity_' + append_id).attr('max', 1);
                        $('#model_price_' + append_id).attr('value', "");
                        $('#details_span_' + append_id).html("");
                        calculate_total_price();
                    }
                }
                
                $('#model_input').hide();
                
                // CREATING BLANK model INPUT
                var blank_model = '';
                $(document).ready(function() {
                    blank_model = $('#model_input').html();
                    
                });
                
                function add_model() {
                    
                    model_count++;
                    // alert(model_count);
                    $("#models").append(blank_model);
                    
                    $('#item_id').attr('id', 'item_id_' + model_count);
                    //  $('#item_id_' + model_count).attr('onchange', 'get_model_available_quantity(this.value, ' + model_count + ')');
                    // $('#details_span').attr('id', 'details_span_' + model_count);
                    $('#item_quantity').attr('id', 'item_quantity_' + model_count);
                    $('#item_quantity_' + model_count).attr('onkeyup', 'calculate_amount(' + model_count + ')');
                    $('#item_batch').attr('id', 'item_batch_' + model_count);
                    $('#item_price').attr('id', 'item_price_' + model_count);
                    $('#item_price_' + model_count).attr('onkeyup', 'calculate_amount(' + model_count + ')');
                    $('#item_amount').attr('id', 'item_amount_' + model_count);
                    $('#item_delete').attr('id', 'item_delete_' + model_count);
                    $('#item_delete_' + model_count).attr('onclick', 'deletemodelParentElement(this, ' + model_count + ')');
                    $('#item_id_' + model_count).select2();
                    $('#item_quantity_' + model_count).attr('required', 'required');
                    $('#item_batch_' + model_count).attr('required', 'required');
                    calculate_total_price();
                }
                
                function calculate_total_price() {
                    var amount;
                    for (i = 1; i <= model_count; i++) {
                        if (jQuery.inArray(i, deleted_models) == -1) {
                            quantity = $('#item_quantity_' + i).val();
                            if (quantity == '')
                            quantity = 0;
                            amount = $('#item_price_' + i).val() * quantity;
                            if (amount != '') {
                                amount = parseInt(amount);
                                total_amount = amount + total_amount;
                            }
                        }
                    }
                    // $('#total_amount').attr('value', total_amount);
                    $('#total_amount').attr('value', total_amount.toFixed(2).toString());
                    total_amount = 0;
                    calculate_grand_total_price();
                }
                
                // function calculate_grand_total_price() {
                    //     var tot_amount = $('#total_amount').val();
                    //     var discount_type = $('#discount_type option:selected').val();
                    //     var discount_value = $('#discount_value').val();
                    //     var grand_total = tot_amount;
                    //     if (discount_type == 'fixed') {
                        //         $('#percent_sign').html("");
                        //         grand_total = tot_amount - discount_value;
                        //     } else if (discount_type == 'percentage') {
                            //         $('#percent_sign').html("%");
                            //         grand_total = tot_amount - ((tot_amount * discount_value) / 100);
                            //     } else {
                                //         $('#percent_sign').html("");
                                //     }
                                
                                //     var gst = parseInt($('#gst').val());
                                //     grand_total = grand_total + parseInt((grand_total * gst) / 100);
                                
                                //     $('#grand_total').val(grand_total);
                                //     calculate_unpaid_amount();
                                // }
                                
                                function calculate_grand_total_price() {
                                    var tot_amount = parseFloat($('#total_amount').val()); // Use parseFloat for decimal values
                                    var discount_type = $('#discount_type').val(); // Simplify getting the selected value
                                    var discount_value = parseFloat($('#discount_value').val()); // Use parseFloat for decimal values
                                    var grand_total = tot_amount;
                                    
                                    if (discount_type === 'fixed') { // Use strict equality operator (===)
                                        $('#percent_sign').html('');
                                        grand_total = tot_amount - discount_value;
                                    } else if (discount_type === 'percentage') {
                                        $('#percent_sign').html('%');
                                        grand_total = tot_amount - (tot_amount * discount_value) / 100;
                                    } else {
                                        $('#percent_sign').html('');
                                    }
                                    
                                    var gst = parseInt($('#gst').val()); // Specify radix 10 for parseInt
                                    grand_total = grand_total + (grand_total * gst) / 100;
                                    
                                    $('#grand_total').val(grand_total.toFixed(2)); // Fix the decimal places to two digits
                                    calculate_unpaid_amount();
                                }
                                
                                
                                function calculate_unpaid_amount() {
                                    var grand_total = $('#grand_total').val();
                                    var paid_amount = $('#paid_amount').val();
                                    $('#unpaid_amount').val((grand_total - paid_amount).toFixed(2));
                                    change_button_attribute();
                                }
                                
                                function change_button_attribute() {
                                    var grand_total = $('#grand_total').val();
                                    var unpaid_amount = $('#unpaid_amount').val();
                                    if (grand_total > 0 && unpaid_amount >= 0) {
                                        $('#submit_button').removeAttr('disabled');
                                    } else {
                                        $('#submit_button').attr('disabled', 'true');
                                    }
                                }
                                
                                //added by tarini on 16-06-2023
                                function deletemodelParentElement(n, model_count) {
                                    n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);
                                    deleted_models.push(model_count);
                                    calculate_total_price(); // Recalculate the total price after removing the row
                                }
                                
                                
                                function get_supplier_details(id) {
                                    
                                    if (id != '') {
                                        $.ajax({
                                            url: '<?php echo site_url('admin/get_supplier_details/'); ?>' +id,
                                            success: function(response) {
                                                // alert(response);
                                                var data = JSON.parse(response);
                                                // alert(data);
                                                
                                                $('#supplier_details').html("<b>Supplier Name : </b>" + data.item_supplier + "<br><b>Supplier Code : </b>" + data.supplier_code+"<br><b>Phone : </b>" + data.phone +"<br><b>Email : </b>" + data.email+"<br><b>Address : </b>" + data.address);
                                                
                                                
                                            }
                                        });
                                        
                                    } else {
                                        $('#supplier_details').html("");
                                        calculate_total_price();
                                    }
                                }
                                
                                function calculate_amount(qp) {
                                    var quantity =$('#item_quantity_' + qp).val();
                                    var price =$('#item_price_' + qp).val();
                                    
                                    var amount = quantity*price;
                                    $('#item_amount_' + qp).val(amount);
                                    calculate_total_price()
                                }
                                </script>