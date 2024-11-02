<?php $bloodgroup_info = $this->db->get('blood_bank')->result_array(); ?>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <h3><?php echo get_phrase('add_laboratorist'); ?></h3>
                </div>
            </div>

            <div class="panel-body">

                <form role="form" class="form-horizontal form-groups" action="<?php echo site_url('admin/laboratorist/create'); ?>" 
                    method="post" enctype="multipart/form-data" onsubmit="disableButton()">
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Staff Id'); ?>  <small style="color:red;">*</small></label>

                        <div class="col-sm-7">
                            <input type="text" name="staff_id" class="form-control" id="field-1" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('name'); ?>  <small style="color:red;">*</small></label>

                        <div class="col-sm-7">
                            <input type="text" name="name" class="form-control" id="field-1" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('email'); ?>  <small style="color:red;">*</small></label>

                        <div class="col-sm-7">
                            <input type="email" name="email" class="form-control" id="field-1" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('password'); ?>  <small style="color:red;">*</small></label>

                        <div class="col-sm-7">
                            <input type="password" name="password" class="form-control" id="field-1" required>
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('phone'); ?> <small style="color:red;">*</small></label>

                        <div class="col-sm-7">
                            <input type="text" name="phone" pattern="[0-9]{10}" class="form-control" id="field-1" >
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('Gender'); ?>  <small style="color:red;">*</small></label>

                        <div class="col-sm-7">
                            <select name="gender" class="form-control" required
                                class="form-control">
                                <option value=""><?php echo get_phrase('Select Gender'); ?></option>
                                <option value="male">Male</option>
  <option value="female">Female</option>
  <option value="other">Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('Blood Group'); ?>  <small style="color:red;">*</small></label>

                        <div class="col-sm-7">
                            <select name="blood_group" class="form-control" required
                                class="form-control">
                                <option value=""><?php echo get_phrase('Select Blood Group'); ?></option>
                                <?php foreach ($bloodgroup_info as $row) { ?>
                                    <option value="<?php echo $row['blood_group_id']; ?>"><?php echo $row['blood_group']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('Current Address'); ?></label>

                        <div class="col-sm-7">
                            <textarea name="current_address" class="form-control" id="current_address" rows="5"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label"></label>

                        <div class="col-sm-7">
                        <input type="checkbox" id="sameAddressCheckbox"><?php echo get_phrase('Same as Current Address'); ?>
                        </div>
                        

                    </div>
                    <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('Permanent Address'); ?></label>

                        <div class="col-sm-7">
                            <textarea name="permanent_address" class="form-control" id="permanent_address" rows="5"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('D.O.B'); ?>  <small style="color:red;">*</small></label>

                        <div class="col-sm-7">
                            <input type="text" name="dob" class="form-control datepicker" id="field-1" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('D.O.J'); ?>  <small style="color:red;">*</small></label>

                        <div class="col-sm-7">
                            <input type="text" name="doj" class="form-control datepicker" id="field-1" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Basic Salary'); ?>  <small style="color:red;">*</small></label>

                        <div class="col-sm-7">
                            <input type="text" name="basic_salary" class="form-control " id="field-1" required>
                        </div>
                    </div>
                      <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Aadhar Card'); ?> </label>

                        <div class="col-sm-4">
                            <input type="text" name="aadhar_card" class="form-control" id="field-1" >
                        </div>
                        <div class="col-sm-3">
                            <input type="file" name="aadhar_card_file" class="form-control " id="field-1" accept=".jpg, .jpeg, .png, .doc, .docx, .pdf, .txt">
                        </div>
                    </div>
                       <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Pan Card'); ?> </label>

                        <div class="col-sm-4">
                            <input type="text" name="pan_card" class="form-control " id="field-1" >
                        </div>
                        <div class="col-sm-3">
                            <input type="file" name="pan_card_file" class="form-control " id="field-1" accept=".jpg, .jpeg, .png, .doc, .docx, .pdf, .txt">
                        </div>
                    </div>
                       <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Existing PF No'); ?>  </label>

                        <div class="col-sm-7">
                            <input type="text" name="existing_pfno" class="form-control " id="field-1" >
                        </div>
                    </div>
                       <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Father Name'); ?> </label>

                        <div class="col-sm-7">
                            <input type="text" name="father_name" class="form-control " id="field-1" >
                        </div>
                    </div>
                       <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Mother Name'); ?>  </label>

                        <div class="col-sm-7">
                            <input type="text" name="mother_name" class="form-control" id="field-1" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('image'); ?></label>

                        <div class="col-sm-7">

                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;" data-trigger="fileinput">
                                    <img src="http://placehold.it/200x150" alt="...">
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
                            <i class="fa fa-check"></i> <?php echo get_phrase('save');?>
                        </button>
                    </div>
                </form>

            </div>

        </div>

    </div>
</div>
<script>
        $(document).ready(function() {
        // Handle checkbox click event
        $("#sameAddressCheckbox").change(function() {
            if ($(this).is(":checked")) {
                // If checkbox is checked, copy current address to permanent address
                var current_address = $("#current_address").val();
              
                $("#permanent_address").val(current_address);          
            
            } else {
                // If checkbox is unchecked, clear the permanent address field
                $("#permanent_address").val("");

            }
        });
    });
    
      function disableButton() {
      var button = document.getElementById("myButton");
      button.disabled = true;
    }
</script>