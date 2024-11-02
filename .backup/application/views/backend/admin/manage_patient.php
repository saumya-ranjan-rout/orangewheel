<?php
//  $this->session->set_flashdata('message', get_phrase('patient_info_saved_successfuly'));
//  $this->session->set_flashdata('error_message', get_phrase('Error Occured'));
 ?>
 <style>  .left-column {
        width: 50%;
    }

    .right-column {
        width: 50%;
    }
    </style><button onclick="showAjaxModal('<?php echo site_url('modal/popup/add_patient');?>');" 
    class="btn btn-primary pull-right">
        <i class="fa fa-plus"></i>&nbsp;<?php echo get_phrase('add_patient'); ?>
</button>
<div style="clear:both;"></div>
<br>
<table class="table table-bordered table-striped datatable" id="table-2">
    <thead>
        <tr>
            <th><?php echo get_phrase('image');?></th>
            <th><?php echo get_phrase('Patient Id');?></th>
            <th><?php echo get_phrase('name');?></th>
           <!-- <th><?php echo get_phrase('email');?></th>-->
            <th><?php echo get_phrase('phone');?></th>
            <th><?php echo get_phrase('sex');?></th>
          
            <th><?php echo get_phrase('age');?></th>
            <th><?php echo get_phrase('blood_group');?></th>
             <th>Date</th>
              <th><?php echo get_phrase('Total Visit');?></th>
            <th><?php echo get_phrase('options');?></th>
             <th style="display:none;"></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($patient_info as $row) {
         $this->db->select('*')
            ->from('patient_consultation_history')
            ->where('patient_id', $row['patient_id']);

        $query = $this->db->get();
        $num = $query->num_rows();
        
        /* $this->db->select('*')
            ->from('patient_consultation_history')
            ->where('patient_id', $row['patient_id'])
            ->order_by('prescription_id', 'DESC')
            ->limit(1);

        $query = $this->db->get();
        $lastvisit = $query->row_array();*/
        ?>   
            <tr>
                <td><img src="<?php echo $this->crud_model->get_image_url('patient' , $row['patient_id']);?>" class="img-circle" width="40px" height="40px"></td>
               <td><?php echo $row['code']?>   <a href="<?php echo site_url('admin/patient_visit_history/'.$row['patient_id']);?>"   title="View Patient History"><i class="fa fa-book" style="color:#42A5F5;"></i></a>
               
               &nbsp;
                </td>
                <td><?php echo $row['name']?></td>
               <!-- <td><?php echo $row['email']?></td>-->
                <td><?php echo $row['phone']?></td>
                <td><?php echo $row['sex']?></td>
               
                <td><?php echo $row['age']?></td>
                <td><?php echo $row['bloodgroup']?></td>
                 <td><?php  $timestamp =$row['date_time'];
                 $date = DateTime::createFromFormat('Y-m-d H:i:s', $timestamp);
echo $date->format('d-m-Y') . "\n" . $date->format('H:i:s');?>
</td>
                  <td><?php echo $num; ?></td>
                <td>
                   <!-- <a  onclick="showAjaxModal('<?php echo site_url('modal/popup/edit_patient/'.$row['patient_id']);?>');" 
                        class="btn btn-info btn-sm">
                            <i class="fa fa-pencil"></i>&nbsp;
                            <?php echo get_phrase('edit');?>
                    </a>
                    <a onclick="confirm_modal('<?php echo site_url('admin/patient/delete/'.$row['patient_id']); ?>')"
                        class="btn btn-danger btn-sm">
                            <i class="fa fa-trash-o"></i>&nbsp;
                            <?php echo get_phrase('delete');?>
                    </a>-->
                    
                    
                    
                    
                    
                        <a  onclick="showAjaxModal('<?php echo site_url('modal/popup/edit_patient/'.$row['patient_id']);?>');" 
    class="btn btn-info btn-sm" title="Edit Patient">
    <i class="fa fa-pencil"></i>&nbsp;

    </a>
    <a onclick="confirm_modal('<?php echo site_url('admin/patient/delete/'.$row['patient_id']); ?>')"
    class="btn btn-danger btn-sm" title="Delete Patient">
    <i class="fa fa-trash-o"></i>&nbsp;

    </a>
       <!-- <a href="<?php echo site_url('admin/patient_item_history/'.$row['patient_id']);?>"   title="View Item History" class="btn btn-default btn-sm"><i class="fa fa-book"></i>&nbsp;</a>
-->
    <a onClick="PrintElem('#invoice_print<?php echo $row['patient_id']?>')"
    class="btn btn-primary btn-sm hidden-print" title="Print Prescription">
    <i class="fa fa-print"></i>&nbsp;
 
    </a>
   <!-- <a onclick=""
    class="btn btn-info btn-sm" title="Check-up History">
    <i class="fa fa-book"></i>&nbsp;

    </a>-->
    
     <?php
$date=date('d-m-Y');
$conditions = array(
    'patient_id' => $row['patient_id'],
    'date' => $date
);
$edit_data = $this->db->get_where('patient_diagnosis', $conditions)->result_array();
 $rowCount = count($edit_data);
if($rowCount > 0){
?> 
 <a onclick="showAjaxModal('<?php echo site_url('modal/popup/view_diaggnosis_report/' . $row['patient_id']); ?>');" 
                        class="btn btn-default btn-sm" title="Diagnosis Report Print">
                        <i class="fa fa-file"></i> &nbsp;
                        
                    </a>
                    
      <?php } else{?>
      
       <a href="<?php echo site_url('admin/patient_diagnosis_add/'.$row['patient_id']);?>"   class="btn btn-success btn-sm" title="Diagnosis" ><i class="fa fa-medkit" ></i></a>

    
     <?php }?>
    <?php
$date=date('d-m-Y');
$conditions = array(
    'patient_id' => $row['patient_id'],
    'date' => $date
);
$edit_data = $this->db->get_where('patient_consultation_history', $conditions)->result_array();
 $rowCount = count($edit_data);
//foreach ($edit_data as $row){
if($rowCount > 0){
?>
 <a onclick="showAjaxModal('<?php echo site_url('modal/popup/view_consultation_fee/' . $row['patient_id']); ?>');" 
                        class="btn btn-default btn-sm" title="Consultation Charge Print">
                        <i class="fa fa-money"></i> &nbsp;
                        
                    </a>
  
    <?php } else{?>
      <a onclick="showAjaxModal('<?php echo site_url('modal/popup/add_cosultation_fee/'.$row['patient_id']); ?>')"
    class="btn btn-warning btn-sm" title="Consultation Charge">
    <i class="fa fa-money"></i>&nbsp;

    </a>
    <?php }?>
    
                </td>
                
                <!-- print prescription start -->
    <td style="display:none;">
    <div id="invoice_print<?php echo $row['patient_id']?>">
    
    <table width="100%" border="0">
    <tr>
    <td ><img src="<?php echo base_url() . 'uploads/hospital_content/header.png' ?>"  style="height:100px; width:100%;" class="img-responsive"/></td>
    <td align="right"></td>
    </tr>
    </table>
    
    <table width="100%" border="0">
        <tr>
                <td colspan="14"align="center"><h3 style="font-family:	Lucida Console;font-weight:bold;">Prescription</h3></td>
               
            </tr>
            </table>
            <hr>
    <table width="100%" border="0">
    <tr>
        <td align="left" valign="top" class="left-column">
            Patient Id: <?php echo $this->db->get_where('patient', array('patient_id' => $row['patient_id']))->row()->code; ?><br>
            Patient Name: <?php echo $this->db->get_where('patient', array('patient_id' => $row['patient_id']))->row()->name; ?><br>
            Address: <?php $res=$this->db->get_where('patient', array('patient_id' => $row['patient_id']))->row(); echo $res->current_street.",".$res->current_city."<br>".$res->current_state.",".$res->current_postalcode; ?><br>
            Phone: <?php echo $this->db->get_where('patient', array('patient_id' => $row['patient_id']))->row()->phone; ?><br>
        </td>
         <td align="" valign="top" class="">
           Age: <?php echo $this->db->get_where('patient', array('patient_id' => $row['patient_id']))->row()->age; ?><br>
            Sex: <?php echo $this->db->get_where('patient', array('patient_id' => $row['patient_id']))->row()->sex; ?><br>
            Weight: <?php echo $this->db->get_where('patient', array('patient_id' => $row['patient_id']))->row()->weight; ?><br>
        </td>
        <td align="right" valign="top" class="right-column">
          <?php
$visitType =  $row['visit_type'];

$walkInChecked = '';
$appointmentChecked = '';
if ($visitType === 'walk-in') {
    $walkInChecked = 'checked';
} elseif ($visitType === 'appointment') {
    $appointmentChecked = 'checked';
}
?>
            Date: <?php echo date('d/m/Y'); ?><br>
             <label for="vehicle1"> Walk In</label>
  <input type="checkbox" id="visit_type" name="visit_type" <?php echo $walkInChecked; ?>><br>
   <label for="vehicle1">Appointment </label>
  <input type="checkbox" id="visit_type" name="visit_type" <?php echo $appointmentChecked; ?>><br>
        </td>
    </tr>
</table>

        <hr>
   
    <div class="footer-image">
    <img src="<?php echo base_url() . 'uploads/hospital_content/footer.png' ?>" class="img-responsive" style="width: 100%"/>
    </div>
    <div class="watermark">
    <img src="<?php echo base_url() . 'uploads/hospital_content/watermark-header.png' ?>" class="img-responsive" style="width: 300%"/>
    </div>
    
    </div>
    </td>
    <!-- print prescription end -->
    
            </tr>
        <?php } ?>
    </tbody>
