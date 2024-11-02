<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <h3>Add Referred Doctor</h3>
                </div>
            </div>

            <div class="panel-body">

                <form role="form" class="form-horizontal form-groups"
                    action="<?php echo site_url('admin/tpa_management/create'); ?>" 
                        method="post" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label">Name <span style="color:red">*</span></label>

                        <div class="col-sm-7">
                            <input type="text" name="tpa_name" class="form-control" id="name" placeholder="" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label">Code </label>

                        <div class="col-sm-7">
                            <input type="text" name="code" class="form-control" id="code" placeholder="" >                            
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label">Phone <span style="color:red">*</span></label>

                        <div class="col-sm-7">
                            <input type="text" name="contact_no"  pattern="[0-9]{10}" class="form-control" id="contact_no" placeholder="" required>                            
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label">Address</label>

                        <div class="col-sm-7">
                        <textarea name="address" class="form-control" id="address"
                                rows="5"></textarea>                            
                        </div>
                    </div>

                  <!--  <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label">Contact Person Name</label>

                        <div class="col-sm-7">
                            <input type="text" name="contact_person_name" class="form-control" id="contact_person_name" placeholder="">                            
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label">Contact Person Phone</label>

                        <div class="col-sm-7">
                            <input type="text" name="contact_person_phone" pattern="[0-9]{10}" class="form-control" id="contact_person_phone" placeholder="">                            
                        </div>
                    </div>-->

                    <!-- <div class="form-group">
                        <label class="col-sm-3 control-label">
                            <?php echo get_phrase('icon'); ?>
                        </label>
                        <div class="col-sm-9">

                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;" 
                                    data-trigger="fileinput">
                                    <img src="http://placehold.it/256x256" alt="...">
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail" 
                                    style="max-width: 200px; max-height: 200px"></div>
                                <div>
                                    <span class="btn btn-white btn-file">
                                        <span class="fileinput-new"><?php echo get_phrase('select_image');?></span>
                                        <span class="fileinput-exists"><?php echo get_phrase('change');?></span>
                                        <input type="file" name="dept_icon" accept="image/*">
                                    </span>
                                    <a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">
                                    <?php echo get_phrase('remove');?>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div> -->

                    <div class="col-sm-3 control-label col-sm-offset-2">
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-check"></i> Save
                        </button>
                    </div>
                </form>

            </div>

        </div>

    </div>
</div>
