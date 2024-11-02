<?php
$diagnosis_info = $this->db->get('diagnosis')->result_array(); 
$single_patient_info = $this->db->select('patient_diagnosis.*, patient.code, patient.name,diagnosis.price,diagnosis.discount_type,diagnosis.discount_price')
->join('patient', 'patient.patient_id = patient_diagnosis.patient_id')
->join('diagnosis', 'diagnosis.id = patient_diagnosis.diagnosis_id')
->get_where('patient_diagnosis', array('patient_diagnosis.id' => $param2))
->result_array();

foreach ($single_patient_info as $row) {
    ?>
    <div class="row">
    <div class="col-md-12">
    
    <div class="panel panel-primary" data-collapsed="0">
    
    <div class="panel-heading">
    <div class="panel-title">
    <h3><?php echo get_phrase('edit_diagnosis'); ?></h3>
    </div>
    </div>
    
    <div class="panel-body">
    
    <form role="form" class="form-horizontal form-groups" action="<?php echo site_url('admin/update_patient_diagnosis_details/'.$row['id'].'/'.$row['patient_id']); ?>" 
    method="post" enctype="multipart/form-data"   onsubmit="disableButton()">
    <div class="form-group">
    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Patient Code'); ?>   <small style="color:red;">*</small></label>
    
    <div class="col-sm-7">
    <input type="text" class="form-control" id="field-1" value="<?php echo $row['code']; ?>" readonly>
    </div>
    </div>
    <div class="form-group">
    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('name'); ?>   <small style="color:red;">*</small></label>
    
    <div class="col-sm-7">
    <input type="text" name="name" class="form-control" id="field-1" value="<?php echo $row['name']; ?>" readonly>
    </div>
    </div>
    
    
    
    <div class="form-group">
    <label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('diagnosis_name'); ?>   </label>
    
    <div class="col-sm-7">
    <select name="diagnosis_id"  id="dediagnosis_id"  required class="form-control" class="form-control" onchange="getDiagnosisdetails()">
    <option value=""><?php echo get_phrase('Select Diagnosis'); ?></option>
    <?php foreach ($diagnosis_info as $row2) { ?>
        <option value="<?php echo $row2['id']; ?>"<?php if ($row['diagnosis_id'] == $row2['id']) echo 'selected'; ?>><?php echo $row2['name']; ?></option>
        <?php } ?>
        </select>
        </div>
        </div>
        
        
        <div class="form-group">
        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Price'); ?></label>
        
        <div class="col-sm-7">
        <input type="number" name="price" class="form-control" id="deprice" value="<?php echo $row['price']; ?>"  readonly>
        </div>
        </div>
        
        <div class="form-group">
        <label class="col-sm-3 control-label"><?php echo get_phrase('Discount_type');?></label>
        <div class="col-sm-7">                             
        <select class="form-control" name="discount_type" id="dediscount_type" disabled>
        <option value="">Select Discount Type</option>
        <option value="fixed" <?php if($row['discount_type']=="fixed"){ echo"selected"; } ?>>Fixed</option>
        <option value="percentage" <?php if($row['discount_type']=="percentage"){ echo"selected"; } ?>>Percentage</option>
        
         </select>
        </div>
        </div>
        
        <div class="form-group" id="dediscount_value_field" >
        <label class="col-sm-3 control-label" id="dediscount_value_label"><?php echo get_phrase('discount_price');?></label>
        <div class="col-sm-7">
        <input type="text" class="form-control" id="dediscount_value"name="discount_price" value="<?php echo $row['discount_price'];?>" readonly/>
        </div>
        </div> 

        <?php
$total=$row['price'];
$dis_per =0;
if ($row['discount_type'] === "fixed") {
  $total= $row['price'] - $row['discount_price'];

} else if ($row['discount_type'] === "percentage") {
    $dis_per = ($row['price'] - $row['discount_price'])/100;
    $total= $row['price'] - $dis_per;
}

        ?>
        
        <div class="form-group" >
        <label class="col-sm-3 control-label"><?php echo get_phrase('total');?></label>
        <div class="col-sm-7">
        <input type="text" class="form-control"  id="detotal" name="total" value="<?php echo $total;?>" readonly/>
        </div>
        </div>
        
        <div class="form-group">
        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('date'); ?></label>
        
        <div class="col-sm-7">
        <?php 
        if ($row['date'] == '') {
            $bt = '';
        } else {
            $bt = date("m/d/Y", strtotime($row['date']));
        }
        ?>
        <input type="text" name="date" class="form-control" id="dedate" value="<?php echo $bt; ?>" readonly>
        </div>
        </div>
        
        
        <div class="col-sm-3 control-label col-sm-offset-2">
        <button type="submit" class="btn btn-success" id="myButton">
        <i class="fa fa-check"></i> <?php echo get_phrase('update');?>
        </button>
        </div>
        </form>
        
        </div>
        
        </div>
        
        </div>
        </div>
        <?php } ?>
        
        <script>
        
        function getDiagnosisdetails() {
    var diagnosis_id = $('#dediagnosis_id').val();
   // alert(diagnosis_id);
   
   
    $.ajax({
        url: '<?php echo site_url('admin/get_diagnosis_details/'); ?>' + diagnosis_id,
        success: function(response) {
            var data = JSON.parse(response);
            
            $('#deprice').val(data.price);
            $('#dediscount_value').val(data.discount_price);
            var total=data.price;
            
            var discountTypeOptions = '<option value="">Select Discount Type</option>';
            if (data.discount_type === "fixed") {
                discountTypeOptions += '<option value="fixed" selected>Fixed</option>';
                discountTypeOptions += '<option value="percentage">Percentage</option>';
          total= data.price - data.discount_price;

            } else if (data.discount_type === "percentage") {
                discountTypeOptions += '<option value="fixed">Fixed</option>';
                discountTypeOptions += '<option value="percentage" selected>Percentage</option>';
                var dis_per = (data.price - data.discount_price)/100;
                total= data.price - dis_per;

            }
            
            $('#dediscount_type').html(discountTypeOptions);
            $('#detotal').val(total);
        },
        error: function(xhr, status, error) {
            console.log(error);
        }
    });
}
 
                            function disableButton() {
                                var button = document.getElementById("myButton");
                                button.disabled = true;
                            }
                            </script>
                           