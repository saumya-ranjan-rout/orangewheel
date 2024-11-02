<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <h3>Add Income Head</h3>
                </div>
            </div>

            <div class="panel-body">

                <form role="form" class="form-horizontal form-groups validate"
                    action="<?php echo site_url('admin/income_head/create'); ?>" 
                        method="post" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label">Income Head <span style="color:red">*</span></label>

                        <div class="col-sm-7">
                            <input type="text" name="income_head_name" class="form-control" id="income_head_name" placeholder="" required>
                        </div>
                    </div>                    

                    <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label">Description</label>

                        <div class="col-sm-7">
                        <textarea name="description" class="form-control" id="description"
                                rows="5"></textarea>                            
                        </div>
                    </div>                    
                    
                    <div class="col-sm-3 control-label col-sm-offset-2">
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-check"></i> Save
                        </button>
                    </div>
                </form>

            </div>

        </div>

    </div>
</div>
