<?php
$tpa_management_info = $this->db->get('tpa_management')->result_array();
 $bloodgroup_info = $this->db->get('blood_bank')->result_array(); ?>
<?php
$single_patient_info = $this->db->get_where('patient', array('patient_id' => $param2))->result_array();
foreach ($single_patient_info as $row) {
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

                    <form role="form" class="form-horizontal form-groups" action="<?php echo site_url('hr/patient/update/'.$row['patient_id']); ?>" 
                        method="post" enctype="multipart/form-data"   onsubmit="disableButton()">
                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Patient Id'); ?>   <small style="color:red;">*</small></label>

                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="field-1" value="<?php echo $row['code']; ?>" required readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('name'); ?>   <small style="color:red;">*</small></label>

                            <div class="col-sm-7">
                                <input type="text" name="name" class="form-control" id="field-1" value="<?php echo $row['name']; ?>" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('email'); ?>   <small style="color:red;">*</small></label>

                            <div class="col-sm-7">
                                <input type="email" name="email" class="form-control" id="field-1" value="<?php echo $row['email']; ?>" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('phone'); ?> <small style="color:red;">*</small></label>

                            <div class="col-sm-7">
                                <input type="text" name="phone" pattern="[0-9]{10}" class="form-control" id="field-1" value="<?php echo $row['phone']; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('sex'); ?>   <small style="color:red;">*</small></label>

                            <div class="col-sm-7">
                                <select name="sex" class="form-control" required>
                                    <option value=""><?php echo get_phrase('select_sex'); ?></option>
                                <option value="male" <?php if($row['sex']=="male"){ echo"selected"; } ?>>Male</option>
  <option value="female" <?php if($row['sex']=="female"){ echo"selected"; } ?>>Female</option>
  <option value="other" <?php if($row['sex']=="other"){ echo"selected"; } ?>>Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('Blood Group'); ?>   <small style="color:red;">*</small></label>

                        <div class="col-sm-7">
                            <select name="blood_group" class="form-control" required
                                class="form-control">
                                <option value=""><?php echo get_phrase('Select Blood Group'); ?></option>
                                <?php foreach ($bloodgroup_info as $row2) { ?>
                                    <option value="<?php echo $row2['blood_group_id']; ?>"<?php if ($row['blood_group'] == $row2['blood_group_id']) echo 'selected'; ?>><?php echo $row2['blood_group']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('birth_date'); ?>   <small style="color:red;">*</small></label>

                            <div class="col-sm-7">
                                <input type="text" name="birth_date" class="form-control datepicker" id="field-1" value="<?php echo date("m/d/Y", $row['birth_date']); ?>" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('age'); ?></label>

                            <div class="col-sm-7">
                                <input type="number" name="age" class="form-control" id="field-1" value="<?php echo $row['age']; ?>">
                            </div>
                        </div>

                        <div class="form-group">
    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Marital Status'); ?></label>
    <div class="col-sm-7">
    <select id="maritalStatus" name="marital_status" class="form-control">
    <option value="">Select Marital Status</option>
    <option value="single" <?php if($row['marital_status']=="single"){ echo"selected"; } ?>>Single</option>
    <option value="married" <?php if($row['marital_status']=="married"){ echo"selected"; } ?>>Married</option>
    <option value="divorced" <?php if($row['marital_status']=="divorced"){ echo"selected"; } ?>>Divorced</option>
    <option value="widowed" <?php if($row['marital_status']=="widowed"){ echo"selected"; } ?>>Widowed</option>
    <option value="other" <?php if($row['marital_status']=="other"){ echo"selected"; } ?>>Other</option>
    </select>
    </div>
    </div>

    <div class="form-group">
    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Weight'); ?></label>
    
    <div class="col-sm-7">
    <input type="number" name="weight" class="form-control" id="weight"  value="<?php echo $row['weight']; ?>">
    </div>
    </div>
    <div class="form-group">
    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Guardian Name'); ?>   <small style="color:red;">*</small></label>
    
    <div class="col-sm-7">
    <input type="text" name="guardian_name" class="form-control" id="guardian_name"  value="<?php echo $row['guardian_name']; ?>"  required>
    </div>
    </div>
    <div class="form-group">
    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Guardian Number'); ?>   <small style="color:red;">*</small></label>
    
    <div class="col-sm-7">
    <input type="number" name="guardian_no" class="form-control" id="guardian_no"  value="<?php echo $row['guardian_no']; ?>" required>
    </div>
    </div>
    <div class="form-group">
    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Referred By'); ?></label>
    
    <div class="col-sm-7">
    <select name="referred_by" class="form-control" id="referred_by" required class="form-control">
        <option value=""><?php echo get_phrase('Select Referred By'); ?></option>
            <?php foreach ($tpa_management_info as $row3) { ?>
                <option value="<?php echo $row3['tpa_id']; ?>"<?php if ($row['referred_by'] == $row3['tpa_id']) echo 'selected'; ?>><?php echo $row3['tpa_name']."/".$row3['code']; ?></option>
            <?php } ?>
    </select>
    </div>
    </div>
    <div class="form-group">
    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Commission Add'); ?></label>
    
    <div class="col-sm-7">
    <input type="number" name="commission_add" class="form-control" id="commission_add"  value="<?php echo $row['commission_add']; ?>">
    </div>
    </div>
    <div class="form-group">
    <div class="col-sm-6">
    <label for="field-1" class="control-label"><?php echo get_phrase('Current Address'); ?></label><br><br>
    </div>
    <div class="col-sm-6">
    <label for="field-1" class="control-label"><?php echo get_phrase('Permanent Address'); ?></label><br>
    <input type="checkbox" id="sameAddressCheckbox"><label for="sameAddressCheckbox" style="font-size:10px;">Same as Current Address</label>
    
    </div>
    </div>
    
    <div class="form-group">
    <div class="col-sm-6">
    <div class="row">
    <div class="col-sm-12">
    <label for="currentStreet"  class="col-sm-3 control-label" style="font-size:10px;"> Street:</label>
    <div class="col-sm-9">
    <input type="text" id="current_street" class="form-control" name="current_street"  value="<?php echo $row['current_street']; ?>">
    </div>
    </div>
    <div class="col-sm-12">
    <label for="currentCity" class="col-sm-3 control-label" style="font-size:10px;"> City:</label>
    <div class="col-sm-9">
    <input type="text" id="current_city" class="form-control" name="current_city"  value="<?php echo $row['current_city']; ?>">
    </div>
    </div>
    <div class="col-sm-12">
    <label for="currentState" class="col-sm-3 control-label" style="font-size:10px;"> State:</label>
    <div class="col-sm-9">
    <input type="text" id="current_state" class="form-control" name="current_state"  value="<?php echo $row['current_state']; ?>">
    </div>
    </div>
    <div class="col-sm-12">
    <label for="currentPostalCode" class="col-sm-3 control-label" style="font-size:10px;"> Postal Code:</label>
    <div class="col-sm-9">
    <input type="text" id="current_postalcode"class="form-control"  name="current_postalcode"  value="<?php echo $row['current_postalcode']; ?>">
    </div>
    </div>
    </div>
    </div>
    <div class="col-sm-6">
    <div class="row">
    <div class="col-sm-12">
    <label for="permanentStreet" class="col-sm-3 control-label" style="font-size:10px;"> Street:</label>
    <div class="col-sm-9">
    <input type="text" id="permanent_street" class="form-control" name="permanent_street"  value="<?php echo $row['permanent_street']; ?>">
    </div>
    </div>
    <div class="col-sm-12">
    <label for="permanentCity" class="col-sm-3 control-label" style="font-size:10px;"> City:</label>
    <div class="col-sm-9">
    <input type="text" id="permanent_city" class="form-control" name="permanent_city"  value="<?php echo $row['permanent_city']; ?>">
    </div>
    </div>
    <div class="col-sm-12">
    <label for="permanentState" class="col-sm-3 control-label" style="font-size:10px;"> State:</label>
    <div class="col-sm-9">
    <input type="text" id="permanent_state" class="form-control" name="permanent_state"  value="<?php echo $row['permanent_state']; ?>">
    </div>
    </div>
    <div class="col-sm-12">
    <label for="permanentPostalCode" class="col-sm-3 control-label" style="font-size:10px;"> Postal Code:</label>
    <div class="col-sm-9">
    <input type="text" id="permanent_postalcode" class="form-control" name="permanent_postalcode"  value="<?php echo $row['permanent_postalcode']; ?>">
    </div>
    </div>
    </div>
    
    </div>
    </div>
    
    

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('image'); ?></label>

                            <div class="col-sm-7">

                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;" data-trigger="fileinput">
                                        <img src="<?php echo $this->crud_model->get_image_url('patient' , $row['patient_id']);?>" alt="...">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px"></div>
                                    <div>
                                        <span class="btn btn-white btn-file">
                                            <span class="fileinput-new">Select image</span>
                                            <span class="fileinput-exists">Change</span>
                                            <input type="file" name="image" accept="image/*">
                                        </span>
                                        <a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Remove</a>
                                    </div>
                                </div>

                            </div>
                        </div>

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
        // Attach the change event to the DOB input element
        $("#birth_date").on("change", function() {
            // Get the chosen DOB value
            var dobValue = $(this).val();
            
            // Calculate age
            var age = calculateAge(dobValue);
            
            // Display the age in the output element
            $("#age").val(age);
        });
    });
    
    // Function to calculate age based on DOB
    function calculateAge(dob) {
        var today = new Date();
        var birthDate = new Date(dob);
        var age = today.getFullYear() - birthDate.getFullYear();
        var monthDiff = today.getMonth() - birthDate.getMonth();
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
            if (age <= 0) {
          age = 0;
            }
     return age;
    }
    
    
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
