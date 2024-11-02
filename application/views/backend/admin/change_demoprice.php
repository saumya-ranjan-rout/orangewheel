<div class="container">
    <div class="row">
        <div class="col-md-12 col-lg-6">
            <!-- Panel 1 -->
            <div class="panel panel-primary" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title">
                        <h3><?php echo 'Add Demo Price'; ?></h3>
                    </div>
                </div>
                <div class="panel-body">
                    <form role="form" class="form-horizontal form-groups" action="<?php echo site_url('admin/change_demoitem_price/create'); ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('serial_no'); ?> <small style="color:red;">*</small></label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" name="sl_no" id="sl_no" required />
                                <input type="hidden" name="item_id" class="form-control" value="<?php echo $item_id; ?>" id="field-1" readonly required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('unit_price'); ?> <small style="color:red;">*</small></label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="unit_price" name="unit_price" value="" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('date'); ?> <small style="color:red;">*</small></label>
                            <div class="col-sm-7">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="entypo-calendar"></i></span>
                                    <input type="text" class="form-control datepicker" name="date_time" value="<?php echo date("m/d/Y"); ?>" required>
                                </div>
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
        <div class="col-md-12 col-lg-6">
            <!-- Panel 2 -->
            <div class="panel panel-primary" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title">
                        <h3><?php echo 'Demo Price Details'; ?></h3>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="tab-pane active" id="prescription" style="overflow-x:auto;">
                        <br>
                        <table class="table table-bordered " id="myTable"><!--id="table-1"-->
                            <thead>
                                <tr class="header" style="background-color: orange;">
                                    <th><?php echo get_phrase('sl_no'); ?></th>
                                    <th><?php echo get_phrase('serial_no'); ?></th>
                                    <th><?php echo get_phrase('price'); ?></th>
                                    <th><?php echo get_phrase('action'); ?></th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $report_info    = $this->db->get_where('demoitem_price_details', array('item_id' => $item_id))->result_array();
                                $i = 1;

                                foreach ($report_info as $row) { ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $row['sl_no'] ?></td>
                                        <td><?php echo $row['unit_price'] ?></td>
                                        <td>
                                            <a onclick="showAjaxModal('<?php echo site_url('modal/popup/edit_demoitem_price/' . $row['id']); ?>');" class="btn btn-info btn-sm" title="Edit Prescription">
                                                <i class="fa fa-pencil"></i>&nbsp;
                                            </a>
                                            <a onclick="confirm_modal('<?php echo site_url('admin/change_demoitem_price/delete/' . $row['id']); ?>')" class="btn btn-danger btn-sm" title="Delete Diagnosis">
                                                <i class="fa fa-trash-o"></i>&nbsp;
                                            </a>
                                            <input type="hidden" name="item_id" class="form-control" value="<?php echo $item_id; ?>" id="field-1" readonly required>

                                        </td>
                                    </tr>
                                <?php
                                    $i++;
                                } ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>