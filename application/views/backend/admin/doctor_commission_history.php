<style>
.search-input {
  
  background-position: 10px 10px;
  background-repeat: no-repeat;
  width: 100%;
  font-size: 16px;
  padding: 12px 20px 12px 40px;
  border: 1px solid #ddd;
  margin-bottom: 12px;
}
</style>
 

<div class="row">

    <div class="col-md-12">

     

        <div class="tab-content">
            
            <div class="tab-pane active" id="prescription" style="overflow-x:auto;">
                <br>
             

              <style>
.search-input {
  
  background-position: 10px 10px;
  background-repeat: no-repeat;
  width: 100%;
  font-size: 16px;
  padding: 12px 20px 12px 40px;
  border: 1px solid #ddd;
  margin-bottom: 12px;
}
</style>

<div style="clear:both;"></div>




<br>
<div class="row">
   <center>  <h4 style="color:#818da1;">Showing Results for <span style="color:red"><?php echo $referred_by; ?> </span></h4></center> 
     
     
 <div class="col-md-6">

     

        <div class="tab-content">
            
            <div class="tab-pane active" id="prescription" style="overflow-x:auto;">
                <br>
     
           <h4 style="color:#818da1;">Showing Results for <span style="color:red"><?php echo 'Diagnosis'; ?> </span></h4>
    <table class="table table-bordered" id="myTable">
     

    
    <thead>
        <tr>
           
            <th style="background-color: #AAA8A8;color:white;"><?php echo get_phrase('name'); ?></th>
            <th style="background-color: #AAA8A8;color:white;"><?php echo get_phrase('phone'); ?></th>
            <th style="background-color: #AAA8A8;color:white;"><?php echo get_phrase('diagnosis'); ?></th>
            <th style="background-color: #AAA8A8;color:white;"><?php echo get_phrase('grand_total'); ?></th>
           
        </tr>
    </thead>
    <tbody>
         <?php if (empty($diag)) { ?>
            <!-- Message to display when no data is available -->
            <tr>
                <td colspan="4" style="text-align: center; color: red;">
                    <?php echo get_phrase('no_data_available'); ?>
                </td>
            </tr>
        <?php } else { ?>
        
        <?php   
         $cc = 0; 
        $count = 1;
        $grand_total = 0;
      
        $diagnosis_count = 0;
    
        foreach ($diag as $row) {
            $sum_total_item = 0;
            $sum_total_price = 0;
            
             $cc++;
            
        ?>   
        <tr>
  
            <td><?php echo $row['name']."[". $row['code']."]"?>
          
            
            </td>
            <td><?php echo $row['phone'] ?></td>
            <td>
                <div>                                    
                    <table style="width: 100%;">
                       <?php 
                            ?>
                            <tr>
                                <th style="text-align: center;background-color: #AAA8A8;color:white;"><?php echo get_phrase('date'); ?></th>
                               <th style="text-align: center;background-color: #AAA8A8;color:white;"><?php echo get_phrase('diagnosis'); ?></th>
                               <th style="text-align: center;background-color: #AAA8A8;color:white;"><?php echo get_phrase('qty'); ?></th>
                               <th style="text-align: center;background-color: #AAA8A8;color:white;"><?php echo get_phrase('price'); ?></th>
                              <th style="text-align: center;background-color: #AAA8A8;color:white;"><?php echo get_phrase('discount_price'); ?></th>
                           <th style="text-align: center;background-color: #AAA8A8;color:white;"><?php echo get_phrase('total_price'); ?></th>
                            <th style="text-align: center;background-color: #AAA8A8;color:white;"><?php echo 'Payment '.get_phrase('status');?></th>
                            </tr>
                     
                         
                            <?php
                       

$cons_info = $this->db->where('patient_id', $row['patient_id']);
  $cons_info = $this->db->where('status', 'Paid');          

if ($date_from != '' && $date_to != '') {

    $this->db->where("date BETWEEN '$date_from' AND '$date_to'");
}

$cons_info = $this->db->get('patient_diagnosis')->result_array();

                 ?>     
                     <!-- <input type="hidden"class="patient_diagnosis_data" id="patient_diagnosis_data<?php echo $count; ?>"value="<?php echo count($cons_info);?>">-->
<?php
  
                      foreach ($cons_info as $row1) {
                     
                        $grand_total +=$row1['sum_total_price'];
                        
 if($row1['status'] != 'Paid'){
    
    ?>

<!-- <input type="hidden" name="pat_diag_id<?php echo $row['patient_id'];?>[]"value="<?php echo $row1['id'];?>">-->
 <?php 
 }
 ?>
                              <?php $diagnosis = json_decode($row1['diagnosis_id']);
                          
                           
                            foreach ($diagnosis as $row2) {
                                $diagnosis_count++;
                            $this->db->select('diagnosis.name as diagnosis_name')->from('diagnosis');
                            $this->db->where('diagnosis.id', $row2->diagnosis_id);
                              $this->db->where('diagnosis.id', $row2->diagnosis_id);
                            $query2 = $this->db->get();
                            $diagnosis_info = $query2->row_array(); ?>
                            
                            
                                <tr style="border-bottom: 0.5px solid #DEDCDC;">
                                    <td style="text-align: center;"><?php echo $row1['date'];?> </td>                                 
                                    <td style="text-align: center;"><?php echo $diagnosis_info['diagnosis_name']; ?></td>
                                    <td style="text-align: center;"><?php echo $row2->quantity; ?></td>
                                    <td style="text-align: center;">
    <span id="patient_diagnosis_price_<?php echo $diagnosis_count; ?>" ondblclick="toggleEdit(<?php echo $diagnosis_count; ?>)">
        <?php echo $row2->diagnosis_price; ?>
    </span>
    <input type="text" class="hiddenField" id="input_patient_diagnosis_price_<?php echo $diagnosis_count; ?>" value="<?php echo $row2->diagnosis_price; ?>" style="display: none; width: 50px;" onkeyup="updateDiagnosisPrice(<?php echo $diagnosis_count; ?>,<?php echo $count; ?>)">
</td>
<td style="text-align: center;"><span id="patient_diagnosis_discountprice_<?php echo $diagnosis_count; ?>"ondblclick="togglediscountEdit(<?php echo $diagnosis_count; ?>)" ><?php if($row2->discount_price != ''){echo $row2->discount_price;} else {echo 0;}; ?></span>

<input type="text" class="hiddenField" id="input_patient_diagnosis_discountprice_<?php echo $diagnosis_count; ?>" value="<?php echo $row2->discount_price; ?>" style="display: none; width: 50px;" onkeyup="updateDiagnosisPrice(<?php echo $diagnosis_count; ?>,<?php echo $count; ?>)">
</td>




                                    <td style="text-align: center;" class="diagnosis-total"><span id="patient_diagnosis_totalprice_<?php echo $diagnosis_count; ?>" class="patient_diagnosis_totalprice_<?php echo $count; ?>"><?php echo $row2->total_price; ?></span></td>
                                    <td style="text-align: center;" class="patient_diagnosis_col<?php echo $count; ?>"> <span <?php if($row1['status'] == 'Paid'){ ?> class="badge label-success" <?php } else if($row1['status'] == 'Unpaid'){ ?> class="badge label-danger" <?php } ?>>
        <?php echo $row1['status']; ?>
    </span></td>
                                </tr>
                            
                            <?php
                     
                           
                        }
                        $sum_total_price+=$row1['sum_total_price'];
                         } ?>
                    </table>
                </div>
            </td>
            <td >
                <div class="diagnosis-grand-total" id="diagnosis-grand-total<?php echo $count; ?>">
                <?php echo number_format($sum_total_price, 2, '.', ''); ?>
             
                
                </div>
            </td>
            
        </tr>
         <?php
                $count++;
            } ?>
        <?php } ?>
    </tbody>
    
