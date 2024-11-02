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
<?php 
$referred_by=$referred_by['referred_by '];
//  $patient_id=$patient_id['patient_id '];

//$patient_id='1';
$nurse_id    = $this->session->userdata('login_user_id'); ?>
<div style="clear:both;"></div>




<br>
<div class="row">

    <div class="col-md-12">

        <!-- <ul class="nav nav-tabs bordered">
            <li class="active">
                <a href="#prescription" data-toggle="tab">
                    <span class="visible-xs"><i class="entypo-home"></i></span>
                    <span class="hidden-xs"><?php echo get_phrase('prescription');?></span>
                </a>
            </li>
            <li>
                <a href="#diagnosis" data-toggle="tab">
                    <span class="visible-xs"><i class="entypo-user"></i></span>
                    <span class="hidden-xs"><?php echo get_phrase('diagnosis');?></span>
                </a>
            </li>
            <li>
                <a href="#charges" data-toggle="tab">
                    <span class="visible-xs"><i class="entypo-user"></i></span>
                    <span class="hidden-xs"><?php echo get_phrase('charges');?></span>
                </a>
            </li>
             <li>
                <a href="#item_history" data-toggle="tab">
                    <span class="visible-xs"><i class="entypo-user"></i></span>
                    <span class="hidden-xs"><?php echo get_phrase('item_history');?></span>
                </a>
            </li>
        </ul> -->

        <div class="tab-content">
            
            <div class="tab-pane active" id="prescription" style="overflow-x:auto;">
                <br>
                <div class="col-sm-6">
                    <input type="text" id="myInput" class="search-input" onkeyup="applyTableSearch('myTable', 'myInput')" placeholder="Search for dates.." title="Type in a dates">
