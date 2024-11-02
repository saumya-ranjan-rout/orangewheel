
<?php if ($this->input->post()) {
    $fdate = date('m/d/Y', strtotime($date_from));
    $tdate = date('m/d/Y', strtotime($date_to));
} else {
    $fdate = date("m/d/Y");
    $tdate = date("m/d/Y");
} ?>
<div class="row">
    <form action="<?php echo site_url('admin/patient_item_issue_report'); ?>" method="post" enctype="multipart/form-data">
        <div class="col-md-3" id="fromdate">
            <div class="form-group">
                <label class="control-label" style="margin-bottom: 11px;">Date From(<span style="color:#14b914">m/d/y</span>) <span style="color:red">*</span></label>
                <input id="date_from" name="date_from" placeholder="" type="text" class="form-control datepicker" value="<?php echo $fdate; ?>" />
            </div>
        </div>

        <div class="col-md-3" id="todate">
            <div class="form-group">
                <label class="control-label" style="margin-bottom: 11px;">Date To(<span style="color:#14b914">m/d/y</span>) <span style="color:red">*</span></label>
                <input id="date_to" name="date_to" placeholder="" type="text" class="form-control datepicker" value="<?php echo $tdate; ?>" />
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label" style="margin-bottom: 11px;">Patient</label>
                <select class="form-control select2" name="patient_id">
                    <option value="">Select</option>
                    <?php foreach ($patient_info as $patient) { ?>
                        <option value="<?Php echo $patient['patient_id'] ?>" <?php if ($patient['patient_id'] == $patient_id) echo 'selected'; ?>><?Php echo $patient['name'] ?>(<?Php echo $patient['phone'] ?>)</option>
                    <?php } ?>

                </select>
            </div>
        </div>

        <div class=" col-md-3" style="margin-top: 30px;">
            <button type="submit" class="btn btn-info">Search</button>
        </div>
    </form>
</div>
<div style="clear:both;"></div>
<div align="center">
    <?php
    if ($this->input->post()) {
    ?>
        <h4 style="color:#818da1;">Showing Results From <span style="color:#14b914"><?php echo date('d-m-Y', strtotime($date_from)) ?></span> To <span style="color:#14b914"><?php echo date('d-m-Y', strtotime($date_to)); ?></span></h4>
    <?php } else{ ?>
            <h4 style="color:#818da1;">Showing Results From <span style="color:#14b914"><?php echo date('Y-m-d')?></span> </h4>

   <?php }  ?>
</div>
<table class="table table-bordered table-striped datatable" id="table-2">
    <thead>
        <tr>
            <th><?php echo get_phrase('item_name'); ?></th>
            <th><?php echo get_phrase('serial_no'); ?></th>
            <th><?php echo get_phrase('invoice_no'); ?></th>
            <th><?php echo get_phrase('date'); ?></th>
            <th><?php echo get_phrase('patient_name'); ?></th>
            <th><?php echo get_phrase('quantity'); ?></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($patient_item_issue_info as $row) {
            $models          = json_decode($row['models']);
            foreach ($models as $row2) {

                $this->db->select('item.*,unit.unit_name')->from('item');
                $this->db->join('unit', 'item.unit = unit.unit_id', 'left');
                $this->db->where('item.id', $row2->model_id);
                $query2 = $this->db->get();
                $model_info = $query2->row_array();
        ?>
                <tr>
                    <td><?php echo $model_info['model']; ?></td>
                    <td><?php echo $model_info['serial_no']; ?></td>
                    <td><?php echo $row['bill_no']; ?></td>
                    <td><?php echo date('d/m/Y', strtotime($row['invoice_date'])); ?></td>
                    <td><?php echo $row['patient_name'] ?></td>
                    <td><?php echo $row2->quantity; ?></td>
                </tr>
        <?php }
        } ?>
    </tbody>
</table>
<script>
    $(document).ready(function() {
        $('#table-2').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',

            ]
        });
    });
</script>
<script type="text/javascript">
    /*jQuery(window).load(function() {
        var $ = jQuery;

        $("#table-2").dataTable({
            "sPaginationType": "bootstrap",
            "sDom": "<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'T>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>"
        });

        $(".dataTables_wrapper select").select2({
            minimumResultsForSearch: -1
        });

        // Highlighted rows
        $("#table-2 tbody input[type=checkbox]").each(function(i, el) {
            var $this = $(el),
                $p = $this.closest('tr');

            $(el).on('change', function() {
                var is_checked = $this.is(':checked');

                $p[is_checked ? 'addClass' : 'removeClass']('highlight');
            });
        });

        // Replace Checboxes
        $(".pagination a").click(function(ev) {
            replaceCheckboxes();
        });
    });*/
</script>