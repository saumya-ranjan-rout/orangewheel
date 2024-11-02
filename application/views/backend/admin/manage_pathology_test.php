
<button onclick="showAjaxModal('<?php echo site_url('modal/popup/add_pathology_test'); ?>');" class="btn btn-primary pull-right">
    <i class="fa fa-plus"></i>&nbsp;<?php echo get_phrase('add_pathology_test'); ?>
</button>
<div style="clear:both;"></div>
<br>
<table class="table table-bordered table-striped datatable" id="table-2">
    <thead>
        <tr>
            <th><?php echo get_phrase('test_name'); ?></th>
            <th><?php echo get_phrase('short_name'); ?></th>
            <th><?php echo get_phrase('test_type'); ?></th>
            <th><?php echo get_phrase('category'); ?></th>
            <th><?php echo get_phrase('sub_category'); ?></th>
            <th><?php echo get_phrase('method'); ?></th>
            <th><?php echo get_phrase('unit'); ?></th>
            <th><?php echo get_phrase('report_days'); ?></th>
            <th><?php echo get_phrase('charge(_Rs_)'); ?></th>
            <th><?php echo get_phrase('options'); ?></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($pathology_test_info as $row) {

        ?>
            <tr>

                <td><?php echo $row['test_name'] ?></td>
                <td><?php echo $row['short_name'] ?></td>
                <td><?php echo $row['test_type'] ?></td>
                <td><?php echo $row['test_category'] ?></td>
                <td><?php echo $row['sub_category'] ?></td>
                <td><?php echo $row['method'] ?></td>
                <td><?php $unit_name = $this->db->get_where('unit' , array('unit_id' => $row['unit'] ))->row()->unit_name;
                        echo $unit_name;?></td>
                <td><?php echo $row['report_days'] ?></td>
                <td><?php echo $row['price'] ?></td>
                <td>
                    <a onclick="showAjaxModal('<?php echo site_url('modal/popup/edit_pathology_test/' . $row['id']); ?>');" class="btn btn-info btn-sm">
                        <i class="fa fa-pencil"></i>&nbsp;
                        <?php echo get_phrase('edit'); ?>
                    </a>
                    <a onclick="confirm_modal('<?php echo site_url('admin/pathology_test/delete/' . $row['id']); ?>')" class="btn btn-danger btn-sm">
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