</div>
<div class="col-sm-6">
</div>

                <table class="table table-bordered " id="myTable" ><!--id="table-1"-->
                <thead>
                        <tr>
                            <th style="background-color: #AAA8A8;color:white;"><?php echo get_phrase('name'); ?></th>
                            <th style="background-color: #AAA8A8;color:white;"><?php echo get_phrase('phone'); ?></th>
                            <!-- <th><?php echo get_phrase('date'); ?></th> -->
                            <th style="background-color: #AAA8A8;color:white;"><?php echo get_phrase('diagnosis'); ?></th>                            
                            <th style="background-color: #AAA8A8;color:white;"><?php echo get_phrase('grand_total'); ?></th>
                          
                            <th style="background-color: #AAA8A8;color:white;"><?php echo get_phrase('models'); ?></th>
                            <!-- <th style="background-color: #0099FF;"><?php echo get_phrase('sum_total'); ?></th>
                            <th style="background-color: #0099FF;"><?php echo get_phrase('discount'); ?></th>
                            <th style="background-color: #0099FF;"><?php echo get_phrase('tax'); ?></th> -->
                            <th style="background-color: #AAA8A8;color:white;"><?php echo get_phrase('grand_total'); ?></th>                            
                        </tr>
                    </thead>

                    
                    <tbody>
                        <?php                        
                        $count = 1;
                        $grand_total = 0;
                        $item_grand_total = 0;
                        foreach ($doctor_info as $row) {
                            $sum_total_item=0;
                             $sum_total_price=0;
                        ?>   
                            <tr>
                                <td><?php echo $row['name']."[". $row['code']."]"?></td>
                                <td><?php echo $row['phone'] ?></td>                                 
                                <td><div>                                    
                        <table style="width: 100%;">
                        <?php if($count==1){
                            ?>
                            <tr>
                                <td style="text-align: center;background-color: #AAA8A8;color:white;"><?php echo get_phrase('date'); ?></td>
                                <td style="text-align: center;background-color: #AAA8A8;color:white;"><?php echo get_phrase('diagnosis'); ?></td>
                                <td style="text-align: center;background-color: #AAA8A8;color:white;"><?php echo get_phrase('quantity'); ?></td>
                                <td style="text-align: center;background-color: #AAA8A8;color:white;"><?php echo get_phrase('price'); ?></td>
                                <td style="text-align: center;background-color: #AAA8A8;color:white;"><?php echo get_phrase('discount_price'); ?></td>
                                <td style="text-align: center;background-color: #AAA8A8;color:white;"><?php echo get_phrase('total_price'); ?></td>
                            </tr>
                     
                         
                            <?php
                        }
                       
                        $cons_info    = $this->db->get_where('patient_diagnosis', array('patient_id' => $row['patient_id']))->result_array();                                   
                        foreach ($cons_info as $row1) {
                        $grand_total +=$row1['sum_total_price'];


                            $diagnosis = json_decode($row1['diagnosis_id']);
                            foreach ($diagnosis as $row2) {
                            $this->db->select('diagnosis.name as diagnosis_name')->from('diagnosis');
                            $this->db->where('diagnosis.id', $row2->diagnosis_id);
                            $query2 = $this->db->get();
                            $diagnosis_info = $query2->row_array(); ?>
                                <tr style="border-bottom: 0.5px solid #DEDCDC;">
                                    <td style="text-align: center;"><?php echo $row1['date'];?></td>                                 
                                    <td style="text-align: center;"><?php echo $diagnosis_info['diagnosis_name']; ?></td>
                                    <td style="text-align: center;"><?php echo $row2->quantity; ?></td>
                                    <td style="text-align: center;"><?php echo $row2->diagnosis_price; ?></td>  
                                    <td style="text-align: center;"><?php echo $row2->discount_price; ?></td>
                                    <td style="text-align: center;"><?php echo $row2->total_price; ?></td>
                                </tr>
                            
                            <?php
                        }
                        $sum_total_price+=$row1['sum_total_price'];
                         } ?>
                        </table>
                            </div></td>                    
                                  <td><?php echo number_format($sum_total_price, 2, '.', ''); ?></td>
                                 
                                  
                                  <td>
                        <div>
                        <table style="width: 100%;">
                        <?php if($count==1){
                            ?>
                            <tr>
                            <td style="text-align: center;background-color: #AAA8A8;color:white;"><?php echo get_phrase('invoice_no'); ?>/<br> <?php echo get_phrase('challan_no'); ?></td>
                                <td style="text-align: center;background-color: #AAA8A8;color:white;"><?php echo get_phrase('model'); ?></td>
                                <td style="text-align: center;background-color: #AAA8A8;color:white;"><?php echo get_phrase('quantity'); ?></td>
                                <td style="text-align: center;background-color: #AAA8A8;color:white;"><?php echo get_phrase('price'); ?></td>
                                <td style="text-align: center;background-color: #AAA8A8;color:white;"><?php echo get_phrase('discount'); ?></td>
                                <td style="text-align: center;background-color: #AAA8A8;color:white;"><?php echo get_phrase('tax'); ?></td>
                                <td style="text-align: center;background-color: #AAA8A8;color:white;"><?php echo get_phrase('total_price'); ?></td>
                            </tr>
                     
                    
                            <?php
                        }
                     
                            $sum_total_item=0;
                            $patient_issues = $this->db->get_where('patient_item_issue', array('patient_id'=> $row['patient_id']))->result_array();
                            foreach ($patient_issues as $row3) { ?>                   
                            <?php 
                            $item_grand_total +=$row3['grand_total'];

                            $models      = json_decode($row3['models']);
                            $rw=1;
                            $count_model = count($models);
                            foreach ($models as $row4) { 
                                if($rw==1){
                                ?>

                                <tr style="border-bottom: 0.5px solid #DEDCDC;">
                              <td rowspan="<?php echo $count_model; ?>"><?php echo $row3['bill_no']; ?></td>
                              <td style="text-align: center;">
                                        <?php
                                        $model_info = $this->db->get_where('item', array('id' => $row4->model_id))->row();
                                        echo $model_info->model; ?>
                                    </td>
                                    <td style="text-align: center;"><?php echo $row4->quantity; ?></td>
                                    <td style="text-align: center;"><?php echo $row4->price; ?></td>
                                    <td style="text-align: center;">
                                        <?php echo $row4->discount;
                                        ?>
                                    </td>
                                    <td style="text-align: center;">
                                        <?php echo $row4->tax;
                                       ?>
                                    </td>
                                    <td style="text-align: center;"><?php echo $row4->total_price; ?></td>
                                </tr>                                                             
                               <?php }
                               else{
                               ?>

                                <tr style="border-bottom: 0.5px solid #DEDCDC;">
                                <!-- <td ><?php echo $row3['bill_no']; ?></td> -->
                                    <td style="text-align: center;">
                                        <?php
                                        $model_info = $this->db->get_where('item', array('id' => $row4->model_id))->row();
                                        echo $model_info->model; ?>
                                    </td>
                                    <td style="text-align: center;"><?php echo $row4->quantity; ?></td>
                                    <td style="text-align: center;"><?php echo $row4->price; ?></td>
                                    <td style="text-align: center;">
                                        <?php echo $row4->discount;
                                        ?>
                                    </td>
                                    <td style="text-align: center;">
                                        <?php echo $row4->tax;
                                       ?>
                                    </td>
                                    <td style="text-align: center;"><?php echo $row4->total_price; ?></td>
                                </tr>
                      
                            <?php 
}
                            $rw++;
                        } 
                            $sum_total_item+=$row3['grand_total'];
                             } ?>
                        </table>
                        </div>
                                  </td>
                                  <td><?php echo number_format($sum_total_item, 2, '.', ''); ?></td>
                                  <!-- <td>
                                  <?php
                                    // if ($row3['discount_type'] == 'fixed') {
                                    //     echo $row3['discount_value'];
                                    // } else if ($row3['discount_type'] == 'percentage') {
                                    //     echo ($row3['total_amount'] * $row3['discount_value']) / 100;
                                    // } else {
                                    //     echo "-";
                                    // }
                                    ?>
                                  </td>
                                  <td><?php //echo $row3['tax_per'];
                                    // if ($row3['tax_per'] > 0) echo '%'; ?>
                                  </td>
                                  <td><?php //echo $row3['grand_total'];?></td> -->
                                 
                            </tr>
                        <?php
                     
                        $count++;
                        }?>
                    </tbody>
                    <tfoot>
        <tr>
            <td style=" border-right-style:hidden"></td>
            <td style=" border-right-style:hidden"></td>
         
            <td style="border-left-style:hidden;text-align:right;font-weight:bold;color:#000">Diagnosis Grand Total :</td>
            <td style="font-weight:bold;color:#000"><?php echo ("Rs. " . number_format($grand_total, 2, '.', '')); ?>
            <td style="border-left-style:hidden;text-align:right;font-weight:bold;color:#000">Item Grand Total :</td>
            <td style="font-weight:bold;color:#000"><?php echo ("Rs. " . number_format($item_grand_total, 2, '.', '')); ?></td>
     
       
         
          
            </td>
        </tr>
    </tfoot>                
                </table>
            </div>


            <!-- table end -->
            
            <div class="tab-pane" id="diagnosis" style="overflow-x:auto;">
                   
                    
                    <br>
                <div class="col-sm-6">
                     <input type="text" id="myInput2" class="search-input" onkeyup="applyTableSearch('myTable2', 'myInput2')" placeholder="Search for dates.." title="Type in a dates">

                    
