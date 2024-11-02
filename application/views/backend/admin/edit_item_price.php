<?php
$single_item_info = $this->db->get_where('item_price_details', array('id' => $param2))->result_array();
$item_category_info = $this->db->where('is_active', 'Y')->get('item_category')->result_array();
$unit_info = $this->db->get('unit')->result_array();
$warranty_info = $this->db->get('warranty')->result_array();
foreach ($single_item_info as $row) {
    $item_sub_category_info = $this->db->where('item_category', $row['item_category_id'])->get('item_subcategory')->result_array();
    $selected_item_category = $this->db->get_where('item_category', array('id' => $row['item_category_id']))->row()->item_category;

?>
    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-primary" data-collapsed="0">

                <div class="panel-heading">
                    <div class="panel-title">
                        <h3><?php echo get_phrase('edit_price_details'); ?></h3>
                    </div>
                </div>

                <div class="panel-body">

                    <form role="form" enctype="multipart/form-data" class="form-horizontal form-groups" action="<?php echo site_url('admin/change_item_price/update/' . $row['id']); ?>" method="post">

                        <input type="hidden" name="item_id" class="form-control" value="<?php echo $row['item_id']; ?>" id="field-1" readonly required>
                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('serial_no'); ?> <small style="color:red;">*</small></label>
                            <div class="col-sm-7">
                                <input type="text" name="sl_no" class="form-control" value="<?php echo $row['sl_no']; ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('quantity'); ?> <small style="color:red;">*</small></label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="quantity" name="quantity" value="<?php echo $row['quantity']; ?>" required />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('unit_price'); ?> <small style="color:red;">*</small></label>
                            <div class="col-sm-7">
                                <input type="number" name="unit_price" class="form-control" value="<?php echo $row['unit_price']; ?>" required>
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