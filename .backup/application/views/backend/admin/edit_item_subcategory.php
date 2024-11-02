<?php
$single_item_subcategory_info = $this->db->get_where('item_subcategory', array('item_id' => $param2))->result_array();
$item_subcategory_info = $this->db->where('is_active', 'Y')->get('item_category')->result_array();
foreach ($single_item_subcategory_info as $row) {
?>
    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-primary" data-collapsed="0">

                <div class="panel-heading">
                    <div class="panel-title">
                        <h3><?php echo get_phrase('edit_item_subcategory'); ?></h3>
                    </div>
                </div>

                <div class="panel-body">

                    <form role="form" class="form-horizontal form-groups" action="<?php echo site_url('admin/item_subcategory/update/' . $row['item_id']); ?>" method="post" enctype="multipart/form-data">

                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('item_category'); ?> <small style="color:red;">*</small></label>

                            <div class="col-sm-7">
                                <select name="item_category" class="form-control select2" required>
                                    <option value=""><?php echo get_phrase('select_item_category'); ?></option>
                                    <?php foreach ($item_subcategory_info as $row2) { ?>
                                        <option value="<?php echo $row2['id']; ?>" <?php if ($row['item_category'] == $row2['id']) echo 'selected'; ?>>
                                            <?php echo $row2['item_category']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>   
                        </div>

                        <div class="form-group">
                            <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('item_subcategory'); ?></label>

                            <div class="col-sm-7">
                                <input type="text" name="item_subcategory" class="form-control" id="field-ta" value="<?php echo $row['item_subcategory']; ?>">
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