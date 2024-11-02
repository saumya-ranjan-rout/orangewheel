<!--Added on 12-06-2023-->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<!--Added on 12-06-2023-->
<table class="table table-bordered table-striped datatable" id="table-2">
    <thead>
        <tr>
            <th><?php echo get_phrase('item_name'); ?></th>
            <th><?php echo get_phrase('category'); ?></th>
            <th><?php echo get_phrase('supplier'); ?></th>
            <th><?php echo get_phrase('initial_quantity'); ?></th>
            <th><?php echo get_phrase('total_purchase_quantity'); ?></th>
            <th><?php echo get_phrase('total_issued_to_patient'); ?></th>
            <th><?php echo get_phrase('available_quantity'); ?></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($item_info as $row) {
            $item_id = $row['id'];
            $purchase_quantity = 0;
            $supplier_ids = array();
            $this->db->select('purchase.*');
            $this->db->from('purchase');
            $query = $this->db->get();
            $purchases = $query->result_array();
            foreach ($purchases as $purchase) {
                $array = unserialize($purchase['items']);
                foreach ($array as $item) {
                    if ($item['item_id'] == $item_id) {
                        $purchase_quantity += $item['item_quantity'];
                        if (!in_array($purchase['supplier_id'], $supplier_ids)) {
                            array_push($supplier_ids, $purchase['supplier_id']);
                        }
                    }
                }
            }

            $item_issue_quantity = 0;
            $this->db->select('patient_item_issue.*');
            $this->db->from('patient_item_issue');
            $query2 = $this->db->get();
            $issues = $query2->result_array();
            foreach ($issues as $issue) {
                $array = json_decode($issue['models']);
                foreach ($array as $item) {
                    if ($item->model_id == $item_id) {
                        $item_issue_quantity += $item->quantity;
                    }
                }
            }
            $initial_quantity = $row['quantity'];
            $available_quantity =  $initial_quantity +  $purchase_quantity - $item_issue_quantity;

            $this->db->select('item_supplier.*,GROUP_CONCAT(item_supplier) AS supplier_names');
            $this->db->from('item_supplier');
            if (!empty($supplier_ids))
                $this->db->where_in('id', $supplier_ids);
            else
                $this->db->where('id', 0);
            $this->db->where('is_active', 'Y');
            $query3 = $this->db->get();
            $result4 = $query3->row_array();
        ?>
            <tr>
                <td><?php echo $row['model']; ?></td>
                <td><?php echo $row['item_category']; ?></td>
                <td><?php echo $result4['supplier_names']; ?></td>
                <td><?php echo $row['quantity']; ?></td>
                <td><?php echo $purchase_quantity; ?></td>
                <td><?php echo $item_issue_quantity; ?></td>
                <td><?php echo $available_quantity; ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<script>
    $(document).ready(function() {
        $('#table-2').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',

            ]
        });
    });
</script>
<script type="text/javascript">
    /*jQuery(window).load(function() {
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
    });*/
</script>