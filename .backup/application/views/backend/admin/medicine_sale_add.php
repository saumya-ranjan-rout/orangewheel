<?php
$payment_mode_info = $this->db->get('payment_mode')->result_array();
$query=$this->db->select('bill_no')->from('medicine_sale')->order_by('medicine_sale_id', 'DESC')->limit(1)->get();
        if ($query->num_rows() > 0) {
            $stringValue = $query->row()->bill_no;
            $numericPart = (int) $stringValue;
            $incrementedNumericPart = $numericPart + 1;
            $lastinvoice = $incrementedNumericPart;
        } else {
            $stringValue = "100";
            $numericPart = (int) $stringValue;
            $incrementedNumericPart = $numericPart + 1;
            $lastinvoice = $incrementedNumericPart;
        }
        ?>
<ol class="breadcrumb bc-3" style="margin-bottom: 0px;">
    <li>
        <a href="<?php echo site_url('pharmacist'); ?>">
            <i class="entypo-folder"></i>
            <?php echo get_phrase('dashboard'); ?>
        </a>
    </li>
    <li>
        <a href="<?php echo site_url('admin/medicine_sale'); ?>">
            <?php echo get_phrase('medicine_sales') ?>
        </a>
    </li>
    <li><?php echo get_phrase('add_medicine_sale') ?></li>
</ol>
<br>

