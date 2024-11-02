<?php
$single_income_head = $this->db->get_where('income_head', array('income_id' => $param2))->result_array();
foreach ($single_income_head as $row) {
?>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <h3>Edit Income Head</h3>
                </div>
            </div>

            <div class="panel-body">

                <form role="form" class="form-horizontal form-groups validate"
                    action="<?php echo site_url('admin/income_head/update/'.$row['income_id']); ?>" 
                        method="post" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label">Income Head <span style="color:red">*</span></label>

                        <div class="col-sm-7">
                            <input type="text" name="income_head_name" value="<?php echo $row['income_head_name']; ?>" class="form-control" id="income_head_name" placeholder="" required>
                        </div>
                    </div>                    

                    <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label">Description </label>

                        <div class="col-sm-7">
                        <textarea name="description" class="form-control" id="description"
                                rows="5"><?php echo $row['description']; ?></textarea>                            
                        </div>
                    </div>                    
                    
                    <div class="col-sm-3 control-label col-sm-offset-2">
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-check"></i> Update
                        </button>
                    </div>
                </form>

            </div>

        </div>

    </div>
</div>
<?php } ?>
