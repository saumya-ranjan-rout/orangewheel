<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <h3><?php echo get_phrase('add_diagnosis'); ?></h3>
                </div>
            </div>

            <div class="panel-body">

                <form role="form" enctype="multipart/form-data" class="form-horizontal form-groups" action="<?php echo site_url('admin/diagnosis/create'); ?>" method="post">
                
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('serial_no'); ?> <small style="color:red;">*</small></label>

                        <div class="col-sm-7">
                            <input type="text" name="slno" class="form-control" id="field-1" required>
                        </div>                       
                    </div>

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('name'); ?> </label>

                        <div class="col-sm-7">
                            <input type="text" name="name" class="form-control" id="field-1">
                        </div>                       
                    </div>

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('quantity'); ?> </label>

                        <div class="col-sm-7">
                            <input type="number" name="qty" class="form-control" id="field-1">
                        </div>                       
                    </div>

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('price'); ?> </label>

                        <div class="col-sm-7">
                            <input type="text" name="price" class="form-control" id="field-1">
                        </div>                       
                    </div>

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('discount_type'); ?> </label>

                        <div class="col-sm-7">
                            <select name="discount_type" class="form-control">
                                <option value="">None</option>
                                <option value="fixed">Fixed</option>
                                <!--<option value="percentage">Percentage(%)</option>-->
                            </select>
                        </div>  
                    </div>

                    <div class="form-group" style="display:none">
                        <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('discount_price'); ?>/% </label>

                        <div class="col-sm-7">
                            <input type="text" name="discount_price" class="form-control" id="field-ta">
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