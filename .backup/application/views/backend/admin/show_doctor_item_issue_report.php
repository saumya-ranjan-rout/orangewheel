<!--Added on 12-06-2023-->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<!--Added on 12-06-2023-->
<?php if ($this->input->post()) {
    $fdate = date('m/d/Y', strtotime($date_from));
    $tdate = date('m/d/Y', strtotime($date_to));
} else {
    $fdate = date("m/d/Y");
    $tdate = date("m/d/Y");
} ?>
<div class="row">
    <form action="<?php echo site_url('admin/doctor_item_issue_report'); ?>" method="post" enctype="multipart/form-data">
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

        <div class="col-md-3" style="margin-top: 30px;">
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
    <?php } ?>
</div>
<table class="table table-bordered table-striped datatable" id="table-2">
    <thead>
        <tr>
            <th><?php echo get_phrase('item_name'); ?></th>
            <th><?php echo get_phrase('category'); ?></th>
            <th><?php echo get_phrase('issue_-_return'); ?></th>
            <th><?php echo get_phrase('issue_to'); ?></th>
            <th><?php echo get_phrase('issue_by'); ?></th>
            <th><?php echo get_phrase('quantity'); ?></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($doctor_item_issue_info as $row) { ?>
            <tr>
                <td><?php echo $row['name'] ?></td>
                <td><?php echo $row['item_category'] ?></td>
                <td><?php echo date('d/m/Y', strtotime($row['issue_date'])) . "-" . date('d/m/Y', strtotime($row['return_date'])); ?></td>
                <td><?php echo $row['doctor_name'] ?></td>
                <td><?php echo $row['issue_by']; ?></td>
                <td><?php echo $row['quantity'] ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<script>
$(document).ready(function() {
    $('#table-2').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            
        ]
    } );
} );
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