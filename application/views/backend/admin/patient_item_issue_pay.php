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
    <li><?php echo get_phrase('patient_item_issue_payment') ?></li>
</ol>
<br>



<div class="panel panel-primary" data-collapsed="0">

    <div class="panel-heading">
        <div class="panel-title">
            <h3><?php echo get_phrase('patient_item_issue_payment'); ?></h3>
        </div>
    </div>

    <div class="panel-body">

        <form role="form" class="form-horizontal form-groups" action="<?php echo site_url('admin/patient_item_issue/payment/'.$patient_item_issue_info['id']); ?>" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-sm-2">
                <label ><?php echo get_phrase('grand_total'); ?></label>

               
                    <input type="number" name="grand_total" class="form-control" id="grand_total" readonly value="<?php echo $patient_item_issue_info['grand_total']; ?>" />
                    <input type="hidden" name="patient_item_issue_id" class="form-control" value="<?php echo $patient_item_issue_info["id"]; ?>" id="field-1" > 

               
            </div>
                


            <div class="col-sm-2">
                <label ><?php echo get_phrase('paying_amount'); ?></label>

           
                    <input type="number" name="received_amount" class="form-control" value="" id="received_amount" onkeyup="calculate_due_amount()" />
                </div>


            <div class="col-sm-2">
                <label><?php echo get_phrase('due_amount'); ?></label>

                    <input type="number" name="due_amount" class="form-control" id="due_amount" value="<?php echo $patient_item_issue_info['due_amount']; ?>"  onkeyup="change_submitbutton_attribute(<?php echo $patient_item_issue_info['due_amount']; ?>)" readonly/>

                    <input type="hidden" class="form-control" id="fetched_due_amount" value="<?php echo $patient_item_issue_info['due_amount']; ?>" readonly/>
             
            </div>

            <div class="col-sm-2">
                <label><?php echo get_phrase('payment_status'); ?> <small style="color:red;">*</small></label>
            
                    <select name="payment_status" class="form-control" id="payment_status" required style="pointer-events: none;">
                        <option value=""><?php echo get_phrase('select_a_status'); ?></option>
                      
                        <option value="paid" <?php if($patient_item_issue_info['payment_status'] == "paid"){ echo "selected"; } ?>><?php echo get_phrase('paid'); ?></option>
                        <option value="unpaid" <?php if($patient_item_issue_info['payment_status'] == "unpaid"){ echo "selected"; } ?>><?php echo get_phrase('unpaid'); ?></option>
                        <option value="partial" <?php if($patient_item_issue_info['payment_status'] == "partial"){ echo "selected"; } ?>><?php echo get_phrase('partial'); ?></option>
                    </select>
              
            </div>

            <div class="col-sm-2">
                <label><?php echo get_phrase('payment_mode'); ?></label>
             
                    <select name="payment_mode_id" class="form-control">
                        <option value=""><?php echo get_phrase('select_payment_mode'); ?></option>
                        <?php foreach ($payment_mode_info as $row) { ?>
                            <option value="<?php echo $row['id']; ?>" <?php if($patient_item_issue_info['payment_mode_id'] == $row['id']){ echo "selected"; } ?>><?php echo $row['payment_mode']; ?></option>
                        <?php } ?>
                    </select>
       
            </div>
            <div class="col-sm-2">
          <br>

                    <button id='submit_button' type="submit" class="btn btn-success">
                        <i class="fa fa-inr"></i> &nbsp; <?php echo get_phrase('pay'); ?>
                    </button>
                </div>
            </div>
        
        </form>
            <hr>


      
                    <div>
                        <table style="width: 100%;"  class="table table-bordered table-striped datatable" id="table-2">
                            <tr>
                            <th style="text-align: center;"><?php echo get_phrase('issue_type'); ?></th>
                                <th style="text-align: center;"><?php echo get_phrase('invoice_id'); ?></th>
                                
                                <th style="text-align: center;"><?php echo get_phrase('grand_total'); ?></th>
                                <th style="text-align: center;"><?php echo get_phrase('received_amount'); ?></th>
                                <th style="text-align: center;"><?php echo get_phrase('due_amount'); ?></th>
                                <th style="text-align: center;"><?php echo get_phrase('paymemnt_status'); ?></th>
                                <th style="text-align: center;"><?php echo get_phrase('payment_mode'); ?></th>
                                <th style="text-align: center;"><?php echo get_phrase('date'); ?></th>
                            </tr>
                  
                            <?php
                            $payments     = json_decode($patient_item_issue_info['payments']);
                            foreach ($payments as $row) { ?>
                                <tr>
                                    <td style="text-align: center;"> <?php echo $patient_item_issue_info["issue_type"]; ?> </td>
                                    <td style="text-align: center;"><?php echo $patient_item_issue_info["bill_no"]; ?></td>
                                    <td style="text-align: center;"><?php echo $row->grand_total; ?></td>
                                    <td style="text-align: center;"> <?php echo $row->received_amount; ?></td>
                                    <td style="text-align: center;">
                                        <?php echo $row->due_amount; ?>
                                    </td>
                                    <td style="text-align: center;"> <?php echo $row->payment_status; ?></td>
                                    <td style="text-align: center;"> <?php echo $this->db->select('payment_mode')->from('payment_mode')->where('id', $row->payment_mode_id)->get()->row()->payment_mode; ?></td>
                                    <td style="text-align: center;"><?php echo $row->date; ?></td>
                                </tr>
                            <?php } ?>
                        </table>
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
      






  

    </div>

