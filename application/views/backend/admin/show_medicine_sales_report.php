
<?php 
if($this->input->post()){
    $ffdate = date('Y-m-d', strtotime($this->input->post('date_from')));
    $ttdate = date('Y-m-d', strtotime($this->input->post('date_to')));
    $fdate = date("m/d/Y",strtotime($ffdate));
    $tdate = date("m/d/Y",strtotime($ttdate));
    $this->db->where("DATE_FORMAT(date_time, '%Y-%m-%d') >= '$ffdate'", NULL, FALSE);
    $this->db->where("DATE_FORMAT(date_time, '%Y-%m-%d') <= '$ttdate'", NULL, FALSE);
    $this->db->order_by('medicine_sale_id', 'desc');
    $medicine_sales = $this->db->get('medicine_sale')->result_array();
 
}else{
    
    $fdate = date("m/d/Y");
    $tdate = date("m/d/Y");
    $fdate1 = date("Y-m-d",strtotime($fdate));
    $tdate1 = date("Y-m-d",strtotime($tdate));
    $this->db->order_by('medicine_sale_id', 'desc');
    $this->db->where("DATE_FORMAT(date_time, '%Y-%m-%d') >= '$fdate1'", NULL, FALSE);
    $this->db->where("DATE_FORMAT(date_time, '%Y-%m-%d') <= '$tdate1'", NULL, FALSE);
    $medicine_sales = $this->db->get('medicine_sale')->result_array();
}
?>


<div class="row">
    <form  method="post" enctype="multipart/form-data">
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

        <div class="col-md-3" style="margin-top: 30px;">
            <button type="submit" name="submit" class="btn btn-info">Search</button>
        </div>
    </form>
</div>
<div style="clear:both;"></div>
<div align="center">
    <?php
    if ($this->input->post()) {
    ?>
        <h4 style="color:#818da1;">Showing Results From <span style="color:#14b914"><?php echo date('d-m-Y', strtotime($ffdate)) ?></span> To <span style="color:#14b914"><?php echo date('d-m-Y', strtotime($ttdate)); ?></span></h4>
    <?php } else{?>
         <h4 style="color:#818da1;">Showing Results For <span style="color:#14b914"><?php echo date('d-m-Y') ?></span> </h4>
  <?php  }
    
    
    ?>
</div>
<table class="table table-bordered table-striped datatable" id="table-2">
    <thead>
        <tr>
            <th style="width: 67px;">#</th>
            <th><?php echo get_phrase('medicines'); ?></th>
            <th><?php echo get_phrase('patient'); ?></th>
            <th><?php echo get_phrase('date'); ?></th>
            <th><?php echo get_phrase('total_price'); ?></th>
        </tr>
    </thead>

    <tbody>
        <?php
        
        
        $counter = 1;
        $grand_total = 0;
        foreach ($medicine_sales as $row) {
            $grand_total = $grand_total + $row['total_amount'];
             ?>   
            <tr>
                <td><?php echo $counter++; ?></td>                                                      
                <?php
                    $medicines = json_decode($row['medicines']);
                    foreach($medicines as $row2) { ?>                               
                <td >
                    <?php
                    $medicine_info = $this->db->get_where('medicine', array('medicine_id' => $row2->medicine_id))->row();
                    echo $medicine_info->name; ?>
                </td>                                                                    
                <?php } ?>                
                <td>
                    <?php echo $this->db->get_where('patient', array('patient_id' => $row['patient_id']))->row()->name; ?>
                </td>
                <td><?php echo date('d-m-Y', strtotime($row['date_time'])); ?></td>
                <td><?php echo $row['total_amount'] ?></td>
            </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <td style=" border-right-style:hidden"></td>
            <td style=" border-right-style:hidden;border-left-style:hidden"></td>
            <td style=" border-right-style:hidden;border-left-style:hidden"></td>
            <td style="border-left-style:hidden;text-align:right;font-weight:bold;color:#000">Grand Total :</td>
            <td style="font-weight:bold;color:#000"><?php echo ("Rs. " . number_format($grand_total, 2, '.', '')); ?>
            </td>
        </tr>
    </tfoot>
</table>
<script>
$(document).ready(function() {
    $('#table-2').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            
        ]
    } );
} );
</script>
<script type="text/javascript">
    /*jQuery(window).load(function ()
    {
        var $ = jQuery;

        $("#table-2").dataTable({
            "sPaginationType": "bootstrap"
        });

        $(".dataTables_wrapper select").select2({
            minimumResultsForSearch: -1
        });
    });*/
</script>