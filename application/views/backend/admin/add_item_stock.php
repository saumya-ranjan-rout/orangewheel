<?php $item_info = $this->db->where('is_active', 'Y')->get('item')->result_array();
$item_supplier_info = $this->db->where('is_active', 'Y')->get('item_supplier')->result_array();
$item_store_info = $this->db->where('is_active', 'Y')->get('item_store')->result_array(); ?>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <h3><?php echo get_phrase('add_item_stock'); ?></h3>
                </div>
            </div>

            <div class="panel-body">

                <form role="form" enctype="multipart/form-data" class="form-horizontal form-groups" action="<?php echo site_url('admin/item_stock/create'); ?>" method="post">



                    <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('item'); ?> <small style="color:red;">*</small></label>

                        <div class="col-sm-7">
                            <select name="item_id" required class="form-control">
                                <option value=""><?php echo get_phrase('select_item'); ?></option>
                                <?php foreach ($item_info as $row) { ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('supplier'); ?> <small style="color:red;">*</small></label>

                        <div class="col-sm-7">
                            <select name="supplier_id" required class="form-control">
                                <option value=""><?php echo get_phrase('select_supplier'); ?></option>
                                <?php foreach ($item_supplier_info as $row) { ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['item_supplier']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('store'); ?> <small style="color:red;">*</small></label>

                        <div class="col-sm-7">
                            <select name="store_id" required class="form-control">
                                <option value=""><?php echo get_phrase('select_store'); ?></option>
                                <?php foreach ($item_store_info as $row) { ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['item_store']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('quantity'); ?> <small style="color:red;">*</small></label>

                        <div class="col-sm-7">
                            <input type="number" name="quantity" class="form-control" id="field-1" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('purchase_price'); ?> <small style="color:red;">*</small></label>

                        <div class="col-sm-7">
                            <input type="number" name="purchase_price" class="form-control" id="field-1" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('rate'); ?> <small style="color:red;">*</small></label>

                        <div class="col-sm-7">
                            <input type="number" name="rate" class="form-control" id="field-1" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('date'); ?> <small style="color:red;">*</small></label>

                        <div class="col-sm-7">
                            <input type="text" name="date" class="form-control datepicker" id="field-1" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('description'); ?></label>

                        <div class="col-sm-7">
                            <textarea rows="5" name="description" class="form-control" id="field-ta"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('attachment'); ?></label>

                        <div class="col-sm-7">

                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="width: 200px; height: 31px;" data-trigger="fileinput">

                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px"></div>
                                <div>
                                    <span class="btn btn-white btn-file">
                                        <span class="fileinput-new">Select File</span>
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
                            <i class="fa fa-check"></i> <?php echo get_phrase('save'); ?>
                        </button>
                    </div>
                </form>

            </div>

        </div>

    </div>
</div>