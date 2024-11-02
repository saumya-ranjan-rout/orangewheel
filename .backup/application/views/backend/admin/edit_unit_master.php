<?php
$single_unit = $this->db->get_where('unit', array('unit_id' => $param2))->result_array();
foreach ($single_unit as $row) {
?>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <h3>Edit Unit</h3>
                </div>
            </div>

            <div class="panel-body">

                <form role="form" class="form-horizontal form-groups"
                    action="<?php echo site_url('admin/unit_master/update/'.$row['unit_id']); ?>" 
                        method="post" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label">Unit Name <span style="color:red">*</span></label>

                        <div class="col-sm-7">
                            <input type="text" name="unit_name" value="<?php echo $row['unit_name']; ?>" class="form-control" id="field-1" placeholder="" required>
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
