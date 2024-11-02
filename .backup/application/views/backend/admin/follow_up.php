<?php
$row = $this->db->order_by('id', 'DESC') ->limit(1) ->get('follow_up') ->row_array();
?>
    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-primary" data-collapsed="0">

     <span style="color:red">  *Follow up notification will come before below mention days</span>

                <div class="panel-body">

                    <form role="form" class="form-horizontal form-groups" action="<?php echo site_url('admin/follow_up/update/' . $row['id']); ?>" method="post" enctype="multipart/form-data">

                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Days'); ?></label>

                            <div class="col-sm-7">
                                <input type="number" name="days" class="form-control" id="field-1" value="<?php echo $row['days']; ?>" required>
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
