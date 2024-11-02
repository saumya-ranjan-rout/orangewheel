<?php
$this->db->select('patient_consultation_history.*,patient.name as patient_name');
$this->db->from('patient_consultation_history');
$this->db->join('patient', 'patient_consultation_history.patient_id = patient.patient_id');
$this->db->where('patient_consultation_history.id', $param2);
$single_patient_consultation_history_info = $this->db->get()->result_array();
// $single_patient_info = $this->db->get_where('patient_consultation_history', array('id' => $param2))->result_array();
foreach ($single_patient_consultation_history_info as $row) {
?>
    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-primary" data-collapsed="0">

                <div class="panel-heading">
                    <div class="panel-title">
                        <h3><?php echo get_phrase('edit_patient'); ?></h3>                      
                    </div>
                </div>

                <div class="panel-body">

                    <form role="form" class="form-horizontal form-groups" action="<?php echo site_url('admin/edit_pres/update/'.$row['patient_id'] . '/' . $row['id']); ?>" 
                        method="post" enctype="multipart/form-data"   onsubmit="disableButton()">                       
                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Patient_name'); ?></label>

                            <div class="col-sm-7">
                                <input type="text" name="patient_name" class="form-control" id="field-1" value="<?php echo $row['patient_name']; ?>" readonly>
                                <input type="hidden" name="name" class="form-control" id="field-1" value="<?php echo $row['patient_id']; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Referred Doctor'); ?></label>
    
                            <div class="col-sm-7">
                                <input type="text" name="referred_by" class="form-control" id="referred_by" value="<?php echo $row['referred_by']; ?>">
                            </div>
                        </div>


                        <div class="form-group">
    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('visit_type'); ?></label>
    
    <div class="col-sm-7">
    <select id="visit_type" name="visit_type" class="form-control">
    <option value="">Select Visit Type</option>
    <option value="walk-in" <?php if($row['visit_type']=="walk-in"){ echo"selected"; } ?>>Walk-in</option>
    <option value="appointment" <?php if($row['visit_type']=="appointment"){ echo"selected"; } ?>>Appointment</option>
    </select>
    </div>
    </div>

    <div class="form-group">
    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Remarks'); ?></label>
    
    <div class="col-sm-7">
    <textarea type="text" name="remarks" class="form-control" id="remarks" ><?php echo $row['remarks'];?></textarea>
    </div>
    </div>

    <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('consultation_name'); ?>   <small style="color:red;">*</small></label>

                            <div class="col-sm-7">
                                <input type="text" name="consultation_name" class="form-control" id="field-1" value="<?php echo $row['consultation_name']; ?>" required>
                            </div>
                        </div>

                    
    <div class="form-group">
    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Price'); ?></label>
    
    <div class="col-sm-7">
    <input type="number" name="price" class="form-control" id="price" value="<?php echo $row['price']; ?>" oninput="calculateTotalPrice()">
    </div>
    </div>

    <div class="form-group">
    <label class="col-sm-3 control-label"><?php echo get_phrase('Discount_type');?></label>
    <div class="col-sm-7">                             
    <select class="form-control" name="discount_type" id="ediscount_type" disable onchange="calculateTotalPrice()">
    <option value="">Select Discount Type</option>
    <option value="fixed" <?php if($row['discount_type']=="fixed"){ echo"selected"; } ?>>Fixed</option>
    <option value="percentage" <?php if($row['discount_type']=="percentage"){ echo"selected"; } ?>>Percentage</option>
    </select>
    </div>
    </div>

    <div class="form-group" id="ediscount_value_field" style="display: none">
      <label class="col-sm-3 control-label" id="ediscount_value_label"><?php echo get_phrase('Discount_Value');?></label>
    <div class="col-sm-7">
      <input type="text" class="form-control" id="ediscount_value" name="discount_price" value="<?php echo $row['discount_price'];?>" oninput="calculateTotalPrice()"/>
    </div>
    </div>

    <div class="form-group" id="etotal_price_field">
      <label class="col-sm-3 control-label" id="etotal_price_label"><?php echo get_phrase('total_price');?></label>
    <div class="col-sm-7">
      <input type="text" class="form-control" id="etotal_price" name="total_price" value="<?php echo $row['total_price'];?>" readonly/>
    </div>
    </div>

    <div class="form-group">
        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('date'); ?>  </label>

        <div class="col-sm-7">
                            <?php
   $input_date = $row['date'];
$date_obj = DateTime::createFromFormat('d-m-Y', $input_date);
$formatted_date = $date_obj->format('m/d/Y');?>     
        <input type="text" name="date"  class="form-control datepicker"  id="field-1"  value="<?php echo $formatted_date; ?>">
        </div>
        </div>    
    <!-- </div>
    </div>     -->
                        <div class="col-sm-3 control-label col-sm-offset-2">
                            <button type="submit" class="btn btn-success" id="myButton">
                                <i class="fa fa-check"></i> <?php echo get_phrase('update');?>
                            </button>
                        </div>
                    </form>

                </div>

            </div>

        </div>
    </div>
<?php } ?>

