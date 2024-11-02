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
// echo $patient_id=$patient_id['patient_id '];

//$patient_id='1';
$nurse_id    = $this->session->userdata('login_user_id'); ?>
<!--<button onclick="showAjaxModal('<?php echo site_url('modal/popup/add_report');?>');" 
    class="btn btn-primary pull-right">
        <i class="fa fa-plus"></i> &nbsp;<?php echo get_phrase('add_report'); ?>
</button>
<a href="<?php echo site_url('nurse/death_report_download'); ?>" 
    class="btn btn-success pull-right"style="margin-right: 5px;">
        <i class="fa fa-download"></i>&nbsp;<?php echo get_phrase('export_death_report'); ?>
</a>
<a href="<?php echo site_url('nurse/birth_report_download'); ?>" 
    class="btn btn-success pull-right"style="margin-right: 5px;">
        <i class="fa fa-download"></i>&nbsp;<?php echo get_phrase('export_birth_report'); ?>
</a>
<a href="<?php echo site_url('nurse/operation_report_download'); ?>" 
    class="btn btn-success pull-right"style="margin-right: 5px;">
        <i class="fa fa-download"></i>&nbsp;<?php echo get_phrase('export_operation_report'); ?>
</a>-->
<div style="clear:both;"></div>

<div class="box-body pb0">             
                    <div class="col-lg-2 col-md-2 col-sm-3 text-center">
                        <img src="<?php echo $this->crud_model->get_image_url('patient' , $patient_id);?>" class="img-circle" width="115" height="115">
                       
                       

                    </div>

                    <div class="col-md-10 col-lg-10 col-sm-9">
                        <div class="table-responsive">
                            <table class="table table-striped mb0 font13">
                                <tbody>
                                    <tr>
                                        <th class="bozerotop">Name</th>
                                        <td class="bozerotop"> <?php echo $patient_info['name']; ?></td>
                                        <th class="bozerotop">Guardian Name</th>
                                        <td class="bozerotop"><?php echo $patient_info['guardian_name']; ?></td>
                                    </tr>
                                    <tr>
                                        <th class="bozerotop">Gender</th>
                                        <td class="bozerotop"><?php echo $patient_info['sex']; ?></td>
                                         <th class="bozerotop">Guardian No</th>
                                        <td class="bozerotop"><?php echo $patient_info['guardian_no']; ?>
                                        </td>
                                        
                                        
                                    </tr>
                                    <tr>
                                        <th class="bozerotop">Phone</th>
                                        <td class="bozerotop"><?php echo $patient_info['phone']; ?></td>
                                                 <th class="bozerotop">Birth Date</th>
                                        <td class="bozerotop"><?php  
                                        
                                    
                                 if( $patient_info['birth_date'] =='' ){
              $bt ='';
         }else{
              $bt=    date("m/d/Y", $patient_info['birth_date']);
         }
                              
                  echo  $bt;          
                                ?>
                                        
                                      
                                        </td>                     

                                    </tr>
                                    <tr>
                                        <th class="bozerotop">Patient Id</th>
                                        <td class="bozerotop"><?php echo $patient_info['code']; ?></td>
                                     
                                        
                                         <th class="bozerotop">Age</th>
                                        <td class="bozerotop">
                                           <?php echo $patient_info['age']; ?>
                                        </td>     
                                    </tr>
                                    <tr>
                                        <th class="bozerotop">Blood Group</th>
                                        <td class="bozerotop"><?php echo $patient_info['bloodgroup']; ?></td>
                                        <th class="bozerotop">Marital Status</th>
                                        <td class="bozerotop"><?php echo $patient_info['marital_status']; ?></td>

                                    </tr>   
                                     <tr>
                                        <th class="bozerotop">Weight</th>
                                        <td class="bozerotop"><?php echo $patient_info['weight']; ?></td>
                                        <th class="bozerotop">Height</th>
                                        <td class="bozerotop"><?php echo $patient_info['height']; ?></td>

                                    </tr>   
                                      <tr>
                                        <th class="bozerotop">Id Proof</th>
                                        <td class="bozerotop"><?php echo $patient_info['id_card']; ?>  
                                      <!--  <a href="<?php echo base_url('uploads/patient_image/'.$row['id_card_file']);?>" class="btn btn-success btn-sm " download>-->
                                        <a href="<?php echo base_url('uploads/patient_image/'.$row['id_card_file']);?>" class="btn btn-success btn-sm" download><!-- change this cpde and fetch from database-->
 
                                        
                    <i class="fa fa-download" style="color:white"></i>
                    </a></td>
                                        <th class="bozerotop">Email</th>
                                        <td class="bozerotop"><?php echo $patient_info['email']; ?></td>

                                    </tr>   
                                    
                                      <tr>
                                        <th class="bozerotop">Current Address</th>
                                        <td class="bozerotop"> <?php echo $patient_info['current_street'].','.$patient_info['current_city'].','.$patient_info['current_state'].','.$patient_info['current_postalcode'] ?></td>
                                        <th class="bozerotop">Permanent Address</th>
                                        <td class="bozerotop"><?php 
                                          echo $patient_info['permanent_street'].','.$patient_info['permanent_street'].','.$patient_info['permanent_state'].','.$patient_info['permanent_postalcode'] ?>
                                        </td>

                                    </tr>   
                                    
                                    
                                    
                                       
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>           
                </div>


