<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <h3>Convert To Invoice</h3>
                </div>
            </div>

            <div class="panel-body">

                <form role="form" class="form-horizontal form-groups" action="<?php echo site_url('admin/patient_item_issue/convert_to_invoice'); ?>" method="post" enctype="multipart/form-data" onsubmit="disableButton()">

                    <input type="hidden" name="id" class="form-control" value="<?php echo $param2; ?>" required readonly>

                    <input type="hidden" name="invoice_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" readonly>

                    <h4 class="modal-title" style="text-align:center;">Are you sure to generate invoice ?</h4>

                    <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
                        <button type="submit" class="btn btn-primary" id="myButton"><?php echo get_phrase('Yes'); ?></button>
                        <button type="button" class="btn btn-info" data-dismiss="modal"><?php echo get_phrase('cancel'); ?></button>
                    </div>

                </form>

            </div>

        </div>

    </div>
</div>