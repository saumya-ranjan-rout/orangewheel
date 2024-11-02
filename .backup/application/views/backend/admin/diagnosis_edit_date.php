<?php

$conditions = array(
     'id' => $param2,
);
$single_patient_info = $this->db->get_where('patient_diagnosis', $conditions)->result_array();
foreach ($single_patient_info as $row) {
    ?>
    <div class="row">
    <div class="col-md-12">
    
    <div class="panel panel-primary" data-collapsed="0">
    
    <div class="panel-heading">
    <div class="panel-title">
    <h3><?php echo get_phrase('edit_diagnosis'); ?>Date</h3>
    </div>
    </div>
    
    <div class="panel-body">
    
    <form role="form" class="form-horizontal form-groups" action="<?php echo site_url('admin/update_patient_diagnosis_date/'.$row['id'].'/'.$row['patient_id']); ?>"
    method="post" enctype="multipart/form-data"   >
    <div class="form-group">
    <label for="field-1" class="col-sm-3 control-label">Date <small style="color:red;">*</small></label>
   <?php
   $input_date = $row['date'];
$date_obj = DateTime::createFromFormat('d-m-Y', $input_date);
$formatted_date = $date_obj->format('m/d/Y');?>
    <div class="col-sm-7">
    <input type="text" class="form-control datepicker" name="creation_timestamp"
                                       value="<?php echo $formatted_date; ?>" >
    </div>
    </div>
    
    
    
    
      <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-8">
                            <button type="submit" class="btn btn-info" id="submit-button">
                                Edit</button>
                          
                        </div>
                    </div>
    
    
    
    
    
  
        </form>
        
        </div>
        
        </div>
        
        </div>
        </div>
        <?php } ?>

                           