<br>
<div class="row">

    <div class="col-md-12">

        <ul class="nav nav-tabs bordered"><!-- available classes "bordered", "right-aligned" -->
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
        </ul>

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
                        <tr class="header"  style="background-color: orange;">
                             <th><?php echo get_phrase('date'); ?></th>
                            <th><?php echo get_phrase('reference'); ?></th>
                           
                            <th><?php echo get_phrase('visit_type'); ?></th>
                            <th><?php echo get_phrase('remarks'); ?></th>
                             <th><?php echo get_phrase('name'); ?></th>
                            <th><?php echo get_phrase('price'); ?></th>
                            <!-- <th><?php echo get_phrase('discount_type'); ?></th> -->
                            <th><?php echo get_phrase('discount_price/%'); ?></th>
                            
                             <th><?php echo get_phrase('total'); ?></th>
                             <th><?php echo get_phrase('upload_prescription'); ?></th>
                             <th><?php echo get_phrase('download_prescription'); ?></th>
                            <th><?php echo get_phrase('options'); ?></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                          $report_info    = $this->db->get_where('patient_consultation_history', array('patient_id' => $patient_id))->result_array();
                      
                     //   $report_info    = $this->db->get_where('report', array('type' => 'operation'))->result_array();
                        foreach ($report_info as $row) { ?>   
                            <tr>
                                <td><?php echo $row['date'] ?></td>
                               <td><?php echo $row['referred_by'] ?></td>
                                <td><?php echo $row['visit_type'] ?></td>
                               <td><?php echo $row['remarks'] ?></td>
                                 <td><?php echo $row['consultation_name'] ?></td>
                                <td><?php echo $row['price'] ?></td>
                                 <!-- <td><?php echo $row['discount_type'] ?></td> -->
                              <td><?php echo $row['discount_price'] ?></td>
                                 <td><?php echo $row['total_price'] ?></td>
                                 <td> <!--<label for="field-1" class="col-sm-3 control-label"><?php echo "Prescription"; ?><small style="color:red;">*</small></label>-->
               <form method="post" enctype="multipart/form-data" action="<?php echo site_url('admin/pres_upload/'.$row['patient_id']. '/' . $row['id']); ?>">

                <input type="hidden" name="patient_id" value="<?php echo $row['patient_id']?>">
                <input type="hidden" name="prescription_id" value="<?php echo $row['id']?>">
                <input type="hidden" name="name" value="prescription">
                <input type="file" name="prescription_document"required><button type="submit"  class="btn btn-primary btn-sm hidden-print">
                    <!-- accept="image/jpeg,image/jpg, image/png" -->
                <i class="fa fa-upload"></i></button>
                </form></td>
                                  <td><?php
                                 $prescription = $this->db->get_where('prescription_upload', array('prescription_id' => $row['id']))->result_array();  
                                 foreach ($prescription as $row1) {          

                if($row1['prescription_document'] != ''){
                    ?>
                    <table>
                        <tr>
                            <td width="85%">
                                <a href="<?php echo base_url('uploads/patient_image/'.$row1['id']. '_' .$row1['prescription_document']);?>" title="" download>
                                <i class="fa fa-download" style="color :green ;"></i></a>
                            </td>
                            <td>
                                <a onclick="confirm_modal('<?php echo site_url('admin/delete_pres_upload/' . $row1['patient_id'] . '/' . $row1['id']); ?>')"
                                title="Delete Prescription">
                                <i class="fa fa-trash-o" style="color : red ;"></i>&nbsp;</a>
                            </td>
                        </tr>
                    </table>
                    <?php
                }else{
                    ?>
                    <a href="#" onclick="alert('No prescription file available.')">
                    <i class="fa fa-download"></i>
                    </a>
                    <?php
                }
                ?>
                <?php } ?>
                </td>
                                <td> <a onclick="confirm_modal('<?php echo site_url('admin/delete_pres/' . $row['patient_id'] . '/' . $row['id']); ?>')"
                                class="btn btn-danger btn-sm" title="Delete Diagnosis">
                                <i class="fa fa-trash-o"></i>&nbsp;
                                </a>
                                <a  onclick="showAjaxModal('<?php echo site_url('modal/popup/edit_patient_cons_history/'.$row['id']);?>');" 
                                class="btn btn-info btn-sm" title="Edit Prescription">
                                <i class="fa fa-pencil"></i>&nbsp;
                                </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

            </div>
            
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
                                <!-- <td style="text-align: center;"><?php echo get_phrase('discount_type'); ?></td> -->
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
                                    <!-- <td style="text-align: center;"<?php echo $row2->discount_type; ?></td> -->
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
                            
                               <a onclick="showAjaxModal('<?php echo site_url('modal/popup/diagnosis_edit_date/' . $row['id']); ?>');"
                           
                        class="btn btn-info btn-sm" title="Diagnosis Edit">
                        <i class="fa fa-pencil"></i>
                        
                    </a>
                                </td>
                                  <td>
                         <!-- <label for="field-1" class="col-sm-3 control-label"><?php echo "Diagnosis"; ?><small style="color:red;">*</small></label>-->
                       <form method="post" enctype="multipart/form-data" action="<?php echo site_url('admin/diag_upload/'.$row['patient_id']. '/' . $row['id']); ?>">
                <input type="hidden" name="patient_id" value="<?php echo $row['patient_id']?>">
                <input type="hidden" name="patient_consultation_history_id" value="<?php echo $row['id']?>">
                <input type="hidden" name="name" value="diagnosis">
                <input type="file" name="file" required>
                <!-- accept="image/jpeg,image/jpg, image/png"-->
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
                            <!-- <th><?php echo get_phrase('discount_type'); ?></th> -->
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
                                <!-- <td><?php echo  $row['discount_type'] ?></td> -->
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
            <!-- <td style=" border-right-style:hidden;border-left-style:hidden"></td> -->
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
<?php echo $patient_id;?>
                <table class="table table-bordered" id="myTable4"><!--id="table-4"-->
                    <thead>
                        <tr>
                           <th style="width: 67px;">#</th>
            <th><?php echo get_phrase('invoice_no'); ?>/ <?php echo get_phrase('challan_no'); ?></th>
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
        $patient_issues =  $this->db->get_where('patient_item_issue', array('patient_id' => $patient_id))->result_array();

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