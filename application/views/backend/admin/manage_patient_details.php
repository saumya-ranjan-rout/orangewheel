<?php $patient_info = $this->db->get('patient')->result_array();
?>
<div class="panel panel-primary" data-collapsed="0">

    <!-- <div class="panel-heading">
        <div class="panel-title">
            <h3><?php echo 'Change Price'; ?></h3>
        </div>
    </div> -->

    <div class="panel-body">
    <form role="form" class="form-horizontal form-groups" method="POST" enctype="multipart/form-data">
        <!-- action="<?php echo site_url('admin/create_patient_details/create'); ?>" -->
      
            <div class="row" style="margin-top: 10px;">
                <!-- <input type="hidden" name="patient_id" class="form-control" value="<?php echo $item_id; ?>" id="field-1" readonly required> -->

                <div class="col-sm-3">
                    <label><?php echo get_phrase('patient'); ?> <small style="color:red;">*</small></label>
                    <select name="patient_id" id="patient_id" class="form-control select2">
                        <option value=""><?php echo get_phrase('select_patient'); ?></option>
                        <?php foreach ($patient_info as $row) { ?>
                            <option value="<?php echo $row['patient_id']; ?>"><?php echo $row['name']; ?>[<?php echo $row['code']; ?>]</option>
                        <?php } ?>
                    </select>
                </div>

                <div class="col-sm-1">
                    <label>&nbsp;</label> <!-- Placeholder label for proper alignment -->
                    <button id='submit_button' type="submit" name="submit" class="btn btn-success btn-block">
                        <i class="fa fa-check"></i> &nbsp; <?php echo get_phrase('submit'); ?>
                    </button>
                </div>
            </div>
       
    </form>
</div>


</div>
<?php 
        if (isset($_POST['submit'])) {
        ?>
<div class="panel panel-primary" data-collapsed="0">
    <!-- <div class="panel-heading">
        <div class="panel-title">
            <h3><?php echo 'Price Details'; ?></h3>
        </div>
    </div> -->

    <div class="tab-pane active" id="prescription" style="overflow-x:auto;">
        <br>
        <!-- <div class="col-sm-6">
                    <input type="text" id="myInput" class="search-input" onkeyup="applyTableSearch('myTable', 'myInput')" placeholder="Search for dates.." title="Type in a dates">
</div> -->
       
      <center>  
<h3>Showing Item Issue (Invoice) details of Patient<b style="color:green"> <?php 
 $patient_data = $this->db->select('name, code')->where('patient_id', $_POST['patient_id'])->get('patient')->row_array();

    echo $patient_name = $patient_data['name'].'['.$patient_data['code'].']';
 ?> </b></h3>
</center>  
<br><br>
        <table class="table table-bordered" id="myTable4"><!--id="table-4"-->
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
            <th><?php echo get_phrase('status'); ?></th>
            <th><?php echo get_phrase('options'); ?></th>
                        </tr>
                    </thead>

                    <tbody>
        <?php
        $counter        = 1;
        $patient_id = $_POST['patient_id'];      
        $this->db->order_by('id', 'desc');
$this->db->where('issue_type', 'invoice');
$this->db->where('sales_return', 'delivered');
$this->db->where('patient_id', $patient_id);
$patient_issues = $this->db->get('patient_item_issue')->result_array();
       // $patient_issues = $this->db->where('issue_type', $list)->get('patient_item_issue')->result_array();
       if (!empty($patient_issues)) {
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
                <td><?php echo $row['grand_total']; ?></td>
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
            <a href="<?php echo site_url('admin/sales_return_list/sales_return_create/' . $row['id']); ?>" class="btn btn-primary">
  <i class="fa fa-pencil"></i> <?php echo 'SR'; ?> </a>
                                   
                </td>
            </tr>
        <?php } 
        } else {
            // If no patient issues found, display a message
            echo "<tr><td colspan='8' style='text-align: center;'>No data available.</td></tr>";
        }
        ?>
    </tbody>
                </table>
               

    </div>
</div>
<?php 
        }   
                ?>