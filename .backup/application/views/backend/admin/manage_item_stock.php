<button onclick="showAjaxModal('<?php echo site_url('modal/popup/add_item_stock'); ?>');" class="btn btn-primary pull-right">
    <i class="fa fa-plus"></i>&nbsp;<?php echo get_phrase('add_item_stock'); ?>
</button>
<div style="clear:both;"></div>
<br>
<table class="table table-bordered table-striped datatable" id="table-2">
    <thead>
        <tr>
            <th><?php echo get_phrase('item_name'); ?></th>
            <th><?php echo get_phrase('category'); ?></th>
            <th><?php echo get_phrase('supplier'); ?></th>
            <th><?php echo get_phrase('store'); ?></th>
            <th><?php echo get_phrase('quantity'); ?></th>
            <th><?php echo get_phrase('purchase_price'); ?></th>
            <th><?php echo get_phrase('rate'); ?></th>
            <th><?php echo get_phrase('date'); ?></th>
            <th><?php echo get_phrase('options'); ?></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($item_stock_info as $row) { ?>
            <tr>
                <td><?php echo $row['name'] ?></td>
                <td><?php echo $row['item_category'] ?></td>
                <td><?php echo $row['item_supplier'] ?></td>
                <td><?php echo $row['item_store']; ?></td>
                <td><?php echo $row['quantity'] ?></td>
                <td><?php echo $row['purchase_price'] ?></td>
                <td><?php echo $row['rate'] ?></td>
                <td><?php echo date('d/m/Y', strtotime($row['date'])); ?></td>
                <td>
                    <?php if ($row['attachment']) {
                    ?>
                        <a href="<?php echo base_url(); ?>uploads/item_stock_attachment/<?php echo $row['upload_name'] ?>" class="btn btn-default btn-xs" data-toggle="tooltip" title="<?php echo $this->lang->line('download'); ?>">
                            <i class="fa fa-download"></i>
                        </a>
                    <?php }
                    ?>
                    <a onclick="showAjaxModal('<?php echo site_url('modal/popup/edit_item_stock/' . $row['id']); ?>');" class="btn btn-info btn-sm">
                        <i class="fa fa-pencil"></i>&nbsp;
                        <?php echo get_phrase('edit'); ?>
                    </a>
                    <a onclick="confirm_modal('<?php echo site_url('admin/item_stock/delete/' . $row['id']); ?>')" class="btn btn-danger btn-sm">
                        <i class="fa fa-trash-o"></i>&nbsp;
                        <?php echo get_phrase('delete'); ?>
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
                    columns: [0, 1, 2, 3, 4, 5, 6, 7] // Specify the column indices to include in the copy
                }
            },
            {
    extend: 'excel',
    text: 'Excel',
    exportOptions: {
        columns: [0, 1, 2, 3, 4, 5, 6, 7]
    }
},          {
    extend: 'csv',
    text: 'Csv',
    exportOptions: {
        columns: [0, 1, 2, 3, 4, 5, 6, 7]
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