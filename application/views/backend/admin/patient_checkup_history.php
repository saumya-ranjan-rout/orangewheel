<style>  .left-column {
    width: 50%;
}

.right-column {
    width: 50%;
}


.footer-image {
    display: none;
}

@media print {
    .footer-image {
        display: block;
        position: fixed;
        bottom: 20px;
        left: 0;
        width: 100%;
        height: 80px;
        background-repeat: no-repeat;
        background-position: bottom left;
    }
}
.watermark {
    position: fixed;
    top: 55%;
    left: 55%;
    transform: translate(-50%, -50%);
    opacity: 0.4;
    z-index: -1;
    pointer-events: none;
    width: 100%;
    height: 100%;
}

</style>
<?php if ($this->input->post()) {
    $fdate = date('m/d/Y', strtotime($date_from));
    $tdate = date('m/d/Y', strtotime($date_to));
} else {
    $fdate = date("m/d/Y");
    $tdate = date("m/d/Y");
} ?>
<div class="row">
<form action="<?php echo site_url('admin/patient_checkup_history/'.$patient_id); ?>" method="post" enctype="multipart/form-data">
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
<button type="submit" class="btn btn-info">Search</button>
</div>
</form>
</div>
<div style="clear:both;"></div>
<div align="center">
<?php
if ($this->input->post()) {
    ?>
    <h4 style="color:#818da1;">Showing Results From <span style="color:#14b914"><?php echo date('d-m-Y', strtotime($date_from)) ?></span> To <span style="color:#14b914"><?php echo date('d-m-Y', strtotime($date_to)); ?></span></h4>
    <?php } else{?>
        <h4 style="color:#818da1;">Showing Results For <span style="color:#14b914"><?php echo date('d-m-Y') ?></span> </h4>
        <?php  }
        
        
        ?>
        </div>
        <br>
        <table class="table table-bordered table-striped datatable" id="table-2">
        <thead>
        <tr>
        <th><?php echo get_phrase('image');?></th>
        <th><?php echo get_phrase('Patient Id');?></th>
        <th><?php echo get_phrase('name');?></th>
        <th><?php echo get_phrase('phone');?></th>
        <th><?php echo get_phrase('sex');?></th>
        <th><?php echo get_phrase('age');?></th>
        <th><?php echo get_phrase('date');?></th>
        <th><?php echo get_phrase('upload');?></th>
        <th><?php echo get_phrase('download');?></th>
        <th><?php echo get_phrase('System Generated');?></th>
        
        </tr>
        </thead>
        
        <tbody>
        <?php 
        if ($this->input->post()) {
            $dateFrom = date('Y-m-d', strtotime($date_from));
            $dateTo = date('Y-m-d', strtotime($date_to));
        } else {
            $dateFrom = date("Y-m-d");
            $dateTo = date("Y-m-d");
        }
        
        // Filter the income array based on the selected date range
        $filteredpatient_info = array_filter($patient_info, function($row) use ($dateFrom, $dateTo) {
            $rowDate = date("Y-m-d", strtotime($row['date']));
            // echo $rowDate;
            return ($rowDate >= $dateFrom && $rowDate <= $dateTo);
        });
        foreach ($filteredpatient_info as $row) {
            
            //foreach ($patient_info as $row) { ?>   
                <tr>
                <td><img src="<?php echo $this->crud_model->get_image_url('patient' , $row['patient_id']);?>" class="img-circle" width="40px" height="40px"></td>
                <td><?php echo $row['code']?></td>
                <td><?php echo $row['name']?></td>
                <td><?php echo $row['phone']?></td>
                <td><?php echo $row['sex']?></td>
                <td><?php echo $row['age']?></td>
                <td><?php echo $row['date']?></td>
                <td> <table>
                <tbody>
                <tr>
                <td>
                <label for="field-1" class="col-sm-3 control-label"><?php echo "Prescription"; ?><small style="color:red;">*</small></label>
                <form method="post" enctype="multipart/form-data" action="<?php echo site_url('admin/patient_checkup_history/'.$row['patient_id'].'/upload'); ?>">
                <input type="hidden" name="patient_id" value="<?php echo $row['patient_id']?>">
                <input type="hidden" name="patient_consultation_history_id" value="<?php echo $row['id']?>">
                <input type="hidden" name="name" value="prescription">
                <input type="file" name="file" required>
                <button type="submit"  class="btn btn-primary btn-sm hidden-print">
                <i class="fa fa-upload"></i>&nbsp;Upload</button>
                </form>
                <br>
                <label for="field-1" class="col-sm-3 control-label"><?php echo "Diagnosis"; ?><small style="color:red;">*</small></label>
                <form method="post" enctype="multipart/form-data" action="<?php echo site_url('admin/patient_checkup_history/'.$row['patient_id'].'/upload'); ?>">
                <input type="hidden" name="patient_id" value="<?php echo $row['patient_id']?>">
                <input type="hidden" name="patient_consultation_history_id" value="<?php echo $row['id']?>">
                <input type="hidden" name="name" value="diagnosis">
                <input type="file" name="file" required>
                <button type="submit"  class="btn btn-primary btn-sm hidden-print">
                <i class="fa fa-upload"></i>&nbsp;Upload</button>
                </form>
                </td>
                </tr>
                </tbody>
                </table></td>
                <td> <table>
                <tbody>
                <tr>
                <td>
                
                <?php 
                if($row['prescription_document'] != ''){
                    ?>
                    <a href="<?php echo base_url('uploads/patient_image/'.$row['prescription_document']);?>" class="btn btn-info btn-sm " download>
                    <i class="fa fa-download"></i>Prescription
                    </a>
                    <?php
                }else{
                    ?>
                    <a href="#" class="btn btn-info btn-sm " onclick="alert('No prescription file available.')">
                    <i class="fa fa-download"></i>Prescription
                    </a>
                    <?php
                }
                ?>
                <br><br>
                <?php 
                if($row['prescription_document'] != ''){
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
                
                </td>
                </tr>
                </tbody>
                </table></td>
                <td>       <a onClick="PrintElem('#invoice_print_diagnosis<?php echo $row['id']?>','Diagnosis Report Print')" 
                class="btn btn-primary btn-sm" title="Diagnosis Report Print">
                <i class="fa fa-print"></i> &nbsp;
                
                </a>
                <!--Diagnosis Report Print start  -->
                <?php
                $date=$row['date'];
                $conditions = array('patient_id' => $row['patient_id'],'date' => date('Y-m-d', strtotime($date)));
                $data = $this->db->get_where('patient_diagnosis', $conditions)->result_array();
                foreach ($data as $roww):
                    ?>
                    <div id="invoice_print_diagnosis<?php echo $row['id']?>" style="display:none;">
                    <table width="100%" border="0">
                    <tr>
                    <td ><img src="<?php echo base_url() . 'uploads/hospital_content/header.png' ?>"  style="height:100px; width:100%;" class="img-responsive"/></td>
                    <td align="right"></td>
                    </tr>
                    </table>
                    <hr>
                    <table width="100%" border="0">    
                    <tr>
                    <td align="left"><h4><?php echo get_phrase('payment_to'); ?> </h4></td>
                    <td align="right"><h4><?php echo get_phrase('bill_to'); ?> </h4></td>
                    </tr>
                    <tr>
                    <td align="left" valign="top" style="width: 55%;">
                    <?php echo $this->db->get_where('settings', array('type' => 'system_name'))->row()->description; ?><br>
                    <?php echo $this->db->get_where('settings', array('type' => 'address'))->row()->description; ?><br>
                    <?php echo $this->db->get_where('settings', array('type' => 'phone'))->row()->description; ?><br>            
                    </td>
                    <td align="right" valign="top" style="width: 45%;">
                    <!--   Bill No:<?php  echo $roww['bill_no'];?><br> -->
                    <?php echo $this->db->get_where('patient', array('patient_id' => $roww['patient_id']))->row()->code; ?><br>
                    <?php echo $this->db->get_where('patient', array('patient_id' => $roww['patient_id']))->row()->name; ?><br>
                    <?php echo $this->db->get_where('patient', array('patient_id' => $roww['patient_id']))->row()->current_street; ?><br>
                    <?php echo $this->db->get_where('patient', array('patient_id' => $roww['patient_id']))->row()->phone; ?><br>
                    <?php echo date('d/m/Y');?><br>
                    </td>
                    </tr>
                    </table>
                    <hr>
                    <!--  <h4><?php echo get_phrase('medicines'); ?></h4> -->
                    <table class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;">
                    <thead>
                    <tr>
                    <th class="text-center">#</th>
                    <th width="40%"><?php echo get_phrase('name'); ?></th>
                    <th><?php echo get_phrase('quantity'); ?></th>
                    <th><?php echo get_phrase('price'); ?></th>
                    <th><?php echo get_phrase('discount_type'); ?></th>
                    <th><?php echo get_phrase('discount_price'); ?>/%</th>
                    </tr>
                    </thead>
                    <tbody>
                    <!-- INVOICE ENTRY STARTS HERE-->
                    <div id="invoice_entry">
                    <?php
                    $i= 1;
                    ?>
                    <tr>
                    <td class="text-center"><?php echo $i++; ?></td>
                    <td>
                    <?php
                    $medicine_info = $this->db->get_where('diagnosis', array('id' => $roww['diagnosis_id']))->row();
                    echo $medicine_info->name;
                    ?>
                    </td>
                    <td align="center">
                    <?php echo $medicine_info->qty; ?>
                    </td>
                    <td align="center">
                    <?php echo $price=$medicine_info->price;; ?>
                    </td>
                    <td align="center">
                    <?php
                    $discount_type=$medicine_info->discount_type;
                    $discount_price=$medicine_info->discount_price;
                    if($discount_type =='percentage'){
                        $to=($price * $discount_price) / 100;
                        $total=$price-$to;
                    }else if($discount_type =='fixed'){
                        $total=$price-$discount_price;
                    }
                    else {
                        $total=$price;
                    }
                    ?>
                    <?php echo $medicine_info->discount_type; ?>
                    </td>
                    <td class="text-right" align="right">
                    <?php echo $medicine_info->discount_price; ?>
                    </td>
                    </tr>
                    </div>
                    <!-- INVOICE ENTRY ENDS HERE-->
                    </tbody>
                    </table>
                    <table width="100%" border="0">
                    <tr>
                    <td align="right" width="90%"><h4><?php echo get_phrase('total_price'); ?> :</h4></td>
                    <td align="right"><h4>₹ <?php echo $total; ?> </h4></td>
                    </tr>
                    </table>
                    <div class="footer-image">
                    <img src="<?php echo base_url() . 'uploads/hospital_content/footer.png' ?>" class="img-responsive" style="width: 100%"/>
                    </div>
                    <!-- Watermark -->
                    <div class="watermark">
                    <img src="<?php echo base_url() . 'uploads/hospital_content/watermark-header.png' ?>" class="img-responsive" style="width: 300%"/>
                    </div>
                    </div>         
                    <?php endforeach; ?>
                    <!-- Diagnosis Report Print End -->
                    
                    <a onClick="PrintElem('#invoice_print_consultation<?php echo $row['id']?>','Consultation Charge')" 
                    class="btn btn-warning btn-sm" title="Consultation Charge Print">
                    <i class="fa fa-print"></i> &nbsp;
                    
                    </a>
                    <!-- Consultation Charge Print Start -->
                    <?php
                    $date2=$row['date'];
                    $conditions2 = array('patient_id' => $row['patient_id'],'date' => $date2);
                    $data2 = $this->db->get_where('patient_consultation_history', $conditions2)->result_array();
                    foreach ($data2 as $roww2):
                        ?>
                        <div id="invoice_print_consultation<?php echo $row['id']?>" style="display:none;">
                        <table width="100%" border="0">
                        <tr>
                        <td ><img src="<?php echo base_url() . 'uploads/hospital_content/header.png' ?>"  style="height:100px; width:100%;" class="img-responsive"/></td>
                        <td align="right"></td>
                        </tr>
                        </table>
                        <hr>
                        <table width="100%" border="0">    
                        <tr>
                        <td align="left"><h4><?php echo get_phrase('payment_to'); ?> </h4></td>
                        <td align="right"><h4><?php echo get_phrase('bill_to'); ?> </h4></td>
                        </tr>
                        <tr>
                        <td align="left" valign="top" style="width: 55%;">
                        <?php echo $this->db->get_where('settings', array('type' => 'system_name'))->row()->description; ?><br>
                        <?php echo $this->db->get_where('settings', array('type' => 'address'))->row()->description; ?><br>
                        <?php echo $this->db->get_where('settings', array('type' => 'phone'))->row()->description; ?><br>            
                        </td>
                        <td align="right" valign="top" style="width: 45%;">
                        <!--   Bill No:<?php  echo $roww2['bill_no'];?><br> -->
                        <?php echo $this->db->get_where('patient', array('patient_id' => $roww2['patient_id']))->row()->code; ?><br>
                        <?php echo $this->db->get_where('patient', array('patient_id' => $roww2['patient_id']))->row()->name; ?><br>
                        <?php echo $this->db->get_where('patient', array('patient_id' => $roww2['patient_id']))->row()->current_street; ?><br>
                        <?php echo $this->db->get_where('patient', array('patient_id' => $roww2['patient_id']))->row()->phone; ?><br>
                        <?php echo date('d/m/Y');?><br>
                        </td>
                        </tr>
                        </table>
                        <hr>
                        <!--  <h4><?php echo get_phrase('medicines'); ?></h4> -->
                        <table class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;">
                        <thead>
                        <tr>
                        <th class="text-center">#</th>
                        <th width="40%"><?php echo get_phrase('name'); ?></th>
                        <th><?php echo get_phrase('quantity'); ?></th>
                        <th><?php echo get_phrase('price'); ?></th>
                        <th><?php echo get_phrase('discount_type'); ?></th>
                        <th><?php echo get_phrase('discount_price'); ?>/%</th>
                        </tr>
                        </thead> 
                        <tbody>
                        <!-- INVOICE ENTRY STARTS HERE-->
                        <div id="invoice_entry">
                        <?php
                        $i= 1;
                        ?>
                        <tr>
                        <td class="text-center"><?php echo $i++; ?></td>
                        <td>
                        <?php
                        //  $medicine_info = $this->db->get_where('medicine', array('medicine_id' => $roww22->medicine_id))->row();
                        // echo $medicine_info->name;
                        echo $roww2['consultation_name']; ?>
                        </td>
                        <td align="center">
                        <?php echo $roww2['qty']; ?>
                        </td>
                        <td align="center">
                        <?php echo $roww2['price']; ?>
                        </td>
                        <td align="center">
                        <?php echo $roww2['discount_type']; ?>
                        </td>
                        <td class="text-right" align="right">
                        <?php echo $roww2['discount_price']; ?>
                        </td>
                        </tr>
                        </div>
                        <!-- INVOICE ENTRY ENDS HERE-->
                        </tbody>
                        </table>
                        <table width="100%" border="0">
                        <tr>
                        <td align="right" width="90%"><h4><?php echo get_phrase('total_price'); ?> :</h4></td>
                        <td align="right"><h4>₹ <?php echo $roww2['total_price']; ?> </h4></td>
                        </tr>
                        </table>
                        <div class="footer-image">
                        <img src="<?php echo base_url() . 'uploads/hospital_content/footer.png' ?>" class="img-responsive" style="width: 100%"/>
                        </div> 
                        <!-- Watermark -->
                        <div class="watermark">
                        <img src="<?php echo base_url() . 'uploads/hospital_content/watermark-header.png' ?>" class="img-responsive" style="width: 300%"/>
                        </div>
                        </div>
                        <?php endforeach; ?>
                        
                        <!-- Consultation Charge Print End -->
                        
                        </td>
                        
                        
                        </tr>
                        <?php } ?>
                        </tbody>
                        </table>
                        
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
                    columns: [0, 1, 2, 3, 4, 5, 6] // Specify the column indices to include in the copy
                }
            },
            {
    extend: 'excel',
    text: 'Excel',
    exportOptions: {
        columns: [0, 1, 2, 3, 4, 5, 6]
    }
},          {
    extend: 'csv',
    text: 'Csv',
    exportOptions: {
        columns: [0, 1, 2, 3, 4, 5, 6]
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
                        // function PrintElem(elem) {
                            //     Popup($(elem).html());
                            //     //   alert("hi");
                            // }
                            
                            function PrintElem(elem,heading) {
                                // alert(elem);
                                var mywindow = window.open('', 'invoice', 'height=400,width=600');
                                mywindow.document.write('<html><head><title>'+heading+'</title>');
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
                                            
                            