</div>



<script type="text/javascript">
    var model_count = <?php echo $i-1; ?>;
    var sum_total_price = 0;
    var deleted_models = [];




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
      //  var due_amount = $('#due_amount').val();
        var fetched_due_amount = $('#fetched_due_amount').val();

        var due_amount = fetched_due_amount - received_amount;


        if (received_amount == fetched_due_amount) {
            
            $('#payment_status').val('paid');
        }else if(received_amount == 0 || received_amount ==''){
            $('#payment_status').val('unpaid');
        }else{
            $('#payment_status').val('partial');
        }
        $('#due_amount').val((due_amount).toFixed(2));
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

    // function get_invoice_no(type) {
    //     if (type == 'challan') {
    //         $('#invoice_no_span').html("Challan No");
    //         $('#date_span').html("Challan Date");
    //     } else {
    //         $('#invoice_no_span').html("Invoice No");
    //         $('#date_span').html("Invoice Date");
    //     }
    // }



    function get_invoice_no(type) {
    if (type == 'challan') {
        $('#invoice_no_span').html("Challan No");
        $('#date_span').html("Challan Date");
        $('#demo_div').hide(); // Hide the demo div
        $('#return_days_div').hide(); // Hide the return days div

        var options = '<option value="">Select A Model</option>';
        <?php foreach ($item_info as $row): ?>
            <?php if ($row['quantity'] > 0 && $row['demo'] == 0): ?>
                options += '<option value="<?php echo $row['id']; ?>"><?php echo $row['model']; ?></option>';
            <?php endif; ?>
        <?php endforeach; ?>

     

        $('.sk').each(function(index) {
                                 var currentIndex = index + 1;
                               
                                 $('#model_id_'+currentIndex).html(options);
                                 
                            });

 

        // Set options for select with class 'srr'
       

    } else if (type == 'demo') {
        $('#invoice_no_span').html("Invoice No");
        $('#date_span').html("Invoice Date");
        $('#demo_div').show(); // Show the demo div
        $('#return_days_div').show(); // Show the return days div

        var options = '<option value="">Select A Model</option>';
        <?php foreach ($item_info as $row): ?>
            <?php if ($row['quantity'] > 0 && $row['demo'] == 1): ?>
                options += '<option value="<?php echo $row['id']; ?>"><?php echo $row['model']; ?></option>';
            <?php endif; ?>
        <?php endforeach; ?>

        $('.sk').each(function(index) {
                                 var currentIndex = index + 1;
                                 $('#model_id_'+currentIndex).html(options);
                                 
                            });
    } else if (type == 'invoice'){
        $('#invoice_no_span').html("Invoice No");
        $('#date_span').html("Invoice Date");
        $('#demo_div').hide(); // Hide the demo div
        $('#return_days_div').hide(); // Hide the return days div

        var options = '<option value="">Select A Model</option>';
        <?php foreach ($item_info as $row): ?>
            <?php if ($row['quantity'] > 0 && $row['demo'] == 0): ?>
                options += '<option value="<?php echo $row['id']; ?>"><?php echo $row['model']; ?></option>';
            <?php endif; ?>
        <?php endforeach; ?>

        $('.sk').each(function(index) {
                                 var currentIndex = index + 1;
                                 $('#model_id_'+currentIndex).html(options);
                                 
                            });
    }else{
        $('#invoice_no_span').html("Invoice No");
        $('#date_span').html("Invoice Date");
        $('#demo_div').hide(); // Hide the demo div
        $('#return_days_div').hide(); // Hide the return days div

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