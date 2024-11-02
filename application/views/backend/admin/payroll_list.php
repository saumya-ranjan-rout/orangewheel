<table class="table table-bordered table-striped datatable" id="table-2">
    <thead>
        <tr>
            <th><div>#</div></th>
            <th><div>ID</div></th>
            <th><div><?php echo get_phrase('employee'); ?></div></th>
            <th><div><?php echo get_phrase('account_type'); ?></div></th>
            <th><div><?php echo get_phrase('summary'); ?></div></th>
            <th><div><?php echo get_phrase('date'); ?></div></th>
            <th><div><?php echo get_phrase('status'); ?></div></th>
            <th><div><?php echo get_phrase('options'); ?></div></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $count = 1;
        $this->db->order_by('payroll_id', 'desc');
        $payroll = $this->db->get('payroll')->result_array();
        foreach($payroll as $row): ?>
            <tr>
                <td><?php echo $count++; ?></td>
                <td><?php echo $row['payroll_code']; ?></td>
                <td>
                    <?php
                    $user = $this->db->get_where($row['user_type'], array($row['user_type'] . '_id' => $row['user_id']))->row();
                    echo $user->name; ?>
                </td>
                <td><?php echo get_phrase($row['user_type']); ?></td>
                <td>
                    <?php
                    $total_allowance    = 0;
                    $total_deduction    = 0;
                    $allowances         = json_decode($row['allowances']);
                    $deductions         = json_decode($row['deductions']);
                    
                    foreach($allowances as $allowance)
                        $total_allowance += $allowance->amount;
                    foreach($deductions as $deduction)
                        $total_deduction += $deduction->amount;
                    
                    $net_salary = $row['joining_salary'] + $total_allowance - $total_deduction;
                    ?>
                    <div>
                        <table style="width: 100%;">
                            <tr>
                                <td style="text-align: right;"><?php echo get_phrase('basic_salary'); ?></td>
                                <td style="width: 15%; text-align: right;"> : </td>
                                <td style="text-align: right;"><?php echo $row['joining_salary']; ?></td>
                            </tr>
                            <tr>
                                <td style="text-align: right;"><?php echo get_phrase('total_allowance'); ?></td>
                                <td style="width: 15%; text-align: right;"> : </td>
                                <td style="text-align: right;"><?php echo $total_allowance; ?></td>
                            </tr>
                            <tr>
                                <td style="text-align: right;"><?php echo get_phrase('total_deduction'); ?></td>
                                <td style="width: 15%; text-align: right;"> : </td>
                                <td style="text-align: right;"><?php echo $total_deduction; ?></td>
                            </tr>
                            <tr>
                                <td colspan="3"><hr style="margin: 5px 0px;"></td>
                            </tr>
                            <tr>
                                <td style="text-align: right;color:#000;font-weight:bold"><?php echo get_phrase('net_salary'); ?></td>
                                <td style="width: 15%; text-align: right;"> : </td>
                                <td style="text-align: right;color:#000;font-weight:bold"><?php echo $net_salary; ?></td>
                            </tr>
                        </table>
                    </div>
                </td>
                <td>
                    <?php
                    $date = explode(',', $row['date']);
                    $month_list = array('january', 'february', 'march', 'april', 'may', 'june', 'july',
                        'august', 'september', 'october', 'november', 'december');
                    for($i = 1; $i <= 12; $i++)
                        if($i == $date[0])
                            $month = get_phrase($month_list[$i-1]);
                    echo $month . ', ' . $date[1];
                    ?>
                </td>
                <td>
                    <?php
                    if($row['status'] == 1)
                        echo '<div class="label label-success">' . get_phrase('paid').'</div>';
                    else
                        echo '<div class="label label-danger">' . get_phrase('unpaid').'</div>';
                    ?>
                </td>
                <td>
                    <div class="btn-group">
                        <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
                            Action <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-default pull-right" role="menu">

                            <li>
                                <a href="#" onclick="showAjaxModal('<?php echo site_url('modal/popup/payroll_details/'.$row['payroll_id']); ?>');">
                                    <i class="fa fa-eye"></i>&nbsp;
                                    <?php echo get_phrase('view_payroll_details'); ?>
                                </a>
                            </li>
                            
                             <li>
                                <a href="#" onclick="confirm_modal('<?php echo site_url('admin/payroll_list/delete/'.$row['payroll_id']); ?>');">
                                    <i class="fa fa-trash-o"></i>&nbsp;
                                   <?php echo get_phrase('delete'); ?>
                                </a>
                            </li>

                            <?php if($row['status'] == 0) { ?>
                                <li>
                                    <a href="<?php echo site_url('admin/payroll_list/mark_paid/'.$row['payroll_id']); ?>">
                                        <i class="fa fa-check"></i>&nbsp;
                                        <?php echo get_phrase('mark_as_paid'); ?>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>

                </td>
            </tr>
    <?php endforeach; ?>
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
                    columns: [0, 1, 2, 3, 4, 5, 6] // Specify the column indices to include in the copy
                }
            },
            {
    extend: 'excel',
    text: 'Excel',
    exportOptions: {
        columns: [0, 1, 2, 3, 4, 5, 6]
    }
},          {
    extend: 'csv',
    text: 'Csv',
    exportOptions: {
        columns: [0, 1, 2, 3, 4, 5, 6]
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