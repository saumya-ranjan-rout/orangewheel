<?php
$single_item_info = $this->db->get_where('item', array('id' => $param2))->result_array();
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
                        <h3><?php echo get_phrase('edit_item'); ?></h3>
                    </div>
                </div>

                <div class="panel-body">

                    <form role="form" class="form-horizontal form-groups" action="<?php echo site_url('admin/item/update/' . $row['id']); ?>" method="post" enctype="multipart/form-data">

                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('model'); ?> </label>
                            <div class="col-sm-7">
                                <input type="text" name="model" class="form-control" value="<?php echo $row['model']; ?>" >
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('serial_no'); ?> </label>
                            <div class="col-sm-7">
                                <input type="text" name="serial_no" class="form-control" value="<?php echo $row['serial_no']; ?>" >
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('item_category'); ?> </label>

                            <div class="col-sm-7">
                                <select name="item_category_id" id="item_category_id"  class="form-control" onchange="get_sub_category(this.value)">
                                    <option value=""><?php echo get_phrase('select_item_category'); ?></option>
                                    <?php foreach ($item_category_info as $row2) { ?>
                                        <option value="<?php echo $row2['id']; ?>" <?php if ($row['item_category_id'] == $row2['id']) echo 'selected'; ?>>
                                            <?php echo $row2['item_category']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('sub_category'); ?></label>
                            <div class="col-sm-7">
                                <select name="item_sub_category_id" id="item_sub_category_id" class="form-control">
                                    <option value=""><?php echo get_phrase('select_sub_category'); ?></option>
                                    <?php foreach ($item_sub_category_info as $row2) { ?>
                                        <option value="<?php echo $row2['item_id']; ?>" <?php if ($row['item_sub_category_id'] == $row2['item_id']) echo 'selected'; ?>>
                                            <?php echo $row2['item_subcategory']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group" id="type_div" <?php if ($selected_item_category == 'Accessories') echo "style='display:none;'" ?>>
                            <label for="type" class="col-sm-3 control-label"><?php echo get_phrase('type'); ?></label>
                            <div class="col-sm-7">
                                <input type="text" name="type" id="type" class="form-control" value="<?php echo $row['type']; ?>">
                            </div>
                        </div>

                        <div class="form-group" id="channel_div" <?php if ($selected_item_category == 'Accessories') echo "style='display:none;'" ?>>
                            <label for="channel" class="col-sm-3 control-label"><?php echo get_phrase('channel'); ?></label>
                            <div class="col-sm-7">
                                <input type="text" name="channel" id="channel" class="form-control" value="<?php echo $row['channel']; ?>">
                            </div>
                        </div>

                        <div class="form-group" id="fitting_range_div" <?php if ($selected_item_category == 'Accessories') echo "style='display:none;'" ?>>
                            <label for="fitting_range" class="col-sm-3 control-label"><?php echo get_phrase('fitting_range'); ?></label>
                            <div class="col-sm-7">
                                <input type="text" name="fitting_range" id="fitting_range" class="form-control" value="<?php echo $row['fitting_range']; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('warranty'); ?> </label>
                            <div class="col-sm-7">
                                <select name="warranty_id" class="form-control select2" >
                                    <option value=""><?php echo get_phrase('select_warranty'); ?></option>
                                    <?php foreach ($warranty_info as $row2) { ?>
                                        <option value="<?php echo $row2['id']; ?>" <?php if ($row['warranty_id'] == $row2['id']) echo 'selected'; ?>>
                                            <?php echo $row2['name']; ?>
                                        </option>
                                    <?php } ?>

                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('unit'); ?> </label>

                            <div class="col-sm-7">
                                <select name="unit" class="form-control select2" >
                                    <option value=""><?php echo get_phrase('select_unit_category'); ?></option>
                                    <?php foreach ($unit_info as $row2) { ?>
                                        <option value="<?php echo $row2['unit_id']; ?>" <?php if ($row['unit'] == $row2['unit_id']) echo 'selected'; ?>>
                                            <?php echo $row2['unit_name']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><span id="price_label">
                                    <?php if ($selected_item_category == 'Accessories') echo get_phrase('price');
                                    else echo get_phrase('unit_price'); ?></span> <small style="color:red;">*</small></label>
                            <div class="col-sm-7">
                                <input type="number" name="unit_price" class="form-control" value="<?php echo $row['unit_price']; ?>" required>
                            </div>
                        </div>
                        
                           <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><span id="price_label">New Price</span> </label>
                            <div class="col-sm-7">
                                <input type="number" name="new_price" class="form-control" value="<?php echo $row['new_price']; ?>" >
                            </div>
                        </div>
                        
                        

                        <div class="form-group" id="lr_div" <?php if ($selected_item_category == 'Accessories') echo "style='display:none;'" ?>>
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('l_/_r'); ?></label>
                            <div class="col-sm-7">
                                <select name="lr" id="lr" class="form-control">
                                    <option value=""><?php echo get_phrase('select'); ?></option>
                                    <option value="left" <?php if ($row['lr'] == 'left') echo 'selected'; ?>><?php echo get_phrase('left'); ?></option>
                                    <option value="right" <?php if ($row['lr'] == 'right') echo 'selected'; ?>><?php echo get_phrase('right'); ?></option>
                                    <!-- <option value="both" <?php if ($row['lr'] == 'both') echo 'selected'; ?>><?php echo get_phrase('both'); ?></option>
                                   -->
                                    <option value="KIT" <?php if ($row['lr'] == 'KIT') echo 'selected'; ?>><?php echo get_phrase('KIT'); ?></option>
                                    <option value="None" <?php if ($row['lr'] == 'None') echo 'selected'; ?>><?php echo get_phrase('None'); ?></option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('quantity'); ?> <small style="color:red;">*</small></label>
                            <div class="col-sm-7">
                                <input type="number" name="quantity" class="form-control" value="<?php echo $row['quantity']; ?>" required >
                            </div>
                        </div>

                        <div class="form-group" id="additional_name_div" <?php if ($selected_item_category != 'Accessories') echo "style='display:none;'" ?>>
                            <label for="additional_name" class="col-sm-3 control-label"><?php echo get_phrase('additional_name'); ?> </label>
                            <div class="col-sm-7">
                                <input type="text" name="additional_name" id="additional_name" class="form-control" value="<?php echo $row['additional_name']; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('HSN_code'); ?> </label>
                            <div class="col-sm-7">
                                <input type="number" name="hsn_code" class="form-control"  value="<?php echo $row['hsn_code']; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('batch_no'); ?> </label>
                            <div class="col-sm-7">
                                <input type="text" name="batch_no" class="form-control" value="<?php echo $row['batch_no']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('GST'); ?></label>
                            <div class="col-sm-7">
                                <select name="gst" class="form-control">
                                    <option value="0" <?php if ($row['gst'] == 0) echo 'selected'; ?>><?php echo get_phrase('Nil'); ?></option>
                                    <option value="5" <?php if ($row['gst'] == 5) echo 'selected'; ?>>5%</option>
                                    <option value="12" <?php if ($row['gst'] == 12) echo 'selected'; ?>>12%</option>
                                    <option value="18" <?php if ($row['gst'] == 18) echo 'selected'; ?>>18%</option>
                                    <option value="28" <?php if ($row['gst'] == 28) echo 'selected'; ?>>28%</option>
                                </select>
                            </div>
                        </div>

                        <!-- <div class="form-group">
                            <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('description'); ?></label>

                            <div class="col-sm-7">
                                <textarea rows="5" name="description" class="form-control" id="field-ta"><?php echo $row['description']; ?></textarea>
                            </div>
                        </div>
 -->


                        <!-- <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('image'); ?></label>

                            <div class="col-sm-7">

                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;" data-trigger="fileinput">
                                        <img src="<?php echo $this->crud_model->get_image_url('item', $row['id']); ?>" alt="...">
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
                        </div> -->
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
<script type="text/javascript">
    function get_sub_category(category_id) {
        if (category_id != '') {
            $.ajax({
                url: '<?php echo site_url('admin/get_sub_category_with_ajax/'); ?>' + category_id,
                dataType: 'json',
                success: function(response) {
                    var select = $('#item_sub_category_id');
                    $('#item_sub_category_id').html("<option value=''>Select Sub Category</option>");
                    $.each(response, function(index, item) {
                        var option = $('<option></option>');
                        option.val(item.item_id);
                        option.text(item.item_subcategory);
                        select.append(option);
                    });
                }
            });
        } else {
            $('#item_sub_category_id').html("<option value=''>Select Sub Category</option>");
        }
        getFields();

    }

    function getFields() {
        var category = $('#item_category_id option:selected').text();
        if ($.trim(category) == 'Accessories') {

            $('#type').val("");
            $('#channel').val("");
            $('#fitting_range').val("");
            $('#lr').val("").change;
            $('#price_label').html("Price");


            $('#type_div').hide();
            $('#channel_div').hide();
            $('#fitting_range_div').hide();
            $('#lr_div').hide();
            $('#additional_name_div').show();
        } else {
            $('#additional_name').val("");
            $('#price_label').html("Unit Price");

            $('#type_div').show();
            $('#channel_div').show();
            $('#fitting_range_div').show();
            $('#lr_div').show();
            $('#additional_name_div').hide();
        }
    }
</script>