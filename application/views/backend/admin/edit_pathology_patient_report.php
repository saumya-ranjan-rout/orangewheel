<?php
$single_pathology_patient_report_info = $this->db->get_where('pathology_patient_report', array('id' => $param2))->result_array();
$patient_info = $this->db->get('patient')->result_array();
$doctor_info = $this->db->get('doctor')->result_array();
$pathology_test = $this->db->where('is_active', 'Y')->get('pathology_test')->result_array();
$payment_mode_info = $this->db->get('payment_mode')->result_array();
foreach ($single_pathology_patient_report_info as $row) {
?>
    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-primary" data-collapsed="0">

                <div class="panel-heading">
                    <div class="panel-title">
                        <h3><?php echo get_phrase('edit_pathology_patient_report'); ?></h3>
                    </div>
                </div>

                <div class="panel-body">

                    <form role="form" class="form-horizontal form-groups" action="<?php echo site_url('admin/pathology_patient_report/update/' . $row['id']); ?>" method="post" enctype="multipart/form-data">

                        <div class="form-group">
                            <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('patient_name'); ?> <small style="color:red;">*</small></label>

                            <div class="col-sm-7">
                                <select name="patient_id" required class="form-control">
                                    <option value=""><?php echo get_phrase('select_patient'); ?></option>
                                    <?php foreach ($patient_info as $row2) { ?>
                                        <option value="<?php echo $row2['patient_id']; ?>" <?php if ($row['patient_id'] == $row2['patient_id']) echo 'selected'; ?>>
                                            <?php echo $row2['name']; ?>(<?php echo $row2['code']; ?>)
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('date'); ?> <small style="color:red;">*</small></label>

                            <div class="col-sm-7">
                                <input type="text" name="date" class="form-control datepicker" id="field-1" required value="<?php echo date('m/d/Y', strtotime($row['date'])); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('test_name'); ?> <small style="color:red;">*</small></label>

                            <div class="col-sm-7">
                                <select name="pathology_test_id" required class="form-control" onchange="get_charge(this.value)">
                                    <option value=""><?php echo get_phrase('select_test'); ?></option>
                                    <?php foreach ($pathology_test as $row2) { ?>
                                        <option value="<?php echo $row2['id']; ?>" <?php if ($row['pathology_test_id'] == $row2['id']) echo 'selected'; ?>>
                                            <?php echo $row2['test_name']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('charge(_rs_)'); ?> <small style="color:red;">*</small></label>

                            <div class="col-sm-7">
                                <input type="number" name="charge" class="form-control" id="charge" required readonly value="<?php echo $row['charge']; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('doctor'); ?> <small style="color:red;">*</small></label>

                            <div class="col-sm-7">
                                <select name="doctor_id" required class="form-control">
                                    <option value=""><?php echo get_phrase('select_doctor'); ?></option>
                                    <?php foreach ($doctor_info as $row2) { ?>
                                        <option value="<?php echo $row2['doctor_id']; ?>" <?php if ($row['doctor_id'] == $row2['doctor_id']) echo 'selected'; ?>>
                                            <?php echo $row2['name']; ?>(<?php echo $row2['staff_id']; ?>)
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('payment_status'); ?> <small style="color:red;">*</small></label>
                            <div class="col-sm-7">
                                <select name="payment_status" required class="form-control">
                                    <?php if ($row['payment_status'] == 'paid') { ?>
                                        <option value="paid"><?php echo get_phrase('paid'); ?></option>
                                    <?php } else { ?>
                                        <option value="unpaid"><?php echo get_phrase('unpaid'); ?></option>
                                        <option value="paid"><?php echo get_phrase('paid'); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('payment_mode'); ?></label>
                            <div class="col-sm-7">
                                <select name="payment_mode_id" class="form-control">
                                    <option value=""><?php echo get_phrase('select_payment_mode'); ?></option>
                                    <?php foreach ($payment_mode_info as $row2) { ?>
                                        <option value="<?php echo $row2['id']; ?>" <?php if ($row['payment_mode_id'] == $row2['id']) echo 'selected'; ?>>
                                            <?php echo $row2['payment_mode']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>



                        <div class="form-group">
                            <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('description'); ?></label>

                            <div class="col-sm-7">
                                <textarea rows="5" name="description" class="form-control" id="field-ta"><?php echo $row['description']; ?></textarea>
                            </div>
                        </div>



                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('attachment'); ?></label>

                            <div class="col-sm-7">

                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 31px;" data-trigger="fileinput">
                                        <?php echo $row['file_name']; ?>
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px"></div>
                                    <div>
                                        <span class="btn btn-white btn-file">
                                            <span class="fileinput-new">Select attachment</span>
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
                                <i class="fa fa-check"></i> <?php echo get_phrase('update'); ?>
                            </button>
                        </div>
                    </form>

                </div>

            </div>

        </div>
    </div>
<?php } ?>