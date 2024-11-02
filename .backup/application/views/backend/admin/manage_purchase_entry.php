<a href="<?php echo site_url('admin/create_purchase_entry'); ?>" class="btn btn-primary pull-right">
    <i class="fa fa-plus"></i> &nbsp;<?php echo get_phrase('add_purchase_entry'); ?>
</a>
<div style="clear:both;"></div>
<br>
<div class="table-container" style="overflow-x: auto;">
<table class="table table-bordered table-striped datatable" id="table-2">
    <thead>
        <tr>
            <th style="width: 67px;">#</th>
            <th><?php echo get_phrase('invoice_no'); ?></th>
            <th><?php echo get_phrase('supplier_name'); ?></th>
            <th><?php echo get_phrase('supplier_invoice_no'); ?></th>
            <th><?php echo get_phrase('invoice_date'); ?></th>
            <th><?php echo get_phrase('total_amount'); ?></th>
            <th><?php echo get_phrase('discount_type'); ?></th>
            <th><?php echo get_phrase('discount_value'); ?></th>
            <th><?php echo get_phrase('tax'); ?></th>
            <th><?php echo get_phrase('grand_total'); ?></th>
            <th><?php echo get_phrase('payment_status'); ?></th>
            <th><?php echo get_phrase('payment_mode'); ?></th>
            <th><?php echo get_phrase('received_amount'); ?></th>
            <th><?php echo get_phrase('due_amount'); ?></th>
            <th><?php echo get_phrase('options'); ?></th>
        </tr>
    </thead>

    <tbody>
        <?php
        $counter        = 1;
        $this->db->select('purchase.*,item_supplier.item_supplier,payment_mode.payment_mode');
$this->db->from('purchase');
$this->db->join('item_supplier', 'item_supplier.id = purchase.supplier_id');
$this->db->join('payment_mode', 'payment_mode.id = purchase.payment_mode_id');
$purchase = $this->db->get()->result_array();


        foreach ($purchase as $row) { ?>
            <tr>
                <td><?php echo $counter++; ?></td>
                <td><?php echo $row['invoice_no'] ?></td>
                <td><?php echo $row['item_supplier']; ?></td>
                <td><?php echo $row['supplier_invoice_no']; ?></td>
                <td><?php echo $row['invoice_date']; ?></td>
                <td><?php echo $row['total_amount']; ?></td>
                <td><?php echo $row['discount_type']; ?></td>
                <td><?php
                    if ($row['discount_type'] == 'fixed') {
                        echo $row['discount_value'];
                    } else if ($row['discount_type'] == 'percentage') {
                        echo ($row['total_amount'] * $row['discount_value']) / 100;
                    } else {
                        echo "-";
                    }

                    ?></td>
                     <td><?php echo $row['tax_value']."%"; ?></td>
                     <td><?php echo $row['grand_total']; ?></td>
               <td>
                   <?php
                   if ($row['payment_status'] == 'paid') { ?>
                       <div class="label label-success" style="font-size: 11px;"><?php echo get_phrase('paid'); ?></div>
                   <?php } else if ($row['payment_status'] == 'partial') { ?>
                       <div class="label label-info" style="font-size: 11px;"><?php echo get_phrase('partial'); ?></div>
                   <?php } else { ?>
                       <div class="label label-danger" style="font-size: 11px;"><?php echo get_phrase('unpaid'); ?></div>
                   <?php } ?>
               </td>
               <td><?php echo $row['payment_mode']; ?></td>
               <td><?php echo $row['received_amount']; ?></td>
               <td><?php echo $row['due_amount']; ?></td>
               <td>
                   <a title="View Purchase items"href="<?php echo site_url('admin/view_purchase_entry_items/view_items/'.$row["id"]); ?>" class="btn btn-primary btn-sm">
                       <i class="fa fa-eye"></i>
                       <?php //echo get_phrase('view_items'); ?>
                   </a>
                   <a title="Edit Purchase"href="<?php echo site_url('admin/edit_purchase_entry/edit_purchase/'.$row["id"]); ?>" class="btn btn-success btn-sm">
                       <i class="fa fa-pencil"></i>
                       <?php //echo get_phrase('view_items'); ?>
                   </a>
               </td>
               
            </tr>
        <?php } ?>
    </tbody>
</table>
                   </div>

<script type="text/javascript">
jQuery(document).ready(function($) {
  var outerTable = $("#table-2").DataTable({
    "sPaginationType": "bootstrap",
    "dom": "<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'B>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>",
    buttons: [
      {
        extend: 'copyHtml5',
        text: 'Copy',
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13],
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
          columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13],
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
          columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13],
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
