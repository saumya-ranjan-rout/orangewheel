<?php $item_subcategory_info = $this->db->where('is_active', 'Y')->get('item_category')->result_array(); ?>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <h3><?php echo get_phrase('add_item_subcategory'); ?></h3>
                </div>
            </div>

            <div class="panel-body">

                <form role="form" enctype="multipart/form-data" class="form-horizontal form-groups" action="<?php echo site_url('admin/item_subcategory/create'); ?>" method="post">

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('item_category'); ?> <small style="color:red;">*</small></label>

                        <div class="col-sm-7">
                            <select name="item_category" class="form-control select2" required>
                                <option value=""><?php echo get_phrase('select_item_category'); ?></option>
                                <?php foreach ($item_subcategory_info as $row) { ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['item_category']; ?></option>
                                <?php } ?>
                            </select>
                        </div>  
                    </div>

                    <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('item_subcategory'); ?></label>

                        <div class="col-sm-7">
                            <input type="text" name="item_subcategory" class="form-control" id="field-ta">
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