</table>
              
            </div>


        </div>
        
    </div>
    <div class="col-md-6">

     

        <div class="tab-content">
            
            <div class="tab-pane active" id="prescription" style="overflow-x:auto;">
                <br>
     
          <h4 style="color:#818da1;">Showing Results for <span style="color:red"><?php echo 'Item'; ?> </span></h4>
   <table class="table table-bordered" id="myTable">
    <thead>
        <tr>
            <th style="background-color: #AAA8A8;color:white;"><?php echo get_phrase('name'); ?></th>
            <th style="background-color: #AAA8A8;color:white;"><?php echo get_phrase('phone'); ?></th>
            <th style="background-color: #AAA8A8;color:white;"><?php echo get_phrase('items'); ?></th>
            <th style="background-color: #AAA8A8;color:white;"><?php echo get_phrase('grand_total'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($item)) { ?>
            <!-- Message to display when no data is available -->
            <tr>
                <td colspan="4" style="text-align: center; color: red;">
                    <?php echo get_phrase('no_data_available'); ?>
                </td>
            </tr>
        <?php } else { ?>
            <?php
            $cc = 0;
            $count = 1;
            $item_grand_total = 0;
            $item_count = 0;

            foreach ($item as $row) {
                $sum_total_item = 0;
                $sum_total_price = 0;
                $cc++;
            ?>
                <tr>
                    <td><?php echo $row['name'] . "[" . $row['code'] . "]"; ?></td>
                    <td><?php echo $row['phone']; ?></td>
                    <td>
                        <div>
                            <table style="width: 100%;">
                                <tr>
                                    <th style="text-align: center;background-color: #AAA8A8;color:white;"><?php echo get_phrase('invoice_no'); ?>/<br> <?php echo get_phrase('challan_no'); ?></th>
                                    <th style="text-align: center;background-color: #AAA8A8;color:white;">Date</th>
                                    <th style="text-align: center;background-color: #AAA8A8;color:white;"><?php echo get_phrase('model'); ?></th>
                                    <th style="text-align: center;background-color: #AAA8A8;color:white;"><?php echo get_phrase('qty'); ?></th>
                                    <th style="text-align: center;background-color: #AAA8A8;color:white;"><?php echo get_phrase('price'); ?></th>
                                    <th style="text-align: center;background-color: #AAA8A8;color:white;"><?php echo get_phrase('discount'); ?></th>
                                    <th style="text-align: center;background-color: #AAA8A8;color:white;"><?php echo get_phrase('tax'); ?></th>
                                    <th style="text-align: center;background-color: #AAA8A8;color:white;"><?php echo get_phrase('total_price'); ?></th>
                                    <th style="text-align: center;background-color: #AAA8A8;color:white;"><?php echo 'Payment ' . get_phrase('status'); ?></th>
                                </tr>

                                <?php
                                // Fetching patient issues
                                $patient_issues = $this->db->where('patient_id', $row['patient_id'])
                                    ->where('status', 'Paid')
                                    ->where('issue_type', 'invoice');

                                if ($date_from != '' && $date_to != '') {
                                    $this->db->group_start();
                                    $this->db->where("(issue_type = 'invoice' AND invoice_date BETWEEN '$date_from' AND '$date_to')");
                                    $this->db->group_end();
                                }

                                $patient_issues = $this->db->get('patient_item_issue')->result_array();
                                ?>

                              <!--  <input type="hidden" class="patient_item_issue_data" id="patient_item_issue_data<?php echo $count; ?>" value="<?php echo count($patient_issues); ?>">-->
                                <?php foreach ($patient_issues as $row3) { 
                                    $item_grand_total += $row3['grand_total'];
                                    $models = json_decode($row3['models']);
                                    $count_model = count($models);
                                    foreach ($models as $index => $row4) {
                                        $item_count++;
                                ?>
                                        <tr style="border-bottom: 0.5px solid #DEDCDC;">
                                            <?php if ($index == 0) { ?>
                                                <td rowspan="<?php echo $count_model; ?>"><?php echo $row3['bill_no']; ?></td>
                                                <td rowspan="<?php echo $count_model; ?>"><?php echo $row3['invoice_date']; ?></td>
                                            <?php } ?>
                                            <td style="text-align: center;"><?php echo $this->db->get_where('item', ['id' => $row4->model_id])->row()->model; ?></td>
                                            <td style="text-align: center;"><?php echo $row4->quantity; ?></td>
                                            <td style="text-align: center;"><span id="patient_item_price_<?php echo $item_count; ?>" ondblclick="toggleEdititem(<?php echo $item_count; ?>)"><?php echo $row4->price; ?></span></td>
                                            <td style="text-align: center;"><span id="patient_item_discountprice_<?php echo $item_count; ?>" ondblclick="togglediscountEdititem(<?php echo $item_count; ?>)"><?php echo $row4->discount ?: 0; ?></span></td>
                                            <td style="text-align: center;"><span id="patient_item_taxprice_<?php echo $item_count; ?>"><?php echo $row4->tax; ?></span></td>
                                            <td style="text-align: center;" class="item-total"><span id="patient_item_totalprice_<?php echo $item_count; ?>" class="patient_item_totalprice_<?php echo $count; ?>"><?php echo $row4->total_price; ?></span></td>
                                            <td style="text-align: center;" class="patient_itemissue_col<?php echo $count; ?>"><span class="<?php echo ($row3['status'] == 'Paid') ? 'badge label-success' : 'badge label-danger'; ?>"><?php echo $row3['status']; ?></span></td>
                                        </tr>
                                <?php }
                                } ?>
                            </table>
                        </div>
                    </td>
                    <td>
                        <div class="item-grand-total" id="item-grand-total<?php echo $count; ?>">
                            <?php echo number_format($sum_total_item, 2, '.', ''); ?>
                        </div>
                    </td>
                </tr>
            <?php
                $count++;
            } ?>
        <?php } ?>
    </tbody>
</table>

              
            </div>


        </div>
        
    </div>
     
    
</div>

            </div>


        </div>
        
    </div>
    
</div>
<!-- Add this script to handle form submission -->
