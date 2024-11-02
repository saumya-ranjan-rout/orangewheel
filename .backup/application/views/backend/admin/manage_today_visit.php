<div style="clear:both;"></div>
<br>
<table class="table table-bordered table-striped datatable" id="table-2">
    <thead>
        <tr>            
            <th><?php echo get_phrase('Patient Id');?></th>
            <th><?php echo get_phrase('name');?></th>
            <th><?php echo get_phrase('referred_by');?></th>
            <th><?php echo get_phrase('visit_type');?></th>          
            <th><?php echo get_phrase('date');?></th>                         
        </tr>
    </thead>

    <tbody>
        <?php foreach ($patient_consultation_history_info as $row) {             
        $currentDate = date('d-m-Y');        
        if ($row['date'] == $currentDate) { ?>
            <tr>
                <td><?php echo $row['patient_code']?></td>
                <td><?php echo $row['patient_name']?></td>
                <td><?php echo $row['referred_by']?></td>
                <td><?php echo $row['visit_type']?></td>               
                <td><?php echo $row['date']?></td>                        
            </tr>
        <?php
        }
     } ?>
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
                    columns: [0, 1, 2, 3, 4] // Specify the column indices to include in the copy
                }
            },
            {
    extend: 'excel',
    text: 'Excel',
    exportOptions: {
        columns: [0, 1, 2, 3, 4]
    }
},          {
    extend: 'csv',
    text: 'Csv',
    exportOptions: {
        columns: [0, 1, 2, 3, 4]
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
 