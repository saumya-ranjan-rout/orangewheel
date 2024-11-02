<?php $patient_info = $this->db->get('patient')->result_array(); 
 $doctor_info = $this->db->get('doctor')->result_array();?>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <h3><?php echo get_phrase('add_prescription'); ?></h3>
                </div>
            </div>

            <div class="panel-body">

                <form role="form" class="form-horizontal form-groups" action="<?php echo site_url('admin/prescription/create'); ?>" 
                    method="post" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('date'); ?> <small style="color:red;">*</small></label>

                        <div class="col-sm-7">
                            <div class="date-and-time">
                                <input type="text" name="date_timestamp" class="form-control datepicker"
                                       data-format="D, dd MM yyyy"
                                        placeholder="<?php echo get_phrase('date');?>" required>
                                <input type="text" name="time_timestamp" class="form-control timepicker" data-template="dropdown" data-show-seconds="false" data-default-time="00:05 AM" data-show-meridian="false" data-minute-step="5"  placeholder="time here" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('doctor'); ?> <small style="color:red;">*</small></label>

                        <div class="col-sm-7">
                            <select name="doctor_id" class="select2" required>
                                <option value=""><?php echo get_phrase('select_doctor'); ?></option>
                                <?php foreach ($doctor_info as $row) { ?>
                                        <option value="<?php echo $row['doctor_id']; ?>"><?php echo $row['name']; ?>(<?php echo $row['staff_id']; ?>)</option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('patient'); ?> <small style="color:red;">*</small></label>

                        <div class="col-sm-7">
                            <select name="patient_id" class="select2" required>
                                <option value=""><?php echo get_phrase('select_patient'); ?></option>
                                <?php foreach ($patient_info as $row) { ?>
                                        <option value="<?php echo $row['patient_id']; ?>"><?php echo $row['name']; ?>(<?php echo $row['code']; ?>)</option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('case_history'); ?></label>

                        <div class="col-sm-9">
                            <textarea name="case_history" class="form-control html5editor" id="field-ta" data-stylesheet-url="assets/css/wysihtml5-color.css"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('medication'); ?></label>

                        <div class="col-sm-9">
                            <textarea name="medication" class="form-control html5editor" id="field-ta" data-stylesheet-url="assets/css/wysihtml5-color.css"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('note'); ?></label>

                        <div class="col-sm-9">
                            <textarea name="note" class="form-control html5editor" id="field-ta" data-stylesheet-url="assets/css/wysihtml5-color.css"></textarea>
                        </div>
                    </div>
					<div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label">follow up date</label>

                        <div class="col-sm-7">
                            <div class="date-and-time">
                                <input type="text" name="fdate_timestamp" class="form-control datepicker"
                                       data-format="D, dd MM yyyy"
                                        placeholder="<?php echo get_phrase('date');?>" >
                                <input type="text" name="ftime_timestamp" class="form-control timepicker" data-template="dropdown" data-show-seconds="false" data-default-time="00:05 AM" data-show-meridian="false" data-minute-step="5"  placeholder="time here" >
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-3 control-label col-sm-offset-2">
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-check"></i> <?php echo get_phrase('save');?>
                        </button>
                    </div>
                </form>

            </div>

        </div>

    </div>
</div>
