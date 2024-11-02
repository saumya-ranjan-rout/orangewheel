<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <h3><?php echo get_phrase('add_warranty'); ?></h3>
                </div>
            </div>

            <div class="panel-body">

                <form role="form" enctype="multipart/form-data" class="form-horizontal form-groups" action="<?php echo site_url('admin/warranty/create'); ?>" method="post">
                
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label">Value <small style="color:red;">*</small></label>

                        <div class="col-sm-7">
                            <input type="text" name="name" class="form-control" id="field-1" required>
                        </div>                       
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Year/Month'); ?> </label>

                        <div class="col-sm-7" >
                          <select name="year_month" class="form-control" >
                             <option value="">SELECT</option>
                              <option value="Y">Year</option>
                              <option value="M">Month</option>
                              
                          </select>
                          
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