</div>
<div class="col-sm-6">
</div>



                <table class="table table-bordered" id="myTable2"><!--id="table-2"-->
                    <thead>
                        <tr>
                              <th><?php echo get_phrase('date'); ?></th>
                            <th><?php echo get_phrase('diagnosis'); ?></th>
                             <!-- <th><?php echo get_phrase('qty'); ?></th>
                            <th><?php echo get_phrase('price'); ?></th>
                            <th><?php echo get_phrase('discount_type'); ?></th>
                            <th><?php echo get_phrase('discount_price/%'); ?></th>-->
                             <th><?php echo get_phrase('total'); ?></th>
                            <th><?php echo get_phrase('options'); ?></th>
                             <th><?php echo get_phrase('upload_diagnosis'); ?></th>
                              <th><?php echo get_phrase('download_diagnosis'); ?></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $cons_info    = $this->db->get_where('patient_diagnosis', array('patient_id' => $patient_id))->result_array();
                         $count = 1;
                        $grand_total = 0;
                        foreach ($cons_info as $row) {
                         $grand_total = $grand_total + $row['sum_total_price']; ?>   
                            <tr>
                                <td><?php echo $row['date'] ?></td>
                                <td>   <div>
                        <table style="width: 100%;">
                            <tr>
                                <td style="text-align: center;"><?php echo get_phrase('diagnosis'); ?></td>
                                <td style="text-align: center;"><?php echo get_phrase('quantity'); ?></td>
                                <td style="text-align: center;"><?php echo get_phrase('price'); ?></td>
                                <td style="text-align: center;"><?php echo get_phrase('discount_type'); ?></td>
                                 <td style="text-align: center;"><?php echo get_phrase('discount_price'); ?></td>
                                <td style="text-align: center;"><?php echo get_phrase('total_price'); ?></td>
                            </tr>
                            <tr>
                                <td colspan="6">
                                    <hr style="margin: 5px 0px;">
                                </td>
                            </tr>
                            <?php
                            $diagnosis          = json_decode($row['diagnosis_id']);
                    foreach ($diagnosis as $row2) {
                            $this->db->select('diagnosis.name as diagnosis_name')->from('diagnosis');
                        $this->db->where('diagnosis.id', $row2->diagnosis_id);
                        $query2 = $this->db->get();
                        $diagnosis_info = $query2->row_array(); ?>
                                <tr>
                                 
                                    <td style="text-align: center;"><?php echo $diagnosis_info['diagnosis_name']; ?></td>
                                    <td style="text-align: center;"><?php echo $row2->quantity; ?></td>
                                   <td style="text-align: center;"><?php echo $row2->diagnosis_price; ?></td>
                                    <td style="text-align: center;"<?php echo $row2->discount_type; ?></td>
                                     <td style="text-align: center;"><?php echo $row2->discount_price; ?></td>
                                      <td style="text-align: center;"><?php echo $row2->total_price; ?></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div></td>
                                
                                  <td><?php echo $row['sum_total_price']; ?></td>
                                <td>
                                      <a onclick="showAjaxModal('<?php echo site_url('modal/popup/diaggnosis_report_print/' . $row['patient_id'] . '/' . $row['date']); ?>');"
                           
                        class="btn btn-default btn-sm" title="Diagnosis Report Print">
                        <i class="fa fa-file"></i> &nbsp;
                        
                    </a>
                     <a onclick="confirm_modal('<?php echo site_url('admin/delete_diag/' . $row['patient_id'] . '/' . $row['id']); ?>')"
                                class="btn btn-danger btn-sm" title="Delete Diagnosis">
                                <i class="fa fa-trash-o"></i>&nbsp;
                                </a>
                            
                              <!--  <a onclick="showAjaxModal('<?php echo site_url('modal/popup/diagnosis_edit/' . $row['id']); ?>');"
                           
                        class="btn btn-info btn-sm" title="Diagnosis Edit">
                        <i class="fa fa-pencil"></i>
                        
                    </a>-->
                                </td>
                                  <td>
                         <!-- <label for="field-1" class="col-sm-3 control-label"><?php echo "Diagnosis"; ?><small style="color:red;">*</small></label>-->
                       <form method="post" enctype="multipart/form-data" action="<?php echo site_url('admin/diag_upload/'.$row['patient_id']. '/' . $row['id']); ?>">
                <input type="hidden" name="patient_id" value="<?php echo $row['patient_id']?>">
                <input type="hidden" name="patient_consultation_history_id" value="<?php echo $row['id']?>">
                <input type="hidden" name="name" value="diagnosis">
                <input type="file" name="file" accept="image/jpeg,image/jpg, image/png"required>
                <button type="submit"  class="btn btn-primary btn-sm hidden-print">
                <i class="fa fa-upload"></i>&nbsp;Upload</button>
                </form>
                                </td>
                                    <td><?php
                                 $prescription = $this->db->get_where('diagnosis_document_upload', array('diagnosis_id' => $row['id']))->result_array();  
                                 foreach ($prescription as $row1) {          

                if($row1['diagnosis_document'] != ''){
                    ?>
                    <table>
                        <tr>
                            <td width="85%">
                                <a href="<?php echo base_url('uploads/patient_image/'.$row1['id']. '_' .$row1['diagnosis_document']);?>" title="" download>
                                <i class="fa fa-download" style="color :green ;"></i></a>
                            </td>
                            <td>
                                <a onclick="confirm_modal('<?php echo site_url('admin/delete_diag_upload/' . $row1['patient_id'] . '/' . $row1['id']); ?>')"
                                title="Delete Diagnosis">
                                <i class="fa fa-trash-o" style="color : red ;"></i>&nbsp;</a>
                            </td>
                        </tr>
                    </table>
                    <?php
                }else{
                    ?>
                    <a href="#" onclick="alert('No Diagnosis file available.')">
                    <i class="fa fa-download"></i>
                    </a>
                    <?php
                }
                ?>
                <?php } ?>
                </td>
                                <!--   <td>
                                    
                                    
                         <?php 
                if($row['diagnosis_document'] != ''){
                    ?>
                    <a href="<?php echo base_url('uploads/patient_image/'.$row['diagnosis_document']);?>" class="btn btn-success btn-sm " download>
                    <i class="fa fa-download"></i>Diagnosis
                    </a>
                    <?php
                }else{
                    ?>
                    <a href="#" class="btn btn-success btn-sm " onclick="alert('No diagnosis file available.')">
                    <i class="fa fa-download"></i>Diagnosis
                    </a>
                    <?php
                }
                ?>
                
                                </td>-->
                            </tr>
                        <?php
                         $count++;
                         } ?>
                    </tbody>
                     <tfoot>
        <tr>
            <td style=" border-right-style:hidden"></td>
           
         
            <td style="border-left-style:hidden;text-align:right;font-weight:bold;color:#000">Grand Total :</td>
            <td style="font-weight:bold;color:#000"><?php echo ("Rs. " . number_format($grand_total, 2, '.', '')); ?>
            <td style=" border-right-style:hidden;border-left-style:hidden"></td>
            <td style=" border-right-style:hidden;border-left-style:hidden"></td>
            <td style=" border-right-style:hidden;border-left-style:hidden"></td>
          
            </td>
        </tr>
    </tfoot>
                </table>

            </div>
            
            <div class="tab-pane" id="charges" style="overflow-x:auto;">
                     <br>
                <div class="col-sm-6">
                     <input type="text" id="myInput3" class="search-input" onkeyup="applyTableSearch('myTable3', 'myInput3')" placeholder="Search for dates.." title="Type in a dates">

                    
</div>
<div class="col-sm-6">
</div>



                <table class="table table-bordered" id="myTable3"><!--id="table-3"-->
                    <thead>
                        <tr>
                              <th><?php echo get_phrase('date'); ?></th>
                            <th><?php echo get_phrase('name'); ?></th>
                            <th><?php echo get_phrase('price'); ?></th>
                            <th><?php echo get_phrase('discount_type'); ?></th>
                            <th><?php echo get_phrase('discount_price/%'); ?></th>
                             <th><?php echo get_phrase('total'); ?></th>
                            <th><?php echo get_phrase('options'); ?></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $cons_info    = $this->db->get_where('patient_consultation_history', array('patient_id' => $patient_id))->result_array();
                         $count = 1;
                        $grand_total = 0;
                        foreach ($cons_info as $row) {
                          $grand_total = $grand_total + $row['total_price'];  ?>   
                            <tr>
                                <td><?php echo $row['date'] ?></td>
                                <td><?php echo $row['consultation_name'] ?></td>
                                <td><?php echo  $row['price'] ?></td>
                                <td><?php echo  $row['discount_type'] ?></td>
                                <td><?php echo  $row['discount_price'] ?></td>
                                  <td><?php echo  $row['total_price'] ?></td>
                                <td>
                                     <a onclick="showAjaxModal('<?php echo site_url('modal/popup/print_consultation_fee/' . $row['patient_id'] . '/' . $row['date']); ?>');"
                          class="btn btn-default btn-sm" title="Consultation Charge Print">
                                    <i class="fa fa-money"></i> &nbsp;                        
                                    </a>
                               
                                </td>
                            </tr>
                        <?php   $count++;
                        } ?>
                    </tbody>
                     <tfoot>
        <tr>
            <td style=" border-right-style:hidden"></td>
            <td style=" border-right-style:hidden;border-left-style:hidden"></td>
            <td style=" border-right-style:hidden;border-left-style:hidden"></td>
            <td style=" border-right-style:hidden;border-left-style:hidden"></td>
            <td style="border-left-style:hidden;text-align:right;font-weight:bold;color:#000">Grand Total :</td>
            <td style="font-weight:bold;color:#000"><?php echo ("Rs. " . number_format($grand_total, 2, '.', '')); ?>
            <td style=" border-right-style:hidden;border-left-style:hidden"></td>
            </td>
        </tr>
    </tfoot>
                </table>

            </div>
             <div class="tab-pane" id="item_history" style="overflow-x:auto;">
                      <br>
                <div class="col-sm-6">
                     <input type="text" id="myInput4" class="search-input" onkeyup="applyTableSearch('myTable4', 'myInput4')" placeholder="Search for dates.." title="Type in a dates">

                    
</div>
<div class="col-sm-6">
</div>
                <table class="table table-bordered" id="myTable4"><!--id="table-4"-->
                    <thead>
                        <tr>
                           <th style="width: 67px;">#</th>
            <th><?php echo get_phrase('invoice_no'); ?>/ <?php echo get_phrase('challan_no'); ?></th>
            <th><?php echo get_phrase('models'); ?></th>
            <th><?php echo get_phrase('sum_total'); ?></th>
            <th><?php echo get_phrase('discount'); ?></th>
            <th><?php echo get_phrase('tax'); ?></th>
            <th><?php echo get_phrase('grand_total'); ?></th>
            <th><?php echo get_phrase('received_amount'); ?></th>
            <th><?php echo get_phrase('patient'); ?></th>
            <th><?php echo get_phrase('status'); ?></th>
            <th><?php echo get_phrase('options'); ?></th>
                        </tr>
                    </thead>

                    <tbody>
        <?php
        $counter        = 1;
        $this->db->order_by('id', 'desc');
        $patient_issues = $this->db->get('patient_item_issue')->result_array();

       // $patient_issues = $this->db->where('issue_type', $list)->get('patient_item_issue')->result_array();
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
                                <td style="text-align: center;"><?php echo get_phrase('total_price'); ?></td>
                            </tr>
                            <tr>
                                <td colspan="5">
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
                                    <td style="text-align: center;"><?php echo $row2->total_price; ?></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                </td>
                <td><?php echo $row['sum_total_price']; ?></td>
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
                </td>
                <td><?php echo $row['grand_total']; ?></td>
                <td><?php echo $row['received_amount']; ?></td>
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
                <td> <?php if($row['issue_type'] == 'invoice'){ ?>
                    <a onclick="showAjaxModal('<?php echo site_url('modal/popup/patient_item_issue_invoice/' . $row['id']); ?>');" class="btn btn-default btn-sm">
                        <i class="fa fa-eye"></i> &nbsp;
                        <?php echo get_phrase('view_invoice'); ?>
                    </a>
                   <?php } else if($row['issue_type'] == 'challan') { ?>
                        
                   
                     <a onclick="showAjaxModal('<?php echo site_url('modal/popup/patient_item_issue_challan/' . $row['id']); ?>');" class="btn btn-info btn-sm">
                        <i class="fa fa-eye"></i></a>&nbsp; <a onclick="showAjaxModal('<?php echo site_url('modal/popup/convert_to_invoice/' . $row['id']); ?>')" class="btn btn-primary btn-sm" title="Convert to invoice">
                        <i class="fa fa-exchange"></i>
                    </a>
                     <?php }?>
                    
                </td>
            </tr>
        <?php } ?>
    </tbody>
                </table>

            </div>
        </div>
        
    </div>
    
