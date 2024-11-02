<?php
$dig_info = $this->db->get(' diagnosis')->result_array();
$single_patient_info = $this->db->get_where('patient', array('patient_id' => $param2))->result_array();
foreach ($single_patient_info as $row) {
?>
    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-primary" data-collapsed="0">

                <div class="panel-heading">
                    <div class="panel-title">
                        <h3>Add Diagnosis</h3>
                    </div>
                </div>

                <div class="panel-body">

                    <form role="form" class="form-horizontal form-groups" action="<?php echo site_url('admin/patient/add_diagnosis_fee/'.$row['patient_id']); ?>" 
                        method="post" enctype="multipart/form-data"   onsubmit="disableButton()">
                     
                                <input type="hidden" name="patient_id"class="form-control" id="field-1" value="<?php echo $row['patient_id']; ?>" required readonly>
                        
                      <input type="hidden" name="date"class="form-control"  value="<?php echo date('d-m-Y'); ?>"  readonly>

                     
                     <div class="col-sm-7">
                            <select name="diagnosis_id" class="form-control" required
                                class="form-control">
                                <option value="">Select <?php echo get_phrase('Diagnosis'); ?></option>
                       
                                 <?php foreach ($dig_info as $row2) { ?>
                                    <option value="<?php echo $row2['id']; ?>"><?php echo $row2['name']; ?></option>
                                <?php } ?>
                                
                                
                            </select>
                        </div>


                        <!-- <h4 class="modal-title" style="text-align:center;">Are you sure to generate consultation bill ?</h4>-->


                         
        

               <div class="col-sm-3 control-label col-sm-offset-2">
                        <button type="submit" class="btn btn-success" id="myButton">
                            <i class="fa fa-check"></i> <?php echo get_phrase('save');?>
                        </button>
                    </div>
            <!--      <button type="submit" class="btn btn-primary" id="myButton" onclick="printAndSaveConsultationBill(event)"><?php echo get_phrase('Print and Save'); ?></button> -->


                <!--<button type="button" class="btn btn-info" data-dismiss="modal"><?php echo get_phrase('cancel'); ?></button>-->
        

                    </form>

                </div>

            </div>

        </div>
    </div>
<?php } ?>
