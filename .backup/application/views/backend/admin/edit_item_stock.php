<?php
$single_item_stock_info = $this->db->get_where('item_stock', array('id' => $param2))->result_array();
$item_info = $this->db->where('is_active', 'Y')->get('item')->result_array();
$item_supplier_info = $this->db->where('is_active', 'Y')->get('item_supplier')->result_array();
$item_store_info = $this->db->where('is_active', 'Y')->get('item_store')->result_array();
foreach ($single_item_stock_info as $row) {
?>
    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-primary" data-collapsed="0">

                <div class="panel-heading">
                    <div class="panel-title">
                        <h3><?php echo get_phrase('edit_item_stock'); ?></h3>
                    </div>
                </div>

                <div class="panel-body">

                    <form role="form" class="form-horizontal form-groups" action="<?php echo site_url('admin/item_stock/update/' . $row['id']); ?>" method="post" enctype="multipart/form-data">

                        <div class="form-group">
                            <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('item'); ?> <small style="color:red;">*</small></label>

                            <div class="col-sm-7">
                                <select name="item_id" required class="form-control">
                                    <option value=""><?php echo get_phrase('select_item'); ?></option>
                                    <?php foreach ($item_info as $row2) { ?>
                                        <option value="<?php echo $row2['id']; ?>" <?php if ($row['item_id'] == $row2['id']) echo 'selected'; ?>>
                                            <?php echo $row2['name']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('supplier'); ?> <small style="color:red;">*</small></label>

                            <div class="col-sm-7">
                                <select name="supplier_id" required class="form-control">
                                    <option value=""><?php echo get_phrase('select_supplier'); ?></option>
                                    <?php foreach ($item_supplier_info as $row2) { ?>
                                        <option value="<?php echo $row2['id']; ?>" <?php if ($row['supplier_id'] == $row2['id']) echo 'selected'; ?>>
                                            <?php echo $row2['item_supplier']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('store'); ?> <small style="color:red;">*</small></label>

                            <div class="col-sm-7">
                                <select name="store_id" required class="form-control">
                                    <option value=""><?php echo get_phrase('select_store'); ?></option>
                                    <?php foreach ($item_store_info as $row2) { ?>
                                        <option value="<?php echo $row2['id']; ?>" <?php if ($row['store_id'] == $row2['id']) echo 'selected'; ?>>
                                            <?php echo $row2['item_store']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('quantity'); ?> <small style="color:red;">*</small></label>

                            <div class="col-sm-7">
                                <input type="number" name="quantity" class="form-control" id="field-1" required value="<?php echo $row['quantity']; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('purchase_price'); ?> <small style="color:red;">*</small></label>

                            <div class="col-sm-7">
                                <input type="number" name="purchase_price" class="form-control" id="field-1" required value="<?php echo $row['purchase_price']; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('rate'); ?> <small style="color:red;">*</small></label>

                            <div class="col-sm-7">
                                <input type="number" name="rate" class="form-control" id="field-1" required value="<?php echo $row['rate']; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('date'); ?> <small style="color:red;">*</small></label>

                            <div class="col-sm-7">
                                <input type="text" name="date" class="form-control datepicker" id="field-1" required value="<?php echo date('m/d/Y', strtotime($row['date'])); ?>">
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