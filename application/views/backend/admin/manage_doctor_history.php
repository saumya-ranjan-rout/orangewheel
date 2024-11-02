<!-- <button onclick="showAjaxModal('<?php echo site_url('modal/popup/add_unit_master'); ?>');" 
    class="btn btn-primary pull-right">
    <i class="fa fa-plus"></i>&nbsp;Add Unit
</button> -->

<div style="clear:both;"></div>
<br>
<table class="table table-bordered table-striped datatable" id="table-2">
    <thead>
        <tr>
            <th>#</th>            
            <th>Doctor Details</th><th>Action</th>
        </tr>        
    </thead>

    <tbody>
        <?php 
         $i=1;
        foreach ($doctor_history as $row) { 
            // if (strpos($row['referred_by'], 'self') !== false) {
            //     // If "self" is present in 'referred_by', skip this row
            //     continue;
            // }
            ?>   
            <tr>
                <td><?php echo $i ;?></td>                
                <td>
                <a href="<?php echo site_url('admin/doctor_visit_history?referred_by=' . urlencode($row['referred_by'])); ?>" style="color:blue"><i class="fa fa-hand-o-right" aria-hidden="true"></i>
                <?php echo $row['referred_by']; ?>
                </a>
                </td>
              
              <td>
    <a onclick="showAjaxModal('<?php echo site_url('modal/popup/edit_doctor_name'); ?>?referred_by=<?php echo urlencode($row['referred_by']); ?>');" 
       class="btn btn-info btn-sm">
        <i class="fa fa-pencil"></i>&nbsp;Edit
    </a>
</td>

            </tr>
        <?php 
        $i++;        
    } 
    ?>
    </tbody>
</table>
<script type="text/javascript">
    jQuery(document).ready(function() {
    var $ = jQuery;

    var table = $("#table-2").DataTable({
        "sPaginationType": "bootstrap",
        "dom": "<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'B>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>",
        buttons: [
            {
                extend: 'copyHtml5',
                text: 'Copy',
                exportOptions: {
                    columns: [0] // Specify the column indices to include in the copy
                }
            },
            {
    extend: 'excel',
    text: 'Excel',
    exportOptions: {
        columns: [0]
    }
},          {
    extend: 'csv',
    text: 'Csv',
    exportOptions: {
        columns: [0]
    }
}
        ]
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

    // Replace Checkboxes
    $(".pagination a").click(function(ev) {
        replaceCheckboxes();
    });

    // Manually add the Buttons to the DataTables layout
    table.buttons().container()
        .appendTo('.export-data'); // Replace '.export-data' with the appropriate selector for the container element where you want the buttons to appear
});


</script>
<!-- 20-09-23 -->
<script>
    $(document).ready(function () {
        $('#addUnitBtn').click(function () {
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('admin/send_patient_data_email'); ?>',
                success: function (response) {
                    // Handle the response (e.g., show a success message)
                    alert(response);
                    console.log(response);
                },
                error: function () {
                    // Handle errors
                    alert('Error sending email');
                }
            });
        });
    });
</script>
