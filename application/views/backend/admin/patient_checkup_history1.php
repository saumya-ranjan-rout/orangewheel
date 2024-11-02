<style>  .left-column {
        width: 50%;
    }

    .right-column {
        width: 50%;
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
<table class="table table-bordered table-striped datatable">
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
              </td>
            </tr>
          </tbody>
        </table></td>
    
            </tr>
        <?php } ?>
    </tbody>
</table>

<script type="text/javascript">
    jQuery(window).load(function ()
    {
        var $ = jQuery;

        $("#table-2").dataTable({
            "sPaginationType": "bootstrap",
            "sDom": "<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'T>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>"
        });

        $(".dataTables_wrapper select").select2({
            minimumResultsForSearch: -1
        });

        // Highlighted rows
        $("#table-2 tbody input[type=checkbox]").each(function (i, el)
        {
            var $this = $(el),
                    $p = $this.closest('tr');

            $(el).on('change', function ()
            {
                var is_checked = $this.is(':checked');

                $p[is_checked ? 'addClass' : 'removeClass']('highlight');
            });
        });

        // Replace Checboxes
        $(".pagination a").click(function (ev)
        {
            replaceCheckboxes();
        });
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
                    
                    
                    <script type="text/javascript">
                    jQuery(window).load(function ()
                    {
                        var $ = jQuery;
                        
                        $("#table-2").dataTable({
                            "sPaginationType": "bootstrap",
                            "sDom": "<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'T>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>"
                        });
                        
                        $(".dataTables_wrapper select").select2({
                            minimumResultsForSearch: -1
                        });
                        
                        // Highlighted rows
                        $("#table-2 tbody input[type=checkbox]").each(function (i, el)
                        {
                            var $this = $(el),
                            $p = $this.closest('tr');
                            
                            $(el).on('change', function ()
                            {
                                var is_checked = $this.is(':checked');
                                
                                $p[is_checked ? 'addClass' : 'removeClass']('highlight');
                            });
                        });
                        
                        // Replace Checboxes
                        $(".pagination a").click(function (ev)
                        {
                            replaceCheckboxes();
                        });
                    });
                    </script>