<button onclick="showAjaxModal('<?php echo site_url('modal/popup/add_department'); ?>');" 
    class="btn btn-primary pull-right">
    <i class="fa fa-plus"></i>&nbsp;<?php echo get_phrase('add_department'); ?>
</button>
<div style="clear:both;"></div>
<br>
<table class="table table-bordered table-striped datatable" id="table-2">
    <thead>
        <tr>
            <th><?php echo get_phrase('icon');?></th>
            <th><?php echo get_phrase('name'); ?></th>
            <th width="50%"><?php echo get_phrase('description'); ?></th>
            <th><?php echo get_phrase('options'); ?></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($department_info as $row) { ?>   
            <tr>
                <td>
                    <img src="<?php echo base_url();?>uploads/frontend/department_images/<?php echo $row['department_id'];?>.png"
                        width="40">
                </td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo substr($row['description'], 0, 200); ?> ...</td>
                <td>
                    <a href="<?php echo site_url('admin/department_facilities/'.$row['department_id']);?>"
                        class="btn btn-default btn-sm">
                        <i class="fa fa-plus"></i>&nbsp;<?php echo get_phrase('manage_facilities');?>
                    </a>
                    <a  onclick="showAjaxModal('<?php echo site_url('modal/popup/edit_department/'.$row['department_id']); ?>');" 
                        class="btn btn-info btn-sm">
                        <i class="fa fa-pencil"></i>&nbsp;<?php echo get_phrase('edit');?>
                    </a>
                    <a onclick="confirm_modal('<?php echo site_url('admin/department/delete/'.$row['department_id']); ?>')"
                       class="btn btn-danger btn-sm">
                        <i class="fa fa-trash-o"></i>&nbsp;<?php echo get_phrase('delete');?>
                    </a>
                </td>
            </tr>
        <?php } ?>
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
                    columns: [0,1,2] // Specify the column indices to include in the copy
                }
            },
            {
    extend: 'excel',
    text: 'Excel',
    exportOptions: {
        columns: [0,1,2]
    }
},          {
    extend: 'csv',
    text: 'Csv',
    exportOptions: {
        columns: [0,1,2]
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