<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <h3><?php echo get_phrase('add_medicine_sale'); ?></h3>
                </div>
            </div>

            <div class="panel-body">

                <form role="form" class="form-horizontal form-groups" action="<?php echo site_url('admin/medicine_sale/create'); ?>" 
                    method="post" enctype="multipart/form-data">
                    
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('bill_number'); ?> <small style="color:red;">*</small></label>

                        <div class="col-sm-6">
                            <input type="text" name="bill_no" class="form-control" value="<?php echo $lastinvoice; ?>" id="field-1" readonly required>
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('patient'); ?> <small style="color:red;">*</small></label>

                        <div class="col-sm-6">
                            <select name="patient_id" class="form-control select2" required>
                                <option value=""><?php echo get_phrase('select_a_patient'); ?></option>
                                <?php
                                $patients = $this->db->get('patient')->result_array();
                                foreach ($patients as $row) { ?>
                                    <option value="<?php echo $row['patient_id']; ?>"><?php echo $row['name']; ?>(<?php echo $row['code']; ?>)</option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <span id="medicine">
                        <br>
                        <div class="form-group">
                            <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('medicines'); ?> <small style="color:red;">*</small></label>

                            <div class="col-sm-4">
                                <select name="medicine_id[]" class="form-control select2" onchange="get_available_quantity(this.value, 1)" required>
                                    <option value=""><?php echo get_phrase('select_a_medicine'); ?></option>
                                    <?php
                                    $medicines = $this->db->get('medicine')->result_array();
                                    foreach ($medicines as $row) {
                                        $available_quantity = $row['total_quantity'] - $row['sold_quantity'];
                                        if($available_quantity > 0) { ?>
                                            <option value="<?php echo $row['medicine_id']; ?>">
                                                <?php echo $row['name']; ?>
                                            </option>
                                        <?php }
                                    } ?>
                                </select>
                            </div>

                            <div class="col-sm-2">
                                <input type="number" class="form-control" name="medicine_quantity[]" id="medicine_quantity_1" min="1" max="999" value="" placeholder="Select Quantity" required/>
                            </div>

                            <div class="col-sm-2">
                                <input type="hidden" class="form-control" id="medicine_price_1" value="" readonly />
                            </div>
                        </div>
                    </span>

                    <span id="medicine_input">
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-4">
                                <select name="medicine_id[]" class="form-control" onchange="get_available_quantity(this.value)" id="medicine_id" >
                                    <option value=""><?php echo get_phrase('select_a_medicine'); ?></option>
                                    <?php
                                    $medicines = $this->db->get('medicine')->result_array();
                                    foreach ($medicines as $row) {
                                        $available_quantity = $row['total_quantity'] - $row['sold_quantity'];
                                        if($available_quantity > 0) { ?>
                                            <option value="<?php echo $row['medicine_id']; ?>">
                                                <?php echo $row['name']; ?>
                                            </option>
                                        <?php }
                                    } ?>
                                </select>
                            </div>

                            <div class="col-sm-2">
                                <input type="number" class="form-control" name="medicine_quantity[]" id="medicine_quantity" min="1" max="999" value="" placeholder="Select Quantity" />
                            </div>

                            <div class="col-sm-2">
                                <button type="button" class="btn btn-danger"
                                    id="medicine_delete" onclick="deletemedicineParentElement(this)">
                                    <i class="fa fa-trash-o"></i>
                                </button>
                            </div>

                            <div class="col-sm-2">
                                <input type="hidden" class="form-control" id="medicine_price" value="" readonly />
                            </div>
                        </div>
                    </span>

                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-6">
                            <button type="button" class="btn btn-primary btn-sm" onClick="add_medicine()">
                                <i class="fa fa-plus"></i> &nbsp;
                                <?php echo get_phrase('add_medicine'); ?>
                            </button>

                            <button type="button" class="btn btn-info btn-sm" onClick="calculate_total_price()">
                                <?php echo get_phrase('calculate_total_price'); ?>
                            </button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('total_price'); ?></label>

                        <div class="col-sm-2">
                            <input type="text" name="total_amount" class="form-control" id="total_amount" value="0" readonly />
                        </div>
                    </div>
                    
                     <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('payment_status'); ?> <small style="color:red;">*</small></label>

                        <div class="col-sm-6">
                            <select name="payment_status" class="form-control select2" id = "payment_status" required>
                                <option value= ""><?php echo get_phrase('select_a_status'); ?></option>
                                <option value="paid"><?php echo get_phrase('paid'); ?></option>
                                <option value="unpaid"><?php echo get_phrase('unpaid'); ?></option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('payment_mode'); ?></label>
                        <div class="col-sm-6">
                            <select name="payment_mode_id" class="form-control select2">
                                <option value=""><?php echo get_phrase('select_payment_mode'); ?></option>
                                <?php foreach ($payment_mode_info as $row) { ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['payment_mode']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-3">
                            <button id = 'submit_button' type="submit" class="btn btn-success">
                                <i class="fa fa-check"></i> &nbsp; <?php echo get_phrase('add_sale');?>
                            </button>
                        </div>
                    </div>
                </form>

            </div>

        </div>

    </div>
</div>

<script type="text/javascript">

    var medicine_count      = 1;
    var total_amount        = 0;
    var deleted_medicines   = [];

    $(document).ready(function(){
      $('#submit_button').attr('disabled', 'true');
    });
    function get_available_quantity(medicine_id, append_id)
    {
        if(medicine_id != '') {
            $.ajax({
                url     : '<?php echo site_url('admin/get_available_quantity/'); ?>' + medicine_id,
                success : function(response)
                {
                    $('#medicine_quantity_' + append_id).attr('max', response);
                }
            });

            $.ajax({
                url     : '<?php echo site_url('admin/get_medicine_price/'); ?>' + medicine_id,
                success : function(response)
                {
                    $('#medicine_price_' + append_id).attr('value', response);
                }
            });
        }
    }

    $('#medicine_input').hide();

    // CREATING BLANK medicine INPUT
    var blank_medicine = '';
    $(document).ready(function () {
        blank_medicine = $('#medicine_input').html();
    });

    function add_medicine()
    {
        medicine_count++;
        $("#medicine").append(blank_medicine);

        $('#medicine_id').attr('id', 'medicine_id_' + medicine_count);
        $('#medicine_id_' + medicine_count).attr('onchange', 'get_available_quantity(this.value, ' + medicine_count + ')');

        $('#medicine_quantity').attr('id', 'medicine_quantity_' + medicine_count);
        $('#medicine_price').attr('id', 'medicine_price_' + medicine_count);

        $('#medicine_delete').attr('id', 'medicine_delete_' + medicine_count);
        $('#medicine_delete_' + medicine_count).attr('onclick', 'deletemedicineParentElement(this, ' + medicine_count + ')');
    }

    // REMOVING medicine INPUT
    function deletemedicineParentElement(n, medicine_count) {
        n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);
        deleted_medicines.push(medicine_count);
    }

    function calculate_total_price()
    {
        var amount;
        for(i = 1; i <= medicine_count; i++) {
            if(jQuery.inArray(i, deleted_medicines) == -1)
            {
                quantity    = $('#medicine_quantity_' + i).val();
                if(quantity == '')
                    quantity = 0;
                amount      = $('#medicine_price_' + i).val() * quantity;
                if(amount != '') {
                    amount = parseInt(amount);
                    total_amount = amount + total_amount;
                    $('#total_amount').attr('value', total_amount);
                }
            }
        }
        change_button_attribute();
        total_amount = 0;
    }
    function change_button_attribute(){
      if (total_amount > 0) {
        $('#submit_button').removeAttr('disabled');
      }
      else{
        $('#submit_button').attr('disabled', 'true');
      }
    }
    
    //added by tarini on 16-06-2023
    function deletemedicineParentElement(n, medicine_count) {
        n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);
        deleted_medicines.push(medicine_count);
        calculate_total_price(); // Recalculate the total price after removing the row
    }

</script>
