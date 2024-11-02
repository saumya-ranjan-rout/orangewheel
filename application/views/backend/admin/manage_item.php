<?php
if ($this->input->post()) {
    // $item_category = $item_category;
    // $item_subcategory = $item_subcategory;
    $item_category_name = $this->db->get_where('item_category', array('id' => $post_item_category))->row()->item_category;
    if ($post_item_subcategory == '') {
        $filtereditem_info = array_filter($item_info, function ($row) use ($post_item_category) {
            $rowcategory = $row['item_category_id'];
            return ($rowcategory == $post_item_category);
        });
        $item_subcategory_name = "";
    } else {
        $filtereditem_info = array_filter($item_info, function ($row) use ($post_item_category, $post_item_subcategory) {
            $rowcategory = $row['item_category_id'];
            $rowsubcategory = $row['item_sub_category_id'];
            return ($rowcategory == $post_item_category && $rowsubcategory == $post_item_subcategory);
        });
        $item_subcategory_name = "<b style=\"color:#818da1;\"> And </b>" . $this->db->get_where('item_subcategory', array('item_id' => $post_item_subcategory))->row()->item_subcategory;
    }
} else {
    $filtereditem_info = $item_info;
}
?>
<div class="row">
    <form action="<?php echo site_url('admin/item'); ?>" method="post" enctype="multipart/form-data">
        <div class="col-md-3" id="fromdate">
            <div class="form-group">
                <label class="control-label" style="margin-bottom: 11px;">Item Category <span style="color:red">*</span></label>
                <select name="item_category" id="item_category" class="form-control" onchange="get_item_subcategory()" required>
                    <option value=""><?php echo get_phrase('Select Category'); ?></option>
                    <?php foreach ($item_category as $row) { ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['item_category']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="col-md-3" id="todate">
            <div class="form-group">
                <label class="control-label" style="margin-bottom: 11px;">Item SubCategory</label>
                <select name="item_subcategory" id="item_subcategory" class="form-control">
                    <option value=""><?php echo get_phrase('Select Subcategory'); ?></option>

                </select>
            </div>
        </div>

        <div class="col-md-3" style="margin-top: 30px;">
            <button type="submit" class="btn btn-info">Search</button>
        </div>
    </form>
</div>
<div style="clear:both;"></div>
<div align="center">
    <?php
    if ($this->input->post()) {
    ?>
        <h4 style="color:#818da1;">Showing Results For <span style="color:#14b914"><?php echo  $item_category_name; ?></span><span style="color:#14b914"><?php echo $item_subcategory_name; ?></span></h4>
    <?php } else { ?>
        <h4 style="color:#818da1;">Showing Results For <span style="color:#14b914">All</span> </h4>
    <?php  }


    ?>
</div>
<br><button onclick="showAjaxModal('<?php echo site_url('modal/popup/add_item'); ?>');" class="btn btn-primary pull-right">
    <i class="fa fa-plus"></i>&nbsp;<?php echo get_phrase('add_item'); ?>
</button>
<div style="clear:both;"></div>
<br>
<table class="table table-bordered  datatable" id="table-2">
    <!-- table-striped -->
    <thead>
        <tr>
            <!-- <th><?php echo get_phrase('serial_no'); ?></th> -->
            <th><?php echo get_phrase('model'); ?></th>

            <th><?php echo get_phrase('category'); ?></th>
            <th><?php echo get_phrase('sub_category'); ?></th>
            <th><?php echo get_phrase('unit'); ?></th>
            <th>Serial No - <?php echo get_phrase('price'); ?></th>
            <!-- <th>New Price</th> -->
            <th><?php echo get_phrase('available_quantity'); ?></th>
            <th><?php echo get_phrase('other_details'); ?></th>
            <th><?php echo get_phrase('options'); ?></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($filtereditem_info as $row) {
            $item_id = $row['id'];
            $purchase_quantity = 0;
            $this->db->select('purchase.*');
            $this->db->from('purchase');
            $query = $this->db->get();
            $purchases = $query->result_array();
            foreach ($purchases as $purchase) {
                $array = unserialize($purchase['items']);
                foreach ($array as $item) {
                    if ($item['item_id'] == $item_id) {
                        $purchase_quantity += $item['item_quantity'];
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
            // $available_quantity =  $initial_quantity +  $purchase_quantity - $item_issue_quantity;
            $available_quantity =  $initial_quantity +  $purchase_quantity;

        
            if ($row['demo'] == 1) {
                $style = "background-color: #D9FFFE";
            } else {
                $style = "background-color: #FFFFFF"; // Default background color if demo is not 1
            }
            ?>
            <tr style="<?php echo $style; ?>">
                <!-- <td><img src="<?php echo $this->crud_model->get_image_url('item', $row['id']); ?>" class="img-circle" width="40px" height="40px"></td> -->
                <!-- <td><?php echo $row['serial_no'] ?></td> -->
                <td><?php echo $row['model'] ?></td>

                <td><?php echo $row['item_category'] ?></td>
                <td><?php $item_subcategory = $this->db->get_where('item_subcategory', array('item_id' => $row['item_sub_category_id']))->row()->item_subcategory;
                    echo $item_subcategory; ?></td>
                <td><?php $unit_name = $this->db->get_where('unit', array('unit_id' => $row['unit']))->row()->unit_name;
                    echo $unit_name; ?></td>
                <td>
    <?php
    // Fetch all rows from item_price_details based on item_id
    $item_prices = $this->db->get_where('item_price_details', array('item_id' => $row['id']))->result_array();

    // Iterate over each row and display the data
    foreach ($item_prices as $price) {
        echo $price['sl_no'] . ' - ' . $price['unit_price'] . '<br>'; // Display sl_no and unit_price
    }
    ?>
</td>

                <!-- <td><?php echo $row['new_price'] ?></td> -->
                <td><?php  foreach ($item_prices as $price) {
       echo $price['sl_no'] . ' - ' . $price['quantity'] . '<br>'; // Display sl_no and quantity
    }?></td>
                <td>
                    <?php
                    $warranty = $this->db->get_where('warranty', array('id' => $row['warranty_id']))->row();
                    $ww = $warranty->name;
                    $year_month = $warranty->year_month;

                    if ($year_month == 'Y') {
                        if ($year_month > '1') {
                            $cc = 'Years';
                        } else {
                            $cc = 'Year';
                        }
                    } else if ($year_month == 'M') {
                        if ($year_month > '1') {
                            $cc = 'Months';
                        } else {
                            $cc = 'Month';
                        }
                    } else {

                        $cc = '';
                    }


                    ?>

                    <?php if ($row['item_category'] == 'Accessories') {
                        echo "Signia # " . $row['model'] . "(" . $row['additional_name'] . ")";
                    } else {
                        echo "Type : " . $row['type'];
                        echo "<br>Channel : " . $row['channel'];
                        echo "<br>Fitting Range : " . $row['fitting_range'];
                        echo "<br>L/R : " . $row['lr'];
                        echo "<br>Warrenty : " . $ww . ' ' . $cc;
                    }
                    ?>


                </td>
                <td>
                    <a href="<?php echo site_url('admin/change_price/'.$row['id']);?>" class="btn btn-success btn-sm">
                        &#8377;&nbsp;
                        <?php echo 'Add Price'; ?>
                    </a>
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
    function get_item_subcategory() {
        var item_category_id = $('#item_category').val();
        // alert(item_category_id);

        $.ajax({
            url: '<?php echo site_url("admin/item_categorywise_subcategory"); ?>',
            method: 'POST',
            data: {
                item_category_id: item_category_id
            },
            dataType: 'json',
            success: function(response) {
                //alert(response);
                $('#item_subcategory').html(response.arr);
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }




    jQuery(document).ready(function() {
        var $ = jQuery;

        var table = $("#table-2").DataTable({
            "sPaginationType": "bootstrap",
            "dom": "<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'B>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>",
            buttons: [{
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
                }, {
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