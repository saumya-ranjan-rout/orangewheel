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


<?php if ($this->input->post()) {
    $fdate = date('m/d/Y', strtotime($date_from));
    $tdate = date('m/d/Y', strtotime($date_to));
} else {
    $fdate = date("m/d/Y");
    $tdate = date("m/d/Y");
} ?>
<div class="row">
  
        <form action="<?php echo site_url('admin/doctor_commission_report');?>" method="post" enctype="multipart/form-data">
 <div class="col-md-3" id="fromdate">
        <div class="form-group">
            <label class="control-label" style="margin-bottom: 11px;">Doctor name <span style="color:red">*</span></label>
          <select id="employeeName"  class="form-control select2 required" name="doctor" required>
  <option value="">--Select a doctor--</option>
  <?php  foreach ($doctor_name as $row1) {?>
  <option value="<?php echo $row1['doctor_name'];?>"><?php echo $row1['doctor_name'];?></option>
<?php } ?>
</select>
        </div>
    </div>
    
    
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
        <h4 style="color:#818da1;">Showing Results From <span style="color:#14b914"><?php echo $df=date('d-m-Y', strtotime($date_from)) ?></span> To <span style="color:#14b914"><?php echo $dt=date('d-m-Y', strtotime($date_to)); ?> </span> for <span style="color:red"><?php echo $referred_by; ?> </span></h4>
    <?php } ?>
</div>



<div class="row">

    <div class="col-md-12">

     

        <div class="tab-content">
            
            <div class="tab-pane active" id="prescription" style="overflow-x:auto;">
                <br>
             

           


  <table class="table table-bordered" id="myTable">


    
    <thead>
        <tr>
           
            <th style="background-color: #AAA8A8;color:white;"><?php echo get_phrase('doctor_name'); ?></th>
         
       
            <th style="background-color: #AAA8A8;color:white;"><?php echo get_phrase('diagnosis_grand_total'); ?></th>
                 <th style="background-color: #AAA8A8;color:white;"><?php echo get_phrase('diagnosis_commission_%'); ?></th>
                      <th style="background-color: #AAA8A8;color:white;"><?php echo get_phrase('Paid_amount'); ?></th>
                      
                       <th style="background-color: #AAA8A8;color:white;"><?php echo get_phrase('item_grand_total'); ?></th>
                 <th style="background-color: #AAA8A8;color:white;"><?php echo get_phrase('item_commission_%'); ?></th>
                      <th style="background-color: #AAA8A8;color:white;"><?php echo get_phrase('Paid_amount'); ?></th>
                      
                       <th style="background-color: #AAA8A8;color:white;"><?php echo get_phrase('total_paid_amount'); ?></th>
                 <th style="background-color: #AAA8A8;color:white;"><?php echo get_phrase('payment_status'); ?></th>
                      <th style="background-color: #AAA8A8;color:white;"><?php echo get_phrase('payment_date'); ?></th>
                       <th style="background-color: #AAA8A8;color:white;"><?php echo get_phrase('action'); ?></th>
        </tr>
    </thead>
  <tbody>
        <?php   
        $total_paid = 0; // Initialize total paid amount
        foreach ($doctor_commission_report as $row1) {
            $total_paid_for_row = $row1['diag_com_amount'] + $row1['item_com_amount']; // Calculate total for each row
            $total_paid += $total_paid_for_row; // Add to the total paid amount
        ?>   
        <tr>
            <td><?php echo $row1['doctor_name'];?></td>
            <td><?php echo $row1['diag_grand_total'];?></td>
            <td><?php echo $row1['diag_com_per'];?></td>
            <td><?php echo $row1['diag_com_amount'];?></td>
            <td><?php echo $row1['item_grand_total'];?></td>
            <td><?php echo $row1['item_com_per'];?></td>
            <td><?php echo $row1['item_com_amount'];?></td>
            <td><?php echo $total_paid_for_row; ?></td> <!-- Total Paid Amount for each row -->
            <td><?php echo 'Paid'?></td>
            <td><?php echo $row1['payment_date'];?></td>
            <td> <!--<a href="<?php echo site_url('admin/doctor_commission_history?referred_by=' . urlencode($row1['id'])); ?>"   title="View  History"><i class="fa fa-money" style="color:#42A5F5;"></i></a>-->
               <!--  <a href="<?php echo site_url('admin/doctor_commission_history?referred_by=' . urlencode($row1['doctor_name']) . '&payment_date=' . urlencode($row1['payment_date'])); ?>" title="View History"><i class="fa fa-money" style="color:#42A5F5;"></i>
</a>-->

<a href="<?php echo site_url('admin/doctor_commission_history?referred_by=' . urlencode($row1['doctor_name']) . '&payment_date=' . urlencode($row1['payment_date']) . '&referred_id=' . urlencode($row1['id'])); ?>" title="View History">
    <i class="fa fa-money" style="color:#42A5F5;"></i>
</a>

</td>
            
        
                
        </tr>
        <?php
        }?>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="7" style="text-align:right;"><b><?php echo get_phrase('Total Paid:'); ?></b></th>
            <th><b><?php echo $total_paid; ?></b></th> <!-- Display total paid amount in footer -->
            <th colspan="3"></th>
        </tr>
    </tfoot>
</table>




            </div>


        </div>
        
    </div>
    
</div>
<!-- Add this script to handle form submission -->