</table>
<div id="prescription_print" style="display:none;">  
        <!-- style="display:none;" -->
    </div>
  <div id="consultation_fee_print" style="display:none;">  
        <!-- style="display:none;" -->
    </div>
<script type="text/javascript">

    jQuery(document).ready(function() {
    var $ = jQuery;

    var table = $("#table-2").DataTable({
        "sPaginationType": "bootstrap",
        "dom": "<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'B>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>",
        buttons: [
            {
                extend: 'copyHtml5',
                text: 'Copy',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7] // Specify the column indices to include in the copy
                }
            },
            {
    extend: 'excel',
    text: 'Excel',
    exportOptions: {
        columns: [0, 1, 2, 3, 4, 5, 6, 7]
    }
},          {
    extend: 'csv',
    text: 'Csv',
    exportOptions: {
        columns: [0, 1, 2, 3, 4, 5, 6, 7]
    }
}
        ]
    });

    $(".dataTables_wrapper select").select2({
        minimumResultsForSearch: -1
    });

    // Highlighted rows
    $("#table-2 tbody input[type=checkbox]").each(function(i, el) {
        var $this = $(el),
            $p = $this.closest('tr');

        $(el).on('change', function() {
            var is_checked = $this.is(':checked');

            $p[is_checked ? 'addClass' : 'removeClass']('highlight');
        });
    });

    // Replace Checkboxes
    $(".pagination a").click(function(ev) {
        replaceCheckboxes();
    });

    // Manually add the Buttons to the DataTables layout
    table.buttons().container()
        .appendTo('.export-data'); // Replace '.export-data' with the appropriate selector for the container element where you want the buttons to appear
});
</script>
 <script type="text/javascript">
    function PrintElem(elem) {
        Popup($(elem).html());
        //   alert("hi");
    }
    
    function PrintElem(elem) {
        // alert("hi2");
        var mywindow = window.open('', 'invoice', 'height=400,width=600');
        mywindow.document.write('<html><head><title>Prescription Invoice</title>');
        mywindow.document.write('<style type="text/css">');
        mywindow.document.write('@media print {');
            mywindow.document.write('.footer-image {');
                mywindow.document.write('position: fixed;');
                mywindow.document.write('bottom: 20px;');
                mywindow.document.write('left: 0;');
                mywindow.document.write('width: 100%;');
                mywindow.document.write('height: 80px;');
                mywindow.document.write('background-repeat: no-repeat;');
                mywindow.document.write('background-position: bottom left;');
                mywindow.document.write('}');
                  mywindow.document.write('hr{');
        mywindow.document.write('border: none;');
        mywindow.document.write('border-top: 1px solid black;');

        mywindow.document.write('}');
                mywindow.document.write('.watermark {');
                    mywindow.document.write('position: fixed;');
                    mywindow.document.write('top: 55%;');
                    mywindow.document.write('left: 55%;');
                    mywindow.document.write('width: 100%;');
                    mywindow.document.write('transform: translate(-50%, -50%);');
                    mywindow.document.write('opacity: 0.1;');
                    mywindow.document.write('}');
                    mywindow.document.write('.hidden-print {');
                        mywindow.document.write('display: none;');
                        mywindow.document.write('}');
                        mywindow.document.write('}');
                        mywindow.document.write('</style>');
                        mywindow.document.write('</head><body >');
                        mywindow.document.write('<div class="footer-image"></div>');
                        mywindow.document.write('<div class="watermark"></div>');
                        mywindow.document.write($(elem).html());
                        mywindow.document.write('</body></html>');
                        
                        mywindow.print();
                        mywindow.close();
                        
                        return true;
                    }
                    </script>
                    
                    
           