<?php $item_info = $this->db->where('is_active', 'Y')->get('item')->result_array();
$doctor_info = $this->db->get('doctor')->result_array(); ?>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <h3><?php echo get_phrase('add_item_issue'); ?></h3>
                </div>
            </div>

            <div class="panel-body">

                <form role="form" enctype="multipart/form-data" class="form-horizontal form-groups" action="<?php echo site_url('admin/item_issue/create'); ?>" method="post">

                    <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('issue_to'); ?> <small style="color:red;">*</small></label>
                        <div class="col-sm-7">
                            <select name="issue_to" required class="form-control">
                                <option value=""><?php echo get_phrase('select_doctor'); ?></option>
                                <?php foreach ($doctor_info as $row) { ?>
                                    <option value="<?php echo $row['doctor_id']; ?>"><?php echo $row['name']; ?>(<?php echo $row['staff_id']; ?>)</option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('issue_by'); ?> <small style="color:red;">*</small></label>

                        <div class="col-sm-7">
                            <input type="text" name="issue_by" class="form-control" id="field-1" value="<?php echo $this->session->userdata('name'); ?>" required readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('issue_date'); ?> <small style="color:red;">*</small></label>

                        <div class="col-sm-7">
                            <input type="text" name="issue_date" class="form-control datepicker" id="field-1" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('return_date'); ?></label>

                        <div class="col-sm-7">
                            <input type="text" name="return_date" class="form-control datepicker" id="field-1">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('item'); ?> <small style="color:red;">*</small></label>
                        <div class="col-sm-7">
                            <select name="item_id" id="item_id" required class="form-control" onchange="available_quantity(this.value)">
                                <option value=""><?php echo get_phrase('select_item'); ?></option>
                                <?php foreach ($item_info as $row) { ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('quantity'); ?> <small style="color:red;">*</small></label>
                        <div class="col-sm-7">
                            <input type="number" name="quantity" class="form-control" id="quantity" onkeyup="validate_quantity()" required>
                            <input type="hidden" name="available_qty" class="form-control" id="available_qty"><br>
                            <span id="avl_qty"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('note'); ?></label>
                        <div class="col-sm-7">
                            <textarea rows="5" name="note" class="form-control" id="field-ta"></textarea>
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
<script type="text/javascript">
    function available_quantity(itemId) {
        //alert(itemId);
        if (itemId != '') {
            $.ajax({
                url: '<?php echo site_url('admin/get_item_stock_with_ajax/'); ?>' + itemId,
                success: function(response) {
                    //alert(response);
                    var data = JSON.parse(response);
                    //alert(data.available_quantity);
                    $('#avl_qty').html("Available quantity: " + data.available_quantity);
                    $('#available_qty').val(data.available_quantity);
                    validate_quantity();
                }
            });
        } else {
            $('#avl_qty').html("Available quantity: ");
            $('#available_qty').val("");
            validate_quantity();
        }

    }

    function validate_quantity() {
        var quantity = $('#quantity').val();
        var aqty = $('#available_qty').val();
        if (quantity != '') {
            quantity = parseInt(quantity);
        }
        if (aqty != '') {
            aqty = parseInt(aqty);
        }
        var item_id = $('#item_id').val();
        if (item_id != '') {
            if (quantity > aqty) {
                alert("Quantity must be less than or equal to available quantity");
                $('#quantity').val("");
            }
        } else {
            alert("First select the item from the list");
            $('#quantity').val("");
        }
    }
</script>