<script>
$(document).ready(function() {
    // Show/hide the "Discount Value" field based on the selected option
    $('#ediscount_type').change(function() {
        if ($(this).val() === 'fixed' || $(this).val() === 'percentage') {
            $('#ediscount_value_field').show();
            if ($(this).val() === 'percentage') {
                $('#ediscount_value_label').text('<?php echo get_phrase('Discount_Value');?> (%)');
            } else {
                $('#ediscount_value_label').text('<?php echo get_phrase('Discount_Value');?>');
            }
        } else {
            $('#ediscount_value_field').hide();
        }
    });

    // Check the selected option on page load
    var selectedOption = $('#ediscount_type').val();
    if (selectedOption === 'fixed' || selectedOption === 'percentage') {
        $('#ediscount_value_field').show();
        if (selectedOption === 'percentage') {
            $('#ediscount_value_label').text('<?php echo get_phrase('Discount_Value');?> (%)');
        } else {
            $('#ediscount_value_label').text('<?php echo get_phrase('Discount_Value');?>');
        }
    }
});
</script>
<script>
function calculateTotalPrice() {
    var price = parseFloat($('#price').val()) || 0;
    var discountType = $('#ediscount_type').val();
    var discountValue = parseFloat($('#ediscount_value').val()) || 0;

    var totalPrice = price;
    if (discountType === 'fixed') {
        totalPrice -= discountValue;
    } else if (discountType === 'percentage') {
        totalPrice -= (price * discountValue) / 100;
    }

    $('#etotal_price').val(totalPrice.toFixed(2));
}
</script>

<script>
    // $(document).ready(function() {
    //     // Attach the change event to the DOB input element
    //     $("#birth_date").on("change", function() {
    //         // Get the chosen DOB value
    //         var dobValue = $(this).val();
            
    //         // Calculate age
    //         var age = calculateAge(dobValue);
            
    //         // Display the age in the output element
    //         $("#age").val(age);
    //     });
    // });
    
    // Function to calculate age based on DOB
    // function calculateAge(dob) {
    //     var today = new Date();
    //     var birthDate = new Date(dob);
    //     var age = today.getFullYear() - birthDate.getFullYear();
    //     var monthDiff = today.getMonth() - birthDate.getMonth();
    //     if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
    //         age--;
    //     }
    //         if (age <= 0) {
    //       age = 0;
    //         }
    //  return age;
    // }
    
    
    $(document).ready(function() {
        // Handle checkbox click event
        $("#sameAddressCheckbox").change(function() {
            if ($(this).is(":checked")) {
                // If checkbox is checked, copy current address to permanent address
                var current_street = $("#current_street").val();
                var current_city = $("#current_city").val();
                var current_state = $("#current_state").val();
                var current_postalcode = $("#current_postalcode").val();
                $("#permanent_street").val(current_street); 
                 $("#permanent_city").val(current_city); 
                 $("#permanent_state").val(current_state);
                  $("#permanent_postalcode").val(current_postalcode);
                
            
            } else {
                // If checkbox is unchecked, clear the permanent address field
                $("#permanent_street").val("");
                $("#permanent_city").val("");
                $("#permanent_state").val("");
                $("#permanent_postalcode").val("");
   

            }
        });
    });
  




    function disableButton() {
      var button = document.getElementById("myButton");
      button.disabled = true;
    }
    </script>
<script>
$(document).ready(function() {
    // Show/hide the "Discount Value" field based on the selected option
    $('#ediscount_type').change(function() {
        if ($(this).val() === 'fixed' || $(this).val() === 'percentage') {
            $('#ediscount_value_field').show();
            if ($(this).val() === 'percentage') {
                $('#ediscount_value_label').text('<?php echo get_phrase('Discount_Value');?> (%)');               
            } else {
                $('#ediscount_value_label').text('<?php echo get_phrase('Discount_Value');?>');              
            }
        } else {
            $('#ediscount_value_field').hide();           
        }
    });

    // Check the selected option on page load
    var selectedOption = $('#ediscount_type').val();
    if (selectedOption === 'fixed' || selectedOption === 'percentage') {
        $('#ediscount_value_field').show();
        if (selectedOption === 'percentage') {
            $('#ediscount_value_label').text('<?php echo get_phrase('Discount_Value');?> (%)');           
        } else {
            $('#ediscount_value_label').text('<?php echo get_phrase('Discount_Value');?>');            
        }
    }
});
</script>