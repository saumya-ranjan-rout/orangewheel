<?php
$unit_category_info = $this->db->get('unit')->result_array();
$medicine_category_info = $this->db->get('medicine_category')->result_array();
$single_medicine_info   = $this->db->get_where('medicine', array('medicine_id' => $param2))->result_array();
foreach ($single_medicine_info as $row) {
?>

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-primary" data-collapsed="0">

                <div class="panel-heading">
                    <div class="panel-title">
                        <h3><?php echo get_phrase('edit_medicine'); ?></h3>
                    </div>
                </div>

                <div class="panel-body">

                    <form role="form" class="form-horizontal form-groups" action="<?php echo site_url('admin/medicine/update/' . $row['medicine_id']); ?>" 
                        method="post" enctype="multipart/form-data">

                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('name'); ?> <small style="color:red;">*</small></label>

                            <div class="col-sm-7">
                                <input type="text" name="name" class="form-control" id="field-1" value="<?php echo $row['name']; ?>" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('medicine_category'); ?> <small style="color:red;">*</small></label>

                            <div class="col-sm-7">
                                <select name="medicine_category_id" class="form-control select2" required>
                                    <option value=""><?php echo get_phrase('select_medicine_category'); ?></option>
                                    <?php foreach ($medicine_category_info as $row2) { ?>
                                        <option value="<?php echo $row2['medicine_category_id']; ?>" <?php if ($row['medicine_category_id'] == $row2['medicine_category_id']) echo 'selected'; ?>>
                                            <?php echo $row2['name']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('unit/packing'); ?> <small style="color:red;">*</small></label>

                            <div class="col-sm-7">
                                <select name="unit_id" class="form-control select2" required>
                                    <option value=""><?php echo get_phrase('select_unit_category'); ?></option>
                                    <?php foreach ($unit_category_info as $row2) { ?>
                                        <option value="<?php echo $row2['unit_id']; ?>" <?php if ($row['unit_id'] == $row2['unit_id']) echo 'selected'; ?>>
                                            <?php echo $row2['unit_name']; ?>
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
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('price'); ?> <small style="color:red;">*</small></label>

                            <div class="col-sm-7">
                                <input type="number" name="price" class="form-control" id="field-1" value="<?php echo $row['price']; ?>" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('total_quantity'); ?> <small style="color:red;">*</small></label>

                            <div class="col-sm-7">
                                <input type="number" name="total_quantity" class="form-control" value="<?php echo $row['total_quantity']; ?>" required/>
                            </div>
                        </div>
                        
                        
                       <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('alert_quantity'); ?> <small style="color:red;">*</small></label>

                            <div class="col-sm-7">
                                <input type="number" name="alert_quantity" class="form-control" value="<?php echo $row['alert_quantity']; ?>" required/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('manufacturing_company'); ?></label>

                            <div class="col-sm-7">
                                <input type="text" name="manufacturing_company" class="form-control" id="field-1" value="<?php echo $row['manufacturing_company']; ?>">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('image'); ?></label>

                            <div class="col-sm-7">

                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;" data-trigger="fileinput">
                                        <img src="<?php echo $this->crud_model->get_image_url('medicine', $row['medicine_id']); ?>" alt="...">
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
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-check"></i> &nbsp;
                                <?php echo get_phrase('update');?>
                            </button>
                        </div>
                    </form>

                </div>

            </div>

        </div>
    </div>
<?php } ?>
