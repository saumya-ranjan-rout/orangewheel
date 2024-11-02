<?php
$single_tpa_management = $this->db->get_where('tpa_management', array('tpa_id' => $param2))->result_array();
foreach ($single_tpa_management as $row) {
?>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <h3>Edit Referred Doctor</h3>
                </div>
            </div>

            <div class="panel-body">

                <form role="form" class="form-horizontal form-groups "
                    action="<?php echo site_url('admin/tpa_management/update/'.$row['tpa_id']); ?>" 
                        method="post" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label">Name <span style="color:red">*</span></label>

                        <div class="col-sm-7">
                            <input type="text" name="tpa_name" value="<?php echo $row['tpa_name']; ?>" class="form-control" id="name" placeholder="" required>
                        </div>
                    </div>

                   <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label">Code </label>

                        <div class="col-sm-7">
                            <input type="text" name="code" value="<?php echo $row['code']; ?>" class="form-control" id="code" placeholder="" >                            
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label">Phone<span style="color:red">*</span></label>

                        <div class="col-sm-7">
                            <input type="text" name="contact_no" pattern="[0-9]{10}" value="<?php echo $row['contact_no']; ?>" class="form-control" id="code" placeholder="" required>                            
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label">Address </label>

                        <div class="col-sm-7">
                        <textarea name="address" class="form-control" id="address"
                                rows="5"><?php echo $row['address']; ?></textarea>                            
                        </div>
                    </div>

                 <!--   <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label">Contact Person Name </label>

                        <div class="col-sm-7">
                            <input type="text" name="contact_person_name"  value="<?php echo $row['contact_person_name']; ?>" class="form-control" id="contact_person_name" placeholder="">                            
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label">Contact Person Phone </label>

                        <div class="col-sm-7">
                            <input type="text" name="contact_person_phone" pattern="[0-9]{10}" value="<?php echo $row['contact_person_phone']; ?>" class="form-control" id="contact_person_phone" placeholder="">                            
                        </div>
                    </div>
                    -->
                    <div class="col-sm-3 control-label col-sm-offset-2">
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-check"></i> Update
                        </button>
                    </div>
                </form>

            </div>

        </div>

    </div>
</div>
<?php } ?>