</div>
<script>
function applyTableSearch(tableId, inputId) {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById(inputId);
    filter = input.value.toUpperCase();
    table = document.getElementById(tableId);
    tr = table.getElementsByTagName("tr");
    
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0];
        if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}
</script>
<?php
for ($count = 1; $count <= 4; $count++) {
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            var array = [0, 1, 2, 3, 4];
            var fileName = 'Patient History Of <?php echo $patient_info['name'] ?>-<?php echo $patient_info['code'] ?>';

            if (<?php echo $count ?> == 1) {
                array = [0, 1, 2, 3, 4, 5, 6, 7, 8];
                fileName = '<?php echo $patient_info['name'] ?>-<?php echo $patient_info['code'] ?>-Prescription';
            } else if (<?php echo $count ?> == 2) {
                array = [0, 1, 2, 3, 4, 5, 6];
                fileName = '<?php echo $patient_info['name'] ?>-<?php echo $patient_info['code'] ?>-Diagnosis';
            } else if (<?php echo $count ?> == 3) {
                array = [0, 1, 2, 3, 4, 5];
                fileName = '<?php echo $patient_info['name'] ?>-<?php echo $patient_info['code'] ?>-Charges';
            } else if (<?php echo $count ?> == 4) {
                array = [0, 1, 2, 3, 4, 5, 6];
                fileName = '<?php echo $patient_info['name'] ?>-<?php echo $patient_info['code'] ?>-Item History';
            }

            var outerTable = $("#table-<?php echo $count ?>").DataTable({
                "sPaginationType": "bootstrap",
                "dom": "<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'B>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>",
                buttons: [{
                        extend: 'copyHtml5',
                        text: 'Copy',
                        filename: fileName,
                        exportOptions: {
                            columns: array,
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
                        filename: fileName,
                        exportOptions: {
                            columns: array,
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
                        filename: fileName,
                        exportOptions: {
                            columns: array,
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
  
    <?php
}
?>