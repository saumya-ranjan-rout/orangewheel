
<div style="clear:both;"></div>
<br>
<table class="table table-bordered table-striped datatable" id="table-2">
    <thead>
        <tr>
            <th style="width: 67px;">#</th>
            <th><?php echo get_phrase('item_name'); ?></th>
            <th><?php echo get_phrase('item_quantity'); ?></th>
            <th><?php echo get_phrase('item_batch'); ?></th>
            <th><?php echo get_phrase('item_price'); ?></th>
            <th><?php echo get_phrase('item_amount'); ?></th>
        </tr>
    </thead>

    <tbody>
        <?php
        $counter        = 1;
        $serializedData = $purchase_items['items'];
        $itemArray = unserialize($serializedData);

        foreach ($itemArray as $row) { 
            $item_name = $this->db->get_where('item', array('id' => $row['item_id']))->row()->model; 
            ?>
            <tr>
                <td><?php echo $counter++; ?></td>
               <td><?php echo $item_name; ?></td>
                <td><?php echo $row['item_quantity']; ?></td>
                <td><?php echo $row['item_batch']; ?></td>
                <td><?php echo $row['item_price']; ?></td>
                <td><?php echo $row['item_amount']; ?></td>
              
            </tr>
        <?php } ?>
    </tbody>
</table>

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
          columns: [0, 1, 2, 3, 4, 5],
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
          columns: [0, 1, 2, 3, 4, 5],
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
          columns: [0, 1, 2, 3, 4, 5],
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