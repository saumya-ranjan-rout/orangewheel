<?php $pathology_test_category_info = $this->db->where('is_active', 'Y')->get('pathology_test_category')->result_array();
$unit_category_info = $this->db->get('unit')->result_array();

?>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <h3><?php echo get_phrase('add_pathology_test'); ?></h3>
                </div>
            </div>

            <div class="panel-body">

                <form role="form" enctype="multipart/form-data" class="form-horizontal form-groups" action="<?php echo site_url('admin/pathology_test/create'); ?>" method="post">

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('test_name'); ?> <small style="color:red;">*</small></label>

                        <div class="col-sm-7">
                            <input type="text" name="test_name" class="form-control" id="field-1" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('short_name'); ?></label>

                        <div class="col-sm-7">
                            <input type="text" name="short_name" class="form-control" id="field-1">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('test_type'); ?></label>

                        <div class="col-sm-7">
                            <input type="text" name="test_type" class="form-control" id="field-1">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('test_category'); ?> <small style="color:red;">*</small></label>

                        <div class="col-sm-7">
                            <select name="test_category_id" required class="form-control">
                                <option value=""><?php echo get_phrase('select_test_category'); ?></option>
                                <?php foreach ($pathology_test_category_info as $row) { ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['test_category']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('unit'); ?> <small style="color:red;">*</small></label>

                        <div class="col-sm-7">
                            <select name="unit" class="form-control select2" required>
                                <option value=""><?php echo get_phrase('select_unit_category'); ?></option>
                                <?php foreach ($unit_category_info as $row) { ?>
                                    <option value="<?php echo $row['unit_id']; ?>"><?php echo $row['unit_name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>   
                    </div>

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('sub_category'); ?></label>

                        <div class="col-sm-7">
                            <input type="text" name="sub_category" class="form-control" id="field-1">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('method'); ?></label>

                        <div class="col-sm-7">
                            <input type="text" name="method" class="form-control" id="field-1">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('report_days'); ?></label>

                        <div class="col-sm-7">
                            <input type="text" name="report_days" class="form-control" id="field-1">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('charge(_rs_)'); ?> <small style="color:red;">*</small></label>

                        <div class="col-sm-7">
                            <input type="text" name="price" class="form-control" id="field-1" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('description'); ?></label>

                        <div class="col-sm-7">
                            <textarea rows="5" name="description" class="form-control" id="field-ta"></textarea>
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