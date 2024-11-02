<?php $patient_info = $this->db->get('patient')->result_array();
$doctor_info = $this->db->get('doctor')->result_array();
$pathology_test = $this->db->where('is_active', 'Y')->get('pathology_test')->result_array();
$payment_mode_info = $this->db->get('payment_mode')->result_array(); ?>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <h3><?php echo get_phrase('add_patient_report'); ?></h3>
                </div>
            </div>

            <div class="panel-body">

                <form role="form" enctype="multipart/form-data" class="form-horizontal form-groups" action="<?php echo site_url('admin/pathology_patient_report/create'); ?>" method="post">



                    <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('patient_name'); ?> <small style="color:red;">*</small></label>

                        <div class="col-sm-7">
                            <select name="patient_id" required class="form-control">
                                <option value=""><?php echo get_phrase('select_patient'); ?></option>
                                <?php foreach ($patient_info as $row) { ?>
                                    <option value="<?php echo $row['patient_id']; ?>"><?php echo $row['name']; ?>(<?php echo $row['code']; ?>)</option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('date'); ?> <small style="color:red;">*</small></label>

                        <div class="col-sm-7">
                            <input type="text" name="date" class="form-control datepicker" id="field-1" required>
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('test_name'); ?> <small style="color:red;">*</small></label>

                        <div class="col-sm-7">
                            <select name="pathology_test_id" required class="form-control" onchange="get_charge(this.value)">
                                <option value=""><?php echo get_phrase('select_test'); ?></option>
                                <?php foreach ($pathology_test as $row) { ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['test_name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('charge(_rs_)'); ?> <small style="color:red;">*</small></label>

                        <div class="col-sm-7">
                            <input type="number" name="charge" class="form-control" id="charge" required readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('doctor'); ?> <small style="color:red;">*</small></label>
                        <div class="col-sm-7">
                            <select name="doctor_id" required class="form-control">
                                <option value=""><?php echo get_phrase('select_doctor'); ?></option>
                                <?php foreach ($doctor_info as $row) { ?>
                                    <option value="<?php echo $row['doctor_id']; ?>"><?php echo $row['name']; ?>(<?php echo $row['staff_id']; ?>)</option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('payment_status'); ?> <small style="color:red;">*</small></label>
                        <div class="col-sm-7">
                            <select name="payment_status" required class="form-control">
                                <option value="unpaid"><?php echo get_phrase('unpaid'); ?></option>
                                <option value="paid"><?php echo get_phrase('paid'); ?></option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('payment_mode'); ?></label>
                        <div class="col-sm-7">
                            <select name="payment_mode_id" class="form-control">
                                <option value=""><?php echo get_phrase('select_payment_mode'); ?></option>
                                <?php foreach ($payment_mode_info as $row) { ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['payment_mode']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('description'); ?></label>

                        <div class="col-sm-7">
                            <textarea rows="5" name="description" class="form-control" id="field-ta"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('attachment'); ?></label>
                        <div class="col-sm-7">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="width: 200px; height: 31px;" data-trigger="fileinput">
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px"></div>
                                <div>
                                    <span class="btn btn-white btn-file">
                                        <span class="fileinput-new">Select File</span>
                                        <span class="fileinput-exists">Change</span>
                                        <input type="file" name="attachment" accept=".jpg, .jpeg, .png, .doc, .docx, .pdf">
                                    </span>
                                    <a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Remove</a>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-sm-3 control-label col-sm-offset-2">
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-check"></i> <?php echo get_phrase('save'); ?>
                        </button>
                    </div>
                </form>

            </div>

        </div>

    </div>
</div>
<script type="text/javascript">
    function get_charge(testId) {
        //alert(testId);
        if (testId != '') {
            $.ajax({
                url: '<?php echo site_url('admin/get_charge_with_ajax/'); ?>' + testId,
                success: function(response) {
                    //alert(response);
                    var data = JSON.parse(response);
                    $('#charge').val(data.price);
                }
            });
        } else {
            $('#charge').val("");
        }

    }
</script>