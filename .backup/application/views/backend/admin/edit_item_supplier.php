<?php
$single_item_supplier_info = $this->db->get_where('item_supplier', array('id' => $param2))->result_array();
foreach ($single_item_supplier_info as $row) {
?>
    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-primary" data-collapsed="0">

                <div class="panel-heading">
                    <div class="panel-title">
                        <h3><?php echo get_phrase('edit_item_supplier'); ?></h3>
                    </div>
                </div>

                <div class="panel-body">

                    <form role="form" class="form-horizontal form-groups" action="<?php echo site_url('admin/item_supplier/update/' . $row['id']); ?>" method="post" enctype="multipart/form-data">

                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('name'); ?> <small style="color:red;">*</small></label>

                            <div class="col-sm-7">
                                <input type="text" name="item_supplier" class="form-control" id="field-1" value="<?php echo $row['item_supplier']; ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('supplier_code'); ?></label>

                            <div class="col-sm-7">
                                <input type="text" name="supplier_code" class="form-control" id="field-1" value="<?php echo $row['supplier_code']; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('phone'); ?> <small style="color:red;">*</small></label>

                            <div class="col-sm-7">
                                <input type="text" name="phone" pattern="[0-9]{10}" class="form-control" id="field-1" value="<?php echo $row['phone']; ?>" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('email'); ?></label>

                            <div class="col-sm-7">
                                <input type="email" name="email" class="form-control" id="field-1" value="<?php echo $row['email']; ?>">
                            </div>
                        </div>
<div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('GST No'); ?></label>

                            <div class="col-sm-7">
                                <input type="text" name="gst_no" class="form-control" id="field-1" value="<?php echo $row['gst_no']; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('DL No'); ?></label>

                            <div class="col-sm-7">
                                <input type="text" name="dl_no" class="form-control" id="field-1" value="<?php echo $row['dl_no']; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('contact_person_name'); ?></label>

                            <div class="col-sm-7">
                                <input type="text" name="contact_person_name" class="form-control" id="field-1" value="<?php echo $row['contact_person_name']; ?>" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('contact_person_phone'); ?></label>

                            <div class="col-sm-7">
                                <input type="text" name="contact_person_phone" pattern="[0-9]{10}" class="form-control" id="field-1" value="<?php echo $row['contact_person_phone']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('contact_person_email'); ?></label>

                            <div class="col-sm-7">
                                <input type="email" name="contact_person_email" class="form-control" id="field-1" value="<?php echo $row['contact_person_email']; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('address'); ?></label>

                            <div class="col-sm-7">
                                <textarea rows="5" name="address" class="form-control" id="field-ta"><?php echo $row['address']; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('description'); ?></label>

                            <div class="col-sm-7">
                                <textarea rows="5" name="description" class="form-control" id="field-ta"><?php echo $row['description']; ?></textarea>
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