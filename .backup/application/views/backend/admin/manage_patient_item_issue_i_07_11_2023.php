<!-- <a href="<?php echo site_url('admin/create_patient_item_issue'); ?>" class="btn btn-primary pull-right">
  <i class="fa fa-plus"></i> &nbsp;<?php echo get_phrase('add_patient_item_issue'); ?>
</a> -->
<div style="clear:both;"></div>
<br>
<table class="table table-bordered table-striped datatable" id="table-2">
    <thead>
        <tr>
            <th style="width: 67px;">#</th>
            <th><?php echo get_phrase('invoice_no'); ?></th>
            <th><?php echo get_phrase('models'); ?></th>
            <!-- <th><?php echo get_phrase('sum_total'); ?></th>
            <th><?php echo get_phrase('discount'); ?></th>
            <th><?php echo get_phrase('tax'); ?></th> -->
            <th><?php echo get_phrase('grand_total'); ?></th>
            <th><?php echo get_phrase('received_amount'); ?></th>
            <th><?php echo get_phrase('due_amount'); ?></th>
            <th><?php echo get_phrase('patient'); ?></th>
            <th><?php echo get_phrase('status'); ?></th>
            <th><?php echo get_phrase('options'); ?></th>
        </tr>
    </thead>

    <tbody>
        <?php
        $counter        = 1;
        $this->db->order_by('id', 'desc');
        $patient_issues = $this->db->where('issue_type', $list)->get('patient_item_issue')->result_array();
        foreach ($patient_issues as $row) { ?>
            <tr>
                <td><?php echo $counter++; ?></td>
                <td><?php echo $row['bill_no'] ?></td>
                <td>
                    <div>
                        <table style="width: 100%;">
                            <tr>
                                <td style="text-align: center;"><?php echo get_phrase('model'); ?></td>
                                <td style="text-align: center;"><?php echo get_phrase('quantity'); ?></td>
                                <td style="text-align: center;"><?php echo get_phrase('price'); ?></td>
                                <td style="text-align: center;"><?php echo get_phrase('tax'); ?></td>
                                <td style="text-align: center;"><?php echo get_phrase('discount'); ?></td>
                                <td style="text-align: center;"><?php echo get_phrase('total_price'); ?></td>
                            </tr>
                            <tr>
                                <td colspan="6">
                                    <hr style="margin: 5px 0px;">
                                </td>
                            </tr>
                            <?php
                            $models      = json_decode($row['models']);
                            foreach ($models as $row2) { ?>
                                <tr>
                                    <td style="text-align: center;">
                                        <?php
                                        $model_info = $this->db->get_where('item', array('id' => $row2->model_id))->row();
                                        echo $model_info->model; ?>
                                    </td>
                                    <td style="text-align: center;"><?php echo $row2->quantity; ?></td>
                                    <td style="text-align: center;"><?php echo $row2->price; ?></td>
                                    <td style="text-align: center;">
                                        <?php echo $row2->tax_percentage;
                                        if ($row2->tax_percentage > 0) echo '%'; ?>
                                    </td>
                                    <td style="text-align: center;">
                                        <?php echo $row2->discount_percentage;
                                        if ($row2->discount_percentage > 0) echo '%'; ?>
                                    </td>
                                    <td style="text-align: center;"><?php echo $row2->total_price; ?></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                </td>
                <!-- <td><?php echo $row['sum_total_price']; ?></td>
                <td><?php
                    if ($row['discount_type'] == 'fixed') {
                        echo $row['discount_value'];
                    } else if ($row['discount_type'] == 'percentage') {
                        echo ($row['total_amount'] * $row['discount_value']) / 100;
                    } else {
                        echo "-";
                    }

                    ?></td>
                <td>
                    <?php echo $row['tax_per'];
                    if ($row['tax_per'] > 0) echo '%'; ?>
                </td> -->
                <td><?php echo $row['grand_total']; ?></td>
                <td><?php echo $row['received_amount']; ?></td>
                <td><?php echo $row['due_amount']; ?></td>
                <td>

                    <?php echo $this->db->get_where('patient', array('patient_id' => $row['patient_id']))->row()->name; ?>
                </td>
                <td>
                    <?php
                    if ($row['payment_status'] == 'paid') { ?>
                        <div class="label label-success" style="font-size: 11px;"><?php echo get_phrase('paid'); ?></div>
                    <?php } else if ($row['payment_status'] == 'partial') { ?>
                        <div class="label label-info" style="font-size: 11px;"><?php echo get_phrase('partial'); ?></div>
                    <?php } else if ($row['payment_status'] == 'advance_paid') { ?>
                        <div class="label label-primary" style="font-size: 11px;"><?php echo get_phrase('advance_paid'); ?></div>
                    <?php } else { ?>
                        <div class="label label-danger" style="font-size: 11px;"><?php echo get_phrase('unpaid'); ?></div>
                    <?php } ?>
                </td>
                <td>
                    <a onclick="showAjaxModal('<?php echo site_url('modal/popup/patient_item_issue_invoice/' . $row['id']); ?>');" class="btn btn-default btn-sm">
                        <i class="fa fa-eye"></i> &nbsp;
                        <?php echo get_phrase('view_invoice'); ?>
                    </a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script type="text/javascript">
    jQuery(document).ready(function($) {
        var outerTable = $("#table-2").DataTable({
            "sPaginationType": "bootstrap",
            "dom": "<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'B>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>",
            buttons: [{
                    extend: 'copyHtml5',
                    text: 'Copy',
                    exportOptions: {
                        columns: [0, 1, 3, 4, 5, 6, 7, 8],
                        format: {
                            body: function(data, row, column, node) {
                                if ($(node).hasClass("child")) {
                                    return $(node).text().trim();
                                } else {
                                    return $(node).text().trim();
                                }
                            }
                        }
                    }
                },
                {
                    extend: 'excelHtml5',
                    text: 'Excel',
                    exportOptions: {
                        columns: [0, 1, 3, 4, 5, 6, 7, 8],
                        format: {
                            body: function(data, row, column, node) {
                                if ($(node).hasClass("child")) {
                                    return '';
                                } else {
                                    return $(node).text().trim();
                                }
                            }
                        }
                    }
                },
                {
                    extend: 'csvHtml5',
                    text: 'Csv',
                    exportOptions: {
                        columns: [0, 1, 3, 4, 5, 6, 7, 8],
                        format: {
                            body: function(data, row, column, node) {
                                if ($(node).hasClass("child")) {
                                    return '';
                                } else {
                                    return $(node).text().trim();
                                }
                            }
                        }
                    }
                }
            ]
        });

        $(".dataTables_wrapper select").select2({
            minimumResultsForSearch: -1
        });
    });
</script>