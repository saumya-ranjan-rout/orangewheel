<?php $item_category_info = $this->db->where('is_active', 'Y')->get('item_category')->result_array();
$unit_info = $this->db->get('unit')->result_array();
$warranty_info = $this->db->get('warranty')->result_array();

?>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <h3><?php echo get_phrase('add_item'); ?></h3>
                </div>
            </div>

            <div class="panel-body">

                <form role="form" enctype="multipart/form-data" class="form-horizontal form-groups" action="<?php echo site_url('admin/item/create'); ?>" method="post">

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('model'); ?> <small style="color:red;">*</small></label>
                        <div class="col-sm-7">
                            <input type="text" name="model" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('serial_no'); ?> <small style="color:red;">*</small></label>
                        <div class="col-sm-7">
                            <input type="text" name="serial_no" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('item_category'); ?> <small style="color:red;">*</small></label>
                        <div class="col-sm-7">
                            <select name="item_category_id" id="item_category_id" required class="form-control select2" onchange="get_sub_category(this.value)">
                                <option value=""><?php echo get_phrase('select_item_category'); ?></option>
                                <?php foreach ($item_category_info as $row) { ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['item_category']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('sub_category'); ?></label>
                        <div class="col-sm-7">
                            <select name="item_sub_category_id" id="item_sub_category_id" class="form-control">
                                <option value=""><?php echo get_phrase('select_sub_category'); ?></option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group" id="type_div">
                        <label for="type" class="col-sm-3 control-label"><?php echo get_phrase('type'); ?></label>
                        <div class="col-sm-7">
                            <input type="text" name="type" id="type" class="form-control">
                        </div>
                    </div>

                    <div class="form-group" id="channel_div">
                        <label for="channel" class="col-sm-3 control-label"><?php echo get_phrase('channel'); ?></label>
                        <div class="col-sm-7">
                            <input type="text" name="channel" id="channel" class="form-control">
                        </div>
                    </div>

                    <div class="form-group" id="fitting_range_div">
                        <label for="fitting_range" class="col-sm-3 control-label"><?php echo get_phrase('fitting_range'); ?></label>
                        <div class="col-sm-7">
                            <input type="text" name="fitting_range" id="fitting_range" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('warranty'); ?> <small style="color:red;">*</small></label>
                        <div class="col-sm-7">
                            <select name="warranty_id" class="form-control select2" required>
                                <option value=""><?php echo get_phrase('select_warranty'); ?></option>
                                <?php foreach ($warranty_info as $row) { ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('unit'); ?> <small style="color:red;">*</small></label>
                        <div class="col-sm-7">
                            <select name="unit" class="form-control" required>
                                <option value=""><?php echo get_phrase('select_unit'); ?></option>
                                <?php foreach ($unit_info as $row) { ?>
                                    <option value="<?php echo $row['unit_id']; ?>"><?php echo $row['unit_name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><span id="price_label"><?php echo get_phrase('unit_price'); ?></span> <small style="color:red;">*</small></label>
                        <div class="col-sm-7">
                            <input type="number" name="unit_price" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group" id="lr_div">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('l_/_r'); ?></label>
                        <div class="col-sm-7">
                            <select name="lr" id="lr" class="form-control">
                                <option value=""><?php echo get_phrase('select'); ?></option>
                                <option value="left"><?php echo get_phrase('left'); ?></option>
                                <option value="right"><?php echo get_phrase('right'); ?></option>
                                <!--  <option value="both"><?php echo get_phrase('both'); ?></option>-->
                                <option value="both"><?php echo get_phrase('KIT'); ?></option>
                                <option value="both"><?php echo get_phrase('None'); ?></option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('quantity'); ?> <small style="color:red;">*</small></label>
                        <div class="col-sm-7">
                            <input type="number" name="quantity" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group" id="additional_name_div" style="display: none;">
                        <label for="additional_name" class="col-sm-3 control-label"><?php echo get_phrase('additional_name'); ?> </label>
                        <div class="col-sm-7">
                            <input type="text" name="additional_name" id="additional_name" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('HSN_code'); ?> <small style="color:red;">*</small></label>
                        <div class="col-sm-7">
                            <input type="number" name="hsn_code" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('batch_no'); ?> </label>
                        <div class="col-sm-7">
                            <input type="text" name="batch_no" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('GST'); ?></label>
                        <div class="col-sm-7">
                            <select name="gst" class="form-control">
                                <option value="0"><?php echo get_phrase('nil'); ?></option>
                                <option value="5">5%</option>
                                <option value="12">12%</option>
                                <option value="18">18%</option>
                                <option value="28">28%</option>
                            </select>
                        </div>
                    </div>



                    <!-- <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('description'); ?></label>

                        <div class="col-sm-7">
                            <textarea rows="5" name="description" class="form-control" id="field-ta"></textarea>
                        </div>
                    </div> -->

                    <!-- <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('image'); ?></label>

                        <div class="col-sm-7">

                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;" data-trigger="fileinput">
                                    <img src="http://placehold.it/200x150" alt="...">
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
                            <i class="fa fa-check"></i> <?php echo get_phrase('save'); ?>
                        </button>
                    </div>
                </form>

            </div>

        </div>

    </div>
</div>
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