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
*data send to two referral table with details<br>
*status update in pending to done in referral_coulmn of both patient_issue_item and patient_diagnosis and date and doctor send to both table<br>
*report do<br>
*if month is different in dt dt2 then data not showing
<br>

<?php if ($this->input->post()) {
    $fdate = date('m/d/Y', strtotime($date_from));
    $tdate = date('m/d/Y', strtotime($date_to));
} else {
    $fdate = date("m/d/Y");
    $tdate = date("m/d/Y");
} ?>
<div class="row">
   <!-- <form action="<?php echo site_url('admin/doctor_visit_history'); ?>" method="post" enctype="multipart/form-data">-->
        <form action="<?php echo site_url('admin/doctor_visit_history?referred_by=') . $referred_by; ?>" method="post" enctype="multipart/form-data">

    <div class="col-md-3" id="fromdate">
        <div class="form-group">
            <label class="control-label" style="margin-bottom: 11px;">Date From(<span style="color:#14b914">m/d/y</span>) <span style="color:red">*</span></label>
            <input id="date_from" name="date_from" placeholder="" type="text" class="form-control datepicker" value="<?php echo $fdate; ?>" />
        </div>
    </div>

    <div class="col-md-3" id="todate">
        <div class="form-group">
            <label class="control-label" style="margin-bottom: 11px;">Date To(<span style="color:#14b914">m/d/y</span>) <span style="color:red">*</span></label>
            <input id="date_to" name="date_to" placeholder="" type="text" class="form-control datepicker" value="<?php echo $tdate; ?>" />
        </div>
    </div>

    <input type="hidden" name="referred_by" value="<?php echo $referred_by; ?>">

    <div class=" col-md-3" style="margin-top: 30px;">
        <button type="submit" class="btn btn-info">Search</button>
    </div>
</form>
</div>
<div style="clear:both;"></div>


<div align="center">
    <?php
    if ($this->input->post()) {
  ?>
        <h4 style="color:#818da1;">Showing Results From <span style="color:#14b914"><?php echo $df=date('d-m-Y', strtotime($date_from)) ?></span> To <span style="color:#14b914"><?php echo $dt=date('d-m-Y', strtotime($date_to)); ?></span></h4>
    <?php } ?>
