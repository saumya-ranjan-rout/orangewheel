<?php
$menu_check                 = $param3;
$patient_info               = $this->db->get('patient')->result_array();
$doctor_info               = $this->db->get('doctor')->result_array();
$single_prescription_info   = $this->db->get_where('prescription', array('prescription_id' => $param2))->result_array();
foreach ($single_prescription_info as $row) {
?>
    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-primary" data-collapsed="0">

                <div class="panel-heading">
                    <div class="panel-title">
                        <h3><?php echo get_phrase('edit_prescription'); ?></h3>
                    </div>
                </div>

                <div class="panel-body">

                    <form role="form" class="form-horizontal form-groups"  method="post"
                        action="<?php echo site_url('admin/prescription/update/'.$row['prescription_id'].'/'.$menu_check.'/'.$row['patient_id']); ?>"
                        enctype="multipart/form-data">

                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('date'); ?> <small style="color:red;">*</small></label>

                            <div class="col-sm-7">
                                <div class="date-and-time">
                                    <input type="text" name="date_timestamp" class="form-control datepicker" data-format="D, dd MM yyyy"
                                           placeholder="date here" value="<?php echo date("d M, Y", $row['timestamp']); ?>" required>
                                    <input type="text" name="time_timestamp" class="form-control timepicker" data-template="dropdown"
                                           data-show-seconds="false" data-default-time="00:05 AM" data-show-meridian="false"
                                           data-minute-step="5"  placeholder="time here" value="<?php echo date("H", $row['timestamp']); ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('doctor'); ?> <small style="color:red;">*</small></label>

                            <div class="col-sm-7">
                                <select name="doctor_id" class="select2" required>
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
                            <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('patient'); ?> <small style="color:red;">*</small></label>

                            <div class="col-sm-7">
                                <select name="patient_id" class="select2" required>
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
                            <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('case_history'); ?></label>

                            <div class="col-sm-9">
                                <textarea name="case_history" class="form-control html5editor" data-stylesheet-url="assets/css/wysihtml5-color.css"
                                          id="field-ta"><?php echo $row['case_history']; ?></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('medication'); ?></label>

                            <div class="col-sm-9">
                                <textarea name="medication" class="form-control html5editor" data-stylesheet-url="assets/css/wysihtml5-color.css"
                                          id="field-ta"><?php echo $row['medication']; ?></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('note'); ?></label>

                            <div class="col-sm-9">
                               <textarea name="medication" class="form-control html5editor" data-stylesheet-url="<?php echo base_url('assets/css/wysihtml5-color.css');?>"
                                          id="field-ta">
                                         <?php echo $row['note']; ?></textarea>
                            </div>
                        </div>

                        <div class="col-sm-3 control-label col-sm-offset-2">
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-check"></i> <?php echo get_phrase('update');?>
                            </button>
                        </div>
                    </form>

                </div>

            </div>

        </div>
    </div>
<?php } ?>
