<button onclick="showAjaxModal('<?php echo site_url('modal/popup/add_item_issue'); ?>');" class="btn btn-primary pull-right">
    <i class="fa fa-plus"></i>&nbsp;<?php echo get_phrase('add_item_issue'); ?>
</button>
<div style="clear:both;"></div>
<br>
<table class="table table-bordered table-striped datatable" id="table-2">
    <thead>
        <tr>
            <th><?php echo get_phrase('item_name'); ?></th>
            <th><?php echo get_phrase('item_category'); ?></th>
            <th><?php echo get_phrase('isuue-_return'); ?></th>
            <th><?php echo get_phrase('issue_to'); ?></th>
            <th><?php echo get_phrase('issue_by'); ?></th>
            <th><?php echo get_phrase('quantity'); ?></th>
            <th><?php echo get_phrase('status'); ?></th>
            <th><?php echo get_phrase('options'); ?></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($item_issue_info as $row) { ?>
            <tr>
                <td><?php echo $row['name'] ?></td>
                <td><?php echo $row['item_category'] ?></td>
                <td><?php echo date('d/m/Y', strtotime($row['issue_date'])) . "-" . date('d/m/Y', strtotime($row['return_date'])); ?></td>
                <td><?php echo $row['doctor_name'] ?></td>
                <td><?php echo $row['issue_by']; ?></td>
                <td><?php echo $row['quantity'] ?></td>
                <td><?php if ($row['is_returned'] == 1) {
                        echo "Returned";
                    } else {
                        echo "Issued";
                    } ?></td>

                <td>
                    <?php if ($row['is_returned'] == 0) { ?>
                        <a onclick="staus_confirm_modal('<?php echo site_url('admin/item_issue/change_status/' . $row['id']); ?>')" class="btn btn-info btn-sm">
                            <i class="fa fa-undo"></i>&nbsp;
                            <?php echo get_phrase('return'); ?>
                        </a>
                    <?php } ?>

                    <a onclick="confirm_modal('<?php echo site_url('admin/item_issue/delete/' . $row['id']); ?>')" class="btn btn-danger btn-sm">
                        <i class="fa fa-trash-o"></i>&nbsp;
                        <?php echo get_phrase('delete'); ?>
                    </a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>



<script type="text/javascript">
    jQuery(window).load(function() {
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
    });
</script>