</div>



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

    <div class="col-md-12">

     

        <div class="tab-content">
            
            <div class="tab-pane active" id="prescription" style="overflow-x:auto;">
                <br>
       <form id="myForm" method="post" action="<?php echo site_url('admin/doctor_referral'); ?>" enctype="multipart/form-data">
    <table class="table table-bordered" id="myTable">
      <input type="hidden" name="doctor_name" value="<?php echo $referred_by; ?>">

    
    <thead>
        <tr>
            <th style="background-color: #AAA8A8; color:white;"><input type="checkbox" id="checkAll" onchange="checkAllChanged(this)"></th>
            <th style="background-color: #AAA8A8;color:white;"><?php echo get_phrase('name'); ?></th>
            <th style="background-color: #AAA8A8;color:white;"><?php echo get_phrase('phone'); ?></th>
            <th style="background-color: #AAA8A8;color:white;"><?php echo get_phrase('diagnosis'); ?></th>
            <th style="background-color: #AAA8A8;color:white;"><?php echo get_phrase('grand_total'); ?></th>
            <th style="background-color: #AAA8A8;color:white;"><?php echo get_phrase('items'); ?></th>
            <th style="background-color: #AAA8A8;color:white;"><?php echo get_phrase('grand_total'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php   
         $cc = 0; 
        $count = 1;
        $grand_total = 0;
        $item_grand_total = 0;
        foreach ($doctor_info as $row) {
            $sum_total_item = 0;
            $sum_total_price = 0;
            
             $cc++;
            
        ?>   
        <tr>
            <td>
        
            <input type="checkbox"id="rowcheckbox<?php echo $count; ?>"class="rowCheckbox" onchange="updateHiddenFieldValue(<?php echo $count; ?>)">
         <input type="hidden" class="hiddenField" id="hiddenField<?php echo $count; ?>" name="checked[]" value="0"></td>
            <td><?php echo $row['name']."[". $row['code']."]"?>
             <input type="hidden" name="patient_id[]"value="<?php echo $row['patient_id'];?>">
            
            </td>
            <td><?php echo $row['phone'] ?></td>
            <td>
                <div>                                    
                    <table style="width: 100%;">
                       <?php //if($count==1){
                            ?>
                            <tr>
                                <th style="text-align: center;background-color: #AAA8A8;color:white;"><?php echo get_phrase('date'); ?></th>
                               <th style="text-align: center;background-color: #AAA8A8;color:white;"><?php echo get_phrase('diagnosis'); ?></th>
                               <th style="text-align: center;background-color: #AAA8A8;color:white;"><?php echo get_phrase('qty'); ?></th>
                               <th style="text-align: center;background-color: #AAA8A8;color:white;"><?php echo get_phrase('price'); ?></th>
                              <th style="text-align: center;background-color: #AAA8A8;color:white;"><?php echo get_phrase('discount_price'); ?></th>
                           <th style="text-align: center;background-color: #AAA8A8;color:white;"><?php echo get_phrase('total_price'); ?></th>
                            </tr>
                     
                         
                            <?php
                       
                     if ($date_from != '' && $date_to != '') {
    $this->db->where('date >=', $df)
             ->where('date <=', $dt);
}

$cons_info = $this->db->where('patient_id', $row['patient_id'])
                      ->where('referral_status', 'pending')
                      ->get('patient_diagnosis')
                      ->result_array();
                 ?>     
                      <input type="hidden"class="patient_diagnosis_data" id="patient_diagnosis_data<?php echo $count; ?>"value="<?php echo count($cons_info);?>">
<?php

                      foreach ($cons_info as $row1) {
                        $grand_total +=$row1['sum_total_price'];?>

 <input type="hidden" name="pat_diag_id<?php echo $row['patient_id'];?>[]"value="<?php echo $row1['id'];?>">
                              <?php $diagnosis = json_decode($row1['diagnosis_id']);
                            foreach ($diagnosis as $row2) {
                            $this->db->select('diagnosis.name as diagnosis_name')->from('diagnosis');
                            $this->db->where('diagnosis.id', $row2->diagnosis_id);
                            $query2 = $this->db->get();
                            $diagnosis_info = $query2->row_array(); ?>
                            
                            
                                <tr style="border-bottom: 0.5px solid #DEDCDC;">
                                    <td style="text-align: center;"><?php echo $row1['date'];?> </td>                                 
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
                </div>
            </td>
            <td >
                <div class="diagnosis-grand-total">
                <?php echo number_format($sum_total_price, 2, '.', ''); ?>
             
                
                </div>
            </td>
              <td>
                <div>                                    
                    <table style="width: 100%;">
                      <?php //if($count==1){
                            ?>
                            <tr>
                                
                            <th style="text-align: center;background-color: #AAA8A8;color:white;"><?php echo get_phrase('invoice_no'); ?>/<br> <?php echo get_phrase('challan_no'); ?></th>
                             <th style="text-align: center;background-color: #AAA8A8;color:white;">Date</th>
                                <th style="text-align: center;background-color: #AAA8A8;color:white;"><?php echo get_phrase('model'); ?></th>
                                <th style="text-align: center;background-color: #AAA8A8;color:white;"><?php echo get_phrase('qty'); ?></th>
                                <th style="text-align: center;background-color: #AAA8A8;color:white;"><?php echo get_phrase('price'); ?></th>
                                <th style="text-align: center;background-color: #AAA8A8;color:white;"><?php echo get_phrase('discount'); ?></th>
                                <th style="text-align: center;background-color: #AAA8A8;color:white;"><?php echo get_phrase('tax'); ?></th>
                                <th style="text-align: center;background-color: #AAA8A8;color:white;"><?php echo get_phrase('total_price'); ?></th>
                            </tr>
                     
                    
                            <?php
                    
                     
                            $sum_total_item=0;
  if ($date_from != '' && $date_to != '') {
    $this->db->where('invoice_date >=', $date_from)
             ->where('invoice_date <=', $date_to);
}

$patient_issues = $this->db->where('patient_id', $row['patient_id'])
                      ->where('referral_status', 'pending')
                      ->get('patient_item_issue')
                      ->result_array();
                      ?>
                      <input type="hidden" class="patient_item_issue_data" id="patient_item_issue_data<?php echo $count; ?>"value="<?php echo count($patient_issues);?>">
                      <?php
                            foreach ($patient_issues as $row3) { ?>    
                            
                             <input type="hidden" name="pat_item_issue_id<?php echo $row['patient_id'];?>[]"value="<?php echo $row3['id'];?>">
           
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
                                  <td rowspan="<?php echo $count_model; ?>"><?php echo  $row3['invoice_date'] ?></td>
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
              <td >
                <div class="item-grand-total">
                  <?php echo number_format($sum_total_item, 2, '.', ''); ?>
                  
                  
                </div>
            </td>
        </tr>
        <?php
            $count++;
        }?>
    </tbody>
     <tfoot>
        <tr>
            <td style="text-align:right;font-weight:bold;color:#000" colspan="4">Diagnosis Grand Total :
              <input type="hidden" class="" name="diag_grand_total" ></td>
            <td id="diagnosisTotal" style="font-weight:bold;color:#000">
                   
              
 
                
                Rs. 0.00</td>
            <td style="text-align:right;font-weight:bold;color:#000">Item Grand Total :
             <input type="hidden" class="" name="item_grand_total" ></td>
            <td id="itemTotal" style="font-weight:bold;color:#000">
               
                Rs. 0.00</td>
        </tr>
        <tr>
            <td style="text-align:right;font-weight:bold;color:#000" colspan="4">Diagnosis Commission %:<span style="color:red">*</span></td>
            <td style="font-weight:bold;color:#000"><input name="commissionPercentage1" id="commissionPercentage1" type="text" required></td>
            <td style="text-align:right;font-weight:bold;color:#000">Item Commission %:<span style="color:red">*</span></td>
            <td style="font-weight:bold;color:#000"><input name="commissionPercentage2" id="commissionPercentage2" type="text" required></td>
        </tr>
        <tr>
            <td style="text-align:right;font-weight:bold;color:#000" colspan="4">Diagnosis Commission Amount :</td>
            <td style="font-weight:bold;color:#000">Rs.<input name="calculatedCommissionAmount1"  id="calculatedCommissionAmount1" type="text" readonly></td>
            <td style="text-align:right;font-weight:bold;color:#000">Item Commission Amount :</td>
            <td style="font-weight:bold;color:#000">Rs.<input  name="calculatedCommissionAmount2" id="calculatedCommissionAmount2" type="text" readonly></td>
        </tr>
        <tr>
            <td colspan="7" align="center"><button type="submit" id="submit" disabled="disabled">Submit</button></td>
        </tr>
    </tfoot>   
</table>
               </form>
            </div>


        </div>
        
    </div>
    
</div>

            </div>


        </div>
        
    </div>
    
</div>
<!-- Add this script to handle form submission -->


<script>
    // Function to toggle all checkboxes
    function checkAllChanged(checkAllCheckbox) {

      //  alert(checkAllCheckbox);
        var checkboxes = document.querySelectorAll('.rowCheckbox');
        var hiddenFields = document.querySelectorAll('.hiddenField');

        checkboxes.forEach(function(checkbox) {
            checkbox.checked = checkAllCheckbox.checked;
        });

        var value = checkAllCheckbox.checked ? 1 : 0;
        hiddenFields.forEach(function(hiddenField) {
            hiddenField.value = value;
        });

        submitDisabled();
    }


    function updateHiddenFieldValue(i) {

       // alert(i);
        // Get the checkbox and hidden field elements
        var checkbox = document.getElementById('rowcheckbox'+i);
        var hiddenField = document.getElementById('hiddenField'+i);
        
        // If checkbox is checked, set hidden field value to 1, otherwise set it to 0
        hiddenField.value = checkbox.checked ? 1 : 0;

        submitDisabled();
    }


    function submitDisabled() {
    var dd = 0;
    $('.rowCheckbox').each(function(index) {
        var currentindex = index + 1;

        var hiddenField = document.getElementById('hiddenField' + currentindex).value;
        var patient_diagnosis_data = document.getElementById('patient_diagnosis_data' + currentindex).value;
        var patient_item_issue_data = document.getElementById('patient_item_issue_data' + currentindex).value;

        if (hiddenField === '1' && (patient_diagnosis_data >= 1 || patient_item_issue_data >= 1)) {
            dd++;
        }
    });

    if (dd >= 1) {
        $('#submit').prop('disabled', false); // Enable submit button
    } else {
        $('#submit').prop('disabled', true); // Disable submit button
    }
}


</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    function calculateTotals() {
        var grandTotalDiagnosis = 0;
        var grandTotalItems = 0;
        $('.rowCheckbox:checked').each(function() {
            var $row = $(this).closest('tr');
            
            // Diagnosis Total
            var diagnosisValue = parseFloat($row.find('.diagnosis-grand-total').text().replace(/[^\d.-]/g, '')) || 0;
            grandTotalDiagnosis += diagnosisValue;

            // Item Total
            var itemValue = $row.find('.item-grand-total').text().replace(/[^\d.-]/g, '');
            var itemTotal = parseFloat(itemValue) || 0;
            grandTotalItems += itemTotal;
        });
        
        // Round to two decimal places
        grandTotalDiagnosis = Math.round(grandTotalDiagnosis * 100) / 100;
        grandTotalItems = Math.round(grandTotalItems * 100) / 100;
        
        $('#diagnosisTotal').text("Rs. " + grandTotalDiagnosis.toFixed(2));
        $('#itemTotal').text("Rs. " + grandTotalItems.toFixed(2));


 // Update the input fields with the calculated totals
        $('input[name="diag_grand_total"]').val(grandTotalDiagnosis.toFixed(2));
        $('input[name="item_grand_total"]').val(grandTotalItems.toFixed(2));

 
        // Calculate commission amount based on commission percentage
        var commissionPercentage1 = parseFloat($('#commissionPercentage1').val()) || 0;
        var commissionPercentage2 = parseFloat($('#commissionPercentage2').val()) || 0;
        var commissionAmount1 = grandTotalDiagnosis * (commissionPercentage1 / 100);
        var commissionAmount2 = grandTotalItems * (commissionPercentage2 / 100);
        $('#calculatedCommissionAmount1').val(commissionAmount1.toFixed(2));
        $('#calculatedCommissionAmount2').val(commissionAmount2.toFixed(2));
    }

    $('input.rowCheckbox').change(function() {
        calculateTotals();
    });

    $('#commissionPercentage1, #commissionPercentage2').on('input', function() {
        calculateTotals();
    });

    $('#checkAll').change(function() {
        $('.rowCheckbox').prop('checked', $(this).prop('checked'));
        calculateTotals();
    });

    calculateTotals();
});


/*$(document).ready(function(){
    $('button[type="submit"]').click(function(e){
        e.preventDefault(); // Prevent form submission
        
        // Array to store selected data
        var selectedData = [];
        
        // Loop through each checked checkbox
        $('input.rowCheckbox:checked').each(function(){
            var $row = $(this).closest('tr');
            var rowData = {
                patient_id: $row.find('input[name="patient_id[]"]').val(),
                pat_diag_id: $row.find('input[name="pat_diag_id[]"]').val(),
                pat_item_issue_id: $row.find('input[name="pat_item_issue_id[]"]').val()
            };
            selectedData.push(rowData);
        });
        
        // Log selected data to console for debugging
        console.log(selectedData);
        
        // Send selected data to the controller using AJAX
        $.ajax({
            url: '<?php echo site_url("admin/doctor_referral"); ?>',
            type: 'POST',
            data: {data: selectedData},
            success: function(response) {
                // Handle success response
                console.log(response);
            },
            error: function(xhr, status, error) {
                // Handle error
                console.error(xhr, status, error);
            }
        });
    });
});
*/
/*document.addEventListener("DOMContentLoaded", function() {
    // Get the form element
    var form = document.getElementById("myForm");

    // Attach a submit event listener to the form
    form.addEventListener("submit", function(event) {
        // Prevent the default form submission behavior
        event.preventDefault();
        
        // Gather data when the form is submitted
        var selectedData = [];
        var checkboxes = document.querySelectorAll('input.rowCheckbox:checked');
        checkboxes.forEach(function(checkbox) {
            var rowData = {
                patient_id: checkbox.closest('tr').querySelector('input[name="patient_id[]"]').value,
                pat_diag_id: checkbox.closest('tr').querySelector('input[name="pat_diag_id[]"]').value,
                pat_item_issue_id: checkbox.closest('tr').querySelector('input[name="pat_item_issue_id[]"]').value
            };
            selectedData.push(rowData);
        });
 console.log(selectedData);
        // Append the gathered data to the form as hidden input fields
        selectedData.forEach(function(data) {
            for (var key in data) {
                var input = document.createElement("input");
                input.setAttribute("type", "text");
                input.setAttribute("name", key);
                input.setAttribute("value", data[key]);
                form.appendChild(input);
            }
        });

        // Submit the form with the appended data
        form.submit();
    });
});*/


</script>


    