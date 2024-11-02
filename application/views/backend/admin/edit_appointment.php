<?php $doctor_info = $this->db->get('doctor')->result_array(); ?>
<?php
$patient_info = $this->db->get('patient')->result_array();
$single_appointment_info = $this->db->get_where('appointment', array('appointment_id' => $param2))->result_array();
foreach ($single_appointment_info as $row) {
?>
    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-primary" data-collapsed="0">

                <div class="panel-heading">
                    <div class="panel-title">
                        <h3><?php echo get_phrase('edit_appointment'); ?></h3>
                    </div>
                </div>

                <div class="panel-body">

                    <form role="form" class="form-horizontal form-groups"
                        action="<?php echo site_url('admin/appointment/update/'.$row['appointment_id']); ?>"
                        method="post" enctype="multipart/form-data">

                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('date'); ?> <small style="color:red;">*</small></label>

                            <div class="col-sm-7">
                                <div class="date-and-time">
                                    <input type="text" name="date_timestamp" class="form-control datepicker" data-format="D, dd MM yyyy"
                                           placeholder="date here" value="<?php echo date("D, d M Y", $row['timestamp']); ?>" required>
                                    <input type="text" name="time_timestamp" class="form-control timepicker" data-template="dropdown"
                                           data-show-seconds="false" data-default-time="00:05 AM" data-show-meridian="false"
                                           data-minute-step="5"  placeholder="time here" value="<?php echo date("H:i", $row['timestamp']); ?>" required>
                                </div>
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
                            <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('Doctor'); ?> <small style="color:red;">*</small></label>

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
                       

                        <!--<div class="form-group">-->
                        <!--    <div class="col-sm-7 col-sm-offset-3">-->
                        <!--        <input type="checkbox" id="notify" name="notify" value="checked" checked>-->
                        <!--        <label class="control-label" for="notify"><?php echo get_phrase('notify_patient_with_') . 'SMS'; ?></label>-->
                        <!--    </div>-->
                        <!--</div>-->

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
