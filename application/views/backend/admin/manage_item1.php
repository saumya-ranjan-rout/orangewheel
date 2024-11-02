<button onclick="showAjaxModal('<?php echo site_url('modal/popup/add_item'); ?>');" class="btn btn-primary pull-right">
    <i class="fa fa-plus"></i>&nbsp;<?php echo get_phrase('add_item'); ?>
</button>
<div style="clear:both;"></div>
<br>
<table class="table table-bordered table-striped datatable" id="table-2">
    <thead>
        <tr>  <th><?php echo get_phrase('serial_no'); ?></th>
            <th><?php echo get_phrase('model'); ?></th>
          
            <th><?php echo get_phrase('category'); ?></th>
            <th><?php echo get_phrase('sub_category'); ?></th>
            <th><?php echo get_phrase('unit'); ?></th>
            <th><?php echo get_phrase('price'); ?></th>
            <th><?php echo get_phrase('available_quantity'); ?></th>
            <th><?php echo get_phrase('other_details'); ?></th>
            <th><?php echo get_phrase('options'); ?></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($item_info as $row) {
            // $item_id = $row['id'];
            // $this->db->select('item_stock.*, SUM(quantity) AS total_stock');
            // $this->db->from('item_stock');
            // $this->db->group_by('item_id');
            // $this->db->where('item_id', $item_id);
            // $this->db->where('is_active', 'Y');
            // $query = $this->db->get();
            // $result1 = $query->row_array();

            // $this->db->select('item_issue.*, SUM(quantity) AS total_issue');
            // $this->db->from('item_issue');
            // $this->db->group_by('item_id');
            // $this->db->where('item_id', $item_id);
            // $this->db->where('is_active', 'Y');
            // $this->db->where('is_returned', 0);
            // $query = $this->db->get();
            // $result2 = $query->row_array();

            // $this->db->select('patient_item_issue.*, SUM(quantity) AS total_patient_issue');
            // $this->db->from('patient_item_issue');
            // $this->db->group_by('item_id');
            // $this->db->where('item_id', $item_id);
            // $this->db->where('is_active', 'Y');
            // $query = $this->db->get();
            // $result3 = $query->row_array();

            // $available_quantity = $result1['total_stock'] - $result2['total_issue'] - $result3['total_patient_issue'];
        ?>
            <tr>
                <!-- <td><img src="<?php echo $this->crud_model->get_image_url('item', $row['id']); ?>" class="img-circle" width="40px" height="40px"></td> -->
                 <td><?php echo $row['serial_no'] ?></td>
                <td><?php echo $row['model'] ?></td>
               
                <td><?php echo $row['item_category'] ?></td>
                <td><?php $item_subcategory = $this->db->get_where('item_subcategory', array('item_id' => $row['item_sub_category_id']))->row()->item_subcategory;
                    echo $item_subcategory; ?></td>
                <td><?php $unit_name = $this->db->get_where('unit', array('unit_id' => $row['unit']))->row()->unit_name;
                    echo $unit_name; ?></td>
                <td><?php echo $row['unit_price'] ?></td>
                <td><?php echo $row['quantity'] ?></td>
                <td>
                    <?php
                    $warranty = $this->db->get_where('warranty', array('id' => $row['warranty_id']))->row();
 $ww=$warranty->name;
$year_month = $warranty->year_month;

if ($year_month == 'Y') {
    if ($year_month > '1') {
        $cc = 'Years';
    } else {
        $cc = 'Year';
    }
} else if($year_month == 'M') {
    if ($year_month > '1') {
        $cc = 'Months';
    } else {
        $cc = 'Month';
    }
}else {
                    
               $cc='';
                 
                  
           }

                    
                    ?>
                    
                    <?php if ($row['item_category'] == 'Accessories') {
                        echo "Signia # ".$row['model'] ."(" . $row['additional_name'].")";
                    } else {
                        echo "Type : " . $row['type'];
                        echo "<br>Channel : " . $row['channel'];
                        echo "<br>Fitting Range : " . $row['fitting_range'];
                        echo "<br>L/R : " . $row['lr'];
                        echo "<br>Warrenty : " . $ww.' '.$cc;
                    }
                    ?>


                </td>
                <td>
                    <a onclick="showAjaxModal('<?php echo site_url('modal/popup/edit_item/' . $row['id']); ?>');" class="btn btn-info btn-sm">
                        <i class="fa fa-pencil"></i>&nbsp;
                        <?php echo get_phrase('edit'); ?>
                    </a>
                    <a onclick="confirm_modal('<?php echo site_url('admin/item/delete/' . $row['id']); ?>')" class="btn btn-danger btn-sm">
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