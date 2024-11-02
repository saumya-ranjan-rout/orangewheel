
<?php if ($this->input->post()) {
    $fdate = date('m/d/Y', strtotime($date_from));
    $tdate = date('m/d/Y', strtotime($date_to));
} else {
    $fdate = date("m/d/Y");
    $tdate = date("m/d/Y");
} ?>
<div class="row">
    <form action="<?php echo site_url('admin/pathology_patient_report_search'); ?>" method="post" enctype="multipart/form-data">
        <div class="col-md-3" id="fromdate">
            <div class="form-group">
                <label class="control-label" style="margin-bottom: 11px;">Date From(<span style="color:#14b914">m/d/y</span>)  <span style="color:red">*</span></label>
                <input id="date_from" name="date_from" placeholder="" type="text" class="form-control datepicker" value="<?php echo $fdate; ?>" />
            </div>
        </div>

        <div class="col-md-3" id="todate">
            <div class="form-group">
                <label class="control-label" style="margin-bottom: 11px;">Date To(<span style="color:#14b914">m/d/y</span>)  <span style="color:red">*</span></label>
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
    <?php } else{?>
         <h4 style="color:#818da1;">Showing Results For <span style="color:#14b914"><?php echo date('d-m-Y') ?></span> </h4>
  <?php  }
    
    
    ?>
</div>
<table class="table table-bordered table-striped datatable" id="table-2">
    <thead>
        <tr>
            <th><?php echo get_phrase('patient_name'); ?></th>
            <th><?php echo get_phrase('test_name'); ?></th>
            <th><?php echo get_phrase('date'); ?></th>
            <th><?php echo get_phrase('description'); ?></th>
            <th><?php echo get_phrase('doctor'); ?></th>
            <th><?php echo get_phrase('charge(_rs_)'); ?></th>
            <th><?php echo get_phrase('status'); ?></th>
        </tr>
    </thead>

    <tbody>
        <?php
        
        
        if ($this->input->post()) {
            $dateFrom = date('Y-m-d', strtotime($date_from));
            $dateTo = date('Y-m-d', strtotime($date_to));
        } else {
            $dateFrom = date("Y-m-d");
            $dateTo = date("Y-m-d");
        }
        
        // Filter the pathology array based on the selected date range
        $filteredPathology = array_filter($pathology_patient_report_info, function($row) use ($dateFrom, $dateTo) {
            $rowDate = date("Y-m-d", strtotime($row['date']));
           // echo $rowDate;
            return ($rowDate >= $dateFrom && $rowDate <= $dateTo);
        });
        
        
        foreach ($filteredPathology as $row) {
        
        
        
        ?>
            <tr>
                <td><?php echo $row['patient_name'] ?></td>
                <td><?php echo $row['test_name']; ?></td>
                <td><?php echo date('d/m/Y', strtotime($row['date'])); ?></td>
                <td><?php echo $row['description'] ?></td>
                <td><?php echo $row['doctor_name'] ?></td>
                <td><?php echo $row['charge']; ?></td>
                <td><?php echo $row['payment_status']; ?></td>
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